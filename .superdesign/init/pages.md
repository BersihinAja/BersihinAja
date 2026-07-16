# BersihinAja — Page Dependency Tree

> Auto-generated analysis of all Blade views. UI framework: **DaisyUI 5 + Tailwind CSS** (customer/pekerja/admin/error pages) and **Laravel Breeze defaults** (auth/profile pages).

---

## 1. Customer Pages (layout: `layouts.app` via `<x-app-layout>`)

### 1.1 `home.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-app-layout>` |
| **Components** | `x-app-layout` |
| **Includes** | None |
| **Sections** | None (content is direct child of layout component) |
| **Alpine.js** | None |
| **Key UI patterns** | Hero section (gradient bg, CTA button), Service cards grid (3-col, image/fallback, badges for room_size & estimation, price, "Lihat Detail" button), Feature cards (icon + heading + text, 3-col), `@forelse`/`@empty` empty state |

---

### 1.2 `services/index.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-app-layout>` |
| **Components** | `x-app-layout` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Page header (h1 + subtitle), Service cards grid (3-col, image/fallback, icon badges for room_size/estimation/cleaners, package count hint, divider, price display + "Detail" btn), `@forelse`/`@empty` with `alert alert-info` empty state |

---

### 1.3 `services/show.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-app-layout>` |
| **Components** | `x-app-layout` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | `x-data="regionSelector()"`, `x-model` (selectedProvince, selectedRegency), `@change="fetchRegencies()"`, `x-bind:href`, `:disabled`, `:class`, `x-for`, `x-text`, `:key`, `:value` |
| **Key UI patterns** | Breadcrumbs (Home > Layanan > name), Detail card (image + info side-by-side), Stat grid (4-col: price, room_size, estimation, max_hours), Package cards (compact, 2-col grid), Region selector (province → regency cascading dropdowns via fetch API), Auth-gated CTA ("Pesan Sekarang" / "Login untuk Memesan"), Inline `<script>` for `regionSelector()` Alpine component |

---

### 1.4 `orders/create.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-app-layout>` |
| **Components** | `x-app-layout` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | `x-data="orderForm()"`, `x-text`, `:class`, `@change="toggleWorker()"`, `@change="togglePackage()"`, `:disabled` |
| **Key UI patterns** | Breadcrumbs, Form (POST with @csrf), Service summary card (4-col grid: name/price/location/estimation), Worker selection card (checkbox cards with avatar, border highlight on select), Package selection card (checkbox cards with price, accent border highlight), Address textarea with validation, Total & Submit card (dynamic price via Alpine, disabled state), Inline `<script>` for `orderForm()` Alpine component, `@error` validation messages |

---

### 1.5 `orders/confirm.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-app-layout>` |
| **Components** | `x-app-layout` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Order detail card (order number + "Menunggu Pembayaran" badge), Service line item, Worker badges (avatar + name), Package line items, Address display, Total amount, "Bayar Sekarang" button (loading state), Expiry warning alert, Midtrans Snap integration (`<script>` with snap.pay, onSuccess/onPending/onError/onClose callbacks) |

---

### 1.6 `orders/receipt.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-app-layout>` |
| **Components** | `x-app-layout` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Order header (order number + dual status badges: order_status + payment_status via `match`), Service info block, Worker list (avatar + name), Package line items with pivot price, Address display, Payment date, Total amount, **Review form** (conditional: star rating via `mask mask-star-2`, comment textarea, submit btn) OR **Review display** (read-only stars + comment quote), Back link to history |

**Status badge mapping (order_status):**
- `pending` → `badge-warning`
- `in_progress` → `badge-info`
- `completed` → `badge-success`
- `cancelled` → `badge-error`

**Status badge mapping (payment_status):**
- `unpaid` → `badge-warning`
- `pending` → `badge-info`
- `paid` → `badge-success`
- `expired` → `badge-error`
- `cancelled` → `badge-error`

---

