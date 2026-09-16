---
name: Meu Blog
description: A warm, quiet personal notebook for study notes, favorite games, and life reflections.
colors:
  rust-warm: "#b3521f"
  rust-warm-deep: "#8c3f17"
  rust-warm-soft: "rgba(179, 82, 31, 0.12)"
  paper-bg: "#fbfaf8"
  surface: "#ffffff"
  ink: "#1f2328"
  ink-muted: "#6b7280"
  hairline: "#e5e2dd"
  meadow-bg: "#e7f5ec"
  meadow-text: "#14683a"
  clay-bg: "#fdecec"
  clay-text: "#9b1c1c"
  sage: "oklch(58% 0.12 145)"
  sage-soft: "oklch(93% 0.03 145)"
  blue: "oklch(58% 0.11 235)"
  blue-soft: "oklch(93% 0.02 235)"
  plum: "oklch(56% 0.13 320)"
  plum-soft: "oklch(93% 0.03 320)"
  gold: "oklch(60% 0.12 80)"
  gold-soft: "oklch(93% 0.03 80)"
typography:
  headline:
    fontFamily: "Newsreader, Georgia, serif"
    fontSize: "2.1rem"
    fontWeight: 500
    lineHeight: 1.25
  title:
    fontFamily: "Newsreader, Georgia, serif"
    fontSize: "1.4rem"
    fontWeight: 500
    lineHeight: 1.3
  body:
    fontFamily: "-apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif"
    fontSize: "16px"
    fontWeight: 400
    lineHeight: 1.65
  label:
    fontFamily: "-apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif"
    fontSize: "0.85rem"
    fontWeight: 600
    lineHeight: 1.4
rounded:
  sm: "8px"
  md: "10px"
  pill: "999px"
spacing:
  sm: "12px"
  md: "20px"
  lg: "28px"
  xl: "40px"
components:
  button-primary:
    backgroundColor: "{colors.rust-warm}"
    textColor: "#ffffff"
    rounded: "{rounded.sm}"
    padding: "10px 18px"
  button-primary-hover:
    backgroundColor: "{colors.rust-warm-deep}"
  button-secondary:
    backgroundColor: "transparent"
    textColor: "{colors.rust-warm}"
    rounded: "{rounded.sm}"
    padding: "10px 18px"
  card:
    backgroundColor: "{colors.surface}"
    rounded: "{rounded.md}"
    padding: "24px"
  badge:
    backgroundColor: "#eceae6"
    textColor: "{colors.ink-muted}"
    rounded: "{rounded.pill}"
  tag-rust:
    backgroundColor: "{colors.rust-warm-soft}"
    textColor: "{colors.rust-warm-deep}"
    rounded: "{rounded.pill}"
  tag-sage:
    backgroundColor: "{colors.sage-soft}"
    textColor: "{colors.sage}"
    rounded: "{rounded.pill}"
  tag-blue:
    backgroundColor: "{colors.blue-soft}"
    textColor: "{colors.blue}"
    rounded: "{rounded.pill}"
  tag-plum:
    backgroundColor: "{colors.plum-soft}"
    textColor: "{colors.plum}"
    rounded: "{rounded.pill}"
  tag-gold:
    backgroundColor: "{colors.gold-soft}"
    textColor: "{colors.gold}"
    rounded: "{rounded.pill}"
---

# Design System: Meu Blog

## Overview

**Creative North Star: "The Warm Notebook"**

This is a quiet, personal system built to feel like a paper notebook, not a media outlet: a warm off-white page, one restrained accent, and hairline borders doing all the work that shadows usually do. Nothing raises its voice. The single sans-serif family carries every role, so hierarchy comes from size and weight alone, and the terracotta accent is spent sparingly — a link, a button, a badge — never a wash of color across a surface.

Buttons, cards, and fields are built to feel quiet and functional: they do their job without asking to be admired.

This system was extended once, deliberately: posts can now carry a cover image and one category, so headlines and titles picked up a quiet serif (Newsreader) to give image-forward pages a touch more warmth, and categories each get one hue-shifted color from the same restrained formula as the original accent. Everything else — the paper background, the hairline borders, the flat surfaces, the rare use of color — was preserved as-is.

