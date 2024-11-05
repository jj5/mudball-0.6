#!/bin/bash

main() {

  cd "$(dirname "$0")/../..";

  [ -d src/gen/error ] || { echo "src/gen/error not found."; exit 1; }

  bin/dev/gen-errors.php > src/gen/error/errors.php;
  bin/dev/gen-errors-bash.php > src/gen/error/errors.sh;

  source src/gen/error/errors.sh;

  while IFS='= ' read -r const code skip; do

    run_test 'code' "$code" "$const";

  done < src/gen/error/errors.sh;

  run_test 'error'      "$EXIT_ERROR"       EXIT_ERROR;

  run_test 'exception'  "$EXIT_EXCEPTION"   EXIT_EXCEPTION;

  run_test 'assertion'  "$EXIT_ASSERT"      EXIT_ASSERT;

  run_test 'string'     "$EXIT_ABORT"       EXIT_ABORT;

  echo "now we run quiet tests, there should be no output.";

  while IFS='= ' read -r const code skip; do

    run_test 'quiet' "$code" "$const";

  done < src/gen/error/errors.sh;

}

run_test() {

  local type="$1";
  local code="$2";
  local const="$3";

  # 2024-02-09 jj5 - if we're passed an invalid code just skip the test, it will be comments and such from the bash script.

  [ -z "$code" ] && return 0;

  if [[ "$code" =~ ^-?[0-9]+$ ]]; then

    # 2024-02-09 jj5 - the code is an integer

    true;

  elif [[ "$const" = '#' ]]; then

    # 2024-02-09 jj5 - the code is a comment

    return 0;

  else

    echo "invalid code: '$code' for '$const'.";
    
    exit $EXIT_BAD_VALUE;

  fi

  if [ "$type" != 'quiet' ]; then

    echo;
    echo $const: $code

  fi

  bin/test/test-gen-error.php "$type" "$code" "$const";

  local error_level="$?";

  if [ "$error_level" = "$code" ]; then

    echo "test for '$const' passed.";

  else
  
    echo "test for '$const' failed with error level '$error_level'.";
    
    exit $EXIT_TEST_FAILED;

  fi

}

main "$@";
