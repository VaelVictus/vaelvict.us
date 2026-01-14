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

$vite_host = '127.0.0.1';
$vite_port_start = 1337;
$vite_port_end = 1350;
$vite_ports = range($vite_port_start, $vite_port_end);
$vite_timeout_seconds = 0.3;

$dev_server_running = false;
$vite_origin = '';

// allow forcing dev mode for debugging
$force_dev = isset($_GET['force_dev']);

function is_vite_dev_server_port(int $vite_port, float $vite_timeout_seconds): bool {
    // validate we're talking to vite, not just any open port
    // note: on windows, localhost may resolve to ipv6 (::1), so try both.
    $hosts = ['127.0.0.1', 'localhost'];

    foreach ($hosts as $host) {
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ]);

        $socket = @stream_socket_client(
            "ssl://$host:$vite_port",
            $errno,
            $errstr,
            $vite_timeout_seconds,
            STREAM_CLIENT_CONNECT,
            $context
        );

        if (!is_resource($socket)) {
            continue;
        }

        stream_set_timeout($socket, (int)ceil($vite_timeout_seconds));

        $request = "GET /@vite/client HTTP/1.1\r\n"
            . "Host: $host:$vite_port\r\n"
            . "Connection: close\r\n\r\n";

        fwrite($socket, $request);

        $response = '';
        while (!feof($socket)) {
            $chunk = fread($socket, 4096);
            if (!is_string($chunk) || $chunk === '') {
                break;
            }
            $response .= $chunk;
            if (strlen($response) > 200000) {
                break;
            }
        }

        fclose($socket);

        if ($response === '') {
            continue;
        }

        if (str_contains($response, '@vite/client')
            || str_contains($response, 'import.meta.hot')
            || str_contains($response, '__vite')) {
            return true;
        }
    }

    return false;
}

if ($is_local_host || $force_dev) {
    foreach ($vite_ports as $vite_port) {
        if (is_vite_dev_server_port($vite_port, $vite_timeout_seconds)) {
            $dev_server_running = true;
            $vite_origin = "https://localhost:$vite_port";
            break;
        }
    }
}

if (($is_local_host && $dev_server_running) || $force_dev) {
    define('DEV_ENV', 'dev');
    $fallback_port = $vite_ports[0] ?? 1337;
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