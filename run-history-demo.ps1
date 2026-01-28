# Script to run History Demo Seeder

Write-Host "Running History Demo Seeder..." -ForegroundColor Green
Write-Host ""

# Run migration first if not yet
Write-Host "Checking migrations..." -ForegroundColor Yellow
php artisan migrate --force

Write-Host ""
Write-Host "Seeding demo data for 2 vehicles..." -ForegroundColor Yellow
php artisan db:seed --class=HistoryDemoSeeder

Write-Host ""
Write-Host "Demo data created successfully!" -ForegroundColor Green
Write-Host ""
Write-Host "You can now:" -ForegroundColor Cyan
Write-Host "1. Open web dashboard: http://localhost/vehicle-dashboard/public/history" -ForegroundColor White
Write-Host "2. Select 'Toyota Avanza - B 1234 XYZ' or 'Honda Jazz - B 5678 ABC'" -ForegroundColor White
Write-Host "3. View timeline with transaction history" -ForegroundColor White
Write-Host ""
Write-Host "For mobile app testing:" -ForegroundColor Cyan
Write-Host "1. Update API base URL in lib/core/config/api_config.dart" -ForegroundColor White
Write-Host "2. Login with demo credentials" -ForegroundColor White
Write-Host "3. Navigate to History tab" -ForegroundColor White
