<?php
declare(strict_types=1);

$project_root = dirname(__DIR__);
require_once($project_root . '/inc/helpers.php');
require_once($project_root . '/src/TumblrStore.php');

$manifest = json_decode(file_get_contents($project_root . '/dist/manifest.json'), true);
$storage_dir = $project_root . '/storage/tumblr';

// get query parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
$order = isset($_GET['order']) && $_GET['order'] === 'oldest' ? 'oldest' : 'newest';

// load and process posts
$posts_index = load_posts_index($storage_dir);
$sorted_posts = sort_posts_index($posts_index, $order);
$pagination = paginate($sorted_posts, $page, $per_page);

// helper to build pagination urls
function build_url(int $page, int $per_page, string $order): string {
    $params = [];
    if ($page > 1) {
        $params['page'] = $page;
    }
    if ($per_page !== 10) {
        $params['per_page'] = $per_page;
    }
    if ($order !== 'newest') {
        $params['order'] = $order;
    }
    if (empty($params)) {
        return '/blog/';
    }
    return '/blog/?' . http_build_query($params);
}

// helper to format date
function format_date(string $iso_date): string {
    $date = new DateTime($iso_date);
    return $date->format('F j, Y');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php if (DEV_ENV == 'prod') { ?>
    <?php foreach ($manifest['index.html']['css'] as $path) { ?>
        <link rel="stylesheet" href="/dist/<?=$path?>">
    <?php } ?>
<?php } else { ?>
    <link rel="stylesheet" href="/css/style.css">
    <script type="module" src="http://localhost:1337/blog.js"></script>
<?php } ?>

    <title>Blog - Vael Victus</title>

    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Blog - Vael Victus">
    <meta name="description" content="Blog posts from Vael Victus - game designer and web developer.">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Vael Victus">

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Blog - Vael Victus" />
    <meta property="og:description" content="Blog posts from Vael Victus - game designer and web developer." />
    <meta property="og:url" content="https://vaelvict.us/blog/" />
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
        <div class="w-full max-w-3xl flex flex-wrap mx-auto">
            <section class='mt-0 sm:mt-2' style='opacity: 1; transform: none;'>
                <div class="w-full px-2 sm:px-3 pt-1 sm:pt-3 shadow-xs section_header blog_header">
                    <h2 class='m-0'>Blog</h2>
                </div>

                <div class='w-full px-2 sm:px-3 p-3 overflow-auto bg-white'>

                    <?php if (empty($pagination['items'])) { ?>
                        <div class="blog_empty">
                            <p>No blog posts yet. Run the sync script to fetch posts from Tumblr.</p>
                        </div>
                    <?php } else { ?>
                        <div class="blog_controls">
                            <div>
                                Showing <?= count($pagination['items']) ?> of <?= $pagination['total_items'] ?> posts
                            </div>
                            <div class="blog_sort_controls">
                                Sort:
                                <a href="<?= build_url(1, $per_page, 'newest') ?>" class="<?= $order === 'newest' ? 'active_sort' : '' ?>">Newest</a>
                                <a href="<?= build_url(1, $per_page, 'oldest') ?>" class="<?= $order === 'oldest' ? 'active_sort' : '' ?>">Oldest</a>
                            </div>
                        </div>

                        <?php foreach ($pagination['items'] as $post) { ?>
                            <article class="blog_post_item">
                                <div class="blog_post_title">
                                    <?php if (!empty($post['title'])) { ?>
                                        <a href="/blog/post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                                    <?php } else { ?>
                                        <a href="/blog/post.php?id=<?= $post['id'] ?>">
                                            <?php if ($post['type'] === 'photo') { ?>
                                                <span class="blog_photo_indicator">[Photo post]</span>
                                            <?php } else { ?>
                                                <span class="blog_photo_indicator">[Untitled]</span>
                                            <?php } ?>
                                        </a>
                                    <?php } ?>
                                </div>
                                <div class="blog_post_meta">
                                    <?= format_date($post['date_iso']) ?>
                                    <?php if ($post['type'] !== 'text') { ?>
                                        &middot; <?= ucfirst($post['type']) ?>
                                    <?php } ?>
                                </div>
                                <?php if (!empty($post['excerpt'])) { ?>
                                    <div class="blog_post_excerpt"><?= $post['excerpt'] ?></div>
                                <?php } ?>
                            </article>
                        <?php } ?>

                        <?php if ($pagination['total_pages'] > 1) { ?>
                            <nav class="blog_pagination">
                                <?php if ($pagination['has_prev']) { ?>
                                    <a href="<?= build_url($pagination['prev_page'], $per_page, $order) ?>">&larr; Prev</a>
                                <?php } else { ?>
                                    <span class="disabled">&larr; Prev</span>
                                <?php } ?>

                                <?php
                                // show page numbers
                                $start_page = max(1, $pagination['page'] - 2);
                                $end_page = min($pagination['total_pages'], $pagination['page'] + 2);
                                
                                if ($start_page > 1) {
                                    echo '<a href="' . build_url(1, $per_page, $order) . '">1</a>';
                                    if ($start_page > 2) {
                                        echo '<span>...</span>';
                                    }
                                }
                                
                                for ($i = $start_page; $i <= $end_page; $i++) {
                                    if ($i === $pagination['page']) {
                                        echo '<span class="current_page">' . $i . '</span>';
                                    } else {
                                        echo '<a href="' . build_url($i, $per_page, $order) . '">' . $i . '</a>';
                                    }
                                }
                                
                                if ($end_page < $pagination['total_pages']) {
                                    if ($end_page < $pagination['total_pages'] - 1) {
                                        echo '<span>...</span>';
                                    }
                                    echo '<a href="' . build_url($pagination['total_pages'], $per_page, $order) . '">' . $pagination['total_pages'] . '</a>';
                                }
                                ?>

                                <?php if ($pagination['has_next']) { ?>
                                    <a href="<?= build_url($pagination['next_page'], $per_page, $order) ?>">Next &rarr;</a>
                                <?php } else { ?>
                                    <span class="disabled">Next &rarr;</span>
                                <?php } ?>
                            </nav>
                        <?php } ?>
                    <?php } ?>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
