<?php
declare(strict_types=1);

$project_root = dirname(__DIR__);
require_once $project_root . '/inc/helpers.php';
require_once $project_root . '/src/TumblrStore.php';

$storage_dir = $project_root . '/storage/tumblr';

// get post id or slug from query
$post_id = isset($_GET['id']) ? $_GET['id'] : '';
$post_slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$posts_index = null;

if (!empty($post_slug)) {
    $post_slug = preg_replace('/[^a-zA-Z0-9-]/', '', $post_slug);
    $post_slug = strtolower((string) $post_slug);
    if ($post_slug !== '') {
        $posts_index = load_posts_index($storage_dir);
        $post_id = find_post_id_by_slug($posts_index, $post_slug) ?? '';
    }
}

if (empty($post_id)) {
    http_response_code(404);
    $post = null;
    $error = $post_slug !== '' ? 'Post not found.' : 'No post ID or slug provided.';
} else {
    $post = get_post_by_id($storage_dir, $post_id);
    if ($post === null) {
        http_response_code(404);
        $error = 'Post not found.';
    }
}

if ($post !== null) {
    $canonical_slug = get_post_slug($post);
    if ($canonical_slug !== '') {
        if (empty($post_slug) || $post_slug !== $canonical_slug) {
            header('Location: /blog/post/' . $canonical_slug, true, 301);
            exit;
        }
    }
}

// find prev/next posts
$prev_post = null;
$next_post = null;
if ($post !== null) {
    if ($posts_index === null) {
        $posts_index = load_posts_index($storage_dir);
    }
    $sorted_posts = sort_posts_index($posts_index, 'newest');
    
    // find current post position
    $current_idx = null;
    foreach ($sorted_posts as $idx => $p) {
        if ($p['id'] === $post_id) {
            $current_idx = $idx;
            break;
        }
    }
    
    if ($current_idx !== null) {
        // prev is newer (lower index), next is older (higher index)
        if ($current_idx > 0) {
            $prev_post = $sorted_posts[$current_idx - 1];
        }
        if ($current_idx < count($sorted_posts) - 1) {
            $next_post = $sorted_posts[$current_idx + 1];
        }
    }
}

// helper to format date
function format_post_date(string $iso_date): string {
    $date = new DateTime($iso_date);
    return $date->format('F j, Y \a\t g:i A');
}

$page_title = $post !== null && !empty($post['title']) ? $post['title'] . ' - Vael Victus' : 'Blog Post - Vael Victus';
$page_description = $post !== null && !empty($post['summary_html']) 
    ? strip_tags($post['summary_html']) 
    : 'Blog post from Vael Victus';
$post_url = $post !== null ? build_post_url($post) : '/blog/';
$canonical_url = $post !== null ? 'https://vaelvict.us' . $post_url : 'https://vaelvict.us/blog/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php if (DEV_ENV == 'prod') { ?>
    <?php $manifest = json_decode(file_get_contents($project_root . '/dist/manifest.json'), true); ?>
    <?php foreach ($manifest['index.html']['css'] as $path) { ?>
        <link rel="stylesheet" href="/dist/<?=$path?>">
    <?php } ?>
