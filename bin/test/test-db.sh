#!/bin/bash

main() {

  set -euo pipefail

  local DB_NAME="mudball_test";

  sudo /home/jj5/bin/backup-mysql.sh "$DB_NAME";

  sudo mariadb -e "drop database $DB_NAME;"

  sudo mariadb -e "create database $DB_NAME;"

}

main "$@";
