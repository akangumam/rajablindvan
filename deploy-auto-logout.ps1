################################################################################
# Auto Logout Feature - Deployment Script (Windows)
# Version: 2.1.0
# Description: Deploy auto-logout feature to production hosting
################################################################################

Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "  Auto Logout Deployment Script v2.1.0" -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""

# Check if we're in the project root
if (-not (Test-Path "artisan")) {
    Write-Host "Error: Not in Laravel project root!" -ForegroundColor Red
    Write-Host "Please run this script from your project root directory."
    exit 1
}

Write-Host "Step 1: Verifying files..." -ForegroundColor Yellow
Write-Host "-------------------------------------------"

# Files to check
$filesToCheck = @(
    "public\js\auto-logout.js",
    "resources\views\layouts\drivvo.blade.php",
    "resources\views\auth\login.blade.php"
)

$missingFiles = 0
foreach ($file in $filesToCheck) {
    if (Test-Path $file) {
        Write-Host "✓ $file exists" -ForegroundColor Green
    } else {
        Write-Host "✗ $file NOT FOUND" -ForegroundColor Red
        $missingFiles++
    }
}

if ($missingFiles -gt 0) {
    Write-Host "Error: $missingFiles file(s) missing!" -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "Step 2: Checking auto-logout.js version..." -ForegroundColor Yellow
Write-Host "-------------------------------------------"

# Check version
$content = Get-Content "public\js\auto-logout.js" -Raw
if ($content -match "2.1.0") {
    Write-Host "✓ auto-logout.js is version 2.1.0" -ForegroundColor Green
} else {
    Write-Host "⚠ auto-logout.js might be outdated" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "Step 3: Git status..." -ForegroundColor Yellow
Write-Host "-------------------------------------------"

# Check if git repository
if (Test-Path ".git") {
    Write-Host "Modified files:"
    git status --short public/js/auto-logout.js
    git status --short resources/views/layouts/drivvo.blade.php
    git status --short resources/views/auth/login.blade.php

    Write-Host ""
    $commit = Read-Host "Do you want to commit and push these changes? (y/n)"

    if ($commit -eq "y" -or $commit -eq "Y") {
        Write-Host "Committing changes..." -ForegroundColor Cyan
        git add public/js/auto-logout.js
        git add resources/views/layouts/drivvo.blade.php
        git add resources/views/auth/login.blade.php
        git commit -m "Deploy auto-logout v2.1.0 - Fix navigation issue"

        Write-Host ""
        $push = Read-Host "Push to remote? (y/n)"

        if ($push -eq "y" -or $push -eq "Y") {
            git push
            Write-Host "✓ Changes pushed to remote" -ForegroundColor Green
        }
    }
} else {
    Write-Host "⚠ Not a git repository" -ForegroundColor Yellow
    Write-Host "You'll need to upload files manually via FTP"
}

Write-Host ""
Write-Host "Step 4: Clear Laravel cache..." -ForegroundColor Yellow
Write-Host "-------------------------------------------"

try {
    php artisan cache:clear
    Write-Host "✓ Cache cleared" -ForegroundColor Green

    php artisan config:clear
    Write-Host "✓ Config cache cleared" -ForegroundColor Green

    php artisan view:clear
    Write-Host "✓ View cache cleared" -ForegroundColor Green

    php artisan route:clear
    Write-Host "✓ Route cache cleared" -ForegroundColor Green
} catch {
    Write-Host "⚠ Error running artisan commands" -ForegroundColor Yellow
    Write-Host "You may need to run them manually"
}

Write-Host ""
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "  Deployment Summary" -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Files updated:"
Write-Host "  - public\js\auto-logout.js (v2.1.0)"
Write-Host "  - resources\views\layouts\drivvo.blade.php"
Write-Host "  - resources\views\auth\login.blade.php"
Write-Host ""
Write-Host "Local deployment complete!" -ForegroundColor Green
Write-Host ""
Write-Host "Next steps for HOSTING deployment:" -ForegroundColor Yellow
Write-Host ""
Write-Host "1. If using Git on hosting:"
Write-Host "   ssh user@yourserver"
Write-Host "   cd /path/to/app"
Write-Host "   git pull origin main"
Write-Host "   php artisan cache:clear"
Write-Host "   php artisan view:clear"
Write-Host ""
Write-Host "2. If using FTP:"
Write-Host "   Upload these files:"
Write-Host "   - public\js\auto-logout.js → public/js/"
Write-Host "   - resources\views\layouts\drivvo.blade.php → resources/views/layouts/"
Write-Host "   - resources\views\auth\login.blade.php → resources/views/auth/"
Write-Host ""
Write-Host "3. After deployment:"
Write-Host "   - Clear browser cache (Ctrl + Shift + Delete)"
Write-Host "   - Hard refresh (Ctrl + F5)"
Write-Host "   - Test navigation between pages"
Write-Host "   - Test tab close still triggers logout"
Write-Host ""
Write-Host "For more details, see: AUTO_LOGOUT_DEPLOYMENT.md" -ForegroundColor Yellow
Write-Host ""
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Press any key to continue..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
