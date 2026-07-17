# BersihinAja

Platform jasa kebersihan rumah profesional. Pelanggan memesan layanan, admin mengelola dan assign pekerja, pekerja navigasi ke lokasi via Google Maps.

Rewrite lengkap dari [proyek asli](https://github.com/kayrinth/BersihinAja) (CodeIgniter 3 + MySQL) ke Laravel 13 + Livewire + PostgreSQL.

## Tech Stack

**Backend:** Laravel 13, Livewire 4, Spatie Permission, Laravel Socialite, Midtrans PHP SDK, Laravel MCP  
**Frontend:** Tailwind CSS, DaisyUI, Alpine.js, Vite  
**Database:** PostgreSQL  

## Fitur

- Katalog layanan kebersihan dengan paket tambahan
- Checkout dengan capture GPS koordinat pelanggan
- Pembayaran via Midtrans (GoPay, OVO, BCA VA, dll)
- Google OAuth login
- Panel admin (kelola layanan, pesanan, user)
- Panel pekerja (daftar order, navigasi Google Maps ke lokasi)
- 3 role: admin, pelanggan, pekerja
- MCP server untuk integrasi AI agent

## Setup

```bash
git clone https://github.com/BersihinAja/BersihinAja.git
cd BersihinAja

composer install
npm install

cp .env.example .env
php artisan key:generate

# edit .env → set DB, Midtrans keys, Google OAuth

php artisan migrate --seed
php artisan storage:link
npm run build

composer dev
```

Default admin: `admin@bersihinaja.com` / `password`

## Struktur

```
app/
├── Livewire/          # Full-page components (semua halaman)
│   ├── Admin/         # Dashboard, ServiceManager, OrderManager, UserManager
│   ├── Auth/          # Login, Register
│   ├── Orders/        # CreateOrder, OrderConfirm, OrderHistory, OrderReceipt
│   ├── Pekerja/       # Dashboard, OrderList, CustomerList
│   └── Profile/       # ProfileEdit
├── Models/            # User, Service, Order, Package, Review
├── Services/          # OrderService, MidtransService, RegionService
└── Mcp/               # Laravel MCP server
```

Dokumentasi lengkap ada di [`docs/README.md`](docs/README.md).

## Lisensi

MIT
