#!/bin/bash
#
# Setup Git Hooks for Server Deployment
# Run this once on the server to enable automatic deployment
#

echo "🔧 Setting up Git Hooks for automatic deployment..."

# Get the repository root
REPO_ROOT=$(git rev-parse --show-toplevel)

if [ ! -d "$REPO_ROOT" ]; then
    echo "❌ Error: Not in a git repository"
    exit 1
fi

# Create hooks directory if not exists
HOOKS_DIR="$REPO_ROOT/.git/hooks"
CUSTOM_HOOKS_DIR="$REPO_ROOT/.git-hooks"

if [ ! -d "$HOOKS_DIR" ]; then
    echo "❌ Error: Git hooks directory not found"
    exit 1
fi

# Copy post-merge hook
if [ -f "$CUSTOM_HOOKS_DIR/post-merge" ]; then
    echo "📝 Installing post-merge hook..."
    cp "$CUSTOM_HOOKS_DIR/post-merge" "$HOOKS_DIR/post-merge"
    chmod +x "$HOOKS_DIR/post-merge"
    echo "✅ post-merge hook installed"
else
    echo "⚠️  Warning: post-merge hook file not found in .git-hooks/"
fi

echo ""
echo "✅ Git hooks setup complete!"
echo ""
echo "📋 What happens now:"
echo "   - After every 'git pull', the following will run automatically:"
echo "     • composer install (if composer.lock changed)"
echo "     • php artisan config:cache"
echo "     • php artisan route:cache"
echo "     • php artisan view:cache"
echo "     • chmod storage permissions"
echo ""
echo "🎉 You can now just run: git pull"
echo ""
