variable "profile" {
    type = string
    default = ""
}

variable "region" {
    default = "af-south-1"
}

variable "webserver_instance_type" {
    default = "t2.micro"
}

variable "ubuntu_20_04" {
    default = "ami-01231db8966c15acd"   # Ubuntu Server 20.04 LTS
}

# set this value in secrets.tfvars (but do NOT commit that file)
# NOTE: NOT USED FOR PRODUCTION
variable "sshPubKey" {
    type = string
    default = ""
}

# set this value in secrets.tfvars (but do NOT commit that file)
variable "sshGabonDeploymentKey" {
    type = string
    default = ""
}

# set this value in secrets.tfvars (but do NOT commit that file)
variable "securedOrigins" {
    type = list
    default = []
}

variable "webserver_storage_size" {
    type = number
    default = -1
}
