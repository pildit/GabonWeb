# Terraform Readme

[Terraform](https://en.wikipedia.org/wiki/Terraform_(software)) is a tool enabling [Infrastructure-as-Code](https://en.wikipedia.org/wiki/Infrastructure_as_code): you *declare* what you want your environment to look like, and terraform brings your environment (or at least the part of which it is aware) into compliance. Terraform is to (cloud) infrastructure what Ansible is to '*configuration*' of that infrastructure.

## Code Structure

There are two directories:

* `./non-prod/`: This contains the dev and test environment. Historically, we've kept the 'production' instance here too. But that production instance will be replaced with the infrastructure defined in `./production/`. The old code has migrated from the root of the `./terraform/` into this directory. No (substantial) changes have been made
* `./production/`: This is all new code which defines the production environment

## Production Environment

The production environment is relatively simple and split over the different files that represent the AWS services:

* [`production/acm.tf`](production/acm.tf): This contains the `*.globalorigin.org` (wildcard) certificate (which has been imported into Terraform from AWS - do NOT delete this!) as well as the SSH key. The certificate is applied at the ALB (seel [`production/ec2.tf`](production/ec2.tf)), and *not* on the individual machines.
* [`production/ec2.tf`](production/ec2.tf): This contains 2 EC2 instances (one per subnet -and thus AZ- as defined in the `vpc.tf` file) as well as the Application Load Balancer (ALB) and its resources (listeners, rules, target groups, etc.).
* [`production/production.tf`](production/production.tf): This contains the provider information (i.e. that we're using AWS)
* [`production/rds.tf`](production/rds.tf): This contains the Production RDS PostgreSQL instance and any artifacts it needs (such as subnet groups and security groups).
* [`production/terraform.tfstate`](production/terraform.tfstate): This is a file managed by terraform, in 99% of the cases, you do not need to muck with it, but when you run terraform, you will need to commit the updated version or else things will go wrong.
* [`production/terraform.tfvars`](production/terraform.tfvars): This contains values for some of the variables declared in [`production/variables.tf`](production/variables.tf).
* [`production/variables.tf`](production/variables.tf): This contains the different variables that exist, they can be accessed through `var.variable_name` in the rest of the code.
* [`production/vpc.tf`](production/vpc.tf): This contains the definition of the VPC, the subnets inside that VPC (split over 2 availability zones/AZs), routing tables, internet gateways and (basic) security groups (+rules).

### Application Load Balancer

The ALB listens on port 443 (HTTPS), and uses a certificate. In other words, this is the place where SSL is applied (which is another reason why we use a wildcard cert for `*.globalorigin.org`). It *then* forwards the traffic to port 80 (HTTP - **not** HTTP*S*) on the machines serving those requests.

By default, all traffic is forwarded to the default target group (which is the one serving `gabon.globalorigin.org`).

The ALB listener (currently) has one rule: it listens for requests where the HTTP `Host` header is set to `gabon.globalorigin.org` and forwards those requests to the appropriate target group. Machines in the target group(s) are contacted over HTTP, and NOT over HTTPS.

In order to scale up, you can provision additional instances, and attach them to the `gabon.globalorigin.org` target group; you can choose to place them in any existing AZ or provision a new one.

## Provisioning the Infrastructure

Note (from `region` , defined in `variables.tf` ) that the production environment is being provisioned in the AWS Africa South (aka '[ `af-south-1` ](https://console.aws.amazon.com/ec2/v2/home?region=af-south-1)') region to enhance latency for the primary users in Gabon.

Use the [ `./run` ](./run) script to provision the infrastructure. This script is a (pretty dumb) wrapper around the terraform binary, which you will need to have installed on your device. When it invokes the terraform binary, this script automatically fills in the value for the `--var-file` parameter. This is a file that contains the values for some secrets. These secrets are listed in the [secrets](#secrets) section.

Apply the state as follows:

``` bash
(my_repo_root)/terraform/production $ ../run apply
```

When terraform is invoked, it combines all `*.tf` and `*.tfvars` files in the current directory and compares this combined, declared, desired state to what is up in the cloud (which it keeps track of through the `terraform.tfstate` file).
It will then output the plan of what it needs to do to bring the cloud into compliance with the declared state and then wait for you to give it permission to execute that plan.

**INSPECT THE PLAN CAREFULLY BEFORE CONFIRMING**: the plan will contain a listing of the actions it will perform, the three buckets of action types are:

* create: this creates new artifacts
* destroy: this destroys new artifacts
* update-in-place: this modifies an artifact without destroying it

While terraform attempts to do as many actions as 'update-in-place', some cannot be done as 'update-in-place' and thus require a destroy-and-recreate. Obviously, these are destructive. Be carefull with these!!!!!

You confirm execution of the plan by typing ' `yes` ' (and this is the *only* value that terraform will interpret as '*I may proceed*', ANY other values, such as 'YeS', 'YES', 'True', ... will be interpreted as 'do nothing and exit')

If you only want to see the plan, you can invoke the run command with the ' `plan` ' parameter instead of the ' `apply` ' one.

### Secrets

In order for the provisioning to succeed, you must provide secrets. When using the `./run` file, terraform will be invoked with a secrets file from the path `${HOME}/.terraform-secrets/gabontransportapp.secrets.tfvars` . Since this file contains secrets, it is obviously never committed (and outside of your repo to avoid an accidental commit). This secrets file follows the same syntax as a `.tfvars` file and must contain at least the following (note that you must, obviously, set these variables to the agreed-upon values or else 'bad stuff'(tm) will happen).

``` bash
# This should be the public part of the Gabon Deployment SSH key
# This key will be granted SSH access to any created instances
# in the production environment
sshGabonDeploymentKey="<Gabon Deployment SSH Key>"

# Not really used for production but must be specified nonetheless;
# make this the same as sshGabonDeploymentKey
sshPubKey="<Gabon Deployment SSH Key>"

# A list of CIDRs that you consider 'secure' and which will be granted
# permission to SSH into Web Front Ends (WebFEs)
# NOTE: There are only WebFE's at this point in time - there's an RDS
# instance as well but you need to be ON a WebFE in order to psql into
# it (or tunnel through a WebFE). We can investigate propping up a
# bastion server in the future
securedOrigins=[
    "A.B.C.D/E",
    , "F.G.H.I/J"
]

# The credentials of the root user on the PostgreSQL RDS instance
db_GabonWeb_username=""
db_GabonWeb_password=""
```

# TODO

* Provision the infrastructure
* Run Ansible against each one of the new WebFEs
* DNS: point `gabon.globalorigin.org` as a CNAME to the DNS name of the ALB
* Scale the machines to the right instance types
    * EC2 instances
    * RDS instance
* Use the ALB to also serve the tiles
    * Create instances for the tile server(s)
    * Set up ALB listener
    * Set up Target group with attachments
    * DNS: point `tile.globalorigin.org` as a CNAME to the DNS name of the ALB

## See Also

* Terraform
    - https://www.terraform.io/
    - https://www.terraform.io/downloads.html
* Wikipedia
    - https://en.wikipedia.org/wiki/Terraform_(software)
    - https://en.wikipedia.org/wiki/Infrastructure_as_code
