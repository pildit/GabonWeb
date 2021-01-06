variable "profile" {
  type    = string
  default = ""
}

variable "region" {
  type    = string
  default = "af-south-1"
}

variable "webserver_instance_type" {
  type    = string
  default = "c5.xlarge"
}

variable "webserver_instance_storage" {
  type    = number
  default = 50
}

variable "tiles_instance_storage" {
  type    = number
  default = 50
}

variable "rdspsql_instance_type" {
  type    = string
  default = "db.m5.large"
}

variable "ubuntu_20_04" {
  type    = string
  default = "ami-01231db8966c15acd" # Ubuntu Server 20.04 LTS
}

# set this value in secrets.tfvars (but do NOT commit that file)
# NOTE: NOT USED FOR PRODUCTION
variable "sshPubKey" {
  type    = string
  default = ""
}

# set this value in secrets.tfvars (but do NOT commit that file)
variable "sshGabonDeploymentKey" {
  type    = string
  default = ""
}

# set this value in secrets.tfvars (but do NOT commit that file)
variable "securedOrigins" {
  type    = list
  default = []
}

variable "webserver_storage_size" {
  type    = number
  default = -1
}

variable "db_availability_zone" {
  type    = string
  default = "af-south-1a"
}

variable "db_GabonWeb_username" {
  type    = string
  default = ""
}

variable "db_GabonWeb_password" {
  type    = string
  default = ""
}
