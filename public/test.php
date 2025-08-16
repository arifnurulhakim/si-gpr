<?php
echo "<h1>E-Kartu Keluarga - Hosting Test</h1>";

// Basic PHP Test
echo "<h2>1. PHP Information</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Required: 8.2+<br>";
echo "Status: " . (version_compare(PHP_VERSION, '8.2.0', '>=') ? '✅ OK' : '❌ TOO OLD') . "<br><br>";

// Laravel Requirements Test
echo "<h2>2. Laravel Requirements</h2>";
$requirements = [
    'BCMath' => extension_loaded('bcmath'),
    'Ctype' => extension_loaded('ctype'),
    'JSON' => extension_loaded('json'),
    'Mbstring' => extension_loaded('mbstring'),
    'OpenSSL' => extension_loaded('openssl'),
    'PDO' => extension_loaded('pdo'),
    'Tokenizer' => extension_loaded('tokenizer'),
    'XML' => extension_loaded('xml'),
];

foreach ($requirements as $requirement => $satisfied) {
    echo $requirement . ': ' . ($satisfied ? '✅ OK' : '❌ MISSING') . '<br>';
}

// File Structure Test
echo "<h2>3. File Structure Test</h2>";
$files = [
    '../app' => 'Laravel App Directory',
    '../bootstrap' => 'Laravel Bootstrap',
    '../config' => 'Laravel Config',
    '../database' => 'Laravel Database',
    '../resources' => 'Laravel Resources',
    '../routes' => 'Laravel Routes',
    '../storage' => 'Laravel Storage',
    '../vendor' => 'Composer Vendor',
    '../.env' => 'Environment File',
    'index.php' => 'Laravel Public Index',
    '.htaccess' => 'Apache Config',
];

foreach ($files as $path => $description) {
    $exists = file_exists($path);
    echo $description . ': ' . ($exists ? '✅ EXISTS' : '❌ MISSING') . '<br>';
}

// Directory Permissions Test
echo "<h2>4. Directory Permissions Test</h2>";
$dirs = [
    '../storage' => 'Storage Directory',
    '../bootstrap/cache' => 'Bootstrap Cache',
    '../public' => 'Public Directory',
];

foreach ($dirs as $path => $description) {
    if (file_exists($path)) {
        $writable = is_writable($path);
        echo $description . ': ' . ($writable ? '✅ WRITABLE' : '❌ NOT WRITABLE') . '<br>';
    } else {
        echo $description . ': ❌ MISSING<br>';
    }
}

// Database Connection Test (if .env exists)
echo "<h2>5. Database Connection Test</h2>";
if (file_exists('../.env')) {
    echo "✅ .env file exists<br>";
    // Note: Don't actually connect here for security
    echo "Database connection test: ⚠️ MANUAL TEST REQUIRED<br>";
} else {
    echo "❌ .env file missing<br>";
}

// Current Directory Info
echo "<h2>6. Current Directory Information</h2>";
echo "Current Directory: " . __DIR__ . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "<br>";

// Recommendations
echo "<h2>7. Recommendations</h2>";
if (!version_compare(PHP_VERSION, '8.2.0', '>=')) {
    echo "❌ Upgrade PHP to 8.2+<br>";
}
if (!file_exists('../.env')) {
    echo "❌ Create .env file<br>";
}
if (!file_exists('../storage') || !is_writable('../storage')) {
    echo "❌ Fix storage directory permissions<br>";
}
if (!file_exists('../bootstrap/cache') || !is_writable('../bootstrap/cache')) {
    echo "❌ Fix bootstrap/cache permissions<br>";
}

echo "<br><strong>If all tests pass, the issue might be:</strong><br>";
echo "- Document root configuration<br>";
echo "- .htaccess configuration<br>";
echo "- Database connection<br>";
echo "- Laravel application key<br>";
?>
