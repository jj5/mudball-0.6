#!/bin/bash

main() {

  set -euo pipefail;

  local DB_NAME="mudball_test";
  local script_dir="$( cd "$(dirname "${BASH_SOURCE[0]}")" && pwd )";

  sudo /home/jj5/bin/backup-mysql.sh "$DB_NAME";

  sudo mariadb -e "drop database $DB_NAME;"

  sudo mariadb -e "create database $DB_NAME;"

  php "$script_dir/test-db.php"

}

main "$@";
