# BersihinAja — Extractable Superdesign Components

> Based on analysis of all 27 Blade views. Each component below represents a reusable UI pattern that appears across multiple pages and would benefit from extraction as a Superdesign DraftComponent.

---

## 1. `NavBar`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | `x-app-layout` component (used by home, services/*, orders/*, profile/edit) |
| **Category** | `layout` |
| **Description** | Top navigation bar for customer-facing pages. Contains logo/brand, navigation links, auth-dependent items (login/register or user dropdown). |
| **Key props** | `currentRoute` (string — active nav highlight), `user` (nullable — auth state) |
| **HTML structure** | `<nav>` with logo, horizontal link list, conditional auth section (avatar/dropdown or login/register links). DaisyUI `navbar` component. |

---

## 2. `SidebarMenu`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | `x-pekerja-layout` (pekerja/*), `x-admin-layout` (admin/*) |
| **Category** | `layout` |
| **Description** | Vertical sidebar navigation for dashboard panels. Both pekerja and admin layouts share a similar structure: logo/brand at top, vertical nav links with icons, active state highlight, user info at bottom. |
| **Key props** | `menuItems` (array of `{label, route, icon, isActive}`), `brandText` (string), `user` (object — name, role) |
| **HTML structure** | `<aside>` with brand header, `<ul>` of `<li><a>` items each with an SVG icon and label. Active item has distinct background/text color. |

---

## 3. `StatCard`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | pekerja/dashboard (4 cards), admin/dashboard (4 main + 4 secondary), admin/users/show (2 stats), pekerja/customer-detail (1 stat), services/show (4 stat blocks) |
| **Category** | `basic` |
| **Description** | Dashboard metric display showing an icon, numeric value, title, and optional description. Uses DaisyUI `stat` component with `stat-figure`, `stat-title`, `stat-value`, `stat-desc`. |
| **Key props** | `title` (string), `value` (string/number), `description` (string, optional), `icon` (SVG slot, optional), `color` (string: primary/success/warning/info/error), `size` (default/compact) |
| **HTML structure** | `<div class="stat bg-base-100 rounded-box shadow">` → `stat-figure` (icon) + `stat-title` + `stat-value` + `stat-desc`. Compact variant omits icon and desc. |

---

## 4. `StatusBadge`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | orders/receipt, orders/history, pekerja/dashboard, pekerja/orders, pekerja/customer-detail, admin/dashboard, admin/orders/index, admin/orders/show, admin/users/index, admin/users/show |
| **Category** | `basic` |
| **Description** | Color-coded badge for order status, payment status, or user role. Maps a status string to a DaisyUI badge variant. Appears in ~10 pages with identical `@switch` / `match()` logic duplicated everywhere. |
| **Key props** | `type` (enum: 'order_status' / 'payment_status' / 'role'), `value` (string: pending/in_progress/completed/cancelled/paid/unpaid/etc.), `size` (sm/md/lg), `outline` (boolean) |
| **HTML structure** | `<span class="badge badge-{color} badge-{size}">Label</span>`. Color mappings: order_status → pending:info, in_progress:warning, completed:success, cancelled:error. payment_status → unpaid:warning, pending:info, paid:success, expired/cancelled:error. role → admin:primary, pekerja:warning, customer:info. |

---

## 5. `ServiceCard`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | home (service grid), services/index (service grid) |
| **Category** | `basic` |
| **Description** | Card displaying a cleaning service with image (or gradient fallback), title, metadata badges, price, and CTA button. Two slightly different variants exist (home has simpler badges, index has icons in badges + package count). |
| **Key props** | `service` (object: name, slug, image, price, room_size, estimation, cleaners_required, packages_count), `showDescription` (boolean), `showPackageCount` (boolean) |
| **HTML structure** | `<div class="card bg-base-100 shadow-xl">` → `<figure>` (image or gradient placeholder) + `<div class="card-body">` (title, badges row, price, CTA link button). Badges use `badge-primary badge-outline` and `badge-accent badge-outline`. |

---

