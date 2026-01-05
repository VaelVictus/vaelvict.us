<?php
declare(strict_types=1);

/**
 * tumblr storage library for reading/writing cached posts
 */

/**
 * load the posts index from storage
 */
function load_posts_index(string $base_dir): array {
    $index_path = rtrim($base_dir, '/\\') . '/posts_index.json';
    
    if (!file_exists($index_path)) {
        return [];
    }
    
    // check if APCu is available for caching
    if (function_exists('apcu_fetch')) {
        $cache_key = 'tumblr_index_' . md5($index_path);
        $mtime = filemtime($index_path);
        $cached = apcu_fetch($cache_key);
        
        if ($cached !== false && isset($cached['mtime']) && $cached['mtime'] === $mtime) {
            return $cached['data'];
        }
    }
    
    $contents = file_get_contents($index_path);
    if ($contents === false) {
        return [];
    }
    
    $data = json_decode($contents, true);
    if (!is_array($data)) {
        return [];
    }
    
    // cache the result if APCu is available
    if (function_exists('apcu_store')) {
        apcu_store($cache_key, [
            'mtime' => $mtime,
            'data' => $data
        ], 3600);
    }
    
    return $data;
}

/**
 * get a single post by id
 */
function get_post_by_id(string $base_dir, string $id): ?array {
    // sanitize id to prevent directory traversal
    $safe_id = preg_replace('/[^a-zA-Z0-9_-]/', '', $id);
    if ($safe_id === '' || $safe_id !== $id) {
        return null;
    }
    
    $post_path = rtrim($base_dir, '/\\') . '/posts/' . $safe_id . '.json';
    
    if (!file_exists($post_path)) {
        return null;
    }
    
    // check if APCu is available for caching
    if (function_exists('apcu_fetch')) {
        $cache_key = 'tumblr_post_' . $safe_id;
        $mtime = filemtime($post_path);
        $cached = apcu_fetch($cache_key);
        
        if ($cached !== false && isset($cached['mtime']) && $cached['mtime'] === $mtime) {
            return $cached['data'];
        }
    }
    
    $contents = file_get_contents($post_path);
    if ($contents === false) {
        return null;
    }
    
    $data = json_decode($contents, true);
    if (!is_array($data)) {
        return null;
    }
    
    // cache the result if APCu is available
    if (function_exists('apcu_store')) {
        apcu_store($cache_key, [
            'mtime' => $mtime,
            'data' => $data
        ], 3600);
    }
    
    return $data;
}

/**
 * sort posts index by timestamp
 * @param string $order 'newest' or 'oldest'
 */
function sort_posts_index(array $index, string $order = 'newest'): array {
    usort($index, function($a, $b) use ($order) {
        // primary sort by timestamp
        $timestamp_a = $a['timestamp'] ?? 0;
        $timestamp_b = $b['timestamp'] ?? 0;
        
        if ($timestamp_a !== $timestamp_b) {
            if ($order === 'oldest') {
                return $timestamp_a <=> $timestamp_b;
            }
            return $timestamp_b <=> $timestamp_a;
        }
        
        // tie-break by id for stable ordering
        $id_a = $a['id'] ?? '';
        $id_b = $b['id'] ?? '';
        
        if ($order === 'oldest') {
            return strcmp($id_a, $id_b);
        }
        return strcmp($id_b, $id_a);
    });
    
    return $index;
}

/**
 * paginate an array of items
 * @return array with pagination metadata and sliced items
 */
function paginate(array $items, int $page, int $per_page): array {
    // clamp per_page between 1 and 50
    $per_page = max(1, min(50, $per_page));
    
    // ensure page is at least 1
    $page = max(1, $page);
    
    $total_items = count($items);
    $total_pages = (int) ceil($total_items / $per_page);
    
    // clamp page to valid range
    if ($total_pages > 0 && $page > $total_pages) {
        $page = $total_pages;
    }
    
    $offset = ($page - 1) * $per_page;
    $sliced_items = array_slice($items, $offset, $per_page);
    
    $has_prev = $page > 1;
    $has_next = $page < $total_pages;
    
    return [
        'page' => $page,
        'per_page' => $per_page,
        'total_items' => $total_items,
        'total_pages' => $total_pages,
        'items' => $sliced_items,
        'has_prev' => $has_prev,
        'has_next' => $has_next,
        'prev_page' => $has_prev ? $page - 1 : null,
        'next_page' => $has_next ? $page + 1 : null,
    ];
}

/**
 * write json data atomically using temp file + rename
 */
function atomic_write_json(string $path, mixed $data): void {
    $dir = dirname($path);
    
    // ensure directory exists
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        throw new RuntimeException("Failed to encode JSON for: $path");
    }
    
    // write to temp file in same directory
    $temp_path = $dir . '/' . uniqid('tmp_', true) . '.json';
    
    $result = file_put_contents($temp_path, $json);
    if ($result === false) {
        throw new RuntimeException("Failed to write temp file: $temp_path");
    }
    
    // rename to target path (atomic on most filesystems)
    if (!rename($temp_path, $path)) {
        unlink($temp_path);
        throw new RuntimeException("Failed to rename temp file to: $path");
    }
}

/**
 * load meta.json from storage
 */
function load_meta(string $base_dir): array {
    $meta_path = rtrim($base_dir, '/\\') . '/meta.json';
    
    if (!file_exists($meta_path)) {
        return [
            'last_sync_at' => null,
            'blog_identifier' => '',
            'index_version' => 1
        ];
    }
    
    $contents = file_get_contents($meta_path);
    if ($contents === false) {
        return [
            'last_sync_at' => null,
            'blog_identifier' => '',
            'index_version' => 1
        ];
    }
    
    $data = json_decode($contents, true);
    if (!is_array($data)) {
        return [
            'last_sync_at' => null,
            'blog_identifier' => '',
            'index_version' => 1
        ];
    }
    
    return $data;
}

/**
 * generate excerpt from html body
 */
function generate_excerpt(string $html, int $max_length = 200): string {
    // strip html tags
    $text = strip_tags($html);
    
    // normalize whitespace
    $text = preg_replace('/\s+/', ' ', $text);
    $text = trim($text);
    
    // truncate if needed
    if (mb_strlen($text) > $max_length) {
        $text = mb_substr($text, 0, $max_length);
        // try to break at word boundary
        $last_space = mb_strrpos($text, ' ');
        if ($last_space !== false && $last_space > $max_length * 0.7) {
            $text = mb_substr($text, 0, $last_space);
        }
        $text .= '...';
    }
    
    return $text;
}

/**
 * ensure storage directories exist
 */
function ensure_storage_dirs(string $base_dir): void {
    $posts_dir = rtrim($base_dir, '/\\') . '/posts';
    
    if (!is_dir($posts_dir)) {
        mkdir($posts_dir, 0755, true);
    }
}
