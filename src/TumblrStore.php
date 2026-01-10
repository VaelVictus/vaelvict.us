<?
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
 * extract slug from a tumblr permalink
 */
function extract_post_slug(string $permalink): string {
    if ($permalink === '') {
        return '';
    }
    
    $path = (string) parse_url($permalink, PHP_URL_PATH);
    $path = trim($path, '/');
    if ($path === '') {
        return '';
    }
    
    $parts = explode('/', $path);
    $slug = end($parts);
    if ($slug === false || $slug === '') {
        return '';
    }
    
    $safe_slug = preg_replace('/[^a-zA-Z0-9-]/', '', $slug);
    return strtolower((string) $safe_slug);
}

/**
 * extract slug from a post record
 */
function get_post_slug(array $post): string {
    $permalink = $post['permalink'] ?? '';
    if ($permalink === '') {
        return '';
    }
    
    return extract_post_slug($permalink);
}

/**
 * find a post id by slug in the posts index
 */
function find_post_id_by_slug(array $index, string $slug): ?string {
    $safe_slug = preg_replace('/[^a-zA-Z0-9-]/', '', $slug);
    $safe_slug = strtolower((string) $safe_slug);
    if ($safe_slug === '') {
        return null;
    }
    
    foreach ($index as $post) {
        $post_slug = get_post_slug($post);
        if ($post_slug === $safe_slug && !empty($post['id'])) {
            return (string) $post['id'];
        }
    }
    
    return null;
}

/**
 * build a blog post url using the slug when available
 */
function build_post_url(array $post): string {
    $slug = get_post_slug($post);
    if ($slug !== '') {
        return '/blog/post/' . $slug;
    }
    
    $post_id = $post['id'] ?? '';
    if ($post_id === '') {
        return '/blog/';
    }
    
    return '/blog/post.php?id=' . $post_id;
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
    $max_length = max(1, $max_length);
    
    // allow only basic inline emphasis tags in previews
    $allowed_tags = '<i><em><b><strong>';
    
    $normalized = normalize_excerpt_html($html, $allowed_tags);
    if ($normalized === '') {
        return '';
    }
    
    return truncate_allowed_html($normalized, $max_length, '...');
}

/**
 * normalize html for excerpt rendering
 */
function normalize_excerpt_html(string $html, string $allowed_tags): string {
    // add explicit breaks between block elements so text does not concatenate
    $html = str_replace(["\r\n", "\r"], "\n", $html);
    
    // convert common block boundaries into newlines
    $html = preg_replace('/<br\s*\/?>/i', "\n", $html);
    $html = preg_replace('/<\/\s*(p|div|h1|h2|h3|h4|h5|h6|li|ul|ol|blockquote|pre)\s*>/i', "\n", $html);
    
    // strip disallowed tags but keep allowed inline tags
    $html = strip_tags($html, $allowed_tags);
    
    // replace newlines with literal spaces (requested behavior)
    $html = str_replace("\n", ' ', $html);

    // normalize “fancy” characters + common mojibake into plain ascii
    $html = normalize_excerpt_chars($html);
    
    // normalize whitespace without removing allowed tags
    $html = preg_replace('/\s+/', ' ', $html);
    $html = trim($html);
    
    return $html;
}

/**
 * normalize fancy unicode + common mojibake to plain ascii
 */
