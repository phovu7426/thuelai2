#!/bin/bash

echo "=== FIXING ADMIN PRICING SYSTEM ==="
echo ""

echo "1. Clearing caches..."
php artisan route:clear
php artisan config:clear
php artisan view:clear
php artisan cache:clear

echo ""
echo "2. Running migrations..."
php artisan migrate

echo ""
echo "3. Dumping autoload..."
composer dump-autoload

echo ""
echo "4. Running seeder..."
php artisan db:seed --class=PricingSeeder

echo ""
echo "5. Checking routes..."
php artisan route:list | grep "distance-tiers\|pricing-rules\|pricing-tiers"

echo ""
echo "=== MANUAL CHECKS ==="
echo "1. Check if user has 'access_driver_services' permission"
echo "2. Try accessing:"
echo "   - /admin/driver/distance-tiers"
echo "   - /admin/driver/pricing-rules" 
echo "   - /admin/driver/pricing-tiers"
echo ""
echo "3. Check browser console for JS errors"
echo "4. Check Laravel logs: storage/logs/laravel.log"
echo ""
echo "Fix completed!"
