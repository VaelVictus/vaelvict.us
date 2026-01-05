<?php
declare(strict_types=1);

require_once(__DIR__ . '/../secrets.php');

$server_name = (string)($_SERVER['SERVER_NAME'] ?? '');
$http_host = (string)($_SERVER['HTTP_HOST'] ?? '');

// treat local hosts as dev only when vite dev server is reachable
$is_local_host = ($server_name === 'localhost'
    || str_contains($server_name, '.loc')
    || str_contains($http_host, '192.168'));

$vite_port = 1337;
$vite_host = '127.0.0.1';
$vite_timeout_seconds = 0.15;

$dev_server_running = false;
if ($is_local_host) {
    $socket = @fsockopen($vite_host, $vite_port, $errno, $errstr, $vite_timeout_seconds);
    if (is_resource($socket)) {
        fclose($socket);
        $dev_server_running = true;
    }
}

if ($is_local_host && $dev_server_running) {
    define('DEV_ENV', 'dev');
} else {
    define('DEV_ENV', 'prod');
}

function get_age($birthdate) {
    // explode the date into meaningful variables
    list($birth_year, $birth_month) = explode("-", $birthdate);
    
    // find the difference between current value for the date, and input date
    $years_old = intval(date("Y") - $birth_year);
    $months_diff = intval(date("n") - $birth_month);
    
    // it will be negative if the date has not occured this year
    if ($months_diff < 0) {
        $years_old--;
    }
    
    // just give months for our cute little babies!
    if ($years_old === 0) {
        $months_old = months($birthdate);
        $label = ($months_old > 1 ? 'months' : 'month');
        return "<b>$months_old</b> $label";
    }

    // while the kids are age 2 or younger, display 1/2 ages
    if ($years_old <= 2) {
        $mos = months($birthdate);
        $half = ($mos - ($years_old * 12) > 6) ? '&#189;' : '';
        $label = ($years_old > 1 ? 'years' : 'year');

        return "<b>$years_old</b> $half $label";
    }
        
    return "<b>$years_old</b> years";
}

function months($date) {
    $tmp = explode('-', $date);
    return (date('Y') - $tmp[0]) * 12 + (( 12 - $tmp[1]) - (12 - date( 'n' )));
}