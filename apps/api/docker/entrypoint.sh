#!/bin/sh
set -e

# Start PHP-FPM in background
php-fpm -D

# Start WebSocket server in background
php bin/console app:start-websocket-server > /var/log/websocket.log 2>&1 &

# Start Caddy in foreground
exec caddy run --config /etc/caddy/Caddyfile --adapter caddyfile 