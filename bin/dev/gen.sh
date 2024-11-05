#!/bin/bash

main() {

  set -euo pipefail;

  cd "$( dirname "$0" )/../..";

  #run ./gen-dal.sh;

  #run ./gen-schemata.sh;

  bin/dev/gen-errors.php > src/gen/error/errors.php;
  bin/dev/gen-errors-bash.php > src/gen/error/errors.sh;

}

run() {

  echo running "$@";

  "$@";

}

main "$@";
