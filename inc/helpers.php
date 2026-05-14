<?
declare(strict_types=1);

require_once __DIR__ . '/../secrets.php';

$server_name = (string)($_SERVER['SERVER_NAME'] ?? '');
$http_host = (string)($_SERVER['HTTP_HOST'] ?? '');

// treat local hosts as dev only when vite dev server is reachable
$is_local_host = ($server_name === 'localhost'
    || str_contains($server_name, '.loc')
    || str_contains($http_host, '.loc')
    || str_contains($http_host, '192.168')
    || $http_host === 'localhost');

$vite_port_start = 1337;
$vite_port_end = 1350;
$vite_status_path = __DIR__ . '/../storage/vite/dev-server.local';
$vite_timeout_seconds = 0.05;

$dev_server_running = false;
$vite_origin = '';

// allow forcing dev mode for debugging
$force_dev = isset($_GET['force_dev']);

function get_vite_status_port(string $vite_status_path): ?int {
    if (!is_file($vite_status_path)) {
        return null;
    }

    $status_json = file_get_contents($vite_status_path);
    if (!is_string($status_json) || $status_json === '') {
        return null;
    }

    $status = json_decode($status_json, true);
    if (!is_array($status) || !isset($status['port'])) {
        return null;
    }

    $vite_port = (int)$status['port'];
    if ($vite_port < 1 || $vite_port > 65535) {
        return null;
    }

    return $vite_port;
}

function is_vite_dev_server_port_open(int $vite_port, float $vite_timeout_seconds): bool {
    $hosts = ['127.0.0.1', 'localhost'];

    foreach ($hosts as $host) {
        $socket = @stream_socket_client(
            "tcp://$host:$vite_port",
            $errno,
            $errstr,
            $vite_timeout_seconds,
            STREAM_CLIENT_CONNECT
        );

        if (is_resource($socket)) {
            fclose($socket);
            return true;
        }
    }

    return false;
}

if ($is_local_host || $force_dev) {
    $vite_status_port = get_vite_status_port($vite_status_path);
    $vite_ports = [];

    if ($vite_status_port !== null) {
        $vite_ports[] = $vite_status_port;
    }

    $vite_ports[] = $vite_port_start;
    $vite_ports = array_merge($vite_ports, range($vite_port_start + 1, $vite_port_end));
    $vite_ports = array_values(array_unique($vite_ports));

    foreach ($vite_ports as $vite_port) {
        if (is_vite_dev_server_port_open($vite_port, $vite_timeout_seconds)) {
            $dev_server_running = true;
            $vite_origin = "https://localhost:$vite_port";
            break;
        }
    }
}

if (($is_local_host && $dev_server_running) || $force_dev) {
    define('DEV_ENV', 'dev');
    $fallback_port = $vite_status_port ?? $vite_port_start;
    define('VITE_ORIGIN', $vite_origin ?: "https://localhost:$fallback_port");
} else {
    define('DEV_ENV', 'prod');
    define('VITE_ORIGIN', '');
}

function get_age($birthdate) {
    // compute an accurate age difference (includes day-of-month)
    $birth_date = new DateTimeImmutable($birthdate);
    $now = new DateTimeImmutable('now');
    $age = ($birth_date > $now) ? new DateInterval('P0D') : $birth_date->diff($now);
    $years_old = $age->y;
    
    // just give months for our cute little babies!
    if ($years_old === 0) {
        $months_old = ($age->y * 12) + $age->m;
        $label = ($months_old === 1 ? 'month' : 'months');
        return "<b>$months_old</b> $label";
    }

    // while the kids are age 2 or younger, display 1/2 ages
    if ($years_old <= 2) {
        $months_into_year = $age->m;
        $half = ($months_into_year >= 6) ? '&#189;' : '';
        $label = ($years_old > 1 ? 'years' : 'year');

        $half_part = ($half !== '') ? " $half" : '';
        return "<b>$years_old</b>$half_part $label";
    }
        
    return "<b>$years_old</b> years";
}

function months($date) {
    $start_date = new DateTimeImmutable($date);
    $now = new DateTimeImmutable('now');

    if ($start_date > $now) {
        return 0;
    }

    $diff = $start_date->diff($now);
    return ($diff->y * 12) + $diff->m;
}