### 1.7 `orders/history.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-app-layout>` |
| **Components** | `x-app-layout` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Flash success alert, Empty state card (icon + heading + subtitle + CTA), Order cards list (stacked, each with: order number, dual status badges, service name, date, total price, "Detail" link), Review display (inline star rating), Pagination (`$orders->links()`) |

---

## 2. Auth Pages (layout: `layouts.guest` via `<x-guest-layout>`)

### 2.1 `auth/login.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-guest-layout>` |
| **Components** | `x-guest-layout`, `x-auth-session-status`, `x-input-label`, `x-text-input`, `x-input-error`, `x-primary-button` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Form (POST, @csrf), Email input, Password input, "Remember me" checkbox, "Forgot password" link, "Log in" primary button, Divider ("Atau"), Google OAuth button (SVG icon, link to `auth.google` route) |

---

### 2.2 `auth/register.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-guest-layout>` |
| **Components** | `x-guest-layout`, `x-input-label`, `x-text-input`, `x-input-error`, `x-primary-button` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Form (POST, @csrf), Name input, Email input, Role select dropdown (Customer / Pekerja), Password input, Confirm password input, "Already registered?" link, "Register" primary button, Divider ("Atau"), Google OAuth button |

---

## 3. Pekerja Pages (layout: `layouts.pekerja` via `<x-pekerja-layout>`)

### 3.1 `pekerja/dashboard.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-pekerja-layout>` |
| **Components** | `x-pekerja-layout` |
| **Slots** | `<x-slot:title>Dashboard</x-slot:title>` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Page header (h1 + welcome message with auth user name), **Stat cards grid** (4-col: Pesanan Aktif / Pesanan Selesai / Total Pendapatan / Status — each with `stat-figure` icon, `stat-title`, `stat-value`, `stat-desc`), Status badge (available=success, busy=warning), Recent orders table (`table-zebra`, columns: order number, customer, service, status badge via `@switch`, date), Empty state (icon + text) |

---

### 3.2 `pekerja/orders.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-pekerja-layout>` |
| **Components** | `x-pekerja-layout` |
| **Slots** | `<x-slot:title>Pesanan Saya</x-slot:title>` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Page header (h1 + subtitle), **Filter tabs** (`tabs-boxed`: All / In Progress / Completed / Cancelled), Orders table (columns: order number, customer w/ avatar placeholder, service, packages badges, total, status badge, action button), "Selesaikan" form button (POST with confirm dialog, only for `in_progress`), Pagination with appended query string, Empty state with conditional message |

---

### 3.3 `pekerja/customers.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-pekerja-layout>` |
| **Components** | `x-pekerja-layout` |
| **Slots** | `<x-slot:title>Pelanggan</x-slot:title>` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Page header, Customer cards grid (3-col, each a clickable `<a>` card with: avatar placeholder, name, email, divider, orders_count badge), Pagination, Empty state (icon + text + subtitle) |

---

### 3.4 `pekerja/customer-detail.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-pekerja-layout>` |
| **Components** | `x-pekerja-layout` |
| **Slots** | `<x-slot:title>Detail Pelanggan — {{ $user->name }}</x-slot:title>` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Breadcrumbs (Dashboard > Pelanggan > name), Customer info card (avatar, name, email/phone/address details, stat box for total orders), Orders history table (columns: order number, service, status badge, date, review display w/ star rating + comment tooltip), Empty state |

---

## 4. Admin Pages (layout: `layouts.admin` via `<x-admin-layout>`)

### 4.1 `admin/dashboard.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-admin-layout>` |
| **Components** | `x-admin-layout` |
| **Slots** | `<x-slot:title>Dashboard</x-slot:title>` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Page header, **Main stat cards** (4-col: Total Pesanan / Total Pendapatan / Total Pengguna / Pekerja Aktif — each with icon, title, value, desc), **Secondary stat cards** (4-col compact: Pelanggan / Pekerja / Pesanan Pending / Pesanan Berjalan), Recent orders table (`table-zebra`, columns: order number, customer, service, total, payment badge, order status badge, date), Empty state |

---

