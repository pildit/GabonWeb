#!/usr/bin/env bash
pushd "$(dirname "${0}")" 1>/dev/null;

INVENTORY="./inventory.yml"
PLAYBOOK="./playbook.yml"
SHOW_DIFF="--diff"
VAULT_PASSWORD_FILE="${HOME}/.ansible-secrets/gabon.secrets"

while [ ! -z "${1}" ]; do
    case "${1}" in
        "--playbook"|"-p")
        shift
        PLAYBOOK="${1}"
        ;;
        "--inventory"|"-i")
        shift
        INVENTORY="${1}"
        ;;
        *)
            echo unknown option "${1}"
        ;;
    esac

    shift
done;

echo "Running ${PLAYBOOK} Ansible Playbook";
ansible-playbook -i "${INVENTORY}" --vault-password-file="${VAULT_PASSWORD_FILE}" "${PLAYBOOK}";

popd;
