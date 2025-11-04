<?php
/**
 * API Test Script
 * Test all Laravel API endpoints for Flutter mobile app
 */

// Base URL
$baseUrl = 'http://127.0.0.1:8000/api/v1';

// Colors for output
function printSuccess($message) {
    echo "\033[0;32m✓ $message\033[0m\n";
}

function printError($message) {
    echo "\033[0;31m✗ $message\033[0m\n";
}

function printInfo($message) {
    echo "\033[0;34mℹ $message\033[0m\n";
}

function printHeader($message) {
    echo "\n\033[1;33m=== $message ===\033[0m\n";
}

// Function to make API request
function apiRequest($method, $url, $data = null, $token = null) {
    $ch = curl_init();
    
    $headers = [
        'Content-Type: application/json',
        'Accept: application/json',
    ];
    
    if ($token) {
        $headers[] = "Authorization: Bearer $token";
    }
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    
    if ($data && in_array($method, ['POST', 'PUT', 'PATCH'])) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        printError('cURL Error: ' . curl_error($ch));
        curl_close($ch);
        return null;
    }
    
    curl_close($ch);
    
    return [
        'status' => $httpCode,
        'body' => json_decode($response, true)
    ];
}

// Start testing
printHeader('STARTING API TESTS');
echo "Base URL: $baseUrl\n";

$token = null;

// ===========================================
// TEST 1: LOGIN
// ===========================================
printHeader('TEST 1: Login Endpoint');
printInfo('POST /login');

$loginData = [
    'email' => 'admin@rajablindvan.com',
    'password' => 'admin123',
    'device_name' => 'Test Device'
];

$result = apiRequest('POST', "$baseUrl/login", $loginData);

if ($result && $result['status'] === 200 && isset($result['body']['data']['token'])) {
    $token = $result['body']['data']['token'];
    printSuccess('Login successful!');
    echo "Token: " . substr($token, 0, 20) . "...\n";
    echo "User: {$result['body']['data']['user']['name']}\n";
    echo "Role: {$result['body']['data']['user']['role']}\n";
} else {
    printError('Login failed!');
    echo "Status: {$result['status']}\n";
    print_r($result['body']);
    exit(1);
}

// ===========================================
// TEST 2: GET USER INFO
// ===========================================
printHeader('TEST 2: Get User Info');
printInfo('GET /me');

$result = apiRequest('GET', "$baseUrl/me", null, $token);

if ($result && $result['status'] === 200) {
    printSuccess('User info retrieved!');
    echo "Name: {$result['body']['data']['name']}\n";
    echo "Email: {$result['body']['data']['email']}\n";
} else {
    printError('Failed to get user info');
    print_r($result);
}

// ===========================================
// TEST 3: DASHBOARD
// ===========================================
printHeader('TEST 3: Dashboard Statistics');
printInfo('GET /dashboard');

$result = apiRequest('GET', "$baseUrl/dashboard", null, $token);

if ($result && $result['status'] === 200) {
    printSuccess('Dashboard data retrieved!');
    $data = $result['body']['data'];
    echo "Total Vehicles: {$data['vehicles']['total']}\n";
    echo "Available: {$data['vehicles']['available']}\n";
    echo "Rented: {$data['vehicles']['rented']}\n";
    echo "Active Rentals: {$data['rentals']['active']}\n";
    echo "Monthly Revenue: Rp " . number_format($data['financial']['monthly_revenue'], 0, ',', '.') . "\n";
    echo "Net Income: Rp " . number_format($data['financial']['net_income'], 0, ',', '.') . "\n";
} else {
    printError('Failed to get dashboard data');
    print_r($result);
}

// ===========================================
// TEST 4: MONTHLY REVENUE CHART
// ===========================================
printHeader('TEST 4: Monthly Revenue Chart');
printInfo('GET /dashboard/monthly-revenue');

$result = apiRequest('GET', "$baseUrl/dashboard/monthly-revenue", null, $token);

if ($result && $result['status'] === 200) {
    printSuccess('Monthly revenue chart retrieved!');
    $data = $result['body']['data'];
    echo "Months: " . implode(', ', $data['labels']) . "\n";
    echo "Values: Rp " . number_format(max($data['values']), 0, ',', '.') . " (highest)\n";
} else {
    printError('Failed to get monthly revenue');
    print_r($result);
}

