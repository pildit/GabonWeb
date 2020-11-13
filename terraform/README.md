# Terraform Readme

[Terraform](https://en.wikipedia.org/wiki/Terraform_(software)) is a tool enabling [Infrastructure-as-Code](https://en.wikipedia.org/wiki/Infrastructure_as_code): you *declare* what you want your environment to look like, and terraform brings your environment (or at least the part of which it is aware) into compliance. Terraform is to (cloud) infrastructure what Ansible is to '*configuration*' of that infrastructure.

## Code Structure

There are two directories:

* `./non-prod/`: This contains the dev and test environment. Historically, we've kept the 'production' instance here too. But that production instance will be replaced with the infrastructure defined in `./prod/`. The old code has migrated from the root of the `./terraform/` into this directory. No (substantial) changes have been made
* `./prod/`: This is all new code which defines the production environment

### Production Environment

## Provisioning the Infrastructure

Use the [`./run`](./run) script to provision the infrastructure. This script is a (pretty dumb) wrapper around the terraform binary, which you will need to have installed on your device. When it invokes the terraform binary, this script automatically fills in the value for the `--var-file` parameter. This is a file that contains the values for some secrets. These secrets are listed in the [secrets](#secrets) section.

### Secrets

In order for the provisioning to succeed, you must provide secrets. When using the `./run` file, terraform will be invoked with a secrets file from the path `${HOME}/.terraform-secrets/gabontransportapp.secrets.tfvars`. Since this file contains secrets, it is obviously never committed (and outside of your repo to avoid an accidental commit). This secrets file follows the same syntax as a `.tfvars` file and must contain at least the following (note that you must, obviously, set these variables to the agreed-upon values or else 'bad stuff'(tm) will happen).

```bash
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


## See Also

* Terraform
    * https://www.terraform.io/
    * https://www.terraform.io/downloads.html
* Wikipedia
    * https://en.wikipedia.org/wiki/Terraform_(software)
    * https://en.wikipedia.org/wiki/Infrastructure_as_code