<?php } else { ?>
    <link rel="stylesheet" href="<?= VITE_ORIGIN ?>/src/style.css">
    <script type="module" src="<?= VITE_ORIGIN ?>/blog.js"></script>
<?php } ?>

    <title>Vael Victus - <?= $page_title ?></title>

    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="<?= $page_title ?>">
    <meta name="description" content="<?= $page_description ?>">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Vael Victus">

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?= $page_title ?>" />
    <meta property="og:description" content="<?= $page_description ?>" />
    <meta property="og:url" content="<?= $canonical_url ?>" />
    <meta property="og:site_name" content="Vael Victus" />

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#000000">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Charm:wght@400;700&family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <main class="text-base overflow-auto bg-cover w-full h-full">
        <div class="w-full max-w-3xl flex flex-wrap mx-auto mb-3">
            <nav class="blog_back_nav">
                <a href="/">&larr; Back to Home</a>
            </nav>

            <section style='opacity: 1; transform: none;'>
                <div class='w-full px-2 sm:px-3 p-3 overflow-auto bg-white'>
                    <?php if ($post === null) { ?>
                        <div class="blog_error">
                            <h3>404 - Not Found</h3>
                            <p><?= $error ?></p>
                            <p><a href="/blog/">Return to blog list</a></p>
                        </div>
                    <?php } else { ?>
                        <nav class="post_nav">
                            <div class="post_nav_prev">
                                <?php if ($prev_post !== null) { ?>
                                    <a href="<?= build_post_url($prev_post) ?>">
                                        <span class="post_nav_arrow">&larr;</span>
                                        <span class="post_nav_title"><?= !empty($prev_post['title']) ? $prev_post['title'] : '[Untitled]' ?></span>
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="post_nav_center">
                                <a href="/blog/">
                                    <button class="button_primary" type="button">Archive</button>
                                </a>
                            </div>
                            <div class="post_nav_next">
                                <?php if ($next_post !== null) { ?>
                                    <a href="<?= build_post_url($next_post) ?>">
                                        <span class="post_nav_title"><?= !empty($next_post['title']) ? $next_post['title'] : '[Untitled]' ?></span>
                                        <span class="post_nav_arrow">&rarr;</span>
                                    </a>
                                <?php } ?>
                            </div>
                        </nav>

                        <article>
                            <header class="blog_post_header">
                                <?php if (!empty($post['title'])) { ?>
                                    <h1 class="blog_post_title"><?= $post['title'] ?></h1>
                                <?php } ?>
                                <div class="blog_post_meta">
                                    <?= format_post_date($post['date_iso']) ?>
                                    <?php if ($post['type'] !== 'text') { ?>
                                        &middot; <?= ucfirst($post['type']) ?> post
                                    <?php } ?>
                                </div>
                            </header>

                            <div class="blog_post_content">
                                <?php if (!empty($post['body_html'])) { ?>
                                    <?= $post['body_html'] ?>
                                <?php } ?>

                                <?php if (!empty($post['photos'])) { ?>
                                    <div class="blog_post_photos">
                                        <?php foreach ($post['photos'] as $img) { ?>
                                            <figure class="blog_photo">
                                                <img src="<?= $img['url'] ?>" 
                                                     alt="<?= !empty($img['alt']) ? $img['alt'] : '' ?>"
                                                     <?php if (!empty($img['width'])) { ?>width="<?= $img['width'] ?>"<?php } ?>
                                                     <?php if (!empty($img['height'])) { ?>height="<?= $img['height'] ?>"<?php } ?>>
                                                <?php if (!empty($img['alt'])) { ?>
                                                    <figcaption class="blog_photo_caption"><?= $img['alt'] ?></figcaption>
                                                <?php } ?>
                                            </figure>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </article>

                        <nav class="post_nav post_nav_bottom">
                            <div class="post_nav_prev">
                                <?php if ($prev_post !== null) { ?>
                                    <a href="<?= build_post_url($prev_post) ?>">
                                        <span class="post_nav_arrow">&larr;</span>
                                        <span class="post_nav_title"><?= !empty($prev_post['title']) ? $prev_post['title'] : '[Untitled]' ?></span>
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="post_nav_center">
                                <a href="/blog/">
                                    <button class="button_primary" type="button">Archive</button>
                                </a>
                            </div>
                            <div class="post_nav_next">
                                <?php if ($next_post !== null) { ?>
                                    <a href="<?= build_post_url($next_post) ?>">
                                        <span class="post_nav_title"><?= !empty($next_post['title']) ? $next_post['title'] : '[Untitled]' ?></span>
                                        <span class="post_nav_arrow">&rarr;</span>
                                    </a>
                                <?php } ?>
                            </div>
                        </nav>
                    <?php } ?>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
