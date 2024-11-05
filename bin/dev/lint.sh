#!/bin/bash

main() {

  set -euo pipefail;

  cd "$( dirname "$0" )";

  php lint.php "$@";

}

main "$@";
