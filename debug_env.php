<?php
declare(strict_types=1);

require_once __DIR__ . '/inc/helpers.php';

echo "<h1>Debug Env</h1>";
echo "<p>SERVER_NAME: " . ($_SERVER['SERVER_NAME'] ?? 'N/A') . "</p>";
echo "<p>HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'N/A') . "</p>";
echo "<p>IS_LOCAL_HOST: " . (isset($is_local_host) ? ($is_local_host ? 'YES' : 'NO') : 'N/A') . "</p>";
echo "<p>DEV_ENV: " . (defined('DEV_ENV') ? DEV_ENV : 'NOT DEFINED') . "</p>";
echo "<p>VITE_ORIGIN: " . (defined('VITE_ORIGIN') ? VITE_ORIGIN : 'NOT DEFINED') . "</p>";

$vite_host = '127.0.0.1';
$vite_port = 1337;
$timeout = 0.5;

echo "<h2>Testing fsockopen</h2>";
$start = microtime(true);
$socket = @fsockopen($vite_host, $vite_port, $errno, $errstr, $timeout);
$end = microtime(true);
$duration = round(($end - $start) * 1000, 2);

if (is_resource($socket)) {
    echo "<p style='color: green;'>SUCCESS: Connected to $vite_host:$vite_port in {$duration}ms</p>";
    fclose($socket);
} else {
    echo "<p style='color: red;'>FAILED: Could not connect to $vite_host:$vite_port in {$duration}ms</p>";
    echo "<p>Error ($errno): $errstr</p>";
}

$vite_host_alt = 'localhost';
echo "<h3>Testing with 'localhost'</h3>";
$start = microtime(true);
$socket = @fsockopen($vite_host_alt, $vite_port, $errno, $errstr, $timeout);
$end = microtime(true);
$duration = round(($end - $start) * 1000, 2);

if (is_resource($socket)) {
    echo "<p style='color: green;'>SUCCESS: Connected to $vite_host_alt:$vite_port in {$duration}ms</p>";
    fclose($socket);
} else {
    echo "<p style='color: red;'>FAILED: Could not connect to $vite_host_alt:$vite_port in {$duration}ms</p>";
    echo "<p>Error ($errno): $errstr</p>";
}
