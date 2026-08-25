# gallery.svaff.org

Official photo gallery for the Silicon Valley African Film Festival.

## Architecture

- **PHP 8.4** — zero Composer, zero database
- **Auto-discovery** — `scandir()` on `assets/photos/{year}/{photographer}/{collection}/`
- **5-minute cache** — flat JSON file at `inc/cache/gallery_index.json`
- **Shared nav/footer** — pulled from `svaff-shared` repo on every deploy

## Adding Photos

Upload via SFTP to:
```
/home/svaff-gallery/htdocs/gallery.svaff.org/assets/photos/{year}/{photographer}/{collection}/
```

Naming convention — underscores throughout:
- `2025/Asha_Alessandra/Opening_Night/`
- `2025/Drew_Altizer/Closing_Night/`

A new folder appears on the site within 5 minutes (cache TTL). To bust immediately, delete `inc/cache/gallery_index.json`.

## Flat photographer folder (no collection subdir)

If a photographer folder contains images directly (no subdir), it renders as a single collection labelled **"All Images"**. Use slug `all` in URLs.

## Deploy

Push to `main` → GitHub Actions → rsync to server (excludes `assets/photos` and `inc/cache`).

**Required GitHub Secret:** `GALLERY_SSH_PRIVATE_KEY` — SSH key for `svaff-gallery@gallery.svaff.org`.
<!-- deployed Tue Aug 25 10:49:41 PM UTC 2026 -->
