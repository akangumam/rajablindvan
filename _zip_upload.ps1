$ErrorActionPreference = "Stop"
$proj    = "E:\WebProgramming\rajablindvan\vehicle-dashboard"
$dest    = "E:\WebProgramming\rajablindvan\rajablindvan.zip"
$tempDir = "E:\WebProgramming\rajablindvan\vehicle-dashboard\_temp_zip"

$excludes = @("node_modules",".git","vendor","storage\logs","storage\framework\cache","storage\framework\sessions","storage\framework\views",".env",".env.production","_temp_zip","_zip_upload.ps1")

if (Test-Path $dest) { Remove-Item $dest -Force; Write-Host "Removed old zip" }
if (Test-Path $tempDir) { Remove-Item $tempDir -Recurse -Force }
New-Item -ItemType Directory -Path $tempDir | Out-Null

Write-Host "Copying files..."
Get-ChildItem -Path $proj -Recurse | ForEach-Object {
    $rel  = $_.FullName.Substring($proj.Length + 1)
    $skip = $false
    foreach ($ex in $excludes) {
        if ($rel -like "*$ex*") { $skip = $true; break }
    }
    if (-not $skip -and -not $_.PSIsContainer) {
        $dst    = Join-Path $tempDir $rel
        $dstDir = Split-Path $dst -Parent
        if (-not (Test-Path $dstDir)) { New-Item -ItemType Directory -Path $dstDir -Force | Out-Null }
        Copy-Item $_.FullName -Destination $dst -Force
    }
}

Write-Host "Compressing..."
Compress-Archive -Path "$tempDir\*" -DestinationPath $dest -Force
Remove-Item $tempDir -Recurse -Force

$sizeMB = [math]::Round((Get-Item $dest).Length / 1MB, 2)
Write-Host "DONE! rajablindvan.zip => $sizeMB MB"
Write-Host "Lokasi: $dest"