### 4.2 `admin/services/index.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-admin-layout>` |
| **Components** | `x-admin-layout` |
| **Slots** | `<x-slot:title>Kelola Layanan</x-slot:title>` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Page header with "Tambah Layanan" CTA button, Services table (columns: service name w/ avatar/image, slug, price, room_size, orders_count badge, actions: edit icon btn + delete form w/ confirm), Empty state with CTA |

---

### 4.3 `admin/services/create.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-admin-layout>` |
| **Components** | `x-admin-layout` |
| **Slots** | `<x-slot:title>Tambah Layanan</x-slot:title>` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Simple breadcrumb (Layanan / Tambah), Form (POST, @csrf, multipart), 2-col grid form fields (name, price, room_size, max_hours, estimation, cleaners_required, description textarea, image file input), Package checkboxes grid, Form actions (Cancel ghost btn + Submit primary btn), `@error` validation messages with `label-text-alt` |

---

### 4.4 `admin/services/edit.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-admin-layout>` |
| **Components** | `x-admin-layout` |
| **Slots** | `<x-slot:title>Edit Layanan</x-slot:title>` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Same as create but pre-filled with existing data, Current image preview thumbnail, @method('PUT'), Package checkboxes with pre-selected state |

---

### 4.5 `admin/users/index.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-admin-layout>` |
| **Components** | `x-admin-layout` |
| **Slots** | `<x-slot:title>Kelola Pengguna</x-slot:title>` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Page header, **Filter tabs** (`tabs-boxed`: Semua / Customer / Pekerja / Admin), Users table (columns: user w/ avatar placeholder + phone, email, role badges via `@switch`, orders_count badge, join date, view detail icon btn), Pagination with query string, Empty state |

**Role badge mapping:**
- `admin` → `badge-primary`
- `pekerja` → `badge-warning`
- `customer` → `badge-info`

---

### 4.6 `admin/users/show.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-admin-layout>` |
| **Components** | `x-admin-layout` |
| **Slots** | `<x-slot:title>Detail Pengguna</x-slot:title>` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Simple breadcrumb, **3-col grid layout** (1 sidebar + 2 main), Profile card (avatar, name, email, role badges, divider, detail rows: phone/address/regency/province/join date/status badge, stats: total orders + total spending), Recent orders table (order number as link, service, total, status badge, date), Empty state |

---

### 4.7 `admin/orders/index.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-admin-layout>` |
| **Components** | `x-admin-layout` |
| **Slots** | `<x-slot:title>Kelola Pesanan</x-slot:title>` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Page header, **Filter tabs** (`tabs-boxed`: Semua / Pending / Berjalan / Selesai / Dibatalkan), Orders table (columns: order number, customer w/ avatar, service, total, payment status badge, order status badge, date, view detail icon btn), Pagination with query string, Empty state |

---

### 4.8 `admin/orders/show.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-admin-layout>` |
| **Components** | `x-admin-layout` |
| **Slots** | `<x-slot:title>Detail Pesanan</x-slot:title>` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Simple breadcrumb (Pesanan / order_number), Header with order status badge, **3-col grid layout** (2 main + 1 sidebar), Order info card (2-col grid: order number, service, address, city, date), Workers card (avatar + name + contact), Packages card (line items with price), Review card (SVG star display + comment + date), **Status timeline** (`steps steps-vertical`: Pesanan Dibuat → Pembayaran → Dikerjakan → Selesai), Sidebar: Customer info card (avatar + name + email + "Lihat Profil" link), Pricing breakdown card (service + packages + divider + total), Payment info card (status badge, midtrans ID, paid_at, expires_at) |

---

## 5. Error Pages (standalone — no layout)

### 5.1 `errors/403.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | None (standalone full HTML document) |
| **Components** | None |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | DaisyUI 5 CDN + Tailwind CDN, `data-theme="dark"`, Floating animation SVG icon (warning/prohibition), Gradient text "403", Heading + description, CTA buttons (Home + Back), Footer copyright, Custom CSS (gradient text clip, float keyframe animation) |

---

### 5.2 `errors/404.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | None (standalone full HTML document) |
| **Components** | None |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Same structure as 403. Icon: question mark circle (info color). Text: "Halaman Tidak Ditemukan". |

