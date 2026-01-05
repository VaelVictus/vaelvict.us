<?php
declare(strict_types=1);

$project_root = dirname(__DIR__);
require_once $project_root . '/inc/helpers.php';
require_once $project_root . '/src/TumblrStore.php';

$manifest = json_decode(file_get_contents($project_root . '/dist/manifest.json'), true);
$storage_dir = $project_root . '/storage/tumblr';

// get post id from query
$post_id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($post_id)) {
    http_response_code(404);
    $post = null;
    $error = 'No post ID provided.';
} else {
    $post = get_post_by_id($storage_dir, $post_id);
    if ($post === null) {
        http_response_code(404);
        $error = 'Post not found.';
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

    <title><?= $page_title ?></title>

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
    <meta property="og:url" content="https://vaelvict.us/blog/post.php?id=<?= $post_id ?>" />
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
                <div class='w-full px-2 sm:px-3 p-3 overflow-auto bg-white'>
                    <?php if ($post === null) { ?>
                        <div class="blog_error">
                            <h3>404 - Not Found</h3>
                            <p><?= $error ?></p>
                            <p><a href="/blog/">Return to blog list</a></p>
                        </div>
                    <?php } else { ?>
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
                    <?php } ?>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