## 6. `OrderTable`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | pekerja/dashboard, pekerja/orders, pekerja/customer-detail, admin/dashboard, admin/orders/index, admin/users/show |
| **Category** | `basic` |
| **Description** | Tabular listing of orders with status columns. Column sets vary by context but share the same core structure: order number (monospace), customer (with avatar), service name, total (formatted), status badges, date, optional actions. |
| **Key props** | `orders` (collection), `columns` (array of column configs), `showCustomer` (boolean), `showPaymentStatus` (boolean), `showActions` (boolean), `actionType` (string: 'view' / 'complete') |
| **HTML structure** | `<div class="overflow-x-auto"><table class="table">` → `<thead>` + `<tbody>` rows. Uses `table-zebra` variant in some pages. Status columns use `StatusBadge` pattern. |

---

## 7. `ReviewStars`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | orders/receipt (form + display), orders/history (display), pekerja/customer-detail (display), admin/orders/show (display) |
| **Category** | `basic` |
| **Description** | Star rating display or input. Two modes: editable (radio inputs with `mask mask-star-2 bg-warning`) and read-only (disabled radios or SVG stars). |
| **Key props** | `rating` (number 1-5), `name` (string — form field name), `readonly` (boolean), `size` (sm/md/lg) |
| **HTML structure** | Editable: `<div class="rating rating-{size}">` + 5× `<input type="radio" class="mask mask-star-2 bg-warning">`. Read-only: same but with `disabled` attribute. Admin variant uses SVG `<svg>` stars with `fill-warning` for filled stars. |

---

## 8. `ReviewForm`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | orders/receipt |
| **Category** | `basic` |
| **Description** | Combined star rating input + comment textarea + submit button for leaving a review. Conditionally shown when order is completed and no review exists yet. |
| **Key props** | `orderId` (number), `actionUrl` (string) |
| **HTML structure** | `<div class="card">` → form with `ReviewStars` (editable), textarea for comment, submit button. |

---

## 9. `FormGroup`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | admin/services/create, admin/services/edit, auth/login, auth/register, profile/partials/* |
| **Category** | `basic` |
| **Description** | Label + input + error message pattern. Two style variants: DaisyUI style (admin pages: `form-control` + `label` + `label-text` + `input-bordered` + `label-text-alt text-error`) and Breeze style (auth/profile: `x-input-label` + `x-text-input` + `x-input-error`). |
| **Key props** | `label` (string), `name` (string), `type` (text/email/password/number/file/textarea), `value` (mixed), `required` (boolean), `error` (string, optional), `placeholder` (string, optional) |
| **HTML structure** | DaisyUI: `<div class="form-control">` → `<label class="label"><span class="label-text">…</span></label>` + `<input class="input input-bordered">` + `@error` block. Breeze: bare `<div>` → `x-input-label` + `x-text-input` + `x-input-error`. |

---

## 10. `ActionButton`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | admin/services/create, admin/services/edit (primary submit + ghost cancel), admin/services/index (edit icon + delete icon), pekerja/orders (success "Selesaikan"), orders/confirm ("Bayar Sekarang"), all error pages (primary home + outline back) |
| **Category** | `basic` |
| **Description** | Styled button with icon. Variants: primary, ghost, outline, danger, success. Sizes: sm, md, lg. Can be a `<button>`, `<a>`, or submit within a form. |
| **Key props** | `variant` (primary/ghost/outline/danger/success), `size` (sm/md/lg), `icon` (SVG slot), `label` (string), `href` (string, optional — renders as `<a>`), `type` (button/submit), `disabled` (boolean) |
| **HTML structure** | `<button class="btn btn-{variant} btn-{size} gap-2">` or `<a class="btn …">` → optional SVG icon + label text. |

---

