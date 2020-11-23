resource "aws_security_group" "sgProductionWebservers" {
  name   = "sgProductionWebservers"
  vpc_id = aws_vpc.vpcGabonProduction.id

  lifecycle {
    create_before_destroy = true
  }

  tags = {
    Name        = "sgProductionWebservers"
    Environment = "production"
    Terraform   = "1"
  }
}

resource "aws_security_group_rule" "sgrProductionSshToWebServersFromSecuredOrigins" {
  security_group_id = aws_security_group.sgProductionWebservers.id
  type              = "ingress"
  from_port         = 22
  to_port           = 22
  protocol          = "tcp"
  cidr_blocks       = var.securedOrigins
}


# TODO: this needs to be better defined: currently both the ALB and the Web Server allows incoming HTTP(S) from anywhere
#       I would like this to be so that the ALB allows incoming connections, and that the web FE's only allow 80 from the ALB and from nowhere else
resource "aws_security_group_rule" "sgrProductionHttpsToWebServersFromEverywhere" {
  security_group_id = aws_security_group.sgProductionWebservers.id
  type              = "ingress"
  from_port         = 443
  to_port           = 443
  protocol          = "tcp"
  cidr_blocks = [
    "0.0.0.0/0"
  ]
}

resource "aws_security_group_rule" "sgrProductionHttpToWebServersFromEverywhere" {
  security_group_id = aws_security_group.sgProductionWebservers.id
  type              = "ingress"
  from_port         = 80
  to_port           = 80
  protocol          = "tcp"
  cidr_blocks = [
    "0.0.0.0/0"
  ]
}

resource "aws_security_group_rule" "sgrProductionOutboundFromWebServersToEverywhere" {
  security_group_id = aws_security_group.sgProductionWebservers.id
  type              = "egress"
  from_port         = 0
  to_port           = 0
  protocol          = "all"
  cidr_blocks = [
    "0.0.0.0/0"
  ]
}

resource "aws_lb" "albProductionFrontEnd" {
  name               = "albProductionFrontEnd"
  internal           = false
  load_balancer_type = "application"
  ip_address_type    = "dualstack"

  security_groups = [
    aws_security_group.sgProductionWebservers.id
  ]

  subnets = [
    aws_subnet.subnProductionPublic_1a.id,
    aws_subnet.subnProductionPublic_1b.id
  ]

  enable_deletion_protection = true

  tags = {
    Environment = "production"
    Terraform   = 1
  }
}

resource "aws_lb_listener" "alblProductionHttps" {
  load_balancer_arn = aws_lb.albProductionFrontEnd.arn
  port              = "443"
  protocol          = "HTTPS"
  ssl_policy        = "ELBSecurityPolicy-2016-08"
  certificate_arn   = aws_acm_certificate.certGabonHttps.arn

  default_action {
    type             = "forward"
    target_group_arn = aws_lb_target_group.lbtgProductionGabonHttp.arn
  }
}

resource "aws_lb_listener_rule" "alblrProductionGabonGlobalOriginOrg" {
  listener_arn = aws_lb_listener.alblProductionHttps.arn
  priority     = 100

  condition {
    host_header {
      values = [
        "gabon.globalorigin.org"
      ]
    }
  }

  action {
    type             = "forward"
    target_group_arn = aws_lb_target_group.lbtgProductionGabonHttp.arn
  }
}

resource "aws_lb_target_group" "lbtgProductionGabonHttp" {
  name     = "lbtgProductionGabonHttp"
  port     = 80
  protocol = "HTTP"
  vpc_id   = aws_vpc.vpcGabonProduction.id

  target_type = "instance"
}

resource "aws_instance" "iProduction_1" {
  ami           = var.ubuntu_20_04
  instance_type = "t3.nano"

  vpc_security_group_ids = [
    aws_security_group.sgProductionWebservers.id
  ]
  subnet_id = aws_subnet.subnProductionPublic_1a.id
  key_name  = aws_key_pair.keyGabonDeploymentKey.key_name
  lifecycle {
    create_before_destroy = true
  }

  root_block_device {
    volume_size = var.webserver_instance_storage
  }

  tags = {
    Name        = "iProduction_1"
    Environment = "production"
    Terraform   = "1"
  }
}

resource "aws_instance" "iProduction_2" {
  ami           = var.ubuntu_20_04
  instance_type = "t3.nano"

  vpc_security_group_ids = [
    aws_security_group.sgProductionWebservers.id
  ]
  subnet_id = aws_subnet.subnProductionPublic_1b.id
  key_name  = aws_key_pair.keyGabonDeploymentKey.key_name
  lifecycle {
    create_before_destroy = true
  }

  root_block_device {
    volume_size = var.webserver_instance_storage
  }

  tags = {
    Name        = "iProduction_2"
    Environment = "production"
    Terraform   = "1"
  }
}


# NOTE: Attach additional hosts to the lbtgProductionGabonHttp target group (just like below) to
# scale horizontally the load balancer's job is to rotate requests around to the instances
# in the target group
resource "aws_lb_target_group_attachment" "lbtgaGabonProdInstance_1" {
  target_group_arn = aws_lb_target_group.lbtgProductionGabonHttp.arn
  target_id        = aws_instance.iProduction_1.id
}
resource "aws_lb_target_group_attachment" "lbtgaGabonProdInstance_2" {
  target_group_arn = aws_lb_target_group.lbtgProductionGabonHttp.arn
  target_id        = aws_instance.iProduction_2.id
}

output "production-alb-dns-name" {
  value = aws_lb.albProductionFrontEnd.dns_name
}

output "webFE-1-ip" {
  value = aws_instance.iProduction_1.public_ip
}

output "webFE-1-public-dns" {
  value = aws_instance.iProduction_1.public_dns
}

output "webFE-2-ip" {
  value = aws_instance.iProduction_2.public_ip
}

output "webFE-2-public-dns" {
  value = aws_instance.iProduction_2.public_dns
}
