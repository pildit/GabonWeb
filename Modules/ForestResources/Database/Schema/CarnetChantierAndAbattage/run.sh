#!/usr/bin/env bash
pushd "$(dirname ${0})" 2>&1 1>/dev/null

USERNAME="${USER}"
DBNAME="postgres"

while [ ! -z "${1}" ]; do
    case "${1}" in
        "--username"|"-U")
        shift
        USERNAME="${1}"
        ;;
        "--dbname"|"-D")
        shift
        DBNAME="${1}"
        ;;
        *)
            echo unknown option "${1}"
        ;;
    esac
    shift
done;

echo "Create structure for carnet d'abatage and chantier: ${DBNAME}";
psql --host localhost --dbname ${DBNAME} --user ${USERNAME} < "./schema.sql" | tee database.log;
popd 2>&1 1>/dev/null

