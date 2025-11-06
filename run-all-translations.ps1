# MASTER SCRIPT - Translasi ke Bahasa Indonesia untuk Settings Pages
# Script ini menjalankan semua perbaikan dengan urutan yang benar

Write-Host "====================================="
Write-Host "TRANSLASI SETTINGS KE BAHASA INDONESIA"
Write-Host "====================================="
Write-Host ""

# Step 1: Translasi text ke Bahasa Indonesia
Write-Host "[1/3] Menjalankan translasi ke Bahasa Indonesia..."
& ".\update-settings-to-indonesian.ps1"
Write-Host ""

# Step 2: Fix route names dan CSS classes
Write-Host "[2/3] Memperbaiki route names dan CSS classes..."
& ".\fix-routes-and-classes.ps1"
Write-Host ""

# Step 3: Fix semua routes yang mungkin rusak
Write-Host "[3/3] Memperbaiki semua routes yang mungkin rusak..."
& ".\fix-all-routes.ps1"
Write-Host ""

Write-Host "====================================="
Write-Host "SELESAI!"
Write-Host "====================================="
Write-Host ""
Write-Host "Semua halaman settings sudah ditranslasi ke Bahasa Indonesia."
Write-Host "Route names dan CSS classes tetap menggunakan format asli."
Write-Host ""
