resource "aws_lb" "albProduction" {
  name               = "albGabonWebProduction"
  internal           = false
  load_balancer_type = "application"
  ip_address_type    = "dualstack"
  security_groups = [
    aws_security_group.sgWebAccessible.id
  ]
  subnets = aws_subnet.subnGabonSystemPublic.*.id

  enable_deletion_protection = true

  tags = {
    Environment = "production"
  }
}

resource "aws_lb_target_group" "lbtgGabonProdHttps" {
  name     = "lbtgGabonProdHttps"
  port     = 443
  protocol = "HTTPS"
  vpc_id   = aws_vpc.vpcGabonSystem.id

  target_type = "instance"
}

resource "aws_lb_target_group_attachment" "lbtgaGabonProdHttps" {
  target_group_arn = aws_lb_target_group.lbtgGabonProdHttps.arn
  target_id        = aws_instance.iProductionInstance.id
}

resource "aws_lb_listener" "alblGabonProdHttps" {
  load_balancer_arn = aws_lb.albProduction.arn
  port              = "443"
  protocol          = "HTTPS"
  #   ssl_policy        = "ELBSecurityPolicy-2016-08"
  #   certificate_arn   = "arn:aws:iam::187416307283:server-certificate/test_cert_rab3wuqwgja25ct3n4jdj2tzu4"

  default_action {
    type             = "forward"
    target_group_arn = aws_lb_target_group.lbtgGabonProdHttps.arn
  }
}

resource "aws_lb_listener_rule" "alblrGabonProduction" {
  listener_arn = aws_lb_listener.alblGabonProdHttps.arn
  priority     = 100

  action {
    type             = "forward"
    target_group_arn = aws_lb_target_group.lbtgGabonProdHttps.arn
  }

  condition {
    host_header {
      values = [
        "gabon.globalorigin.org"
      ]
    }
  }
}
