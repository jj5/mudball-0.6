#!/bin/bash

main() {

  set -euo pipefail;

  cd "$( dirname "$0" )";

  local target="$( realpath ../../src/gen/uri-scheme/ )";

  test -d "$target";

  #rm "$target"/*.php || true;

  php import-uri-scheme.php "$target" "$@";

}

main "$@";
