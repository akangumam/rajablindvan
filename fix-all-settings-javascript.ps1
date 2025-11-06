# Script untuk memperbaiki semua JavaScript errors di halaman settings

$files = Get-ChildItem -Path "resources\views\settings" -Filter "*.blade.php" -Recurse

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw
    
    Write-Host "Processing: $($file.Name)"
    
    # Fix reLokasi yang seharusnya replace
    $originalContent = $content
    $content = $content -replace "\.reTempat\(", ".replace("
    $content = $content -replace "\.rePlace\(", ".replace("
    $content = $content -replace "\.reLokasi\(", ".replace("
    $content = $content -replace "\.reService\(", ".replace("
    $content = $content -replace "\.reExpense\(", ".replace("
    $content = $content -replace "\.reIncome\(", ".replace("
    $content = $content -replace "\.reInvestor\(", ".replace("
    $content = $content -replace "\.rePayment\(", ".replace("
    
    # Fix onclick function calls yang mungkin rusak
    $content = $content -replace "onclick=`"openEditModal\([^)]+\)`"", 'onclick="openEditModal($1, $2, $3)"'
    
    # Fix other common translation issues in JavaScript
    $content = $content -replace "TAMBAH ([A-Z\s]+) BARU", "TAMBAH `$1 BARU"
    
    if ($content -ne $originalContent) {
        Set-Content -Path $file.FullName -Value $content -NoNewline
        Write-Host "Fixed: $($file.Name)" -ForegroundColor Green
    }
    else {
        Write-Host "No changes needed: $($file.Name)" -ForegroundColor Yellow
    }
}

Write-Host "`nDone! All JavaScript issues have been fixed." -ForegroundColor Cyan