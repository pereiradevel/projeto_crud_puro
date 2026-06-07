#!/bin/bash
set -e

host="${DB_HOST:-db}"
port="${DB_PORT:-3306}"

echo "Waiting for MySQL at $host:$port..."
until mysqladmin ping -h "$host" -P "$port" --silent; do
  sleep 1
done

exec docker-php-entrypoint "$@"
