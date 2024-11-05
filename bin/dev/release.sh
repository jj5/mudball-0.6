#!/bin/bash

main() {

  set -euo pipefail

  cd "$( dirname "$0" )";

  run ./gen.sh;
  run ./import.sh;

  cd ../../;

  run svnman release;

}

run() {

  echo running "$@";

  "$@";

}

main "$@";
