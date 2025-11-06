# Script untuk memperbaiki route names dan CSS classes yang salah

$files = Get-ChildItem -Path "resources\views\settings" -Filter "*.blade.php" -Recurse

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw
    
    # Fix route names - ganti Pengaturan kembali ke settings di route()
    $content = $content -replace "route\('Pengaturan\.", "route('settings."
    
    # Fix CSS classes - ganti Pengaturan kembali ke settings di class
    $content = $content -replace 'class="Pengaturan-', 'class="settings-'
    $content = $content -replace "class='Pengaturan-", "class='settings-"
    
    # Fix CSS selectors
    $content = $content -replace '\.Pengaturan-', '.settings-'
    
    Set-Content -Path $file.FullName -Value $content -NoNewline
    Write-Host "Fixed: $($file.Name)"
}

Write-Host "`nDone! All route names and CSS classes have been fixed."