## 11. `ConfirmDialog`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | admin/services/index (delete confirm via JS `confirm()`), pekerja/orders (complete confirm via JS `confirm()`), profile/partials/delete-user-form (modal via `x-modal`) |
| **Category** | `basic` |
| **Description** | Confirmation prompt before destructive actions. Two implementations: simple `onsubmit="return confirm(…)"` and full `x-modal` component with password verification. |
| **Key props** | `title` (string), `message` (string), `confirmLabel` (string), `cancelLabel` (string), `variant` (danger/warning), `requirePassword` (boolean) |
| **HTML structure** | Simple: inline JS `confirm()`. Full modal: `x-modal` wrapper → form with title, message, optional password input, cancel + confirm buttons. |

---

## 12. `AlertNotification`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | orders/history (success flash), orders/create (warning alert for no workers), services/index (info alert for no services), orders/confirm (warning expiry alert) |
| **Category** | `basic` |
| **Description** | DaisyUI alert component for inline notifications. Used for flash messages, warnings, and info notices. |
| **Key props** | `type` (success/warning/info/error), `message` (string), `dismissible` (boolean, optional) |
| **HTML structure** | `<div class="alert alert-{type}">` → SVG icon + `<span>` message text. |

---

## 13. `Breadcrumb`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | services/show, orders/create, pekerja/customer-detail, admin/services/create, admin/services/edit, admin/users/show, admin/orders/show |
| **Category** | `basic` |
| **Description** | Navigation breadcrumb trail. Two style variants: DaisyUI `breadcrumbs` component (services/show, orders/create, pekerja/customer-detail) and simple text-link chain with `/` separator (admin pages). |
| **Key props** | `items` (array of `{label, url?}` — last item has no url) |
| **HTML structure** | DaisyUI: `<div class="text-sm breadcrumbs"><ul><li><a>…</a></li>…<li class="text-base-content/60">Current</li></ul></div>`. Admin: `<div class="flex items-center gap-2 text-sm text-base-content/60"><a>…</a><span>/</span><span>…</span></div>`. |

---

## 14. `Pagination`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | orders/history, pekerja/orders, pekerja/customers, admin/users/index, admin/orders/index |
| **Category** | `basic` |
| **Description** | Laravel pagination links wrapper. Uses `$collection->links()` or `$collection->withQueryString()->links()` or `$collection->appends(['key' => 'val'])->links()`. |
| **Key props** | `paginator` (LengthAwarePaginator), `queryParams` (array, optional) |
| **HTML structure** | `<div class="mt-8">{{ $paginator->links() }}</div>` or wrapped in `<div class="p-4 border-t border-base-300">`. |

---

## 15. `EmptyState`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | orders/history, pekerja/dashboard, pekerja/orders, pekerja/customers, pekerja/customer-detail, admin/dashboard, admin/services/index, admin/users/index, admin/orders/index, admin/users/show, home (forelse empty), services/index (forelse empty) |
| **Category** | `basic` |
| **Description** | Placeholder shown when a list/table has no data. Centered layout with large muted SVG icon, heading text, optional subtitle, and optional CTA button. |
| **Key props** | `icon` (SVG slot), `title` (string), `subtitle` (string, optional), `ctaLabel` (string, optional), `ctaUrl` (string, optional) |
| **HTML structure** | `<div class="text-center py-12/py-16">` → large SVG icon (`h-16 w-16 text-base-content/20`) + `<p class="text-base-content/40">` title + optional subtitle + optional CTA `<a class="btn btn-primary">`. Some variants are inside cards, others are bare. |

---

## 16. `UserAvatar`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | orders/create (worker avatars), orders/confirm (worker avatar badges), orders/receipt (worker avatars), pekerja/orders (customer avatar), pekerja/customers (customer avatar), pekerja/customer-detail (customer avatar), admin/users/index (user avatar), admin/users/show (user avatar), admin/orders/index (customer avatar), admin/orders/show (customer + worker avatars) |
| **Category** | `basic` |
| **Description** | User avatar display with fallback. Three variants: (1) Image avatar using `asset('storage/…')` or `ui-avatars.com` API, (2) Placeholder with initial letter, (3) DaisyUI `avatar placeholder` with colored background. |
| **Key props** | `user` (object: name, avatar?), `size` (number: 5/8/10/12/16/20 → w-{size}), `shape` (circle/squircle), `bgColor` (primary/neutral/warning), `online` (boolean, optional) |
| **HTML structure** | `<div class="avatar placeholder"><div class="bg-{color} text-{color}-content rounded-full w-{size}"><span>{{ initial }}</span></div></div>` or `<div class="avatar"><div class="w-{size} rounded-full"><img src="…"></div></div>`. |

