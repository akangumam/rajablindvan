<?php
// Simple test file
echo "<h1>Laravel Application Test</h1>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>PHP Version: " . phpversion() . "</p>";

// Test database connection
try {
    require_once __DIR__ . '/../vendor/autoload.php';
    
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    
    echo "<p style='color: green;'>✓ Laravel Application Loaded Successfully</p>";
    
    // Test database
    $pdo = new PDO('sqlite:' . __DIR__ . '/../database/database.sqlite');
    echo "<p style='color: green;'>✓ Database Connection OK</p>";
    
    // Count vehicles
    $stmt = $pdo->query('SELECT COUNT(*) as count FROM vehicles');
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Total Vehicles: " . $result['count'] . "</p>";
    
    // Count fuel fills
    $stmt = $pdo->query('SELECT COUNT(*) as count FROM fuel_fills');
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Total Fuel Fills: " . $result['count'] . "</p>";
    
    echo "<hr>";
    echo "<p><a href='/test-laravel.php'>Laravel Test Page</a></p>";
    echo "<p><a href='/index.php'>Back to Laravel App</a> (if working)</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>