# Design System: RentEase — Luxury Furniture Rental

## 1. Visual Theme & Atmosphere

A cinematic, gallery-airy interface with confident asymmetric layouts and fluid spring-physics motion. The atmosphere is warm-luxury meets modern minimalism — like stepping into a well-lit designer showroom. Deep charcoal foundations offset by warm gold/champagne accents. Glassmorphism and subtle neumorphism add tactile depth. Every interaction feels deliberate, weighty, and premium.

**Density:** 3/10 (Art Gallery Airy)
**Variance:** 7/10 (Offset Asymmetric)
**Motion:** 8/10 (Cinematic Choreography)

## 2. Color Palette & Roles

- **Canvas** (#FAFAF9) — Primary background surface, warm off-white
- **Pure Surface** (#FFFFFF) — Card and container fill
- **Deep Ink** (#18181B) — Primary text, Zinc-950 depth
- **Warm Charcoal** (#27272A) — Secondary headings, dark elements
- **Muted Taupe** (#78716C) — Secondary text, descriptions, metadata
- **Whisper Border** (rgba(231,229,228,0.6)) — Card borders, 1px structural lines
- **Champagne Gold** (#C5A98B) — Single accent: CTAs, active states, focus rings, decorative elements
- **Rose Gold** (#D4A59A) — Secondary accent for micro-interactions, hover states
- **Dusty Blush** (#F5EDEB) — Subtle backgrounds, section dividers
- **Obsidian Glass** (rgba(24,24,27,0.08)) — Glassmorphism surface
- **Gold Glass** (rgba(197,169,139,0.15)) — Glassmorphism accent surface

**Banned:** Pure black (#000000), neon colors, oversaturated accents, teal, blue gradients, purple

## 3. Typography Rules

- **Display/Headlines:** `"Playfair Display"` — Track-tight (-0.03em), italic variants for elegance, weight-driven hierarchy (400/500/600). Generous size scale via `clamp()`.
- **Body:** `"Inter"` — Allowed for body only due to readability at small sizes. Light weight (300) for premium feel.
- **Mono:** `"JetBrains Mono"` — For prices, dates, tracking numbers, metadata.
- **Banned:** Georgia, Times New Roman, Garamond serifs. Inter for headlines (premium contexts). Comic Sans, Papyrus.

**Scale:**
- Hero Display: `clamp(3.5rem, 8vw, 7rem)`
- Section Title: `clamp(2rem, 4vw, 3.5rem)`
- Card Title: `clamp(1.125rem, 1.5vw, 1.5rem)`
- Body: `clamp(0.875rem, 1vw, 1rem)`
- Meta/Label: `0.6875rem` (11px) uppercase tracking-widest

## 4. Component Stylings

### Buttons
- **Primary:** Deep Ink fill with Champagne Gold hover. 0px border-radius or 9999px pill (context dependent). No outer glow. Tactile -1px translateY on active.
- **Secondary:** Transparent with Ink border. Hover fills Ink.
- **Ghost:** No border, subtle opacity change on hover.
- All buttons: 11px font-size, 0.2em letter-spacing, uppercase. 44px min-height touch target.

### Cards
- No border-radius or generous 24px+ radius (context dependent).
- Diffused shadow: `0 4px 24px rgba(24,24,27,0.04)` to `0 24px 64px rgba(24,24,27,0.08)`.
- Glassmorphism cards: `backdrop-filter: blur(20px)` with subtle border.
- Used only when elevation communicates hierarchy.
- High-density views: replace cards with clean border-top dividers.

### Inputs
- Border-bottom only (no full border box) for clean lines.
- Focus state: border transitions to Champagne Gold.
- Label above input, 10px uppercase tracking-widest.
- Error text below input in muted red.
- No floating labels.

### Loaders
- Skeletal shimmer matching exact layout dimensions.
- Loading line animation (horizontal scale) for initial page load.
- No circular spinners except for action buttons during submission.

### Navigation
- Fixed top bar with glassmorphism (`backdrop-blur-md`, `bg-white/80`).
- Text links in Muted Taupe, hover to Deep Ink.
- Mobile bottom nav bar with glassmorphism.
- Mobile hamburger expands to full overlay menu.

## 5. Layout Principles

- **Grid-first** responsive architecture using CSS Grid.
- **Asymmetric splits** for Hero sections (never centered when variance > 4).
- **Mobile-first collapse** below 768px — all multi-column layouts to single column.
- **Max-width containment** at 1600px centered.
- **Full-height sections** use `min-h-[100dvh]` — never `h-screen`.
- **No horizontal scroll** on mobile.
- **No flexbox percentage math** — use CSS Grid.
- **Generous whitespace** — vertical section gaps via `py-32` (8rem).
- **Split-screen auth** pages: 50/50 form/image layout, image side hidden on mobile.

## 6. Motion & Interaction

### Engine
- **GSAP** with ScrollTrigger plugin for scroll-based reveals.
- **Spring physics default:** `ease: "power4.out"` for premium weighty feel.
- **No linear easing** ever.

### Page Load
1. Loading bar expands horizontally (book spine opening metaphor)
2. Loader slides up (cover lifts)
3. Hero image zooms out (page settles)
4. Text masks reveal (content appears with staggered timing)
5. Curtain overlay reveals image
6. Form elements fade up

### Scroll Triggers
- Benefit cards: stagger fade-up at 85% viewport
- Sticky storytelling: image swaps based on scroll position
- Product cards: cascade reveal at 85% viewport
- Section headers: split-text line reveals

### Micro-interactions
- Button hover: scale(1.02) with back easing
- Button active: scale(0.95) with spring snap
- Card hover: image scale(1.05), overlay gradient fade
- Link hover: subtle opacity transition
- Checkbox toggle: smooth color transition
- Price change: GSAP snap counter animation

### Perpetual Motion
- Pulse dot on status indicators
- Shimmer on skeleton loaders
- Gentle float animation on decorative elements
- Typewriter cursor on input focus

### Performance
- Animate exclusively via `transform` and `opacity`
- Never animate `top`, `left`, `width`, `height`
- `will-change: transform` on animated elements
- GSAP context cleanup for memory management
- Video/image lazy loading with IntersectionObserver

## 7. Responsive Rules

### Mobile (< 768px)
- Single column layouts. No exceptions.
- Hero text left-aligned, image full-width below.
- Top nav collapses to hamburger.
- Bottom nav bar appears (4 icons: Home, Explore, Cart, Profile).
- Typography scales down via clamp().
- Touch targets minimum 44px.
- Auth pages show form only (no image side).
- Product grids: 1 or 2 columns.

### Tablet (768px - 1024px)
- 2-column grids for products.
- Navigation fully visible.
- Hero maintains split or stack layout.
- Auth pages show image with reduced size.

### Desktop (1024px+)
- Full multi-column layouts.
- Asymmetric product grids with offset rows.
- Split-screen auth with full hero imagery.
- Sticky storytelling sections.
- Hover micro-interactions enabled.
- Max-width containers for comfortable reading.

## 8. Anti-Patterns (Banned)

- No emojis anywhere in the interface
- No pure black (#000000) — use Deep Ink (#18181B)
- No neon/outer glow shadows
- No oversaturated accents
- No excessive gradient text on large headers
- No custom mouse cursors
- No overlapping elements — clean spatial separation always
- No 3-column equal card layouts — use 2-column zig-zag or 4-column asymmetric
- No generic placeholder names ("John Doe", "Acme Corp")
- No fabricated data or statistics — use real data or clear [placeholder] labels
- No "Scroll to explore", "Swipe down", bouncing chevrons, scroll arrow icons
- No centered Hero layouts (for high-variance projects)
- No "LABEL // YEAR" formatting conventions
- No Inter for headlines (allowed for body text only)
- No AI copywriting clichés ("Elevate", "Seamless", "Unleash", "Next-Gen")
- No broken image links — use `/api/placeholder/` or unsplash with `auto=format`
