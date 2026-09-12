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

Every push to `main` that changes the theme first validates PHP and confirms the theme contains all 22 Major Arcana cards.

Deployment is intentionally skipped until the SSH settings exist.

When the WordPress host is ready, add these GitHub Actions repository secrets:

- `SSH_HOST`
- `SSH_USERNAME`
- `SSH_PRIVATE_KEY`
- `SSH_PORT` (optional; defaults to 22)
- `SSH_PATH` — target theme directory on the server

The cPanel public key used for deployment should be authorized first. The matching private key belongs only in the GitHub Actions secret `SSH_PRIVATE_KEY`; do not commit it to this repository.

After the secrets are configured, future pushes to `main` will validate, test the SSH connection, and then sync `themes/tarot-goi-mo/` to the configured WordPress theme directory.

## Important

Do not configure the production SSH secrets until the host name, port, username, and exact WordPress theme path have been checked.
