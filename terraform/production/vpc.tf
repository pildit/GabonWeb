resource "aws_vpc" "vpcGabonProduction" {
  cidr_block                       = "10.0.0.0/16"
  instance_tenancy                 = "default"
  enable_dns_support               = "true"
  enable_dns_hostnames             = "true"
  enable_classiclink               = "false"
  assign_generated_ipv6_cidr_block = "true"

  tags = {
    Name        = "vpcGabonProduction"
    Environment = "production"
    Terraform   = "1"
  }
}

resource "aws_subnet" "subnProductionPublic_1a" {
  vpc_id                          = aws_vpc.vpcGabonProduction.id
  availability_zone               = "af-south-1a"

  cidr_block                      = "10.0.1.0/24"
  map_public_ip_on_launch         = "true"

  assign_ipv6_address_on_creation = "true"
  ipv6_cidr_block                 = cidrsubnet(aws_vpc.vpcGabonProduction.ipv6_cidr_block, 8, 1)

  tags = {
    Name        = "subnProductionPublic_1a"
    Environment = "production"
    Terraform   = "1"
  }
}

resource "aws_subnet" "subnProductionPublic_1b" {
  vpc_id                          = aws_vpc.vpcGabonProduction.id
  availability_zone               = "af-south-1b"

  cidr_block                      = "10.0.2.0/24"
  map_public_ip_on_launch         = "true"

  assign_ipv6_address_on_creation = "true"
  ipv6_cidr_block                 = cidrsubnet(aws_vpc.vpcGabonProduction.ipv6_cidr_block, 8, 2)

  tags = {
    Name        = "subnProductionPublic_1b"
    Environment = "production"
    Terraform   = "1"
  }
}

resource "aws_internet_gateway" "igwProduction" {
  vpc_id = aws_vpc.vpcGabonProduction.id

  tags = {
    Name        = "igwProduction"
    Environment = "production"
    Terraform   = "1"
  }
}

resource "aws_route_table" "rtProductionDefault" {
  vpc_id = aws_vpc.vpcGabonProduction.id
  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = aws_internet_gateway.igwProduction.id
  }

  tags = {
    Name        = "rtProductionDefault"
    Environment = "production"
    Terraform   = "1"
  }
}

resource "aws_route_table_association" "association-production-public_1a-subnet" {
  subnet_id      = aws_subnet.subnProductionPublic_1a.id
  route_table_id = aws_route_table.rtProductionDefault.id
}

resource "aws_route_table_association" "association-production-public_1b-subnet" {
  subnet_id      = aws_subnet.subnProductionPublic_1b.id
  route_table_id = aws_route_table.rtProductionDefault.id
}
