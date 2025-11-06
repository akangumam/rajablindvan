# Script untuk memperbaiki route names yang masih salah

$files = Get-ChildItem -Path "resources\views\settings" -Filter "*.blade.php" -Recurse

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw
    
    # Fix Investor route - seharusnya investors (lowercase plural)
    $content = $content -replace "settings\.Investor\.index", "settings.investors.index"
    
    Set-Content -Path $file.FullName -Value $content -NoNewline
    Write-Host "Fixed: $($file.Name)"
}

Write-Host "`nDone! All Investor routes have been corrected to investors."
