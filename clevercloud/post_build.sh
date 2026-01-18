#!/bin/bash

# Run Laravel migrations
php artisan migrate --force

# Clear and cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Deployment complete!"
