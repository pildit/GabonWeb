Work in Progress

@bogdflor and @constantin.dinu please take a look at this and find some time to walk through it first by yourself and then with me.

This uses ansible (https://en.wikipedia.org/wiki/Ansible_(software) and https://www.ansible.com/; this runs on Windows too) to bring the servers into compliance and to deploy the application. You will have to install ansible on your machine.

Look at the `./ansible` sub-directory which is where all the activity is:

**NOTE**: because of hard coded items (in e.g. `config.inc.php`), this code is currently *'broken'* (i.e. it only works if all hostnames are exactly as hard-coded, which is a bug)

# Deploying

## Running the playbook

This is the advised way of doing a deployment

1. Ensure you have ansible installed for your platform
1. Ensure you have a directory called `${HOME}/.ansible-secrets/`
    1. In this directory, create a file `gabon.secrets` that contains the password to the vault
1. Set the commit or branch to sync to in the inventory app
1. Run the run.sh script without any parameters, this file will pick up these secrets to unlock the vault(s) at runtime
    * or on windows, invoke `ansible-playbook -i "inventory.yml" --vault-password-file="path-to-gabon.secrets" "playbook.yml"`

## Updating the website from the machine itself

If all you're doing is pulling in new changes (and not any changes to the configuration of the website), then go to the repository's location, and execute a `git pull` (but make sure that you have your GitLab credentials on that machine, or things will fail)

# Roles
There are three roles I created (which should be thought of as being overlaid in that fashion):
1. debian: a machine that's a plain debian
1. apache: a machine that's supposed to be running the apache2 web server
1. website: a machine that's supposed to be running the customer-specific website

## Debian

This role is defined in the `./ansible/debian` galaxy directory; the important parts here are `./tasks/main.yml` and `./vars/main.yml`.
This role does nothing else but ensure that the following packages are installed on it and on the latest version (defined as `baseline_packages` in `./debian/vars/main.yml`):
- aptitude
- git
- nfs-common
- python-apt
- software-properties-common
- tmux
- unattended-upgrades
- wget
- iptables-persistent

## Apache

This role is defined in the `./ansible/apache` galaxy directory; again, the important parts here are `./tasks/main.yml` and `./vars/main.yml`.
This role ensures apache2 is installed and that it is enabled and running.

## Website

This role defines a deployed website and it is the most important aspect of this merge request. The role is defined in `./ansible/website/` galaxy directory. Here's how to reason over the code (note: all paths are relative to this galaxy directory unless otherwise noted):

The `./tasks/main.yaml` is the file that contains all the steps that ansible will perform to deploy the website and which references the files in the other directories:
1. Perform SSH configuration so that talking to the repo (cloning and pulling) will work (because we authenticate with SSH)
    1. Ensure the directory ${HOME}/.ssh with the right permissions
    1. Deploy the ***private*** SSH key for the user 'Gabon.Deployment@eia-global.org' (which is a GitLab user) to this account
        * This file is pulled from `./files/gabon.deployment@eia-global.org`, which is an encrypted vault file (see 'Running the Playbook' on how to provide the password to that vault file)
    1. Deploy the *public* SSH key for the user 'Gabon.Deployment@eia-global.org' (which is a GitLab user) to this account
        * This file is pulled from `./files/gabon.deployment@eia-global.org.pub`, which is an encrypted vault file (see 'Running the Playbook' on how to provide the password to that vault file)
    1. Add a configuration entry to the user's `${HOME}/.ssh/config` file to make sure that the (ssh) host gabon.gitlab.com is correctly configured (if this isn't present yet)
        * Basically, this created an entry in the user's ssh config file so that when you use gabon.gitlab.com, it talks to gitlab.com with using the private key we've just step up in the steps above.
1. Create a clone of the repository (this is why we set up the SSH configuration first)
    1. This clones the repo from GitLab (using gabon.gitlab.com - and thus the SSH configuration we set up to use the particular SSH key)
    1. It checks out the commit (or branch) to deploy
        * This is defined as the variable `WEBSITE_DEPLOYMENT_COMMIT` in the `inventory.yml` file located in the ansible root
    1. It ensures that the permissions on the repository are set
1. Configure Apache to be able to serve the cloned repo as a website
    1. Create the directory in which the logs (`access.log` and `error.log`) will be produced for this website; this directory is defined as the combination of `apache_log_dir` (see `./vars/main.yml`) and `WEBSITE_DOMAIN` (see `${root}/inventory.yml`)
        * e.g. if WEBSITE_DOMAIN is set to `www.domain.com`, then the logging directory will be `/var/log/apache2/www.domain.com`.
        * NOTE: we do not merge these logs with the logs from another host
    1. Set up logrotation for the generated logs by transforming the `./templates/domain.logrotate.j2` file into `/etc/logrotate.d/apache2-WEBSITE_DOMAIN.conf` (note: `WEBSITE_DOMAIN` will be replaced with the actual domain - as defined in the inventory file for this host). During this transformation, any j2 variable (those encassed between '`{{ ... }}`') will be replaced with their runtime value. There is only 1 substitution:
        * `WEBSITE_DOMAIN`: from the inventory file
    1. Deploy the host configuration file by transforming the template into `/etc/apache2/sites-available/WEBSITE_DOMAIN` (again, with the substitution made for the domain). The template is located in `./templates/available-sites.domain.j2`. There are 2 substitutions:
        * `WEBSITE_DOMAIN`: from the inventory file
        * `www_document_root`: from `./vars/main.yml`
        * NOTE: this will also trigger a handler to *reload* apache (as defined in `./handlers/main.yml`) if this action caused in changes on ths system (if this action did not cause changes to the system, then this handler is skipped as it isn't needed)
    1. Enable the new domain/host using a2ensite
        * NOTE: this will also trigger a handler to *reload* apache (as defined in `./handlers/main.yml`) if this action caused in changes on ths system (if this action did not cause changes to the system, then this handler is skipped as it isn't needed)
