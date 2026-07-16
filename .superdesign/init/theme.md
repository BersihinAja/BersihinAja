# BersihinAja — Theme & Frontend Documentation

> Comprehensive frontend configuration, design tokens, and build pipeline reference.

---

## 1. Configuration Source Code

### 1.1 `tailwind.config.js`

```js
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import daisyui from 'daisyui';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, daisyui],

    daisyui: {
        themes: [
            {
                bersihinaja: {
                    "primary": "#570df8",
                    "secondary": "#f000b8",
                    "accent": "#37cdbe",
                    "neutral": "#2a323c",
                    "base-100": "#1d232a",
                    "info": "#3abff8",
                    "success": "#36d399",
                    "warning": "#fbbd23",
                    "error": "#f87272",
                },
            },
            "light",
            "dark",
        ],
    },
};
```

### 1.2 `resources/css/app.css`

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

### 1.3 `postcss.config.js`

```js
export default {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
    },
};
```

### 1.4 `vite.config.js`

```js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

### 1.5 `package.json`

```json
{
    "$schema": "https://www.schemastore.org/package.json",
    "private": true,
    "type": "module",
    "scripts": {
        "build": "vite build",
        "dev": "vite"
    },
    "devDependencies": {
        "@tailwindcss/forms": "^0.5.2",
        "@tailwindcss/vite": "^4.0.0",
        "alpinejs": "^3.4.2",
        "autoprefixer": "^10.4.2",
        "concurrently": "^9.0.1",
        "daisyui": "^5.6.18",
        "laravel-vite-plugin": "^3.1",
        "postcss": "^8.4.31",
        "tailwindcss": "^3.1.0",
        "vite": "^8.0.0"
    }
}
```

---

## 2. DaisyUI Custom Theme: `bersihinaja`

The project uses a custom daisyUI theme named **`bersihinaja`** — a dark-mode theme based on deep navy/charcoal tones with vibrant accent colors.

### 2.1 Color Token Map

| Token | Hex Value | RGB | HSL (approx.) | Visual | Usage |
|-------|-----------|-----|----------------|--------|-------|
| `primary` | `#570df8` | `87, 13, 248` | `259°, 94%, 51%` | 🟣 Electric Violet | Primary buttons, links, active states |
| `secondary` | `#f000b8` | `240, 0, 184` | `314°, 100%, 47%` | 🩷 Hot Magenta | Secondary actions, badges, highlights |
| `accent` | `#37cdbe` | `55, 205, 190` | `174°, 60%, 51%` | 🟢 Turquoise/Teal | Accents, tags, decorative elements |
| `neutral` | `#2a323c` | `42, 50, 60` | `213°, 18%, 20%` | ⬛ Charcoal Slate | Sidebar, cards, secondary backgrounds |
| `base-100` | `#1d232a` | `29, 35, 42` | `212°, 18%, 14%` | ⬛ Deep Navy | Page background |
| `info` | `#3abff8` | `58, 191, 248` | `198°, 93%, 60%` | 🔵 Sky Blue | Informational alerts, tooltips |
| `success` | `#36d399` | `54, 211, 153` | `158°, 64%, 52%` | 🟢 Mint Green | Success states, completed badges |
| `warning` | `#fbbd23` | `251, 189, 35` | `43°, 96%, 56%` | 🟡 Amber Yellow | Warnings, pending states |
| `error` | `#f87272` | `248, 114, 114` | `0°, 91%, 71%` | 🔴 Coral Red | Error states, delete actions |

### 2.2 Auto-Generated DaisyUI Tokens

DaisyUI automatically derives the following from the base colors above:

| Derived Token | Source | Purpose |
|---------------|--------|---------|
| `primary-content` | Auto from `primary` | Text on primary backgrounds |
| `secondary-content` | Auto from `secondary` | Text on secondary backgrounds |
| `accent-content` | Auto from `accent` | Text on accent backgrounds |
| `neutral-content` | Auto from `neutral` | Text on neutral backgrounds |
| `base-200` | Auto from `base-100` | Slightly lighter background (cards, inputs) |
| `base-300` | Auto from `base-100` | Borders, dividers |
| `base-content` | Auto from `base-100` | Default text color on base backgrounds |
| `info-content` | Auto from `info` | Text on info backgrounds |
| `success-content` | Auto from `success` | Text on success backgrounds |
| `warning-content` | Auto from `warning` | Text on warning backgrounds |
| `error-content` | Auto from `error` | Text on error backgrounds |

### 2.3 Theme Character

- **Mode**: Dark (base-100 is `#1d232a` — very dark navy)
- **Personality**: Tech-forward, vibrant, modern cleaning platform
- **Primary Palette**: Purple–Magenta–Teal triad with high saturation
- **Text**: Light text on dark backgrounds (auto-derived by daisyUI)
- **Feedback Colors**: Standard semantic colors (blue info, green success, amber warning, coral error)

### 2.4 Available Themes

The configuration registers 3 themes. The first theme (`bersihinaja`) is the **default** applied to `<html data-theme="bersihinaja">`:

1. **`bersihinaja`** — Custom dark theme (default)
2. **`light`** — daisyUI built-in light theme
3. **`dark`** — daisyUI built-in dark theme

---

## 3. Typography

### 3.1 Font Stack

```
font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont,
             "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif,
             "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
```

