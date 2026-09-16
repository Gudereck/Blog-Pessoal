---
name: Meu Blog
description: A warm, quiet personal notebook for study notes, favorite games, and life reflections.
colors:
  rust-warm: "#b3521f"
  rust-warm-deep: "#8c3f17"
  paper-bg: "#fbfaf8"
  surface: "#ffffff"
  ink: "#1f2328"
  ink-muted: "#6b7280"
  hairline: "#e5e2dd"
  meadow-bg: "#e7f5ec"
  meadow-text: "#14683a"
  clay-bg: "#fdecec"
  clay-text: "#9b1c1c"
typography:
  headline:
    fontFamily: "-apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif"
    fontSize: "1.9rem"
    fontWeight: 700
    lineHeight: 1.25
  title:
    fontFamily: "-apple-system, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif"
    fontSize: "1.35rem"
    fontWeight: 700
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
---

# Design System: Meu Blog

## Overview

**Creative North Star: "The Warm Notebook"**

This is a quiet, personal system built to feel like a paper notebook, not a media outlet: a warm off-white page, one restrained accent, and hairline borders doing all the work that shadows usually do. Nothing raises its voice. The single sans-serif family carries every role, so hierarchy comes from size and weight alone, and the terracotta accent is spent sparingly — a link, a button, a badge — never a wash of color across a surface.

Buttons, cards, and fields are built to feel quiet and functional: they do their job without asking to be admired. The system currently has no imagery and no display typeface; it was designed around text-only content (titles, meta lines, prose), which is the main thing the next phase of work extends rather than replaces.

**Key Characteristics:**
- Warm, near-white paper background with a single terracotta accent used rarely.
- Completely flat — no shadows anywhere; separation comes from 1px hairline borders.
- One typeface for every role; hierarchy is size and weight only.
- Single-column, stacked layouts; no grid system yet.

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

### Named Rules
**The Rare Rust Rule.** Ferrugem Quente appears in exactly one purposeful place per view — a button, a link, a badge. It never fills a background or covers more than a small control.

## Typography

**Body Font:** -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif
**Display Font:** none yet — headings reuse the body family at a larger size and bold weight.

**Character:** One plain, native-feeling sans-serif carries the whole page. The system reads as understated and utilitarian by choice, not by omission.

### Hierarchy
- **Headline** (700, 1.9rem, line-height 1.25): the one page title per screen (`.page-title`) — "Últimos posts", a post's own title, "Painel".
- **Title** (700, 1.35rem, line-height 1.3): card and form headings — a post-card's title link, a form's `<h1>`.
- **Body** (400, 16px, line-height 1.65): paragraphs, post body copy.
- **Label** (600, 0.78–0.93rem, uppercase with 0.04em tracking on table headers only): nav links, meta lines ("por X em Y"), form labels, table headers, badges.

### Named Rules
**The One Face Rule.** Every role shares the same sans-serif family; hierarchy is expressed only through size and weight, never a second typeface.

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

### Cards / Containers
- **Corner Style:** 10px radius
- **Background:** white Superfície on the warm Papel page background
- **Shadow Strategy:** none — see Elevation & Depth
- **Border:** 1px solid Linha Fina
- **Internal Padding:** 24px for post cards, 28–32px for forms and the full post view

### Inputs / Fields
- **Style:** 1px Linha Fina border, 8px radius, white background
- **Focus:** 2px Ferrugem Quente outline (1px offset), border shifts to the same accent
- **Error / Disabled:** not yet distinguished with a dedicated style

### Navigation
- **Style:** plain Tinta Suave text links, no underline at rest, turning to Ferrugem Quente on hover. The admin header is told apart from the public one only by swapping its bottom hairline for an accent-colored border — same layout, same typography.

## Do's and Don'ts

### Do:
- **Do** keep Ferrugem Quente rare — one accent moment per view, never a background fill.
- **Do** use the 1px hairline border as the only tool for separating surfaces; never simulate depth with shadow.
- **Do** drive all hierarchy through the single sans-serif family's size and weight.

### Don't:
- **Don't** add `box-shadow` anywhere in this system.
- **Don't** introduce a second typeface without a deliberate, documented decision.
- **Don't** use a border radius outside 8px, 10px, or the 999px pill.
