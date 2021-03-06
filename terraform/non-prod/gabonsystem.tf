provider "aws" {
  profile = var.profile
  region  = var.region
}

resource "aws_vpc" "vpcGabonSystem" {
  cidr_block           = "10.0.0.0/24"
  instance_tenancy     = "default"
  enable_dns_support   = "true"
  enable_dns_hostnames = "true"
  enable_classiclink   = "false"

  tags = {
    Name      = "vpcGabonSystem"
    Terraform = "1"
  }
}

resource "aws_subnet" "subnGabonSystemPublic" {
  vpc_id                  = aws_vpc.vpcGabonSystem.id
  cidr_block              = "10.0.0.0/24"
  map_public_ip_on_launch = "true"
  availability_zone = "us-east-1b"

  tags = {
    Name      = "subnGabonSystemPublic"
    Terraform = "1"
  }
}

resource "aws_internet_gateway" "igw" {
  vpc_id = aws_vpc.vpcGabonSystem.id

  tags = {
    Terraform = "1"
  }
}

resource "aws_route_table" "rtDefault" {
  vpc_id = aws_vpc.vpcGabonSystem.id
  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = aws_internet_gateway.igw.id
  }

  tags = {
    Terraform = "1"
  }
}

resource "aws_route_table_association" "association-subnet" {
  subnet_id      = aws_subnet.subnGabonSystemPublic.id
  route_table_id = aws_route_table.rtDefault.id
}

resource "aws_security_group" "sgWebAccessible" {
  name   = "sgWebAccessible"
  vpc_id = aws_vpc.vpcGabonSystem.id

  lifecycle {
    create_before_destroy = true
  }

  tags = {
    Name      = "sgWebAccessible"
    Terraform = "1"
  }
}

resource "aws_security_group_rule" "sgrSshFromEverywhere" {
  security_group_id = aws_security_group.sgWebAccessible.id
  type              = "ingress"
  from_port         = 22
  to_port           = 22
  protocol          = "tcp"
  cidr_blocks       = ["0.0.0.0/0"]
}

resource "aws_security_group_rule" "sgrHttpFromEverywhere" {
  security_group_id = aws_security_group.sgWebAccessible.id
  type              = "ingress"
  from_port         = 80
  to_port           = 80
  protocol          = "tcp"
  cidr_blocks       = ["0.0.0.0/0"]
}

resource "aws_security_group_rule" "sgrPostgresFromSecured" {
  security_group_id = aws_security_group.sgWebAccessible.id
  type              = "ingress"
  from_port         = 5432
  to_port           = 5432
  protocol          = "tcp"
  cidr_blocks       = var.securedOrigins
}

resource "aws_security_group_rule" "sgOutboundAll" {
  security_group_id = aws_security_group.sgWebAccessible.id
  type              = "egress"
  from_port         = 0
  to_port           = 0
  protocol          = "all"
  cidr_blocks       = ["0.0.0.0/0"]
}

resource "aws_key_pair" "keyDefaultKey" {
  key_name   = "GabonSystem-DefaultKey"
  public_key = var.sshPubKey
}

resource "aws_instance" "iTestInstance" {
  ami           = var.ami
  instance_type = var.instance_type
  vpc_security_group_ids = [
    aws_security_group.sgWebAccessible.id
  ]
  subnet_id = aws_subnet.subnGabonSystemPublic.id
  key_name  = aws_key_pair.keyDefaultKey.key_name
  lifecycle {
    create_before_destroy = true
  }

  root_block_device {
    volume_size = var.storage_size
  }

  tags = {
    Name        = "iTestInstance"
    Environment = "test"
    Terraform   = "1"
  }
}

resource "aws_eip" "eipTest" {
  instance = aws_instance.iTestInstance.id
  vpc      = "true"

  tags = {
    Name        = "eipTest"
    Environment = "test"
    Terraform   = "1"
  }
}

resource "aws_instance" "iProductionInstance" {
  ami           = var.ami
  instance_type = var.instance_type
  vpc_security_group_ids = [
    aws_security_group.sgWebAccessible.id
  ]
  subnet_id = aws_subnet.subnGabonSystemPublic.id
  key_name  = aws_key_pair.keyDefaultKey.key_name
  lifecycle {
    create_before_destroy = true
  }

  root_block_device {
    volume_size = var.storage_size
  }

  tags = {
    Name        = "iProductionInstance"
    Environment = "production"
    Terraform   = "1"
  }
}

resource "aws_eip" "eipProduction" {
  instance = aws_instance.iProductionInstance.id
  vpc      = "true"

  tags = {
    Name        = "eipProduction"
    Environment = "production"
    Terraform   = "1"
  }
}

output "vpc-id" {
  value = aws_vpc.vpcGabonSystem.id
}

output "vpc-publicsubnet" {
  value = aws_subnet.subnGabonSystemPublic.cidr_block
}

output "vpc-publicsubnet-id" {
  value = aws_subnet.subnGabonSystemPublic.id
}

output "test_instance_public_ip" {
  value = aws_instance.iTestInstance.public_ip
}

output "test_elastic_ip" {
  value = aws_eip.eipTest.public_ip
}

output "production_instance_public_ip" {
  value = aws_instance.iProductionInstance.public_ip
}

output "production_elastic_ip" {
  value = aws_eip.eipProduction.public_ip
}
