#!/bin/sh
# Linux / macOS launcher (needs php-cli with pdo_sqlite)
cd "$(dirname "$0")" && echo "Open http://localhost:8000" && php -S localhost:8000
