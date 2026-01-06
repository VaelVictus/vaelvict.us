<?php
declare(strict_types=1);

/**
 * tumblr sync CLI script
 * 
 * usage: php bin/sync_tumblr.php
 * 
 * fetches posts from vael.tumblr.com tagged with "vaelvict.us"
 * and stores them in the filesystem cache
 * 
 * uses Tumblr API v2: https://www.tumblr.com/docs/en/api/v2
 */

// determine base paths
$project_root = dirname(__DIR__);
$storage_dir = $project_root . '/storage/tumblr';

// load dependencies
require_once $project_root . '/secrets.php';
require_once $project_root . '/src/TumblrStore.php';

echo "Starting Tumblr sync...\n";
echo "Blog: $tumblr_blog_identifier\n";
echo "Tag filters: $tumblr_tag_filter, annual review\n";
echo "Storage: $storage_dir\n\n";

// ensure storage directories exist
ensure_storage_dirs($storage_dir);

// fetch posts from tumblr API
$tag_filters = [
    $tumblr_tag_filter,
    'annual review',
];
$posts = fetch_tumblr_posts($tumblr_api_key, $tumblr_blog_identifier, $tag_filters);

echo "Fetched " . count($posts) . " posts from Tumblr API\n";

// process each post
$index_records = [];

foreach ($posts as $post) {
    $post_id = isset($post['id']) ? (string) $post['id'] : '';
    if ($post_id === '') {
        echo "  Skipping post with missing id\n";
        continue;
    }

    // the /posts endpoint only returns published posts, but double-check anyway
    if (!is_publishable_post($post)) {
        $state = isset($post['state']) ? (string) $post['state'] : '';
        echo "  Skipping unpublished post: $post_id (state: $state)\n";
        continue;
    }

    $post_path = $storage_dir . '/posts/' . $post_id . '.json';
    
    // write full post data
    atomic_write_json($post_path, $post);
    echo "  Wrote post: $post_id\n";
    
    // create lightweight index record
    $index_records[] = [
        'id' => $post['id'],
        'timestamp' => $post['timestamp'],
        'date_iso' => $post['date_iso'],
        'title' => $post['title'] ?? '',
        'excerpt' => generate_excerpt($post['body_html'] ?? '', 180),
        'permalink' => $post['permalink'],
        'tags' => $post['tags'] ?? [],
        'type' => $post['type'],
        'has_body' => !empty($post['body_html']),
    ];
}

// sort index by timestamp descending (newest first) for consistency
$index_records = sort_posts_index($index_records, 'newest');

// write posts index
$index_path = $storage_dir . '/posts_index.json';
atomic_write_json($index_path, $index_records);
echo "\nWrote posts index with " . count($index_records) . " records\n";

// write meta
$meta_path = $storage_dir . '/meta.json';
$meta = [
    'last_sync_at' => date('c'),
    'blog_identifier' => $tumblr_blog_identifier,
    'index_version' => 1
];
atomic_write_json($meta_path, $meta);
echo "Wrote meta.json\n";

echo "\nSync complete!\n";

/**
 * fetch all posts from tumblr API matching the tag filters
 * 
 * uses the /v2/blog/{blog-identifier}/posts endpoint with api_key auth
 * handles pagination automatically (max 20 posts per request)
 * 
 * @param string $api_key the tumblr OAuth consumer key
 * @param string $blog_identifier the tumblr blog (e.g., vael.tumblr.com)
 * @param array $tag_filters only return posts that match any of these tags
 * @return array normalized post records
 */
function fetch_tumblr_posts(string $api_key, string $blog_identifier, array $tag_filters): array {
    $posts_by_id = [];
    
    foreach ($tag_filters as $tag_filter) {
        $tag_filter = trim((string) $tag_filter);
        if ($tag_filter === '') {
            continue;
        }
        
        $tag_posts = fetch_tumblr_posts_by_tag($api_key, $blog_identifier, $tag_filter);
        foreach ($tag_posts as $post) {
            $post_id = isset($post['id']) ? (string) $post['id'] : '';
            if ($post_id === '') {
                continue;
            }
            $posts_by_id[$post_id] = $post;
        }
    }
    
    return array_values($posts_by_id);
}

