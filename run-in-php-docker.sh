#!/usr/bin/env bash

set -euo pipefail
IFS=$'\n\t'

args="$@"
docker exec -ti phphsite_phph-php-fpm_1 bash -c "cd /app; $args"
