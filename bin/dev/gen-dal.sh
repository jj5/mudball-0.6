#!/bin/bash

main() {

  set -euo pipefail;

  cd "$( dirname "$0" )";

  local rel_path='../../../../src/gen/dal/';

  if [ ! -d "$rel_path" ]; then

    exit 0;

  fi;

  local target="$( realpath $rel_path )";

  if [ ! -d "$target" ]; then

    echo "warning: DAL directory not found, skipping DAL generation." >&2;

    exit 1;

  fi;

  #rm "$target"/*.php || true;

  php gen-dal.php "$target" "$@";

}

main "$@";
