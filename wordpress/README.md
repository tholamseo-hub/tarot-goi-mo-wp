# Tarot Gợi Mở — Flatsome / tholamseo.live

Approved configuration (2026-10-25): preserve the Tarot Gợi Mở brand; closely follow boitarot.com.vn's purple/orange layout; WordPress on HawkHost, Flatsome + UX Builder editable homepage; 78-card functionality in a separate plugin; free usage and no visitor login; authored grounding plus optional server-side AI.

## Install
1. Back up the existing site. Keep the existing Flatsome parent theme.
2. Install the `tarot-goi-mo-core` plugin ZIP and activate.
3. Install the `tarot-goi-mo-flatsome-child` child theme. It requires the existing Flatsome parent.
4. Tarot Gợi Mở → Thiết lập & AI → Tạo nội dung Tarot còn thiếu.
5. Inspect created pages, then apply homepage & Tarot menu.
6. Set AI base URL, model and key directly in WordPress. Enable only after testing; provider charges still apply to the operator. Defaults: 10 AI calls/IP/hour, 200/day sitewide. Set provider spending limits independently.

## Shortcodes
- `[tarot_goi_mo_app mode="three"]`
- `[tarot_goi_mo_app mode="daily"]`
- `[tarot_goi_mo_app mode="custom"]`
- `[tarot_goi_mo_app mode="library"]`
- `[tarot_goi_mo_app mode="readers"]`
- `[tarot_goi_mo_app mode="history"]`
- Homepage modules: `tarot_goi_mo_hero`, `tarot_goi_mo_daily`, `tarot_goi_mo_readers`, `tarot_goi_mo_topics`.

The homepage is native Flatsome shortcodes, editable in UX Builder. Functional app content is rendered by the plugin. All new pages use WordPress permalinks and card detail posts are native `tgm_tarot_card` content. Existing content is not overwritten by setup. Demo cleanup must be based on the actual inventory, using draft/Trash rather than permanent deletion.

## Privacy and AI
The visitor journal remains browser-local. AI runs only on an explicit user request with disclosure before transmitting the question/card data. No API key appears in browser configuration. The upstream URL/model come only from admin settings. Do not commit secrets. The default AI service is disabled until configured. Basic public rate limits reduce abuse but do not replace upstream account spending caps or production monitoring.

## Verification before installation
JavaScript syntax checked with Node, complete dataset and core behavior tested with six Node test groups. PHP files parsed using php-parser 3.7.0 in PHP 7.4 mode (syntax parsing, not a full WordPress execution test). Live WordPress/Flatsome rendering and AI response testing are separate deployment checks.
