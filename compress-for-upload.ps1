# Script untuk compress project tanpa folder yang tidak perlu
# Jalankan: .\compress-for-upload.ps1

Write-Host "Compressing Rajablindvan project..." -ForegroundColor Green

# Hapus zip lama jika ada
if (Test-Path "rajablindvan.zip") {
    Remove-Item "rajablindvan.zip" -Force
    Write-Host "Removed old zip file" -ForegroundColor Yellow
}

# Folder dan file yang akan di-exclude
$excludeItems = @(
    "node_modules",
    ".git",
    "vendor",
    "storage\logs",
    "storage\framework\cache",
    "storage\framework\sessions",
    "storage\framework\views",
    ".env",
    ".env.production",
    "*.zip",
    "*.log",
    "cleanup_users.php",
    "check_users.php",
    "check_users_updated.php"
)

Write-Host "Creating temporary folder..." -ForegroundColor Cyan

# Buat folder temporary
$tempFolder = "rajablindvan_temp"
if (Test-Path $tempFolder) {
    Remove-Item $tempFolder -Recurse -Force
}
New-Item -ItemType Directory -Path $tempFolder | Out-Null

# Copy semua file kecuali yang di-exclude
Write-Host "Copying files..." -ForegroundColor Cyan

Get-ChildItem -Path . -Recurse | ForEach-Object {
    $relativePath = $_.FullName.Substring((Get-Location).Path.Length + 1)
    
    # Check if path contains any excluded item
    $shouldExclude = $false
    foreach ($exclude in $excludeItems) {
        if ($relativePath -like "*$exclude*") {
            $shouldExclude = $true
            break
        }
    }
    
    if (-not $shouldExclude) {
        $destPath = Join-Path $tempFolder $relativePath
        $destDir = Split-Path $destPath -Parent
        
        if (-not (Test-Path $destDir)) {
            New-Item -ItemType Directory -Path $destDir -Force | Out-Null
        }
        
        if ($_.PSIsContainer -eq $false) {
            Copy-Item $_.FullName -Destination $destPath -Force
        }
    }
}

# Compress temporary folder
Write-Host "Compressing to rajablindvan.zip..." -ForegroundColor Cyan
Compress-Archive -Path "$tempFolder\*" -DestinationPath "rajablindvan.zip" -Force

# Hapus temporary folder
Write-Host "Cleaning up..." -ForegroundColor Cyan
Remove-Item $tempFolder -Recurse -Force

# Show file size
$zipFile = Get-Item "rajablindvan.zip"
$sizeInMB = [math]::Round($zipFile.Length / 1MB, 2)

Write-Host "`n================================" -ForegroundColor Green
Write-Host "✓ DONE!" -ForegroundColor Green
Write-Host "File: rajablindvan.zip" -ForegroundColor Yellow
Write-Host "Size: $sizeInMB MB" -ForegroundColor Yellow
Write-Host "================================`n" -ForegroundColor Green

Write-Host "Ready to upload to Domainesia!" -ForegroundColor Cyan
