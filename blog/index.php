<?
declare(strict_types=1);

$project_root = dirname(__DIR__);
require_once $project_root . '/inc/helpers.php';
require_once $project_root . '/src/TumblrStore.php';

$storage_dir = $project_root . '/storage/tumblr';

// get query parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
$order = isset($_GET['order']) && $_GET['order'] === 'oldest' ? 'oldest' : 'newest';
$show_all = isset($_GET['show_all']) && ((string)$_GET['show_all'] === '1' || (string)$_GET['show_all'] === 'true');

// load and process posts
$posts_index = load_posts_index($storage_dir);
$sorted_posts = sort_posts_index($posts_index, $order);
$pagination = [];
if ($show_all) {
    $total_items = count($sorted_posts);
    $pagination = [
        'page' => 1,
        'per_page' => $total_items,
        'total_items' => $total_items,
        'total_pages' => 1,
        'items' => $sorted_posts,
        'has_prev' => false,
        'has_next' => false,
        'prev_page' => null,
        'next_page' => null,
    ];
} else {
    $pagination = paginate($sorted_posts, $page, $per_page);
}

// helper to build pagination urls
function build_url(int $page, int $per_page, string $order, bool $show_all): string {
    $params = [];
    if ($show_all) {
        $params['show_all'] = 1;
    } else {
    if ($page > 1) {
        $params['page'] = $page;
    }
    if ($per_page !== 10) {
        $params['per_page'] = $per_page;
    }
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
<? if (DEV_ENV == 'prod') { ?>
    <? $manifest = json_decode(file_get_contents($project_root . '/dist/manifest.json'), true); ?>
    <? foreach ($manifest['index.html']['css'] as $path) { ?>
        <link rel="stylesheet" href="/dist/<?=$path?>">
    <? } ?>
<? } else { ?>
    <link rel="stylesheet" href="<?= VITE_ORIGIN ?>/src/style.css">
    <script type="module" src="<?= VITE_ORIGIN ?>/blog.js"></script>
<? } ?>

    <? require_once $project_root . '/inc/head_static.php'; ?>

    <title>Vael Victus - Blog</title>

    <meta name="title" content="Blog - Vael Victus">
    <meta name="description" content="Blog posts from Vael Victus - game designer and web developer.">

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Blog - Vael Victus" />
    <meta property="og:description" content="Blog posts from Vael Victus - game designer and web developer." />
    <meta property="og:url" content="https://vaelvict.us/blog/" />
    <meta property="og:site_name" content="Vael Victus" />

</head>

<body>
    <main class="text-base overflow-auto bg-cover w-full h-full">
        <div class="w-full max-w-3xl flex flex-wrap mx-auto">
            <nav class="blog_back_nav">
                <a href="/">
                    <span class="post_nav_arrow">&larrhk;</span>
                    <span>Back to Home Page</span>
                </a>
            </nav>

            <section style='opacity: 1; transform: none;'>
                <div class="w-full px-2 sm:px-3 pt-1 sm:pt-3 shadow-xs section_header blog_header">
                    <h2 class='m-0'>Blog</h2>
                </div>

                <div class='w-full px-2 sm:px-3 p-3 overflow-auto bg-white'>

                    <div class="blog_controls">
                        <div>
                            <? if ($show_all) { ?>
                                Showing all posts.
                            <? } else { ?>
                                Showing <?= count($pagination['items']) ?> of <?= $pagination['total_items'] ?> posts. 
                                <? if (count($pagination['items']) < $pagination['total_items']) { ?>
                                    <a href="<?= build_url(1, $per_page, $order, true) ?>">Show all.</a>
                                <? } ?>
                            <? } ?>
                        </div>
                        <div class="blog_sort_controls">
                            Sort:
                            <a href="<?= build_url(1, $per_page, 'newest', $show_all) ?>" class="<?= $order === 'newest' ? 'active_sort' : '' ?>">Newest</a>
                            <a href="<?= build_url(1, $per_page, 'oldest', $show_all) ?>" class="<?= $order === 'oldest' ? 'active_sort' : '' ?>">Oldest</a>
                        </div>
                    </div>

                    <? 
                    $items = $pagination['items'];
                    $total_items = count($items);
                    foreach ($items as $index => $post) { 
                        $post_url = build_post_url($post);
                    ?>
                        <a class="blog_post_item blog_post_link py-2" href="<?= $post_url ?>">
                            <div class="blog_post_title">
                                <? if (!empty($post['title'])) { ?>
                                    <?= $post['title'] ?>
                                <? } else { ?>
                                    <? if ($post['type'] === 'photo') { ?>
                                        <span class="blog_photo_indicator">[Photo post]</span>
                                    <? } else { ?>
                                        <span class="blog_photo_indicator">[Untitled]</span>
                                    <? } ?>
                                <? } ?>
                            </div>
                            <div class="blog_post_meta mb-1">
                                <?= format_date($post['date_iso']) ?>
                                <? if ($post['type'] !== 'text') { ?>
                                    &middot; <?= ucfirst($post['type']) ?>
                                <? } ?>
                            </div>
                            <? if (!empty($post['excerpt'])) { ?>
                                <div class="blog_post_excerpt"><?= $post['excerpt'] ?></div>
                            <? } ?>
                        </a>
                        <? if ($index < $total_items - 1) { ?>
                            <hr class="blog_post_hr">
                        <? } ?>
                    <? } ?>

                    <? if ($pagination['total_pages'] > 1) { ?>
                        <nav class="blog_pagination">
                            <? if ($pagination['has_prev']) { ?>
                                <a href="<?= build_url($pagination['prev_page'], $per_page, $order, $show_all) ?>">&larr; Prev</a>
                            <? } else { ?>
                                <span class="disabled">&larr; Prev</span>
                            <? } ?>

                            <?
                            // show page numbers
                            $start_page = max(1, $pagination['page'] - 2);
                            $end_page = min($pagination['total_pages'], $pagination['page'] + 2);
                            
                            if ($start_page > 1) {
                                echo '<a href="' . build_url(1, $per_page, $order, $show_all) . '">1</a>';
                                if ($start_page > 2) {
                                    echo '<span>...</span>';
                                }
                            }
                            
                            for ($i = $start_page; $i <= $end_page; $i++) {
                                if ($i === $pagination['page']) {
                                    echo '<span class="current_page">' . $i . '</span>';
                                } else {
                                    echo '<a href="' . build_url($i, $per_page, $order, $show_all) . '">' . $i . '</a>';
                                }
                            }
                            
                            if ($end_page < $pagination['total_pages']) {
                                if ($end_page < $pagination['total_pages'] - 1) {
                                    echo '<span>...</span>';
                                }
                                echo '<a href="' . build_url($pagination['total_pages'], $per_page, $order, $show_all) . '">' . $pagination['total_pages'] . '</a>';
                            }
                            ?>

                            <? if ($pagination['has_next']) { ?>
                                <a href="<?= build_url($pagination['next_page'], $per_page, $order, $show_all) ?>">Next &rarr;</a>
                            <? } else { ?>
                                <span class="disabled">Next &rarr;</span>
                            <? } ?>
                        </nav>
                    <? } ?>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