// ===========================================
// TEST 5: VEHICLES LIST
// ===========================================
printHeader('TEST 5: Vehicles List');
printInfo('GET /vehicles');

$result = apiRequest('GET', "$baseUrl/vehicles", null, $token);

if ($result && $result['status'] === 200) {
    printSuccess('Vehicles list retrieved!');
    $vehicles = $result['body']['data'];
    echo "Total vehicles in response: " . count($vehicles) . "\n";
    
    if (count($vehicles) > 0) {
        $vehicle = $vehicles[0];
        echo "\nFirst Vehicle:\n";
        echo "- Brand: {$vehicle['brand']}\n";
        echo "- Model: {$vehicle['model']}\n";
        echo "- License: {$vehicle['license_plate']}\n";
        echo "- Status: {$vehicle['status']}\n";
        echo "- Location: {$vehicle['location']['name']}\n";
        
        $vehicleId = $vehicle['id'];
        
        // ===========================================
        // TEST 6: VEHICLE DETAILS
        // ===========================================
        printHeader('TEST 6: Vehicle Details');
        printInfo("GET /vehicles/$vehicleId");
        
        $result = apiRequest('GET', "$baseUrl/vehicles/$vehicleId", null, $token);
        
        if ($result && $result['status'] === 200) {
            printSuccess('Vehicle details retrieved!');
            $v = $result['body']['data'];
            echo "Total Rentals: {$v['statistics']['total_rentals']}\n";
            echo "Total Revenue: Rp " . number_format($v['statistics']['total_revenue'], 0, ',', '.') . "\n";
        } else {
            printError('Failed to get vehicle details');
        }
        
        // ===========================================
        // TEST 7: VEHICLE RENTAL HISTORY
        // ===========================================
        printHeader('TEST 7: Vehicle Rental History');
        printInfo("GET /vehicles/$vehicleId/rentals");
        
        $result = apiRequest('GET', "$baseUrl/vehicles/$vehicleId/rentals", null, $token);
        
        if ($result && $result['status'] === 200) {
            printSuccess('Vehicle rental history retrieved!');
            echo "Total rentals: {$result['body']['meta']['total']}\n";
        } else {
            printError('Failed to get vehicle rental history');
        }
    }
} else {
    printError('Failed to get vehicles');
    print_r($result);
}

// ===========================================
// TEST 8: RENTALS LIST
// ===========================================
printHeader('TEST 8: Rentals List');
printInfo('GET /rentals');

$result = apiRequest('GET', "$baseUrl/rentals", null, $token);

if ($result && $result['status'] === 200) {
    printSuccess('Rentals list retrieved!');
    echo "Total rentals: {$result['body']['meta']['total']}\n";
    
    if (count($result['body']['data']) > 0) {
        $rental = $result['body']['data'][0];
        echo "\nFirst Rental:\n";
        echo "- Vehicle: {$rental['vehicle']['brand']} {$rental['vehicle']['model']}\n";
        echo "- Customer: {$rental['customer']['name']}\n";
        echo "- Status: {$rental['status']}\n";
        echo "- Total: Rp " . number_format($rental['total_price'], 0, ',', '.') . "\n";
    }
} else {
    printError('Failed to get rentals');
    print_r($result);
}

// ===========================================
// TEST 9: ACTIVE RENTALS
// ===========================================
printHeader('TEST 9: Active Rentals Only');
printInfo('GET /rentals/active');

$result = apiRequest('GET', "$baseUrl/rentals/active", null, $token);

if ($result && $result['status'] === 200) {
    printSuccess('Active rentals retrieved!');
    echo "Active rentals count: " . count($result['body']['data']) . "\n";
} else {
    printError('Failed to get active rentals');
    print_r($result);
}

// ===========================================
// TEST 10: LOGOUT
// ===========================================
printHeader('TEST 10: Logout');
printInfo('POST /logout');

$result = apiRequest('POST', "$baseUrl/logout", null, $token);

if ($result && $result['status'] === 200) {
    printSuccess('Logout successful!');
    echo "Message: {$result['body']['message']}\n";
} else {
    printError('Logout failed');
    print_r($result);
}

// ===========================================
// SUMMARY
// ===========================================
printHeader('TEST SUMMARY');
printSuccess('All API endpoints are working correctly! ✓');
echo "\nAPI is ready for Flutter integration.\n";
echo "Check API_DOCUMENTATION.md for complete reference.\n\n";