/**
 * fetch posts from tumblr API for a single tag
 */
function fetch_tumblr_posts_by_tag(string $api_key, string $blog_identifier, string $tag_filter): array {
    $all_posts = [];
    $offset = 0;
    $limit = 20; // tumblr API max per request
    
    echo "Fetching posts from Tumblr API (tag: $tag_filter)...\n";
    
    while (true) {
        $url = sprintf(
            'https://api.tumblr.com/v2/blog/%s/posts?api_key=%s&tag=%s&limit=%d&offset=%d',
            urlencode($blog_identifier),
            urlencode($api_key),
            urlencode($tag_filter),
            $limit,
            $offset
        );
        
        echo "  Requesting offset=$offset... ";
        
        $response = tumblr_curl_get($url);
        
        if ($response === null) {
            echo "FAILED (curl error)\n";
            break;
        }
        
        $data = json_decode($response, true);
        
        if (!isset($data['meta']['status']) || $data['meta']['status'] !== 200) {
            $status = $data['meta']['status'] ?? 'unknown';
            $msg = $data['meta']['msg'] ?? 'unknown error';
            echo "FAILED (API error: $status - $msg)\n";
            break;
        }
        
        $posts = $data['response']['posts'] ?? [];
        $total = $data['response']['total_posts'] ?? 0;
        
        echo "got " . count($posts) . " posts (total: $total)\n";
        
        if (empty($posts)) {
            break;
        }
        
        foreach ($posts as $raw_post) {
            $normalized = normalize_tumblr_post($raw_post);
            if ($normalized !== null) {
                $all_posts[] = $normalized;
            }
        }
        
        $offset += $limit;
        
        // stop if we've fetched all posts
        if ($offset >= $total) {
            break;
        }
        
        // small delay to be nice to the API
        usleep(250000); // 250ms
    }
    
    return $all_posts;
}

/**
 * make a GET request to the tumblr API using cURL
 */
function tumblr_curl_get(string $url): ?string {
    $ch = curl_init();
    
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTPHEADER => [
            'User-Agent: vaelvict.us-sync/1.0',
            'Accept: application/json',
        ],
    ]);
    
    $response = curl_exec($ch);
    $error = curl_error($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    if ($response === false) {
        echo "cURL error: $error\n";
        return null;
    }
    
    if ($http_code >= 400) {
        echo "HTTP $http_code\n";
        return null;
    }
    
    return $response;
}

/**
 * normalize a tumblr API post response to our internal format
 */
