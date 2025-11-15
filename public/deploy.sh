#!/bin/bash
cd /home/elitmsbx/mubasher-local-backend
git pull origin main

# Check if the git pull was successful
if [ $? -eq 0 ]; then
    # Run the Laravel optimization commands
    # php artisan optimize
    # php artisan config:cache
    # php artisan route:cache
    # php artisan view:cache
    # php artisan migrate --seed
else
    echo "Git pull failed."
    exit 1
fi