# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

Primary user: the site's author, writing for themself as a personal record of what they're studying, the games they're playing, and other life notes. Confirmed secondary audience: the author intends to share the blog's link so other people can read it too, so it can't be designed as a private-only journal.

## Product Purpose

A personal blog where the author keeps notes on studies, thoughts on favorite games, and general life reflections in one place, organized well enough that entries don't get lost over time. Success is the author actually keeping it up and being able to browse past entries; secondary success is that shared readers can browse and read comfortably.

## Positioning

Not a professional publication or a single-topic games/study blog — it's a personal notebook made public. What makes it itself is the mix of categories (estudos, jogos, vida) held together under one author's voice, rather than three disconnected sites.

## Operating Context

Single admin/author manages posts through a protected panel (`/admin`): create, edit, publish, delete. Public visitors browse published posts on `/` (list) and `/posts/{slug}` (single post). Runs on PHP 8.2 with MySQL/MariaDB via PDO, no framework, developed so far against a local XAMPP setup.

## Capabilities and Constraints

- Posts can carry one cover image (uploaded file, stored in `public/uploads/`, filename kept in `posts.cover_image`) and one category (`posts.category_id`, managed in `/admin/categories`). Both are optional per post.
- The author still has no real photos or screenshots; posts without a cover image fall back to a calm icon placeholder (never a fabricated photo) tinted by the post's category color.
- Categories are user-managed (create/edit/delete in the admin panel) with a name and one color chosen from five curated presets — never a free-typed color, to keep the palette coherent as categories are added.
- Hosting/deploy target is undecided — the author hasn't chosen between staying local (XAMPP) or publishing to a server yet. Don't assume a specific host or bake in deploy-specific constraints.

## Evidence on Hand

No existing published content, photos, or brand assets — this is an early-stage personal project. Nothing from prior posts to preserve; any sample post titles/copy used in mockups so far are placeholders, not real content.

## Product Principles

- Keep it fast and low-friction for a single author to write and publish.
- Design for outside readers from day one, even though the habit started as personal notes.
- Leave visible, intentional room for images without depending on having them yet.
- Keep the three personal categories (estudos, jogos, vida) reading as one coherent voice, not three disconnected sections.

## Accessibility & Inclusion

No specific requirement established yet.
