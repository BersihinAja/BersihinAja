# BersihinAja

Professional home cleaning service platform. Customers book cleaning services, admins manage orders and assign workers, workers navigate to customer locations via Google Maps.

Full rewrite from the [original project](https://github.com/kayrinth/BersihinAja) (CodeIgniter 3 + MySQL) to Laravel 13 + Livewire + PostgreSQL.

## Tech Stack

**Backend:** Laravel 13, Livewire 4, Spatie Permission, Laravel Socialite, Midtrans PHP SDK, Laravel MCP  
**Frontend:** Tailwind CSS, DaisyUI, Alpine.js, Vite  
**Database:** PostgreSQL

## Features

- Cleaning service catalog with add-on packages
- Checkout with GPS coordinate capture
- Payment via Midtrans (GoPay, OVO, BCA VA, etc.)
- Google OAuth login
- Admin panel (manage services, orders, users)
- Worker panel (order list, Google Maps navigation to location)
- 3 roles: admin, customer, worker
- MCP server for AI agent integration

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

## Structure

```
app/
├── Livewire/          # Full-page components (all pages)
│   ├── Admin/         # Dashboard, ServiceManager, OrderManager, UserManager
│   ├── Auth/          # Login, Register
│   ├── Orders/        # CreateOrder, OrderConfirm, OrderHistory, OrderReceipt
│   ├── Pekerja/       # Dashboard, OrderList, CustomerList
│   └── Profile/       # ProfileEdit
├── Models/            # User, Service, Order, Package, Review
├── Services/          # OrderService, MidtransService, RegionService
└── Mcp/               # Laravel MCP server
```

Full documentation in [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md).