---

## 17. `PriceDisplay`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | home, services/index, services/show, orders/create, orders/confirm, orders/receipt, orders/history, pekerja/orders, admin/dashboard, admin/services/index, admin/orders/index, admin/orders/show, admin/users/show |
| **Category** | `basic` |
| **Description** | Formatted Indonesian Rupiah display. Pattern: `Rp {{ number_format($amount, 0, ',', '.') }}`. Sometimes includes "Mulai dari" label above, or "+" prefix for package add-on prices. |
| **Key props** | `amount` (number), `prefix` (string: '' / '+ ' / 'Rp '), `size` (text-lg/text-xl/text-2xl/text-3xl), `color` (primary/success/default), `label` (string, optional — "Mulai dari", "Harga Dasar", "Total") |
| **HTML structure** | `<span class="text-{size} font-bold text-{color}">Rp {{ formatted }}</span>` or `<div><span class="text-xs">Label</span><p class="text-xl font-bold text-primary">Rp …</p></div>`. |

---

## 18. `FilterTabs`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | pekerja/orders, admin/users/index, admin/orders/index |
| **Category** | `basic` |
| **Description** | Horizontal tab bar for filtering lists by status/role. Uses DaisyUI `tabs tabs-boxed` with active state toggled via URL query parameter. |
| **Key props** | `tabs` (array of `{label, value, route}`), `currentValue` (string — the active tab), `paramName` (string — 'status' or 'role') |
| **HTML structure** | `<div class="tabs tabs-boxed bg-base-100 mb-6 p-1">` → `<a class="tab {{ active ? 'tab-active' : '' }}" href="…">Label</a>` for each tab. Some have `w-fit`, others have `inline-flex`. |

---

## 19. `PageHeader`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | Nearly all pages (home excluded — uses hero instead) |
| **Category** | `basic` |
| **Description** | Page title heading with optional subtitle and optional action button. |
| **Key props** | `title` (string), `subtitle` (string, optional), `actionLabel` (string, optional), `actionUrl` (string, optional), `actionIcon` (SVG slot, optional) |
| **HTML structure** | `<div class="mb-8"><h1 class="text-3xl font-bold text-base-content">…</h1><p class="mt-1 text-base-content/60">…</p></div>`. With action: wrapped in flex with button aligned right. |

---

## 20. `ErrorPage`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | errors/403, errors/404, errors/500 |
| **Category** | `layout` |
| **Description** | Standalone error page with animated icon, gradient error code, heading, description, and action buttons. All three share 95% identical markup. |
| **Key props** | `code` (number: 403/404/500), `title` (string), `description` (string), `icon` (SVG), `iconColor` (warning/info/error), `gradientColors` (pair), `showReload` (boolean) |
| **HTML structure** | Full HTML document → centered flexbox → floating animated SVG → gradient text code → heading → description → CTA buttons (Home + Back/Reload) → copyright footer. |

---

## 21. `WorkerCard`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | orders/create (selectable worker checkbox cards), admin/orders/show (worker info cards) |
| **Category** | `basic` |
| **Description** | Card displaying worker info (avatar, name, location/contact). In order creation, it's a selectable checkbox card with border highlight. In admin view, it's a static info display. |
| **Key props** | `worker` (object: id, name, avatar, regency_name, phone, email), `selectable` (boolean), `selected` (boolean), `inputName` (string) |
| **HTML structure** | Selectable: `<label class="card card-compact cursor-pointer border-2" :class="…">` → checkbox + avatar + name + location. Static: `<div class="flex items-center gap-3 bg-base-200 rounded-lg px-4 py-3">` → avatar + name + contact. |

---

