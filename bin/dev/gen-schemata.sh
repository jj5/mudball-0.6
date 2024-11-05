#!/bin/bash

main() {

  set -euo pipefail;

  cd "$( dirname "$0" )";

  local rel_path='../../../../src/gen/schemata/';

  if [ ! -d "$rel_path" ]; then

    exit 0;

  fi;

  local target="$( realpath $rel_path )";

  if [ ! -d "$target" ]; then

    echo "warning: schemata directory not found, skipping schema generation." >&2;

    exit 1;

  fi;

  #rm "$target"/schemata.dat || true;

  php gen-schemata.php "$target" "$@";

}

main "$@";
