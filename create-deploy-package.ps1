# Quick Deployment Package
# Exclude heavy folders - install via composer di server

Write-Host "Creating deployment package (without node_modules & vendor)..." -ForegroundColor Cyan

$source = "E:\WebProgramming\rajablindvan\vehicle-dashboard"
$destination = "E:\WebProgramming\rajablindvan\rajablindvan-deploy.zip"

# Folders to exclude
$excludeFolders = @(
    "node_modules",
    "vendor",
    ".git",
    "storage\logs",
    "storage\framework\cache",
    "storage\framework\sessions",
    "storage\framework\views",
    "tests",
    "*.log"
)

Write-Host "Calculating size..." -ForegroundColor Yellow

# Create temp folder
$tempFolder = "E:\WebProgramming\rajablindvan\temp-deploy"
if (Test-Path $tempFolder) {
    Remove-Item $tempFolder -Recurse -Force
}
New-Item -ItemType Directory -Path $tempFolder | Out-Null

# Copy files (exclude heavy folders)
Write-Host "Copying essential files..." -ForegroundColor Yellow
Copy-Item -Path "$source\*" -Destination $tempFolder -Recurse -Exclude $excludeFolders -Force

# Copy important dot files
Copy-Item -Path "$source\.env.example" -Destination $tempFolder -Force -ErrorAction SilentlyContinue
Copy-Item -Path "$source\.env.production" -Destination $tempFolder -Force -ErrorAction SilentlyContinue
Copy-Item -Path "$source\.htaccess" -Destination "$tempFolder\public\" -Force -ErrorAction SilentlyContinue

# Create vendor placeholder
New-Item -ItemType Directory -Path "$tempFolder\vendor" -Force | Out-Null
"Run: composer install --optimize-autoloader --no-dev" | Out-File "$tempFolder\vendor\README.txt"

Write-Host "Compressing..." -ForegroundColor Yellow
Compress-Archive -Path "$tempFolder\*" -DestinationPath $destination -Force

# Cleanup
Remove-Item $tempFolder -Recurse -Force

$size = [math]::Round((Get-Item $destination).Length / 1MB, 2)
Write-Host "✅ Done! Size: $size MB" -ForegroundColor Green
Write-Host "Location: $destination" -ForegroundColor Cyan
Write-Host ""
Write-Host "IMPORTANT: Run 'composer install' di server!" -ForegroundColor Red
