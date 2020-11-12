variable "profile" {
    type = string
    default = ""
}

variable "region" {
    default = "us-east-1"
}

variable "instance_type" {
    default = "t2.micro"
}

variable "ami" {
    default = "ami-07d0cf3af28718ef8"   # Ubuntu Server 18.04 LTS
}

# set this value in secrets.tfvars (but do NOT commit that file)
variable "sshPubKey" {
    type = string
    default = ""
}

# set this value in secrets.tfvars (but do NOT commit that file)
variable "securedOrigins" {
    type = list
    default = []
}

variable "storage_size" {
    type = number
    default = -1
}
