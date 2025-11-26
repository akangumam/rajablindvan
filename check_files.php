<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\UploadedFile;

echo "=== Checking Uploaded Files ===" . PHP_EOL;
echo "Total files: " . UploadedFile::count() . PHP_EOL . PHP_EOL;

$files = UploadedFile::all();

if ($files->count() > 0) {
    foreach ($files as $file) {
        echo "ID: " . $file->id . PHP_EOL;
        echo "Original Name: " . $file->original_name . PHP_EOL;
        echo "Category: " . $file->category . PHP_EOL;
        echo "File Size: " . $file->file_size . " bytes" . PHP_EOL;
        echo "File Path: " . $file->file_path . PHP_EOL;
        echo "Created: " . $file->created_at . PHP_EOL;
        echo "---" . PHP_EOL;
    }
} else {
    echo "No files found in database." . PHP_EOL;
}
