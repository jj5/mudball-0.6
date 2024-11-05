#!/bin/bash

set -euo pipefail

ext/mudball/bin/db-drop.php
ext/mudball/bin/db-create.php
ext/mudball/bin/db-upgrade.php
