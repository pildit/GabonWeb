resource "aws_elasticache_subnet_group" "elasticachesubnetgrpProduction" {
  name = "elasticachesubnetgrpProduction"
  subnet_ids = [
    aws_subnet.subnProductionPublic_1a.id
    , aws_subnet.subnProductionPublic_1b.id
  ]
}

resource "aws_elasticache_cluster" "cacheGabonWebFE" {
  cluster_id           = "cache-gabon-webfe"
  engine               = "redis"
  node_type            = "cache.r5.large"
  num_cache_nodes      = 1
  parameter_group_name = "default.redis6.x"
  # engine_version       = "6.x" # 6.0.5
  port                 = 6379

  subnet_group_name = aws_elasticache_subnet_group.elasticachesubnetgrpProduction.name

  apply_immediately = true

  #   lifecycle {
  #     ignore_changes = [engine_version]
  #   }

  tags = {
    Name        = "cacheGabonWebFE"
    Environment = "production"
    Terraform   = "1"
  }
}

resource "aws_security_group" "sgWebFEElastiCache" {
  name   = "sgWebFEElastiCache"
  vpc_id = aws_vpc.vpcGabonProduction.id

  lifecycle {
    create_before_destroy = true
  }

  tags = {
    Name        = "sgWebFEElastiCache"
    Environment = "production"
    Terraform   = "1"
  }
}

resource "aws_security_group_rule" "sgrWebFEtoElastiCache" {
  security_group_id = aws_security_group.sgWebFEElastiCache.id
  type              = "ingress"
  from_port         = aws_elasticache_cluster.cacheGabonWebFE.port
  to_port           = aws_elasticache_cluster.cacheGabonWebFE.port
  protocol          = "tcp"
  cidr_blocks = [
    aws_subnet.subnProductionPublic_1a.cidr_block,
    aws_subnet.subnProductionPublic_1b.cidr_block
  ]
}

output "ElastiCache-cache_nodes" {
  value = aws_elasticache_cluster.cacheGabonWebFE.cache_nodes
}
