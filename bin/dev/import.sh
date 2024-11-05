#!/bin/bash

main() {

  set -euo pipefail;

  cd "$( dirname "$0" )";

  run ./import-country-code.sh;

  run ./import-uri-scheme.sh;

}

run() {

  echo running "$@";

  "$@";

}

main "$@";
