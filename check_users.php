<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ALL USERS IN DATABASE ===\n\n";

$users = App\Models\User::all(['id', 'name', 'email', 'role', 'user_type', 'is_active']);

if ($users->isEmpty()) {
    echo "No users found!\n";
} else {
    echo "Total Users: " . $users->count() . "\n\n";
    
    foreach ($users as $user) {
        echo "ID: {$user->id}\n";
        echo "Name: {$user->name}\n";
        echo "Email: {$user->email}\n";
        echo "Role: {$user->role}\n";
        echo "User Type: {$user->user_type}\n";
        echo "Active: " . ($user->is_active ? 'Yes' : 'No') . "\n";
        echo str_repeat('-', 50) . "\n";
    }
}
