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
    esac
    shift
done;

echo "Creating Forest Resources database structure in database: ${DBNAME}";
psql --host localhost --dbname postgres --user ${USERNAME} < "./ForestResources.sql" | tee database.log;
popd 2>&1 1>/dev/null

