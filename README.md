# Tarot Gợi Mở → GitHub → WordPress

Custom WordPress theme for **Tarot Gợi Mở**, based on the V2 Dark Elegant direction.

## Current build

- Dark Elegant palette: charcoal black, antique gold, wine red.
- Single-card Major Arcana draw.
- Random upright / reversed orientation.
- Last draw saved locally in the browser.
- Copy reading button.
- Full 22 Major Arcana library.
- Each card includes: Tổng quan, Tình cảm, Công việc, Tài chính, Nội tâm, Đảo ngược, Lời nhắc.
- Reflective wording: the site does not present Tarot as certain prediction.

Theme path: `themes/tarot-goi-mo/`

## GitHub Actions

Workflow: `.github/workflows/deploy-wordpress.yml`

Every push to `main` that changes the theme first validates PHP and confirms the JSON contains all 22 cards.

Deployment is intentionally skipped until SFTP settings exist.

When the WordPress host is ready, add these GitHub Actions repository secrets:

- `SFTP_HOST`
- `SFTP_USERNAME`
- `SFTP_PASSWORD`
- `SFTP_PORT` (optional; defaults to 22)
- `SFTP_PATH` — target theme directory, for example `/public_html/wp-content/themes/tarot-goi-mo/`

After the secrets are configured, future pushes to `main` will validate and then mirror the theme folder to the configured WordPress theme directory.

## Important

Do not configure production SFTP secrets until the target WordPress URL and cPanel/SFTP information have been checked.
