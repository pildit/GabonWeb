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
    target_group_arn = aws_lb_target_group.lbtgProductionGabonHttps.arn
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
    target_group_arn = aws_lb_target_group.lbtgProductionGabonHttps.arn
  }
}

resource "aws_lb_target_group" "lbtgProductionGabonHttps" {
  name     = "lbtgProductionGabonHttps"
  port     = 443
  protocol = "HTTPS"
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
    volume_size = "50"
  }

  tags = {
    Name        = "iProduction_1"
    Environment = "production"
    Terraform   = "1"
  }
}


# NOTE: Attach additional hosts to the lbtgProduction_Https target group (just like below) to
# scale horizontally the load balancer's job is to rotate requests around to the instances
# in the target group
resource "aws_lb_target_group_attachment" "lbtgaGabonProdInstance" {
  target_group_arn = aws_lb_target_group.lbtgProductionGabonHttps.arn
  target_id        = aws_instance.iProduction_1.id
}

output "production-alb-dns-name" {
  value = aws_lb.albProductionFrontEnd.dns_name
}