---

### 5.3 `errors/500.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | None (standalone full HTML document) |
| **Components** | None |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | None |
| **Key UI patterns** | Same structure as 403/404 but with additional `pulse-icon` animation. Gradient uses `--er` (error) instead of `--s` (secondary). Icon: warning triangle (error color). CTA: Home + "Coba Lagi" (reload). |

---

## 6. Profile Pages (layout: `layouts.app` via `<x-app-layout>`)

### 6.1 `profile/edit.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | `<x-app-layout>` |
| **Components** | `x-app-layout` |
| **Slots** | `<x-slot name="header">` (h2 "Profile") |
| **Includes** | `@include('profile.partials.update-profile-information-form')`, `@include('profile.partials.update-password-form')`, `@include('profile.partials.delete-user-form')` |
| **Sections** | None |
| **Alpine.js** | None (partials use Alpine) |
| **Key UI patterns** | 3 stacked cards (white bg, shadow, rounded), each containing a partial within `max-w-xl` wrapper. Uses **Breeze default styling** (gray-800/dark:gray-200 colors, not DaisyUI). |

---

### 6.2 `profile/partials/update-profile-information-form.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | Partial (included in profile/edit) |
| **Components** | `x-input-label`, `x-text-input`, `x-input-error`, `x-primary-button` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | `x-data="{ show: true }"`, `x-show`, `x-transition`, `x-init="setTimeout(…)"` (for "Saved." flash message) |
| **Key UI patterns** | Section header (h2 + description), Email verification sub-form, Name input, Email input, Save button + transient "Saved." indicator |

---

### 6.3 `profile/partials/update-password-form.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | Partial (included in profile/edit) |
| **Components** | `x-input-label`, `x-text-input`, `x-input-error`, `x-primary-button` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | `x-data="{ show: true }"`, `x-show`, `x-transition`, `x-init="setTimeout(…)"` |
| **Key UI patterns** | Section header, Current password input, New password input, Confirm password input, Save button + "Saved." flash |

---

### 6.4 `profile/partials/delete-user-form.blade.php`

| Attribute | Value |
|-----------|-------|
| **Layout** | Partial (included in profile/edit) |
| **Components** | `x-danger-button`, `x-modal`, `x-input-label`, `x-text-input`, `x-input-error`, `x-secondary-button` |
| **Includes** | None |
| **Sections** | None |
| **Alpine.js** | `x-data=""`, `x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"`, `x-on:click="$dispatch('close')"` |
| **Key UI patterns** | Section header + warning text, "Delete Account" danger button, **Confirmation modal** (`x-modal` component with `name` and `:show` props), Modal form (password confirmation + cancel/delete buttons) |

---

## Summary of Blade Components Used

| Component | Used In |
|-----------|---------|
| `x-app-layout` | home, services/index, services/show, orders/*, profile/edit |
| `x-guest-layout` | auth/login, auth/register |
| `x-pekerja-layout` | pekerja/* |
| `x-admin-layout` | admin/* |
| `x-auth-session-status` | auth/login |
| `x-input-label` | auth/login, auth/register, profile/partials/* |
| `x-text-input` | auth/login, auth/register, profile/partials/* |
| `x-input-error` | auth/login, auth/register, profile/partials/* |
| `x-primary-button` | auth/login, auth/register, profile/partials/update-* |
| `x-danger-button` | profile/partials/delete-user-form |
| `x-secondary-button` | profile/partials/delete-user-form |
| `x-modal` | profile/partials/delete-user-form |

## Summary of Alpine.js Usage

| Page | Alpine Feature |
|------|---------------|
| services/show | `regionSelector()` — cascading province/regency dropdowns via fetch |
| orders/create | `orderForm()` — worker/package selection with dynamic total calculation |
| profile/partials/update-profile-information-form | `{ show: true }` — transient "Saved." flash |
| profile/partials/update-password-form | `{ show: true }` — transient "Saved." flash |
| profile/partials/delete-user-form | `$dispatch('open-modal')` / `$dispatch('close')` — modal control |
