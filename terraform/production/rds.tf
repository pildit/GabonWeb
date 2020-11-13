resource "aws_db_subnet_group" "dbsubnetgrpProduction" {
  name = "db_subnetgrp_production"
  subnet_ids = [
    aws_subnet.subnProductionPublic_1a.id
    , aws_subnet.subnProductionPublic_1b.id
  ]

  tags = {
    Environment = "production"
    Terraform   = 1
  }
}

resource "aws_security_group" "sgProductionDatabases" {
  name   = "sgProductionDatabases"
  vpc_id = aws_vpc.vpcGabonProduction.id

  lifecycle {
    create_before_destroy = true
  }

  tags = {
    Name        = "sgProductionDatabases"
    Environment = "production"
    Terraform   = "1"
  }
}

resource "aws_security_group_rule" "sgrProductionPostgresAccessibleFromWebFEs" {
  security_group_id = aws_security_group.sgProductionDatabases.id
  type              = "ingress"
  from_port         = 5432
  to_port           = 5432
  protocol          = "tcp"
  cidr_blocks = [
    aws_subnet.subnProductionPublic_1a.cidr_block
    , aws_subnet.subnProductionPublic_1b.cidr_block
  ]
}

resource "aws_db_instance" "rdsGabonWeb" {
  engine         = "postgres"
  engine_version = "13"
  instance_class = "db.t3.micro"
  name           = "GabonWeb"

  availability_zone = var.db_availability_zone

  username = var.db_GabonWeb_username
  password = var.db_GabonWeb_password

  allocated_storage     = 20
  max_allocated_storage = 100
  storage_type          = "gp2"

  publicly_accessible = false

  db_subnet_group_name = aws_db_subnet_group.dbsubnetgrpProduction.name

  vpc_security_group_ids = [
    aws_security_group.sgProductionDatabases.id
  ]

  deletion_protection     = true
  skip_final_snapshot     = false
  backup_retention_period = 30
  backup_window           = "05:00-06:00" # NOTE: UTC

  allow_major_version_upgrade = true
  auto_minor_version_upgrade  = true
  maintenance_window          = "Sat:07:00-Sat:13:00" # NOTE: UTC

  apply_immediately = true

  tags = {
    Environment = "production"
    Name        = "GabonWeb"
    Terraform   = 1
  }
}

output "rdsGabonWeb_hostname" {
  value = aws_db_instance.rdsGabonWeb.address
}