- **Primary Font**: [Inter](https://fonts.google.com/specimen/Inter) — loaded externally (Google Fonts or local)
- **Fallback**: Tailwind's default sans-serif stack

### 3.2 Font Configuration

The `Inter` font is prepended to Tailwind's default `fontFamily.sans` array, making it the primary font for all `font-sans` and body text throughout the application.

---

## 4. CSS Architecture

### 4.1 CSS Entry Point

The application uses a single CSS entry point at `resources/css/app.css`:

```css
@tailwind base;     /* Tailwind's reset / preflight styles */
@tailwind components; /* DaisyUI component classes + custom @layer components */
@tailwind utilities;  /* All Tailwind utility classes */
```

### 4.2 Custom Styles

No custom CSS classes or `@layer` extensions are defined in `app.css`. The project relies entirely on:

1. **Tailwind CSS utility classes** for layout and spacing
2. **DaisyUI component classes** for UI components (buttons, cards, forms, modals, etc.)
3. **`@tailwindcss/forms`** plugin for form element resets

### 4.3 DaisyUI Component Classes Available

With daisyUI v5.6.18 installed, the following component classes are available out of the box:

| Category | Components |
|----------|------------|
| **Actions** | `btn`, `dropdown`, `modal`, `swap`, `theme-controller` |
| **Data Display** | `badge`, `card`, `carousel`, `chat`, `collapse`, `countdown`, `diff`, `kbd`, `stat`, `table`, `timeline` |
| **Navigation** | `breadcrumbs`, `bottom-navigation`, `link`, `menu`, `navbar`, `pagination`, `steps`, `tab` |
| **Feedback** | `alert`, `loading`, `progress`, `radial-progress`, `skeleton`, `toast`, `tooltip` |
| **Data Input** | `checkbox`, `file-input`, `input`, `radio`, `range`, `rating`, `select`, `textarea`, `toggle` |
| **Layout** | `artboard`, `divider`, `drawer`, `footer`, `hero`, `indicator`, `join`, `mask`, `stack` |

---

## 5. Frontend Dependencies

### 5.1 Dev Dependencies (from `package.json`)

| Package | Version | Purpose |
|---------|---------|---------|
| `tailwindcss` | `^3.1.0` | Utility-first CSS framework |
| `daisyui` | `^5.6.18` | Tailwind CSS component library with themes |
| `@tailwindcss/forms` | `^0.5.2` | Form element reset plugin for Tailwind |
| `@tailwindcss/vite` | `^4.0.0` | Tailwind CSS Vite integration plugin |
| `autoprefixer` | `^10.4.2` | PostCSS plugin for vendor prefixes |
| `postcss` | `^8.4.31` | CSS transformation pipeline |
| `vite` | `^8.0.0` | Frontend build tool / dev server |
| `laravel-vite-plugin` | `^3.1` | Laravel integration for Vite (asset versioning, HMR) |
| `alpinejs` | `^3.4.2` | Lightweight JS framework for interactivity |
| `concurrently` | `^9.0.1` | Run multiple npm scripts concurrently |

### 5.2 Runtime / Implicit Dependencies

- **Alpine.js** — Used for client-side interactivity (dropdowns, modals, toggles, form logic)
- **Midtrans Snap.js** — Loaded via CDN for payment processing (not in package.json)

---

## 6. Build Pipeline

### 6.1 Architecture

```
resources/css/app.css  ──┐
                         ├──→  Vite  ──→  PostCSS (Tailwind + Autoprefixer)  ──→  public/build/
resources/js/app.js   ──┘        ↑
                          laravel-vite-plugin
                          (HMR, versioning, manifest)
```

### 6.2 Pipeline Steps

1. **Entry Points**: Vite processes two entry points:
   - `resources/css/app.css` — CSS with Tailwind directives
   - `resources/js/app.js` — JavaScript with Alpine.js

2. **PostCSS Processing**:
   - `tailwindcss` — Scans Blade templates, generates utility classes, includes daisyUI components
   - `autoprefixer` — Adds vendor prefixes for cross-browser compatibility

3. **Tailwind Content Scanning**: Tailwind scans these paths for class usage:
   - `./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php`
   - `./storage/framework/views/*.php`
   - `./resources/views/**/*.blade.php`

4. **Output**:
   - Development: Vite dev server with HMR at `http://localhost:5173`
   - Production: Hashed, minified bundles in `public/build/` with `manifest.json`

### 6.3 Commands

| Command | Description |
|---------|-------------|
| `npm run dev` | Start Vite dev server with HMR |
| `npm run build` | Production build (minified, hashed output) |

### 6.4 Laravel Integration

The `laravel-vite-plugin` provides:
- **`@vite()` directive** in Blade templates to load assets
- **Hot Module Replacement** during development
- **Asset versioning** via `manifest.json` in production
- **Auto-refresh** on Blade file changes (`refresh: true`)

---

## 7. Design System Summary

| Aspect | Value |
|--------|-------|
| **CSS Framework** | Tailwind CSS v3 |
| **Component Library** | daisyUI v5 |
| **Theme** | Custom `bersihinaja` (dark mode) |
| **Typography** | Inter (Google Fonts) |
| **JS Framework** | Alpine.js v3 |
| **Build Tool** | Vite v8 |
| **PostCSS Plugins** | tailwindcss, autoprefixer |
| **Form Plugin** | @tailwindcss/forms |
| **Color Palette** | Purple primary, Magenta secondary, Teal accent on dark navy base |
