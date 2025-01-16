#!/bin/sh
set -e

echo "Starting entrypoint script..."

# Start PHP-FPM in background
php-fpm -D

# Wait for Clickhouse to be ready
echo "Waiting for Clickhouse to be ready..."
until nc -z -v -w30 $CLICKHOUSE_HOST 8123
do
  echo "Waiting for Clickhouse..."
  sleep 5
done

# Run Clickhouse migrations with verbose output
echo "Running Clickhouse migrations..."
php bin/console clickhouse-migrations:migrate --verbose || {
    echo "Migration failed. Check the logs for more details."
    exit 1
}

# Start WebSocket server in background
echo "Starting WebSocket server..."
php bin/console app:start-websocket-server --verbose

# Start Caddy in foreground
exec caddy run --config /etc/caddy/Caddyfile --adapter caddyfile 