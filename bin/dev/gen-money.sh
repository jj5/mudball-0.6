#!/bin/bash

main() {

  set -euo pipefail;

  cd "$( dirname "$0" )";

  local rel_path='../../src/gen/money/';

  if [ ! -d "$rel_path" ]; then

    echo "warning: money directory not found, skipping money generation." >&2;

    exit 0;

  fi;

  local target="$( realpath $rel_path )";

  if [ ! -d "$target" ]; then

    echo "warning: money directory not found, failing money generation." >&2;

    exit 1;

  fi;

  php gen-money.php "$@" > "$target"/money.php;

}

main "$@";
