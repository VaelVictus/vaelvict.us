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

if ($is_local_host || $force_dev) {
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

function get_vite_manifest(): array {
    static $manifest = null;

    if ($manifest !== null) {
        return $manifest;
    }

    $manifest_path = __DIR__ . '/../dist/manifest.json';
    if (!is_file($manifest_path)) {
        $manifest = [];
        return $manifest;
    }

    $manifest_json = file_get_contents($manifest_path);
    if (!is_string($manifest_json) || $manifest_json === '') {
        $manifest = [];
        return $manifest;
    }

    $decoded_manifest = json_decode($manifest_json, true);
    $manifest = is_array($decoded_manifest) ? $decoded_manifest : [];

    return $manifest;
}

function find_vite_manifest_entry(array $manifest, string $entry): ?array {
    $entry_keys = [$entry, '/' . $entry, './' . $entry];

    if ($entry === 'main.js') {
        $entry_keys[] = 'index.html';
    }

    foreach ($entry_keys as $entry_key) {
        if (isset($manifest[$entry_key]) && is_array($manifest[$entry_key])) {
            return $manifest[$entry_key];
        }
    }

    foreach ($manifest as $manifest_entry) {
        if (!is_array($manifest_entry) || !isset($manifest_entry['src'])) {
            continue;
        }

        if ($manifest_entry['src'] === $entry || $manifest_entry['src'] === '/' . $entry) {
            return $manifest_entry;
        }
    }

    return null;
}

function collect_vite_css_paths(array $manifest, ?array $entry_item): array {
    $css_paths = [];
    $style_entry = find_vite_manifest_entry($manifest, 'src/style.css');

    if ($style_entry !== null && isset($style_entry['file']) && substr((string)$style_entry['file'], -4) === '.css') {
        $css_paths[] = (string)$style_entry['file'];
    }

    if ($entry_item !== null && isset($entry_item['css']) && is_array($entry_item['css'])) {
        foreach ($entry_item['css'] as $css_path) {
            $css_paths[] = (string)$css_path;
        }
    }

    $fallback_entry = find_vite_manifest_entry($manifest, 'main.js');
    if (empty($css_paths) && $fallback_entry !== null && isset($fallback_entry['css']) && is_array($fallback_entry['css'])) {
        foreach ($fallback_entry['css'] as $css_path) {
            $css_paths[] = (string)$css_path;
        }
    }

    return array_values(array_unique($css_paths));
}

function render_vite_modulepreloads(array $manifest, array $entry_item, array &$seen_imports): void {
    if (!isset($entry_item['imports']) || !is_array($entry_item['imports'])) {
        return;
    }

    foreach ($entry_item['imports'] as $import_key) {
        if (isset($seen_imports[$import_key]) || !isset($manifest[$import_key]) || !is_array($manifest[$import_key])) {
            continue;
        }

        $seen_imports[$import_key] = true;
        $import_item = $manifest[$import_key];

        if (isset($import_item['file'])) {
            echo '    <link rel="modulepreload" crossorigin href="/dist/' . $import_item['file'] . '">' . "\n";
        }

        render_vite_modulepreloads($manifest, $import_item, $seen_imports);
    }
}

function render_vite_assets(?string $entry = null): void {
    if (DEV_ENV === 'dev') {
        echo '    <link rel="stylesheet" href="/css/style.css">' . "\n";
        echo '    <link rel="stylesheet" href="/fonts/inter/inter.css">' . "\n";
        if ($entry !== null) {
            echo '    <script type="module" src="/' . $entry . '"></script>' . "\n";
        }
        return;
    }

    $manifest = get_vite_manifest();
    $entry_item = $entry !== null ? find_vite_manifest_entry($manifest, $entry) : null;
    $css_paths = collect_vite_css_paths($manifest, $entry_item);

    foreach ($css_paths as $css_path) {
        echo '    <link rel="stylesheet" href="/dist/' . $css_path . '">' . "\n";
    }

    echo '    <link rel="stylesheet" href="/fonts/inter/inter.css">' . "\n";

    if ($entry_item === null || !isset($entry_item['file']) || substr((string)$entry_item['file'], -3) !== '.js') {
        return;
    }

    $seen_imports = [];
    render_vite_modulepreloads($manifest, $entry_item, $seen_imports);
    echo '    <script type="module" crossorigin src="/dist/' . $entry_item['file'] . '"></script>' . "\n";
}