function normalize_tumblr_post(array $raw): ?array {
    // use id_string to safely handle 64-bit post IDs
    $id = $raw['id_string'] ?? (string) ($raw['id'] ?? '');
    if ($id === '') {
        return null;
    }
    
    $timestamp = $raw['timestamp'] ?? 0;
    $date_iso = date('c', $timestamp);
    
    // extract body HTML based on post type
    $body_html = '';
    $summary_html = '';
    $title = '';
    
    $type = $raw['type'] ?? 'text';
    
    switch ($type) {
        case 'text':
            $title = $raw['title'] ?? '';
            $body_html = $raw['body'] ?? '';
            
            // newer tumblr posts may not populate "title" and "body" (npf)
            // try to derive the title from a heading block and build html from "content"
            if ($title === '' || $body_html === '') {
                $npf = derive_npf_title_and_body($raw);
                if ($npf !== null) {
                    if ($title === '' && $npf['title'] !== '') {
                        $title = $npf['title'];
                    }
                    if ($body_html === '' && $npf['body_html'] !== '') {
                        $body_html = $npf['body_html'];
                    }
                }
            }
            break;
            
        case 'quote':
            $body_html = '<blockquote>' . ($raw['text'] ?? '') . '</blockquote>';
            if (!empty($raw['source'])) {
                $body_html .= '<cite>' . $raw['source'] . '</cite>';
            }
            break;
            
        case 'link':
            $title = $raw['title'] ?? $raw['url'] ?? '';
            $body_html = $raw['description'] ?? '';
            break;
            
        case 'chat':
            $title = $raw['title'] ?? '';
            $body_html = $raw['body'] ?? '';
            break;
            
        case 'photo':
        case 'video':
        case 'audio':
            $body_html = $raw['caption'] ?? '';
            break;
            
        case 'answer':
            $body_html = '<p class="tumblr_question"><strong>' . ($raw['asking_name'] ?? 'Anonymous') . '</strong> asked: ' . ($raw['question'] ?? '') . '</p>';
            $body_html .= $raw['answer'] ?? '';
            break;
            
        default:
            $body_html = $raw['body'] ?? $raw['caption'] ?? '';
    }
    
    // extract photos for photo posts (legacy format)
    $photos = [];
    if (!empty($raw['photos']) && is_array($raw['photos'])) {
        foreach ($raw['photos'] as $photo) {
            $original = $photo['original_size'] ?? [];
            if (!empty($original['url'])) {
                $photos[] = [
                    'url' => $original['url'],
                    'width' => $original['width'] ?? 0,
                    'height' => $original['height'] ?? 0,
                    'alt' => $photo['caption'] ?? '',
                ];
            }
        }
    }
    
    // summary from tumblr's summary field or generate from body
    $summary_html = $raw['summary'] ?? '';
    
    // if title is still empty and body starts with a heading, use it as title
    if ($title === '' && $body_html !== '') {
        $derived = derive_title_from_body_html($body_html);
        if ($derived !== null) {
            $title = $derived['title'];
            $body_html = $derived['body_html'];
        }
    }
    
    return [
        'id' => $id,
        'state' => $raw['state'] ?? 'published',
        'timestamp' => $timestamp,
        'date_iso' => $date_iso,
        'title' => $title,
        'permalink' => $raw['post_url'] ?? '',
        'tags' => $raw['tags'] ?? [],
        'type' => $type,
        'body_html' => $body_html,
        'summary_html' => $summary_html,
        'photos' => $photos,
    ];
}

/**
 * derive title/body_html from tumblr npf fields when legacy title/body are absent
 */
function derive_npf_title_and_body(array $raw): ?array {
    if (empty($raw['content']) || !is_array($raw['content'])) {
        return null;
    }
    
    $content = $raw['content'];
    $title = '';
    $html_parts = [];
    
    foreach ($content as $block) {
        if (!is_array($block)) {
            continue;
        }
        
        $block_type = $block['type'] ?? '';
        if ($block_type !== 'text') {
            continue;
        }
        
        $text = (string) ($block['text'] ?? '');
        $subtype = (string) ($block['subtype'] ?? '');
        
        if ($title === '' && $text !== '' && str_starts_with($subtype, 'heading')) {
            $title = $text;
            continue;
        }
        
        if ($text !== '') {
            $safe_text = str_replace("\n", "<br>\n", $text);
            $html_parts[] = '<p>' . $safe_text . '</p>';
        }
    }
    
    $body_html = implode("\n", $html_parts);
    if ($title === '' && $body_html === '') {
        return null;
    }
    
    return [
        'title' => $title,
        'body_html' => $body_html,
    ];
}

/**
 * extract a title from leading <h1>/<h2>/<h3> in body_html
 */
function derive_title_from_body_html(string $body_html): ?array {
    $trimmed = ltrim($body_html);
    
    if (!preg_match('/^<(h1|h2|h3)[^>]*>(.*?)<\/\\1>/is', $trimmed, $m)) {
        return null;
    }
    
    $title = trim(strip_tags($m[2]));
    if ($title === '') {
        return null;
    }
    
    $new_body = preg_replace('/^<(h1|h2|h3)[^>]*>.*?<\/\\1>\\s*/is', '', $trimmed, 1);
    if ($new_body === null) {
        $new_body = $body_html;
    }
    
    return [
        'title' => $title,
        'body_html' => $new_body,
    ];
}

/**
 * only import posts that are published
 */
function is_publishable_post(array $post): bool {
    // the /posts endpoint only returns published posts, but check anyway
    if (isset($post['state'])) {
        $state = strtolower((string) $post['state']);
        if ($state !== 'published') {
            return false;
        }
    }
    
    return true;
}