function normalize_excerpt_chars(string $text): string {
    // normalize common html entities first (DOMDocument will otherwise decode them later)
    $text = str_ireplace(
        [
            '&nbsp;', '&rsquo;', '&lsquo;', '&ldquo;', '&rdquo;', '&ndash;', '&mdash;', '&hellip;', '&prime;',
        ],
        [
            ' ', "'", "'", '"', '"', '-', '--', '...', "'",
        ],
        $text
    );

    // normalize common numeric entities
    $text = preg_replace('/&#0*160;?/i', ' ', $text); // nbsp
    $text = preg_replace('/&#0*8217;?/i', "'", $text); // ’
    $text = preg_replace('/&#0*8216;?/i', "'", $text); // ‘
    $text = preg_replace('/&#0*8220;?/i', '"', $text); // “
    $text = preg_replace('/&#0*8221;?/i', '"', $text); // ”
    $text = preg_replace('/&#0*8211;?/i', '-', $text); // –
    $text = preg_replace('/&#0*8212;?/i', '--', $text); // —
    $text = preg_replace('/&#0*8230;?/i', '...', $text); // …
    $text = preg_replace('/&#0*8242;?/i', "'", $text); // ′
    $text = preg_replace_callback('/&#x0*([0-9a-f]+);?/i', function ($m) {
        $hex = strtolower($m[1]);
        return match ($hex) {
            'a0' => ' ',
            '2019', '2018' => "'",
            '201c', '201d' => '"',
            '2013' => '-',
            '2014' => '--',
            '2026' => '...',
            '2032' => "'",
            default => $m[0],
        };
    }, $text);

    // common mojibake sequences seen when utf-8 bytes are misread as cp1252
    $text = str_replace(
        [
            'â', 'â', 'â', 'â', 'â', 'â', 'â¦', 'â²',
            'Â ', 'Â ', 'Â',
        ],
        [
            "'", "'", '"', '"', '-', '--', '...', "'",
            ' ', ' ', '',
        ],
        $text
    );

    // normalize real unicode punctuation to ascii
    $text = str_replace(
        [
            "\u{00A0}", // nbsp
            "\u{2019}", "\u{2018}", // ’ ‘
            "\u{201C}", "\u{201D}", // “ ”
            "\u{2013}", "\u{2014}", // – —
            "\u{2026}", // …
            "\u{2032}", // ′ prime
            "\u{200B}", // zero width space
        ],
        [
            ' ',
            "'", "'",
            '"', '"',
            '-', '--',
            '...',
            "'",
            '',
        ],
        $text
    );

    // fallback literal replacements (in case unicode escapes aren't interpreted in runtime)
    $text = str_replace(
        ["\xc2\xa0", '’', '‘', '“', '”', '–', '—', '…', '′'],
        [' ', "'", "'", '"', '"', '-', '--', '...', "'"],
        $text
    );

    // remove other control characters (but keep spaces)
    $text = preg_replace('/[^\P{C}\t\n\r ]+/u', '', $text);

    // final pass: transliterate any remaining non-ascii punctuation
    if (function_exists('iconv')) {
        $transliterated = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
        if (is_string($transliterated) && $transliterated !== '') {
            $text = $transliterated;
        }
    }

    return $text;
}

/**
 * truncate html while preserving allowed tags
 */
function truncate_allowed_html(string $html, int $max_length, string $suffix): string {
    $plain = strip_tags($html);
    if (mb_strlen($plain) <= $max_length) {
        return $html;
    }
    
    $doc = new DOMDocument('1.0', 'UTF-8');
    $prev = libxml_use_internal_errors(true);
    
    // ensure DOMDocument treats input as utf-8, otherwise characters like ’ become â
    $html_for_dom = '<?xml encoding="UTF-8">' . $html;
    
    $doc->loadHTML('<div>' . $html_for_dom . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    libxml_use_internal_errors($prev);
    
    $root = $doc->documentElement;
    if ($root === null) {
        $cut = mb_substr($plain, 0, $max_length) . $suffix;
        return $cut;
    }
    
    $out_doc = new DOMDocument('1.0', 'UTF-8');
    $out_root = $out_doc->createElement('div');
    $out_doc->appendChild($out_root);
    
    $remaining = $max_length;
    foreach (iterator_to_array($root->childNodes) as $child) {
        if ($remaining <= 0) {
            break;
        }
        $cloned = truncate_node($out_doc, $child, $remaining);
        if ($cloned !== null) {
            $out_root->appendChild($cloned);
        }
    }
    
    $out_root->appendChild($out_doc->createTextNode($suffix));
    
    $result = '';
    foreach ($out_root->childNodes as $child) {
        $result .= $out_doc->saveHTML($child);
    }
    
    return $result;
}

/**
 * truncate a DOM node to remaining visible characters
 */
function truncate_node(DOMDocument $doc, DOMNode $node, int &$remaining): ?DOMNode {
    if ($remaining <= 0) {
        return null;
    }
    
    if ($node->nodeType === XML_TEXT_NODE) {
        $text = (string) $node->nodeValue;
        $len = mb_strlen($text);
        if ($len <= $remaining) {
            $remaining -= $len;
            return $doc->createTextNode($text);
        }
        
        $slice = mb_substr($text, 0, $remaining);
        $remaining = 0;
        return $doc->createTextNode($slice);
    }
    
    if ($node->nodeType !== XML_ELEMENT_NODE) {
        return null;
    }
    
    $el = $doc->createElement($node->nodeName);
    
    // preserve attributes on allowed tags only if present
    if ($node->attributes !== null) {
        foreach ($node->attributes as $attr) {
            $el->setAttribute($attr->nodeName, $attr->nodeValue);
        }
    }
    
    foreach ($node->childNodes as $child) {
        if ($remaining <= 0) {
            break;
        }
        $child_clone = truncate_node($doc, $child, $remaining);
        if ($child_clone !== null) {
            $el->appendChild($child_clone);
        }
    }
    
    return $el;
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
