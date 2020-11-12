resource "aws_acm_certificate" "certGabonHttps" {
  domain_name       = "*.globalorigin.org"
  validation_method = "DNS"

  lifecycle {
    create_before_destroy = true
  }
}

resource "aws_key_pair" "keyGabonDeploymentKey" {
  key_name   = "gabon-deployment-key"
  public_key = var.sshGabonDeploymentKey
}
