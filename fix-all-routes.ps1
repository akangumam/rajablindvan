# Script untuk memperbaiki semua route yang rusak karena translasi

$files = Get-ChildItem -Path "resources\views\settings" -Filter "*.blade.php" -Recurse

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw
    
    # Fix common route patterns that got translated
    $content = $content -replace "route\('settings\.format\.SIMPAN'\)", "route('settings.format.save')"
    $content = $content -replace "route\('settings\.format\.store'\)", "route('settings.format.save')"
    $content = $content -replace "route\('settings\.format\.UPDATE'\)", "route('settings.format.update')"
    $content = $content -replace "route\('settings\.format\.TAMBAH'\)", "route('settings.format.create')"
    $content = $content -replace "route\('settings\.format\.HAPUS'\)", "route('settings.format.destroy')"
    
    # Fix other common translations in routes
    $content = $content -replace "route\('settings\.([^']+)\.SIMPAN'\)", "route('settings.`$1.store')"
    $content = $content -replace "route\('settings\.([^']+)\.UPDATE'\)", "route('settings.`$1.update')"
    $content = $content -replace "route\('settings\.([^']+)\.TAMBAH'\)", "route('settings.`$1.create')"
    $content = $content -replace "route\('settings\.([^']+)\.HAPUS'\)", "route('settings.`$1.destroy')"
    $content = $content -replace "route\('settings\.([^']+)\.EDIT'\)", "route('settings.`$1.edit')"
    
    # Special case for format routes that use .save instead of .store
    $content = $content -replace "route\('settings\.format\.store'\)", "route('settings.format.save')"
    
    # Fix Investor back to investors
    $content = $content -replace "settings\.Investor\.index", "settings.investors.index"
    
    # Fix Pengaturan (Settings in Indonesian) back to settings
    $content = $content -replace "Pengaturan\.([^']+)\.([^']+)", "settings.`$1.`$2"
    $content = $content -replace '"Pengaturan\.([^"]+)"', '"settings.$1"'
    
    Set-Content -Path $file.FullName -Value $content -NoNewline
    Write-Host "Fixed: $($file.Name)"
}

Write-Host "`nDone! All routes have been corrected."
