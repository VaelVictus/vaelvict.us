# Agents: `vaelvict.us`

This repo is a vanilla PHP personal/portfolio site with a small PHP blog that renders from a filesystem cache (synced from Tumblr). Frontend assets are bundled by Vite and CSS is generated via Tailwind (Vite/PostCSS).

## Quick orientation

- **Primary entrypoints**
  - `index.php`: homepage (PHP-rendered)
  - `blog/index.php`: blog listing
  - `blog/post.php`: blog post view
- **Frontend**
  - `main.js`: homepage JS entry (Vite dev + build)
  - `blog.js`: blog JS entry (Vite dev + build)
  - `src/style.css`: Tailwind source (compiled by Vite/PostCSS)
- **Build output**
  - `dist/manifest.json`: Vite manifest consumed by PHP to load hashed assets in prod
  - `dist/assets/*`: built assets
- **Blog storage**
  - `storage/tumblr/posts_index.json`: lightweight index for listing/pagination
  - `storage/tumblr/posts/*.json`: full post payloads
  - `storage/tumblr/meta.json`: last sync metadata
- **Sync**
  - `bin/sync_tumblr.php`: CLI sync script (currently includes a stub fetch implementation)
- **Secrets**
  - `secrets.php`: required at runtime; ignored by git (`.gitignore`)

## Local development

This project expects **two** processes in dev:

- **PHP server** (Apache/Laragon, or any PHP host) serving the project root
- **Vite dev server** starting at port **1337** for JS/CSS HMR (auto-increments if busy)

Commands:

- `npm install`
- `npm run dev` (Vite starts at `http://localhost:1337` and uses the next free port if needed)

In dev mode, PHP pages load scripts from the Vite server:

- `index.php` loads `http://localhost:<vite-port>/main.js`
- blog pages load `http://localhost:<vite-port>/blog.js`

Dev/prod mode is decided in `inc/helpers.php` based on `$_SERVER['SERVER_NAME']` / `$_SERVER['HTTP_HOST']`.

## Production build

- `npm install`
- `npm run build`

In prod mode, PHP reads `dist/manifest.json` and includes the hashed asset paths under `dist/`.

## Tumblr/blog data flow

- The blog does not hit Tumblr live; it reads from `storage/tumblr/*`.
- Run `php bin/sync_tumblr.php` to populate/update cache files.
- The sync script currently uses a **stub** `fetch_tumblr_posts(...)` that returns dummy data; swapping this for real Tumblr API calls is the intended next step.
- If APCu is available, `src/TumblrStore.php` caches `posts_index.json` and individual post JSON reads.

## Conventions (important)

Follow these repo conventions when editing code:

- **General**
  - all variables should be `snake_case`
  - all comments must start with lowercase letters
- **PHP**
  - never use `endif`/`endforeach`/etc; always use brackets
  - never use `htmlspecialchars()` (assume data is already sanitized)
  - never use `error_log()`; echo debugging output instead
- **JavaScript**
  - function names in `camelCase`
  - use ES2023+ (prefer `let`/`const` over `var`)
  - do not sanitize strings here (assume sanitized elsewhere)
- **CSS**
  - all class names should be `snake_case`
  - do not reformat CSS styles; do not remove comments unless they are irrelevant

## Common pitfalls

- `secrets.php` is required by `inc/helpers.php`; missing it will break the site.
- Vite dev uses port **1337** (see `vite.config.js`); if you change it, update PHP templates accordingly.
- Vite dev starts at port **1337** (see `vite.config.js`) and auto-increments; PHP discovers the active port at runtime.
- The blog will appear empty until `storage/tumblr/posts_index.json` exists (run the sync script).

