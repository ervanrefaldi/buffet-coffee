#!/bin/sh
set -e

echo "🚀 Starting Buffet Coffee application..."

if [ -z "$APP_KEY" ]; then
  echo "❌ APP_KEY is not set. Set it in Cloud Run env vars."
  exit 1
fi

# Optional sanity logs (safe, no secrets exposed)
echo "APP_ENV=${APP_ENV:-}"
echo "APP_DEBUG=${APP_DEBUG:-}"
echo "APP_URL=${APP_URL:-}"

# Run migrations (optional, can be disabled via env var)
if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
  echo "📦 Running database migrations..."
  php artisan migrate --force
fi

# Cache config for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ensure storage link exists
php artisan storage:link --force

echo "✅ Application ready!"
exec /usr/bin/supervisord -c /etc/supervisord.conf
