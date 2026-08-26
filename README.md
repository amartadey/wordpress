# Custom WordPress Build

Automated GitHub Actions workflow that builds a clean, opinionated WordPress zip and publishes it as a GitHub Release every day.

## What's included

**Plugins**
- [aam-wp-migration](https://github.com/amartadey/Some-Tools) — migration helper
- [classic-editor](https://wordpress.org/plugins/classic-editor/) — restores the classic editor
- [secure-custom-fields](https://wordpress.org/plugins/secure-custom-fields/) — custom fields (community fork of ACF)

**Theme**
All default WordPress themes (Twenty Twenty-*) are removed. Ships `wgh-starter` — the blank scaffold used as the base for every new build. It bundles its own assets under `wgh-starter/assets/` (Bootstrap, Font Awesome 4.7, Owl Carousel, Superfish, Responsive Slides) and is auto-activated on first boot.

**Extras**
- Opinionated root `.htaccess` — gzip, far-future caching for static assets, blocks `wp-config.php` / `readme.html` / `xmlrpc.php`.
- `readme.html` is stripped from the build (version disclosure).

## How to get the zip

### Always-latest link (like wordpress.org/latest.zip)

```
https://github.com/amartadey/wordpress/releases/latest/download/wordpress-custom-latest.zip
```

This URL redirects to whichever release is marked **latest** — the workflow forces that pointer on every run, so it is never stale.

### Specific version

All versions are kept under the [Releases](https://github.com/amartadey/wordpress/releases) tab. Each release contains two assets:

| File | Purpose |
|---|---|
| `wordpress-custom-x.x.x.zip` | Named after the WordPress core version |
| `wordpress-custom-latest.zip` | Fixed-name alias (same file) |

The `vX.Y.Z` release is **rebuilt in place** — its assets are refreshed daily with the newest plugin versions, so a given tag is not a frozen bundle, it tracks the latest safe build for that WordPress core version.

## Build schedule

Runs every day at **06:00 UTC**, and on **push to `main`** (`wgh-starter/`, `mu-plugins/`, or the workflow) and **manual dispatch**.

Every run does a full rebuild: fresh WordPress core, fresh plugins, current theme. It then creates the `vX.Y.Z` release (new core version) or refreshes the existing one's assets, and forces it to be the **latest** release. Plugins and core therefore never go stale between WordPress version bumps.

## Manual trigger

**Actions → Build Custom WordPress → Run workflow**.

## Repo structure

```
.github/workflows/build.yml   ← build pipeline
wgh-starter/                   ← the scaffold theme (PHP + assets/)
mu-plugins/wgh-auto-setup.php  ← first-boot setup (theme + plugins + cleanup + screenshot)
README.md
```

WordPress core and the three plugins are downloaded fresh each run from official sources.
