# Custom WordPress Build

Automated GitHub Actions workflow that builds a clean, opinionated WordPress zip and publishes it as a GitHub Release every day.

## What's included

**Plugins**
- [aam-wp-migration](https://github.com/amartadey/Some-Tools) — migration helper
- [classic-editor](https://wordpress.org/plugins/classic-editor/) — restores the classic editor
- [secure-custom-fields](https://wordpress.org/plugins/secure-custom-fields/) — custom fields (community fork of ACF)

**Themes**
All default WordPress themes (Twenty Twenty-*) are removed. The `wp-content/themes/` folder is empty except for a silent `index.php` placeholder.

## How to get the zip

### Always-latest link (like wordpress.org/latest.zip)

```
https://github.com/amartadey/wordpress/releases/latest/download/wordpress-custom-latest.zip
```

This URL permanently redirects to the latest build. Bookmark it, use it in scripts, or share it — it never changes.

### Specific version

All versions are kept under the [Releases](https://github.com/amartadey/wordpress/releases) tab. Each release contains two assets:

| File | Purpose |
|---|---|
| `wordpress-custom-x.x.x.zip` | Versioned archive |
| `wordpress-custom-latest.zip` | Fixed-name alias (same file) |

## Build schedule

The workflow runs automatically every day at **06:00 UTC**. It detects the current WordPress version and only creates a new release if one for that version doesn't already exist — so re-runs are safe and idempotent.

## Manual trigger

Go to **Actions → Build Custom WordPress → Run workflow** to trigger a build immediately.

## Repo structure

```
.github/
  workflows/
    build.yml   ← the entire build pipeline
README.md
```

No source files are committed. Everything is downloaded fresh each run from official sources.
