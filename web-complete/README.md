# Tarot Gợi Mở — complete standalone web edition

Vietnamese static Tarot application inspired by the functional flows at boitarot.com.vn, with independently written copy and original symbolic SVG illustrations.

## Included
- 78 cards: 22 Major Arcana and 56 Minor Arcana; individually authored upright/reversed meanings.
- Three-card spread, daily card across five topics (Vietnam timezone), and custom-question single-card reading.
- 17 topics, suggested questions, three clearly labeled automated reading styles.
- Browser Web Crypto shuffle, no duplicate cards, 25% reversed orientation.
- Search/filter/pagination, 78 card detail pages, six original guide articles.
- Local journal (100 entries), delete, JSON export, copy/download result.
- Responsive navigation, keyboard controls, reduced-motion support, CSP and security headers.
- No application dependencies; Node.js build and tests.

## Run
`npm test`
`npm run build`
Serve `dist/` with any static server. Production uses HTTPS.

## Vercel
Import this repository branch `web-complete-20261025`, Root Directory `web-complete`, Framework Other, Build Command `npm run build`, Output Directory `dist`. Do not deploy the WordPress theme directory to Vercel.

## Deliberate integration limits
All readings are free. There is no payment collection, bank account, SePay webhook, unlock-code system, authenticated account or human-reader booking service. These require owner's real service/account configuration. Custom questions are displayed with card/topic-based authored interpretations, not analyzed by an external AI API. No API key is required or embedded. The three styles are automated personas, not invented human experts.

Saved readings and daily picks remain only in localStorage on each browser/device; clearing browser site data removes them. JSON export provides a backup, not multi-device sync.

## Validation
Six Node test groups cover deck completeness, 78-card draw coverage, uniqueness, upright/reversed interpretation, Vietnam date boundaries, record validation and escaping. Browser QA checks three-card reading, saving/rereading journal, daily persistence, library search and custom reading.
