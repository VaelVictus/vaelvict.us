<?php
declare(strict_types=1);

/**
 * tumblr sync CLI script
 * 
 * usage: php bin/sync_tumblr.php
 * 
 * fetches posts from vael.tumblr.com tagged with "vaelvict.us"
 * and stores them in the filesystem cache
 */

// determine base paths
$project_root = dirname(__DIR__);
$storage_dir = $project_root . '/storage/tumblr';

// load dependencies
require_once $project_root . '/secrets.php';
require_once $project_root . '/src/TumblrStore.php';

echo "Starting Tumblr sync...\n";
echo "Blog: $tumblr_blog_identifier\n";
echo "Tag filter: $tumblr_tag_filter\n";
echo "Storage: $storage_dir\n\n";

// ensure storage directories exist
ensure_storage_dirs($storage_dir);

// fetch posts from tumblr (stub for now)
$posts = fetch_tumblr_posts($tumblr_tag_filter);

echo "Fetched " . count($posts) . " posts\n";

// process each post
$index_records = [];

foreach ($posts as $post) {
    $post_id = isset($post['id']) ? (string) $post['id'] : '';
    if ($post_id === '') {
        echo "  Skipping post with missing id\n";
        continue;
    }

    if (!is_publishable_post($post)) {
        $state = isset($post['state']) ? (string) $post['state'] : '';
        $status = isset($post['status']) ? (string) $post['status'] : '';
        echo "  Skipping unpublished post: $post_id";
        if ($state !== '') {
            echo " (state: $state)";
        }
        if ($status !== '') {
            echo " (status: $status)";
        }
        echo "\n";
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
        'excerpt' => generate_excerpt($post['body_html'] ?? '', 200),
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
 * fetch posts from tumblr API
 * 
 * STUB IMPLEMENTATION: returns dummy data for testing
 * replace with actual OAuth-based API calls later
 * 
 * @param string $tag_filter only return posts with this tag
 * @return array normalized post records
 */
function fetch_tumblr_posts(string $tag_filter): array {
    // TODO: replace with actual Tumblr API OAuth implementation
    // for now, return dummy data for testing
    
    $dummy_posts = [
        [
            'id' => '187341440887',
            'state' => 'published',
            'timestamp' => 1567123456,
            'date_iso' => '2019-08-30T12:30:56Z',
            'title' => 'Die2Nite Teardown',
            'permalink' => 'https://vael.tumblr.com/post/187341440887/die2nite-teardown',
            'tags' => ['vaelvict.us', 'game-design', 'teardown'],
            'type' => 'text',
            'body_html' => '<p>A teardown is a document that examines a game\'s design decisions and mechanics in depth. This teardown covers Die2Nite, a browser-based zombie survival game that emphasizes cooperation and resource management.</p><p>The game forces players to work together to survive waves of zombies, creating interesting social dynamics and emergent gameplay.</p>',
            'summary_html' => '<p>A comprehensive analysis of Die2Nite\'s game design.</p>',
            'photos' => []
        ],
        [
            'id' => '634149707769430016',
            'state' => 'published',
            'timestamp' => 1605000000,
            'date_iso' => '2020-11-10T12:00:00Z',
            'title' => 'Marosia Teardown 2020',
            'permalink' => 'https://vael.tumblr.com/post/634149707769430016/marosia-teardown-2020-final',
            'tags' => ['vaelvict.us', 'game-design', 'teardown', 'marosia'],
            'type' => 'text',
            'body_html' => '<p>Marosia is a persistent browser game that combines elements of life simulation with medieval politics. Players control characters who are born, live, and die within the game world.</p><p>This teardown examines the unique intergenerational gameplay mechanics and how they create compelling long-term engagement.</p>',
            'summary_html' => '<p>An in-depth analysis of Marosia\'s unique gameplay systems.</p>',
            'photos' => []
        ],
        [
            'id' => '123456789012',
            'state' => 'published',
            'timestamp' => 1700000000,
            'date_iso' => '2023-11-14T22:13:20Z',
            'title' => 'Thoughts on Browser Game Design',
            'permalink' => 'https://vael.tumblr.com/post/123456789012/browser-game-design',
            'tags' => ['vaelvict.us', 'game-design', 'browser-games'],
            'type' => 'text',
            'body_html' => '<p>Browser games have a unique set of constraints and opportunities that shape their design. Unlike traditional games, they must work within the limitations of web technologies while also leveraging the accessibility that browsers provide.</p><p>In this post, I explore some key principles for effective browser game design based on my experience developing games at Tinydark.</p>',
            'summary_html' => '<p>Key principles for browser game design.</p>',
            'photos' => []
        ],
        [
            'id' => '987654321098',
            'state' => 'published',
            'timestamp' => 1710000000,
            'date_iso' => '2024-03-09T16:00:00Z',
            'title' => '',
            'permalink' => 'https://vael.tumblr.com/post/987654321098/photo-post',
            'tags' => ['vaelvict.us', 'art', 'game-dev'],
            'type' => 'photo',
            'body_html' => '',
            'summary_html' => '',
            'photos' => [
                [
                    'url' => 'https://64.media.tumblr.com/example/s1280x1920/image.jpg',
                    'width' => 1280,
                    'height' => 720,
                    'alt' => 'Game screenshot showing the main interface'
                ]
            ]
        ],
        [
            'id' => '111222333444',
            'state' => 'published',
            'timestamp' => 1715000000,
            'date_iso' => '2024-05-06T11:33:20Z',
            'title' => 'Player-First Game Design',
            'permalink' => 'https://vael.tumblr.com/post/111222333444/player-first-design',
            'tags' => ['vaelvict.us', 'game-design', 'ethics', 'tinydark'],
            'type' => 'text',
            'body_html' => '<p>At Tinydark, we believe games should benefit players, not exploit them. This philosophy shapes every design decision we make.</p><p>Too many modern games are designed to extract maximum value from players through predatory monetization, artificial time gates, and psychological manipulation. We take a different approach.</p><p>Our mission statement commits us to creating games that respect players\' time, money, and mental health. Here\'s how we put that into practice...</p>',
            'summary_html' => '<p>How Tinydark approaches ethical game design.</p>',
            'photos' => []
        ]
    ];
    
    // filter to only posts with the required tag
    $filtered = array_filter($dummy_posts, function($post) use ($tag_filter) {
        $tags = array_map('strtolower', $post['tags'] ?? []);
        return in_array(strtolower($tag_filter), $tags);
    });
    
    return array_values($filtered);
}

/**
 * only import posts that are published
 */
function is_publishable_post(array $post): bool {
    $is_publishable = true;

    if (isset($post['is_draft']) && $post['is_draft']) {
        $is_publishable = false;
    }

    if (isset($post['draft']) && $post['draft']) {
        $is_publishable = false;
    }

    if (isset($post['published']) && $post['published'] === false) {
        $is_publishable = false;
    }

    if (isset($post['state'])) {
        $state = strtolower((string) $post['state']);
        if ($state !== 'published') {
            $is_publishable = false;
        }
    }

    if (isset($post['status'])) {
        $status = strtolower((string) $post['status']);
        $non_published = ['draft', 'queued', 'queue', 'private', 'unpublished'];
        if (in_array($status, $non_published, true)) {
            $is_publishable = false;
        }
    }

    return $is_publishable;
}
