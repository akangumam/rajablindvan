# Script untuk mengubah bahasa Settings ke Bahasa Indonesia

$settingsPath = "E:\WebProgramming\rajablindvan\vehicle-dashboard\resources\views\settings"

$replacements = @{
    "Settings"                                                      = "Pengaturan"
    "Apps Format"                                                   = "Format Aplikasi"
    "My Account"                                                    = "Akun Saya"
    "File and Storage"                                              = "File dan Penyimpanan"
    "Place"                                                         = "Tempat"
    "Types of Service"                                              = "Jenis Service"
    "Type of Service"                                               = "Jenis Service"
    "Type of Expense"                                               = "Jenis Pengeluaran"
    "Type of Income"                                                = "Jenis Pendapatan"
    "Investors"                                                     = "Investor"
    "Payment Methods"                                               = "Metode Pembayaran"
    "Configure your application preferences and formatting options" = "Konfigurasi preferensi aplikasi dan opsi format"
    "Add New Service Type"                                          = "Tambah Jenis Service Baru"
    "Edit Service Type"                                             = "Edit Jenis Service"
    "Add New Expense Type"                                          = "Tambah Jenis Pengeluaran Baru"
    "Edit Expense Type"                                             = "Edit Jenis Pengeluaran"
    "Add New Income Type"                                           = "Tambah Jenis Pendapatan Baru"
    "Edit Income Type"                                              = "Edit Jenis Pendapatan"
    "CANCEL"                                                        = "BATAL"
    "SAVE"                                                          = "SIMPAN"
    "ADD NEW"                                                       = "TAMBAH BARU"
}

$files = Get-ChildItem -Path $settingsPath -Filter "*.blade.php"

foreach ($file in $files) {
    Write-Host "Processing: $($file.Name)"
    $content = Get-Content $file.FullName -Raw -Encoding UTF8
    
    foreach ($key in $replacements.Keys) {
        $content = $content -replace [regex]::Escape($key), $replacements[$key]
    }
    
    Set-Content $file.FullName -Value $content -Encoding UTF8 -NoNewline
}

Write-Host "Done!" -ForegroundColor Green
