# Git Hooks Setup Script for Windows
# Run this script to install Git hooks for the project

Write-Host ""
Write-Host "🔧 Rajablindvan Vehicle Dashboard - Git Hooks Setup" -ForegroundColor Cyan
Write-Host "=" * 60 -ForegroundColor Cyan
Write-Host ""

# Check if .githooks directory exists
if (!(Test-Path ".githooks")) {
    Write-Host "❌ Error: .githooks directory not found!" -ForegroundColor Red
    Write-Host "Please run this script from the project root directory." -ForegroundColor Yellow
    exit 1
}

# Check if .git directory exists
if (!(Test-Path ".git")) {
    Write-Host "❌ Error: Not a Git repository!" -ForegroundColor Red
    Write-Host "Please initialize Git first: git init" -ForegroundColor Yellow
    exit 1
}

Write-Host "📂 Installing Git hooks..." -ForegroundColor Green
Write-Host ""

# Create .git/hooks directory if not exists
if (!(Test-Path ".git/hooks")) {
    New-Item -ItemType Directory -Path ".git/hooks" -Force | Out-Null
}

# Copy hooks
$hooks = @("pre-commit", "prepare-commit-msg", "post-commit")
$installedCount = 0

foreach ($hook in $hooks) {
    $sourcePath = ".githooks\$hook"
    $targetPath = ".git\hooks\$hook"
    
    if (Test-Path $sourcePath) {
        Copy-Item $sourcePath $targetPath -Force
        Write-Host "  ✅ Installed: $hook" -ForegroundColor Green
        $installedCount++
    } else {
        Write-Host "  ⚠️  Warning: $hook not found in .githooks/" -ForegroundColor Yellow
    }
}

Write-Host ""
Write-Host "=" * 60 -ForegroundColor Cyan
Write-Host "✨ Installation Complete!" -ForegroundColor Green
Write-Host ""
Write-Host "📊 Summary:" -ForegroundColor Cyan
Write-Host "  - Installed $installedCount hook(s)" -ForegroundColor White
Write-Host "  - Location: .git/hooks/" -ForegroundColor White
Write-Host ""

Write-Host "📝 Installed Hooks:" -ForegroundColor Cyan
Write-Host "  1. pre-commit       - Validates code before commit" -ForegroundColor White
Write-Host "  2. prepare-commit-msg - Formats commit messages" -ForegroundColor White
Write-Host "  3. post-commit      - Shows commit summary" -ForegroundColor White
Write-Host ""

Write-Host "💡 Tips:" -ForegroundColor Cyan
Write-Host "  - To skip hooks temporarily: git commit --no-verify" -ForegroundColor White
Write-Host "  - To disable a hook: remove it from .git/hooks/" -ForegroundColor White
Write-Host "  - For more info: see .githooks/README.md" -ForegroundColor White
Write-Host ""

Write-Host "🎉 You're all set! Happy coding!" -ForegroundColor Green
Write-Host ""

# Test if hooks are working
Write-Host "🧪 Testing hooks..." -ForegroundColor Cyan
$hookTest = Test-Path ".git/hooks/pre-commit"
if ($hookTest) {
    Write-Host "  ✅ Hooks are ready to use!" -ForegroundColor Green
} else {
    Write-Host "  ⚠️  Warning: Hook test failed" -ForegroundColor Yellow
}
Write-Host ""