**Key Characteristics:**
- Warm, near-white paper background with a single terracotta accent used rarely.
- Completely flat — no shadows anywhere; separation comes from 1px hairline borders.
- Two typefaces: a quiet serif for headlines/titles, the original sans for everything else.
- Cards and post pages can now carry a cover image; a calm icon placeholder fills the gap until one exists.
- Category color is one of five curated hues (same lightness/chroma as the accent), never a free-typed color.

## Colors

A warm neutral base (paper, not stark white) with one earthy accent and two small semantic pairs for success/error feedback.

### Primary
- **Ferrugem Quente** (`#b3521f`): links, primary buttons, the "read more" affordance, active/focus states, admin header accent border. Used as text/border/fill on small elements only — never as a large background.
- **Ferrugem Quente Escura** (`#8c3f17`): hover/active state for the primary color above.

### Neutral
- **Papel** (`#fbfaf8`): page background.
- **Superfície** (`#ffffff`): cards, header, form fields — anything raised off the page background.
- **Tinta** (`#1f2328`): body and heading text.
- **Tinta Suave** (`#6b7280`): meta text, secondary nav links, placeholder-weight copy.
- **Linha Fina** (`#e5e2dd`): the only separator in the system — borders on cards, header, table, and inputs.

### Feedback
- **Fundo Sucesso / Texto Sucesso** (`#e7f5ec` / `#14683a`): success alerts, "published" badge.
- **Fundo Erro / Texto Erro** (`#fdecec` / `#9b1c1c`): error alerts, destructive link-buttons.

### Category Palette
Five curated hues share the accent's lightness and chroma in oklch, varying only the hue — a category is never a free-typed color, only one of these five:
- **Ferrugem Quente** (`oklch(58% 0.13 38)` ≈ `#b3521f`): the default/first category color, same value as the Primary accent.
- **Verde-Sálvia** (`oklch(58% 0.12 145)`): a second, calmer category color.
- **Azul-Poeira** (`oklch(58% 0.11 235)`): a third, cooler category color.
- **Ameixa** (`oklch(56% 0.13 320)`): a fourth category color.
- **Ouro-Velho** (`oklch(60% 0.12 80)`): a fifth category color.

Each carries a "soft" tint at ~93% lightness for tag backgrounds and cover-image placeholders, the same formula the original accent already used informally.

### Named Rules
**The Rare Rust Rule.** Ferrugem Quente appears in exactly one purposeful place per view — a button, a link, a badge. It never fills a background or covers more than a small control.
**The Five Hues Rule.** A category's color is always one of the five Category Palette hues, picked in the admin form's swatches — never a hex value typed by hand. This keeps every future category visually harmonious by construction.

## Typography

**Body Font:** -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif
**Display Font:** Newsreader (with Georgia, serif fallback) — headlines and titles only.

**Character:** A quiet serif for the words that name a page or a post, a plain sans for everything read in bulk. The pairing stays understated on purpose — Newsreader is a text serif, not a decorative display face.

### Hierarchy
- **Headline** (Newsreader, 500, 2.1rem, line-height 1.25): the one page title per screen (`.page-title`) — "Últimos posts", a post's own title, "Painel".
- **Title** (Newsreader, 500, 1.4rem, line-height 1.3): card and form headings — a post-card's title link, a form's `<h1>`.
- **Body** (sans, 400, 16px, line-height 1.65): paragraphs, post body copy.
- **Label** (sans, 600, 0.78–0.93rem, uppercase with 0.04em tracking on table headers only): nav links, meta lines ("por X em Y"), form labels, table headers, badges.

### Named Rules
**The Two Face Rule.** Exactly two typefaces, each locked to a role: Newsreader for Headline and Title, the system sans for Body and Label. Never a third face, and never Newsreader for body copy.

## Layout

Single-column, stacked layouts throughout — there is no grid system yet, even where multiple cards appear (the post list is a vertical stack, not a grid). A centered `.container` caps content at 760px for reading-focused pages, with a 400px `.narrow` variant for the login form; the admin table is the one full-width exception. Base horizontal padding is 20px. Vertical rhythm runs on a handful of repeated gaps: 40px under the header, 28px between stacked post cards, 24–32px of internal card padding, 20px form-field spacing. One breakpoint at 560px: page titles drop to 1.5rem and card/table padding tightens.

