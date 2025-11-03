<?php
/**
 * GitHub Webhook Auto-Deploy Script
 * 
 * Place this file in: public/deploy.php
 * GitHub Webhook URL: https://rajafleet.khaerulumam.id/deploy.php
 * 
 * Workflow:
 * 1. You push to GitHub
 * 2. GitHub sends webhook to this file
 * 3. Script runs git pull + cache automatically
 * 4. Done! No cPanel login needed!
 */

// Configuration
define('SECRET_TOKEN', 'CHANGE_THIS_TO_RANDOM_STRING'); // Set this to match GitHub webhook secret
define('REPO_PATH', '/home/srherba3/rajafleet.khaerulumam.id');
define('BRANCH', 'refs/heads/master'); // Only deploy master branch
define('LOG_FILE', REPO_PATH . '/storage/logs/deploy.log');

// Verify GitHub signature
function verifySignature($payload, $signature) {
    if (SECRET_TOKEN === 'CHANGE_THIS_TO_RANDOM_STRING') {
        return false; // Security: Must set custom secret
    }
    
    $hash = 'sha256=' . hash_hmac('sha256', $payload, SECRET_TOKEN);
    return hash_equals($hash, $signature);
}

// Log function
function logMessage($message) {
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[{$timestamp}] {$message}\n";
    file_put_contents(LOG_FILE, $logEntry, FILE_APPEND);
    echo $logEntry;
}

// Main deployment function
function deploy() {
    logMessage("🚀 Starting deployment...");
    
    // Change to repository directory
    chdir(REPO_PATH);
    
    $commands = [
        // 1. Git pull
        'git pull origin master 2>&1',
        
        // 2. Check if composer.lock changed
        'COMPOSER_CHANGED=$(git diff HEAD@{1} HEAD --name-only | grep composer.lock); if [ ! -z "$COMPOSER_CHANGED" ]; then composer install --no-dev --optimize-autoloader --ignore-platform-reqs 2>&1; else echo "Composer not changed, skipping..."; fi',
        
        // 3. Run database migrations
        'php artisan migrate --force 2>&1',
        
        // 4. Clear cache
        'php artisan config:clear 2>&1',
        'php artisan route:clear 2>&1',
        'php artisan view:clear 2>&1',
        
        // 5. Rebuild cache
        'php artisan config:cache 2>&1',
        'php artisan route:cache 2>&1',
        'php artisan view:cache 2>&1',
        
        // 6. Fix permissions
        'chmod -R 775 storage bootstrap/cache 2>&1',
    ];
    
    $output = [];
    foreach ($commands as $command) {
        logMessage("📝 Running: {$command}");
        exec($command, $cmdOutput, $returnVar);
        
        foreach ($cmdOutput as $line) {
            logMessage("   " . $line);
        }
        
        if ($returnVar !== 0) {
            logMessage("❌ Command failed with code: {$returnVar}");
            return false;
        }
        
        $cmdOutput = []; // Reset for next command
    }
    
    logMessage("✅ Deployment completed successfully!");
    return true;
}

// Main execution
header('Content-Type: application/json');

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed. Use POST.']);
    exit;
}

// Get payload
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

// For testing without webhook (remove in production)
if (isset($_GET['test']) && $_GET['test'] === 'manual') {
    logMessage("⚠️  Manual deployment triggered via URL");
    
    if (deploy()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Deployment completed successfully!',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'Deployment failed. Check logs.',
            'log_file' => LOG_FILE
        ]);
    }
    exit;
}

// Verify signature
if (empty($signature) || !verifySignature($payload, $signature)) {
    logMessage("❌ Invalid signature or missing secret token");
    http_response_code(403);
    echo json_encode(['error' => 'Invalid signature']);
    exit;
}

// Parse payload
$data = json_decode($payload, true);

if (!$data) {
    logMessage("❌ Invalid JSON payload");
    http_response_code(400);
    echo json_encode(['error' => 'Invalid payload']);
    exit;
}

// Check if it's the correct branch
$ref = $data['ref'] ?? '';
if ($ref !== BRANCH) {
    logMessage("ℹ️  Ignoring push to branch: {$ref}");
    echo json_encode([
        'status' => 'ignored',
        'message' => "Not deploying branch: {$ref}"
    ]);
    exit;
}

// Log the push info
$pusher = $data['pusher']['name'] ?? 'unknown';
$commits = count($data['commits'] ?? []);
logMessage("📦 Push from {$pusher} with {$commits} commit(s)");

// Deploy!
if (deploy()) {
    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Deployment completed successfully!',
        'pusher' => $pusher,
        'commits' => $commits,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Deployment failed. Check logs.',
        'log_file' => LOG_FILE
    ]);
}