## 22. `PackageCard`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | services/show (info display), orders/create (selectable checkboxes), orders/confirm (line items), orders/receipt (line items), admin/orders/show (line items) |
| **Category** | `basic` |
| **Description** | Addon package display. In service detail, it's an info card. In order creation, it's a selectable checkbox. In receipts, it's a line item with price. |
| **Key props** | `package` (object: id, name, description, price), `selectable` (boolean), `selected` (boolean), `showDescription` (boolean) |
| **HTML structure** | Info: `<div class="card card-compact bg-base-200">` → name + description + price. Selectable: `<label class="card … border-2">` → checkbox + name + description + price. Line item: `<div class="flex justify-between bg-base-200 rounded-lg p-3">` → name + "+ Rp price". |

---

## 23. `OrderTimeline`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | admin/orders/show |
| **Category** | `basic` |
| **Description** | Vertical step indicator showing the lifecycle of an order. Uses DaisyUI `steps steps-vertical` with `step-primary` for completed steps. |
| **Key props** | `order` (object: order_status, payment_status, created_at, paid_at) |
| **HTML structure** | `<ul class="steps steps-vertical">` → 4 `<li class="step step-primary?">` items (Pesanan Dibuat → Pembayaran → Dikerjakan → Selesai), each with title + timestamp/status text. |

---

## 24. `CustomerInfoCard`

| Attribute | Value |
|-----------|-------|
| **Source file(s)** | pekerja/customer-detail, admin/users/show, admin/orders/show (sidebar) |
| **Category** | `basic` |
| **Description** | Detailed customer/user profile card with avatar, name, email, contact info, and optional stats. |
| **Key props** | `user` (object: name, email, phone, address, regency_name, province_name), `stats` (array of `{label, value}`, optional), `showProfileLink` (boolean), `profileUrl` (string, optional) |
| **HTML structure** | `<div class="bg-base-100 rounded-box shadow p-6">` → centered avatar + name + email + role badges + divider + detail rows (label: value) + divider + stats grid. |

---

## Priority Extraction Order

Components ranked by duplication count and consistency benefit:

| Priority | Component | Duplicated In (page count) |
|----------|-----------|---------------------------|
| 🔴 1 | `StatusBadge` | ~10 pages with identical switch/match logic |
| 🔴 2 | `EmptyState` | ~12 pages with similar icon+text+CTA pattern |
| 🔴 3 | `StatCard` | ~5 pages (dashboards + detail pages) |
| 🟠 4 | `UserAvatar` | ~10 pages with 3 different fallback patterns |
| 🟠 5 | `PriceDisplay` | ~13 pages with identical number_format |
| 🟠 6 | `OrderTable` | ~6 pages with similar column structures |
| 🟠 7 | `FilterTabs` | 3 pages with identical tabs-boxed pattern |
| 🟡 8 | `Breadcrumb` | 7 pages with 2 style variants |
| 🟡 9 | `PageHeader` | ~15 pages |
| 🟡 10 | `ServiceCard` | 2 pages (could be 1 component) |
| 🟡 11 | `ReviewStars` | 4 pages |
| 🟡 12 | `ActionButton` | Throughout (general utility) |
| 🟢 13 | `FormGroup` | 2 style variants (DaisyUI + Breeze) |
| 🟢 14 | `ErrorPage` | 3 pages (95% shared markup) |
| 🟢 15 | `AlertNotification` | 4 pages |
| 🟢 16 | `WorkerCard` | 2 pages |
| 🟢 17 | `PackageCard` | 5 pages (3 rendering modes) |
| 🟢 18 | `OrderTimeline` | 1 page (but complex) |
| 🟢 19 | `SidebarMenu` | 2 layouts (pekerja + admin) |
| 🟢 20 | `NavBar` | 1 layout (customer) |
| 🟢 21 | `ConfirmDialog` | 3 pages (2 implementations) |
| 🟢 22 | `CustomerInfoCard` | 3 pages |
| 🟢 23 | `ReviewForm` | 1 page |
| 🟢 24 | `Pagination` | 5 pages (wrapper only) |
