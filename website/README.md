# UNO Online – PHP Framework Skeleton

A lightweight PHP 8 project scaffold for `uno.augesrob.net` featuring:

- Email + OAuth login (Google/Discord/Facebook/Yahoo placeholders)
- Friendly URLs via `.htaccess`
- Admin area with roles/permissions, settings, and pages
- Lobbies, chat (SSE), leaderboard
- XP + Challenges + Coins model
- Tailwind/Alpine UI, animated canvas for cards

## Install

1. `composer install`
2. Copy `.env.example` to `.env` and set values.
3. Import `database/schema.sql` into your MySQL database.
4. Point your web root to `public/`.
5. Ensure HTTPS and Apache `mod_rewrite` enabled.

## Assets

Mirror your assets from https://github.com/augesrob/Uno-Assets/tree/main into `/public/assets` or your CDN.

## Captcha

Set `CAPTCHA_DRIVER` to `none|hcaptcha|turnstile|recaptcha|qa` and add keys.

## Payments (Coins)

Integrate PayPal Buttons on the profile/shop page and post back to `/api/coins/purchase` (to be implemented) to credit coins.

## Real-time

This starter uses Server-Sent Events (SSE) for chat and simple state polling for game data to keep compatibility with shared hosting. You can later swap to WebSockets (Ratchet or Node + Socket.IO) behind Cloudflare.
