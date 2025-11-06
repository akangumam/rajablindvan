# Script untuk memperbaiki onclick yang rusak di semua halaman settings

$files = Get-ChildItem -Path "resources\views\settings" -Filter "*.blade.php" -Recurse

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw
    $originalContent = $content
    
    Write-Host "Processing: $($file.Name)"
    
    # Fix onclick patterns untuk berbagai jenis items
    # Service Types
    $content = $content -replace 'onclick="openEditModal\(\$1, \$2, \$3\)"', 'onclick="openEditModal({{ $serviceType->id }}, ''{{ $serviceType->name }}'', ''{{ $serviceType->description }}'')"'
    
    # Expense Types  
    $content = $content -replace 'onclick="openEditModal\(\$1, \$2, \$3\)"', 'onclick="openEditModal({{ $expenseType->id }}, ''{{ $expenseType->name }}'', ''{{ $expenseType->description }}'')"'
    
    # Income Types
    $content = $content -replace 'onclick="openEditModal\(\$1, \$2, \$3\)"', 'onclick="openEditModal({{ $incomeType->id }}, ''{{ $incomeType->name }}'', ''{{ $incomeType->description }}'')"'
    
    # Payment Methods
    $content = $content -replace 'onclick="openEditModal\(\$1, \$2, \$3\)"', 'onclick="openEditModal({{ $paymentMethod->id }}, ''{{ $paymentMethod->name }}'', ''{{ $paymentMethod->description }}'')"'
    
    # Deteksi jenis file dan perbaiki sesuai konteks
    if ($file.Name -match "service-types") {
        $content = $content -replace 'onclick="openEditModal\(\$1, \$2, \$3\)"', 'onclick="openEditModal({{ $serviceType->id }}, ''{{ $serviceType->name }}'', ''{{ $serviceType->description }}'')"'
    }
    elseif ($file.Name -match "expense-types") {
        $content = $content -replace 'onclick="openEditModal\(\$1, \$2, \$3\)"', 'onclick="openEditModal({{ $expenseType->id }}, ''{{ $expenseType->name }}'', ''{{ $expenseType->description }}'')"'
    }
    elseif ($file.Name -match "income-types") {
        $content = $content -replace 'onclick="openEditModal\(\$1, \$2, \$3\)"', 'onclick="openEditModal({{ $incomeType->id }}, ''{{ $incomeType->name }}'', ''{{ $incomeType->description }}'')"'
    }
    elseif ($file.Name -match "payment-methods") {
        $content = $content -replace 'onclick="openEditModal\(\$1, \$2, \$3\)"', 'onclick="openEditModal({{ $paymentMethod->id }}, ''{{ $paymentMethod->name }}'', ''{{ $paymentMethod->description }}'')"'
    }
    
    if ($content -ne $originalContent) {
        Set-Content -Path $file.FullName -Value $content -NoNewline
        Write-Host "Fixed: $($file.Name)" -ForegroundColor Green
    }
    else {
        Write-Host "No changes needed: $($file.Name)" -ForegroundColor Yellow
    }
}

Write-Host "`nDone! All onclick issues have been fixed." -ForegroundColor Cyan