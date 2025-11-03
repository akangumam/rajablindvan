<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CLEANING OLD USERS ===\n\n";

// Delete old users (admin, viewer, and old test users)
$deleted = \App\Models\User::whereIn('email', [
    'admin2@rajablindvan.com',   // Old admin
    'manager@rajablindvan.com',   // Old manager  
    'operator@rajablindvan.com',  // Old operator
    'viewer@rajablindvan.com',    // Old viewer
])->delete();

echo "Deleted {$deleted} old users\n\n";

echo "=== REMAINING USERS ===\n\n";

$users = \App\Models\User::all();

foreach ($users as $user) {
    echo "Name: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Role: {$user->role}\n";
    echo "User Type: {$user->user_type}\n";
    echo "---\n";
}

echo "\nTotal users: " . $users->count() . "\n";