## Elevation & Depth

Completely flat. No `box-shadow` is used anywhere in the codebase; every surface sits at the same visual depth. Separation between a raised surface (white) and the page (warm off-white) comes only from that background-tone difference plus a 1px hairline border.

### Named Rules
**The Flat-By-Default Rule.** No box-shadow is used anywhere. Depth is never simulated; two adjacent surfaces are told apart by a 1px border and a subtle background-tone shift, nothing else.

## Shapes

Two corner radii and one pill: 10px on cards and alerts, 8px on buttons and form inputs, and a full 999px pill on badges and the "Entrar" nav action. Every border is 1px solid Linha Fina — never thicker, never a heavier accent-colored stroke. No clipping, overlap, or decorative shape beyond these rounded rectangles.

## Components

Every component here is built to disappear into the reading experience — quiet and functional, not decorative.

### Buttons
- **Shape:** 8px radius (`{rounded.sm}`)
- **Primary:** solid Ferrugem Quente background, white text, 10px/18px padding, semibold weight
- **Hover / Focus:** background darkens to Ferrugem Quente Escura; form fields instead get a 2px accent outline, 1px offset, and a border color shift
- **Secondary / Ghost:** transparent background, Ferrugem Quente text; hover fills with a faint accent tint (`rgba(179, 82, 31, 0.08)`)

### Badges
- **Style:** 999px pill, small semibold text
- **State:** neutral gray by default (`#eceae6` background); success state swaps to the Feedback success pair

### Category Tags
- **Style:** same 999px pill as a badge, but colored from the Category Palette (`tag-rust`, `tag-sage`, `tag-blue`, `tag-plum`, `tag-gold`) — soft tint background, solid-hue text.
- **Placement:** sits just above a title (post card, post page) or inside a table cell (admin list); never overlaid on the image itself.

### Cover Images
- **Style:** 4:3 in a post card, 16:9 as a post's hero; `object-fit: cover`, same 10px radius as the card that holds it, no border of its own.
- **Placeholder:** when a post has no cover image yet, a flat icon (a plain image glyph, never a category-specific illustration — categories are user-created and open-ended) centered on a soft gradient tinted by the post's category color (or the accent when there is none). Never fabricate a photo-like image in its place.

### Cards / Containers
- **Corner Style:** 10px radius
- **Background:** white Superfície on the warm Papel page background
- **Shadow Strategy:** none — see Elevation & Depth
- **Border:** 1px solid Linha Fina
- **Internal Padding:** 24px for post cards, 28–32px for forms and the full post view

### Inputs / Fields
- **Style:** 1px Linha Fina border, 8px radius, white background — the same style now covers `<select>` (category picker) as well as text inputs and textareas
- **Focus:** 2px Ferrugem Quente outline (1px offset), border shifts to the same accent
- **Error / Disabled:** not yet distinguished with a dedicated style
- **Color Picker:** a row of 34px solid-color circles (one per Category Palette hue), the checked one ringed in Tinta — used only on the category form

### Navigation
- **Style:** plain Tinta Suave text links, no underline at rest, turning to Ferrugem Quente on hover. The admin header is told apart from the public one only by swapping its bottom hairline for an accent-colored border — same layout, same typography.

## Do's and Don'ts

### Do:
- **Do** keep Ferrugem Quente rare — one accent moment per view, never a background fill.
- **Do** use the 1px hairline border as the only tool for separating surfaces; never simulate depth with shadow.
- **Do** keep Newsreader locked to Headline/Title and the sans locked to Body/Label — never mix them within a role.
- **Do** pick category color only from the five Category Palette swatches, never a typed hex.
- **Do** show a flat icon placeholder for a missing cover image — never a fabricated photo.

### Don't:
- **Don't** add `box-shadow` anywhere in this system.
- **Don't** introduce a third typeface, or use Newsreader for body copy.
- **Don't** use a border radius outside 8px, 10px, or the 999px pill.
- **Don't** invent a category-specific illustration (a book for "Estudos", a controller for "Jogos") — categories are user-created and open-ended, so the placeholder stays generic.
