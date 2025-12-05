#!/bin/bash

################################################################################
# Auto Logout Feature - Deployment Script
# Version: 2.1.0
# Description: Deploy auto-logout feature to production hosting
################################################################################

echo "========================================="
echo "  Auto Logout Deployment Script v2.1.0"
echo "========================================="
echo ""

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if we're in the project root
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: Not in Laravel project root!${NC}"
    echo "Please run this script from your project root directory."
    exit 1
fi

echo "Step 1: Verifying files..."
echo "-------------------------------------------"

# Check if files exist
FILES_TO_CHECK=(
    "public/js/auto-logout.js"
    "resources/views/layouts/drivvo.blade.php"
    "resources/views/auth/login.blade.php"
)

MISSING_FILES=0
for file in "${FILES_TO_CHECK[@]}"; do
    if [ -f "$file" ]; then
        echo -e "${GREEN}✓${NC} $file exists"
    else
        echo -e "${RED}✗${NC} $file NOT FOUND"
        MISSING_FILES=$((MISSING_FILES + 1))
    fi
done

if [ $MISSING_FILES -gt 0 ]; then
    echo -e "${RED}Error: $MISSING_FILES file(s) missing!${NC}"
    exit 1
fi

echo ""
echo "Step 2: Checking auto-logout.js version..."
echo "-------------------------------------------"

# Check version in auto-logout.js
if grep -q "2.1.0" public/js/auto-logout.js; then
    echo -e "${GREEN}✓${NC} auto-logout.js is version 2.1.0"
else
    echo -e "${YELLOW}⚠${NC} auto-logout.js might be outdated"
fi

echo ""
echo "Step 3: Git status..."
echo "-------------------------------------------"

# Check if files are tracked by git
if [ -d ".git" ]; then
    echo "Modified files:"
    git status --short public/js/auto-logout.js
    git status --short resources/views/layouts/drivvo.blade.php
    git status --short resources/views/auth/login.blade.php

    echo ""
    read -p "Do you want to commit and push these changes? (y/n) " -n 1 -r
    echo ""

    if [[ $REPLY =~ ^[Yy]$ ]]; then
        echo "Committing changes..."
        git add public/js/auto-logout.js
        git add resources/views/layouts/drivvo.blade.php
        git add resources/views/auth/login.blade.php
        git commit -m "Deploy auto-logout v2.1.0 - Fix navigation issue"

        echo ""
        read -p "Push to remote? (y/n) " -n 1 -r
        echo ""

        if [[ $REPLY =~ ^[Yy]$ ]]; then
            git push
            echo -e "${GREEN}✓${NC} Changes pushed to remote"
        fi
    fi
else
    echo -e "${YELLOW}⚠${NC} Not a git repository"
    echo "You'll need to upload files manually via FTP"
fi

echo ""
echo "Step 4: Clear Laravel cache..."
echo "-------------------------------------------"

if command -v php &> /dev/null; then
    php artisan cache:clear
    echo -e "${GREEN}✓${NC} Cache cleared"

    php artisan config:clear
    echo -e "${GREEN}✓${NC} Config cache cleared"

    php artisan view:clear
    echo -e "${GREEN}✓${NC} View cache cleared"

    php artisan route:clear
    echo -e "${GREEN}✓${NC} Route cache cleared"
else
    echo -e "${YELLOW}⚠${NC} PHP not found in PATH"
    echo "You'll need to run artisan commands manually"
fi

echo ""
echo "========================================="
echo "  Deployment Summary"
echo "========================================="
echo ""
echo "Files updated:"
echo "  - public/js/auto-logout.js (v2.1.0)"
echo "  - resources/views/layouts/drivvo.blade.php"
echo "  - resources/views/auth/login.blade.php"
echo ""
echo -e "${GREEN}Local deployment complete!${NC}"
echo ""
echo "Next steps for HOSTING deployment:"
echo ""
echo "1. If using Git on hosting:"
echo "   ssh user@yourserver"
echo "   cd /path/to/app"
echo "   git pull origin main"
echo "   php artisan cache:clear"
echo "   php artisan view:clear"
echo ""
echo "2. If using FTP:"
echo "   Upload these files:"
echo "   - public/js/auto-logout.js → public/js/"
echo "   - resources/views/layouts/drivvo.blade.php → resources/views/layouts/"
echo "   - resources/views/auth/login.blade.php → resources/views/auth/"
echo ""
echo "3. After deployment:"
echo "   - Clear browser cache (Ctrl + Shift + Delete)"
echo "   - Hard refresh (Ctrl + F5)"
echo "   - Test navigation between pages"
echo "   - Test tab close still triggers logout"
echo ""
echo -e "${YELLOW}For more details, see: AUTO_LOGOUT_DEPLOYMENT.md${NC}"
echo ""
echo "========================================="
