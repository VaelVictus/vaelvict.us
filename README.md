# vaelvict.us

Single-page personal/portfolio site built with **vanilla PHP**, **Vite**, and **Tailwind CSS**. Includes a lightweight PHP blog that renders from a local filesystem cache (intended to be synced from Tumblr).

## Tech stack

- **PHP**: server-rendered pages (`index.php`, `blog/*`)
- **Vite**: JS/CSS bundling + dev server (starts at **1337**, auto-increments if busy)
- **Tailwind**: compiled via Vite/PostCSS from `src/style.css`

## Prerequisites

- **PHP** web server (Laragon/Apache, nginx+php-fpm, etc.)
- **Node.js + npm**

## Setup

Install dependencies:

```bash
npm install
```

Create `secrets.php` (required at runtime; ignored by git):

- Copy/paste and adjust values in `secrets.php` (it already exists in this repo, but on a fresh clone you’ll need your own copy).
- It is required by `inc/helpers.php` and by `bin/sync_tumblr.php`.

## Development (local)

Run the Vite dev server (starts at **1337**, uses the next free port if needed):

```bash
npm run dev
```

Serve the project root via your PHP server (Laragon is typical for this repo).

In dev mode, PHP pages load scripts from the Vite server:

- Homepage: `http://localhost:<vite-port>/main.js`
- Blog: `http://localhost:<vite-port>/blog.js`

Dev/prod switching is determined in `inc/helpers.php` based on host/server name.

## Build (production)

Build the hashed assets and `dist/manifest.json`:

```bash
npm run build
```

In prod mode, PHP reads `dist/manifest.json` and includes the built assets under `dist/`.

## Blog / Tumblr cache

The blog reads posts from the filesystem (not from Tumblr live):

- Index: `storage/tumblr/posts_index.json`
- Posts: `storage/tumblr/posts/*.json`

To (re)generate the cache:

```bash
php bin/sync_tumblr.php
```

Note: `bin/sync_tumblr.php` currently contains a stub `fetch_tumblr_posts(...)` that returns dummy data for testing; replacing it with real Tumblr API calls is the intended next step.

## Project layout (high level)

- `index.php`: homepage template (loads Vite assets in dev/prod)
- `blog/index.php`, `blog/post.php`: blog list + post pages
- `main.js`, `blog.js`: Vite entrypoints
- `src/style.css`: Tailwind source
- `dist/`: Vite build output (including `manifest.json`)
- `storage/tumblr/`: cached blog data

## Agent notes

See `agents.md` for repo conventions and “how to work here” guidance.