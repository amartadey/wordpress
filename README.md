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

1. Go to the **Releases** tab of this repository.
2. Open the latest release (e.g. `v6.x.x`).
3. Download `wordpress-custom-x.x.x.zip` from the release assets.

To always fetch the latest release asset programmatically:

```
https://github.com/YOUR_USERNAME/YOUR_REPO/releases/latest/download/wordpress-custom-REPLACE_VERSION.zip
```

Or use the GitHub API to find the current latest version:

```bash
curl -s https://api.github.com/repos/YOUR_USERNAME/YOUR_REPO/releases/latest \
  | python3 -c "import sys, json; r=json.load(sys.stdin); print(r['assets'][0]['browser_download_url'])"
```

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
