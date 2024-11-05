#!/bin/bash

main() {

  set -euo pipefail;

  cd "$( dirname "$0" )"

  local target="$( realpath ../../src/gen/country-code/ )";

  test -d "$target";

  #rm "$target"/*.php || true;

  php import-country-code.php "$target" "$@";

}

main "$@";
