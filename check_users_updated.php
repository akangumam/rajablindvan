<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== USER LIST (UPDATED) ===\n\n";

$users = \App\Models\User::all();

foreach ($users as $user) {
    echo "Name: {$user->name}\n";
    echo "Email: {$user->email}\n";
    echo "Role: {$user->role}\n";
    echo "User Type: {$user->user_type}\n";
    echo "Title: {$user->title}\n";
    echo "---\n";
}

echo "\n=== ROLE SUMMARY ===\n";
echo "Total Users: " . $users->count() . "\n";
echo "Administrator (super_admin): " . $users->where('role', 'super_admin')->count() . "\n";
echo "Sales (manager): " . $users->where('role', 'manager')->count() . "\n";
echo "Operation (operator): " . $users->where('role', 'operator')->count() . "\n";
echo "Old roles (admin/viewer): " . $users->whereIn('role', ['admin', 'viewer'])->count() . "\n";
