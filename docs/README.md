# BersihinAja — Dokumentasi Teknis

> Platform jasa kebersihan rumah profesional berbasis web.  
> Ditulis ulang sepenuhnya dari CodeIgniter 3 ke **Laravel 13** + **Livewire 4** + **PostgreSQL**.

---

## Daftar Isi

- [Tech Stack](#tech-stack)
- [Arsitektur Sistem](#arsitektur-sistem)
- [Alur Request (Livewire SPA)](#alur-request-livewire-spa)
- [Alur Pemesanan & Pembayaran](#alur-pemesanan--pembayaran)
- [Struktur Direktori](#struktur-direktori)
- [Database Schema (ERD)](#database-schema-erd)
- [Fitur per Role](#fitur-per-role)
- [Daftar Route](#daftar-route)
- [Livewire Components](#livewire-components)
- [Service Layer](#service-layer)
- [Laravel MCP Server](#laravel-mcp-server)
- [Setup & Instalasi](#setup--instalasi)
- [Environment Variables](#environment-variables)
- [Deployment](#deployment)
- [Kredit](#kredit)

---

## Tech Stack

### Backend

| Teknologi | Versi | Fungsi |
|---|---|---|
| PHP | 8.3+ | Runtime |
| Laravel | 13.x | Framework utama |
| Livewire | 4.x | Full-page SPA components (zero JS reload) |
| Spatie Permission | 8.x | Role-based access control (admin, pelanggan, pekerja) |
| Laravel Socialite | 5.x | OAuth — Google Login |
| Midtrans PHP | 2.x | Payment gateway (Snap token) |
| Laravel MCP | 0.8.x | Model Context Protocol server untuk integrasi AI |

### Frontend

| Teknologi | Versi | Fungsi |
|---|---|---|
| Tailwind CSS | 3.x | Utility-first CSS framework |
| DaisyUI | 5.x | Component library di atas Tailwind |
| Alpine.js | 3.x | Lightweight JS interactivity (dropdown, GPS, dll) |
| Vite | 8.x | Build tool & HMR dev server |
| Iconify | latest | Icon library (Lucide icon set) |

### Database & Infra

| Teknologi | Fungsi |
|---|---|
| PostgreSQL | Database utama (relational) |
| Emsifa API | Data provinsi & kabupaten Indonesia (REST) |
| HTML5 Geolocation | Capture koordinat GPS pelanggan di browser |
| Google Maps URL Scheme | Navigasi pekerja ke lokasi pelanggan |

---

## Arsitektur Sistem

```mermaid
graph TB
    subgraph CLIENT["🖥️ Browser (Client)"]
        A["Tailwind + DaisyUI + Alpine.js"]
        L["Livewire JS Runtime"]
    end

    subgraph SERVER["⚙️ Laravel 13 (Server)"]
        direction TB
        LW["Livewire Components<br/>(Full-Page & Nested)"]
        SVC["Service Layer<br/>OrderService · MidtransService · RegionService"]
        MDL["Eloquent Models<br/>User · Service · Order · Package · Review"]
        MW["Middleware<br/>Auth · Role (Spatie) · Verified"]
        MCP["MCP Server<br/>Tools & Resources"]
    end

    subgraph DATA["🗄️ Data Layer"]
        PG[("PostgreSQL")]
        SNAP["Midtrans Snap API"]
        REGION["Emsifa Region API"]
        GMAPS["Google Maps<br/>(URL redirect)"]
    end

    A <-->|"Livewire XHR / wire:navigate"| LW
    L <-->|"Alpine ↔ Livewire bridge"| LW
    LW --> SVC
    SVC --> MDL
    MDL --> PG
    SVC -->|"Create Snap Token"| SNAP
    SVC -->|"GET provinces/regencies"| REGION
    LW -->|"GPS coords → Maps link"| GMAPS
    MW -.->|"guards"| LW
    MCP -->|"expose tools"| MDL

    style CLIENT fill:#1d232a,stroke:#37cdbe,color:#fff
    style SERVER fill:#0f172a,stroke:#37cdbe,color:#fff
    style DATA fill:#1e293b,stroke:#94a3b8,color:#fff
```

---

## Alur Request (Livewire SPA)

Seluruh halaman menggunakan **Livewire Full-Page Components** dengan `wire:navigate` sehingga navigasi antar halaman terasa seperti SPA tanpa full page reload.

```mermaid
sequenceDiagram
    participant B as Browser
    participant LW as Livewire Runtime
    participant C as Livewire Component
    participant S as Service Layer
    participant DB as PostgreSQL

    B->>LW: Click link (wire:navigate)
    LW->>C: Mount full-page component
    C->>S: Call service method
    S->>DB: Eloquent query
    DB-->>S: Result
    S-->>C: Return data
    C-->>LW: Render Blade view
    LW-->>B: Morph DOM (no full reload)

    Note over B,LW: Subsequent interactions use<br/>XHR AJAX (no page reload)

    B->>LW: User action (wire:click, wire:model)
    LW->>C: Call component method
    C-->>LW: Re-render partial
    LW-->>B: Morph only changed DOM
```

---

## Alur Pemesanan & Pembayaran

```mermaid
flowchart TD
    A["👤 Pelanggan buka halaman layanan"] --> B["Pilih layanan & klik Pesan"]
    B --> C["Form pemesanan<br/>(alamat, wilayah, paket tambahan)"]
    C --> D{"📍 Izinkan GPS?"}
    D -->|Ya| E["Capture latitude & longitude"]
    D -->|Tidak| F["Hanya alamat teks"]
    E --> G["Submit order"]
    F --> G
    G --> H["OrderService::createOrder()"]
    H --> I["Simpan ke DB<br/>(status: pending, payment: unpaid)"]
    I --> J["MidtransService::createSnapToken()"]
    J --> K["Redirect ke halaman konfirmasi"]
    K --> L["Tampilkan Snap payment popup"]
    L --> M{"Pembayaran berhasil?"}
    M -->|Ya| N["Midtrans Webhook → update payment_status = paid"]
    M -->|Tidak| O["Status tetap unpaid"]
    N --> P["Admin assign pekerja"]
    P --> Q["Pekerja lihat order + navigasi Google Maps"]
    Q --> R["Pekerjaan selesai → status = completed"]
    R --> S["Pelanggan beri review ⭐"]

    style A fill:#1d232a,stroke:#37cdbe,color:#fff
    style N fill:#065f46,stroke:#37cdbe,color:#fff
    style R fill:#065f46,stroke:#37cdbe,color:#fff
```

---

## Struktur Direktori

```
BersihinAja/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Api/
│   │       │   └── RegionController.php      # REST API provinsi & kabupaten
│   │       ├── Auth/
│   │       │   ├── SocialiteController.php    # Google OAuth
│   │       │   └── ...                        # Breeze auth controllers
│   │       └── PaymentController.php          # Midtrans webhook handler
│   │
│   ├── Livewire/                              # 🔥 Seluruh halaman = Livewire component
│   │   ├── Admin/
│   │   │   ├── Dashboard.php                  # Statistik admin
│   │   │   ├── OrderManager.php               # CRUD & assign pekerja
│   │   │   ├── ServiceManager.php             # CRUD layanan + upload gambar
│   │   │   └── UserManager.php                # Kelola user & role
│   │   ├── Auth/
│   │   │   ├── Login.php                      # Halaman login
│   │   │   └── Register.php                   # Halaman register
│   │   ├── Forms/
│   │   │   └── OrderForm.php                  # Livewire Form Object (validasi)
│   │   ├── Orders/
│   │   │   ├── CreateOrder.php                # Form pemesanan + GPS
│   │   │   ├── OrderConfirm.php               # Konfirmasi & Snap payment
│   │   │   ├── OrderHistory.php               # Riwayat pesanan pelanggan
│   │   │   └── OrderReceipt.php               # Bukti pembayaran
│   │   ├── Pekerja/
│   │   │   ├── CustomerList.php               # Daftar pelanggan per wilayah
│   │   │   ├── Dashboard.php                  # Statistik pekerja
│   │   │   └── OrderList.php                  # Order + link Google Maps
│   │   ├── Profile/
│   │   │   └── ProfileEdit.php                # Edit profil + wilayah
│   │   ├── HomePage.php                       # Landing page
│   │   ├── ServiceList.php                    # Katalog layanan
│   │   └── ServiceDetail.php                  # Detail layanan + paket
│   │
│   ├── Mcp/
│   │   └── Servers/
│   │       └── BersihinAjaServer.php          # Laravel MCP server
│   │
│   ├── Models/
│   │   ├── User.php                           # + Google OAuth, roles, wilayah
│   │   ├── Service.php                        # Layanan kebersihan
│   │   ├── Order.php                          # Pesanan + koordinat GPS
│   │   ├── Package.php                        # Paket tambahan
│   │   └── Review.php                         # Ulasan pelanggan
│   │
│   ├── Policies/
│   │   └── OrderPolicy.php                    # Authorization rules
│   │
│   └── Services/                              # 🧩 Business logic layer
│       ├── MidtransService.php                # Snap token & config
│       ├── OrderService.php                   # Create order, assign worker
│       └── RegionService.php                  # Fetch provinsi/kabupaten
│
├── database/
│   ├── migrations/                            # 12 migration files
│   │   ├── create_users_table                 # + phone, KTP, Google ID, wilayah
│   │   ├── create_permission_tables           # Spatie roles & permissions
│   │   ├── create_services_table
│   │   ├── create_packages_table
│   │   ├── create_service_packages_table      # Pivot: service ↔ package
│   │   ├── create_orders_table
│   │   ├── create_order_workers_table         # Pivot: order ↔ pekerja
│   │   ├── create_order_packages_table        # Pivot: order ↔ paket tambahan
│   │   ├── create_reviews_table
│   │   └── add_coordinates_to_orders_table    # latitude & longitude (GPS)
│   └── seeders/
│       ├── RoleSeeder.php                     # admin, pelanggan, pekerja
│       ├── ServiceSeeder.php                  # Data layanan awal
│       ├── PackageSeeder.php                  # Data paket tambahan
│       └── AdminUserSeeder.php                # Akun admin default
│
├── resources/views/
│   ├── components/                            # Blade components (layout, nav)
│   ├── livewire/                              # Blade views untuk Livewire
│   │   ├── admin/                             # Views admin panel
│   │   ├── auth/                              # Views login & register
│   │   ├── orders/                            # Views pemesanan
│   │   ├── pekerja/                           # Views panel pekerja
│   │   └── profile/                           # Views profil
│   └── errors/                                # Custom 404, 403, 500 pages
│
├── routes/
│   ├── web.php                                # Route utama
│   ├── auth.php                               # Route autentikasi (Breeze)
│   └── ai.php                                 # Route MCP server
│
├── config/
│   └── midtrans.php                           # Konfigurasi Midtrans
│
└── public/
    ├── images/                                # Logo, favicon, assets statis
    └── build/                                 # Compiled Vite output
```

---

## Database Schema (ERD)

```mermaid
erDiagram
    users {
        bigint id PK
        string name
        string email UK
        string password "nullable (OAuth)"
        string phone "nullable"
        text address "nullable"
        string ktp_number "nullable"
        string avatar "nullable"
        string google_id UK "nullable"
        string province_id "nullable"
        string regency_id "nullable"
        string province_name "nullable"
        string regency_name "nullable"
        string status "default: available"
        timestamp deleted_at "soft delete"
    }

    services {
        bigint id PK
        string name
        string slug UK
        decimal price "12,2"
        string image "nullable"
        string room_size
        int max_hours
        string estimation
        int cleaners_required
        text description "nullable"
        timestamp deleted_at "soft delete"
    }

    packages {
        bigint id PK
        string name
        decimal price "12,2"
        text description "nullable"
    }

    service_packages {
        bigint id PK
        bigint service_id FK
        bigint package_id FK
    }

    orders {
        bigint id PK
        string order_number UK
        bigint customer_id FK
        bigint service_id FK
        decimal total "12,2"
        text address
        string regency_name
        decimal latitude "10,8 nullable"
        decimal longitude "11,8 nullable"
        string payment_status "default: unpaid"
        string order_status "default: pending"
        string snap_token "nullable"
        timestamp scheduled_at "nullable"
        timestamp completed_at "nullable"
        timestamp deleted_at "soft delete"
    }

    order_workers {
        bigint id PK
        bigint order_id FK
        bigint worker_id FK
    }

    order_packages {
        bigint id PK
        bigint order_id FK
        bigint package_id FK
        decimal price "12,2"
    }

    reviews {
        bigint id PK
        bigint order_id FK
        bigint customer_id FK
        int rating "1-5"
        text comment "nullable"
    }

    roles {
        bigint id PK
        string name "admin / pelanggan / pekerja"
    }

    users ||--o{ orders : "places (customer)"
    users ||--o{ order_workers : "assigned (worker)"
    users ||--o{ reviews : "writes"
    services ||--o{ orders : "ordered"
    services ||--o{ service_packages : "has"
    packages ||--o{ service_packages : "belongs to"
    orders ||--o{ order_workers : "assigned to"
    orders ||--o{ order_packages : "includes"
    orders ||--o| reviews : "reviewed"
    packages ||--o{ order_packages : "added to"
    users }o--o{ roles : "has (Spatie)"
```

---

## Fitur per Role

### 👤 Pelanggan (Customer)
- Registrasi & login (email/password + Google OAuth)
- Jelajahi katalog layanan
- Pesan layanan + pilih paket tambahan
- Capture koordinat GPS saat checkout
- Bayar via Midtrans (GoPay, OVO, BCA VA, dll)
- Lihat riwayat pesanan & bukti pembayaran
- Beri review & rating
- Edit profil & pilih wilayah

### 🛡️ Admin
- Dashboard statistik (total order, revenue, user)
- Kelola layanan (CRUD + upload gambar)
- Kelola pesanan & assign pekerja
- Kelola user & role
- Lihat lokasi pelanggan di Google Maps

### 🧹 Pekerja (Worker)
- Dashboard statistik pribadi
- Lihat daftar order yang di-assign
- Navigasi ke lokasi pelanggan via Google Maps (GPS / alamat)
- Lihat daftar pelanggan per wilayah

---

## Daftar Route

### Public
| Method | URI | Komponen |
|---|---|---|
| GET | `/` | `HomePage` |
| GET | `/services` | `ServiceList` |
| GET | `/services/{slug}` | `ServiceDetail` |
| GET | `/login` | `Auth\Login` |
| GET | `/register` | `Auth\Register` |

### Authenticated (Pelanggan)
| Method | URI | Komponen |
|---|---|---|
| GET | `/orders/create/{slug}` | `Orders\CreateOrder` |
| GET | `/orders/history` | `Orders\OrderHistory` |
| GET | `/orders/{id}/confirm` | `Orders\OrderConfirm` |
| GET | `/orders/{id}/receipt` | `Orders\OrderReceipt` |
| GET | `/profile` | `Profile\ProfileEdit` |

### Admin
| Method | URI | Komponen |
|---|---|---|
| GET | `/admin/dashboard` | `Admin\Dashboard` |
| GET | `/admin/services` | `Admin\ServiceManager` |
| GET | `/admin/orders` | `Admin\OrderManager` |
| GET | `/admin/users` | `Admin\UserManager` |

### Pekerja
| Method | URI | Komponen |
|---|---|---|
| GET | `/pekerja/dashboard` | `Pekerja\Dashboard` |
| GET | `/pekerja/orders` | `Pekerja\OrderList` |
| GET | `/pekerja/customers` | `Pekerja\CustomerList` |

### API & Webhooks
| Method | URI | Controller |
|---|---|---|
| GET | `/api/regions/provinces` | `RegionController@provinces` |
| GET | `/api/regions/regencies/{id}` | `RegionController@regencies` |
| POST | `/midtrans/webhook` | `PaymentController@handleWebhook` |
| GET | `/auth/google` | `SocialiteController@redirect` |
| GET | `/auth/google/callback` | `SocialiteController@callback` |
| ANY | `/mcp/bersihinaja` | Laravel MCP Server |

---

## Livewire Components

Semua halaman menggunakan **Full-Page Livewire Components** (bukan Blade controller-based views).

```mermaid
graph LR
    subgraph PUBLIC["Public Pages"]
        HP[HomePage]
        SL[ServiceList]
        SD[ServiceDetail]
    end

    subgraph AUTH["Auth Pages"]
        LG[Login]
        RG[Register]
    end

    subgraph CUSTOMER["Customer Pages"]
        CO[CreateOrder]
        OC[OrderConfirm]
        OH[OrderHistory]
        OR[OrderReceipt]
        PE[ProfileEdit]
    end

    subgraph ADMIN["Admin Panel"]
        AD[Admin Dashboard]
        SM[ServiceManager]
        OM[OrderManager]
        UM[UserManager]
    end

    subgraph WORKER["Worker Panel"]
        PD[Pekerja Dashboard]
        OL[OrderList]
        CL[CustomerList]
    end

    HP --> SD
    SD --> CO
    CO --> OC
    OC --> OR
    OH --> OR

    style PUBLIC fill:#134e4a,stroke:#37cdbe,color:#fff
    style AUTH fill:#1e1b4b,stroke:#818cf8,color:#fff
    style CUSTOMER fill:#172554,stroke:#60a5fa,color:#fff
    style ADMIN fill:#4c1d95,stroke:#a78bfa,color:#fff
    style WORKER fill:#78350f,stroke:#fbbf24,color:#fff
```

---

## Service Layer

Logika bisnis dipisahkan dari Livewire component ke dalam **Service classes**:

| Service | Fungsi |
|---|---|
| `OrderService` | Membuat order, generate nomor order, menghitung total, assign pekerja |
| `MidtransService` | Membuat Snap token untuk payment gateway Midtrans |
| `RegionService` | Fetch data provinsi & kabupaten dari Emsifa API |

### Kenapa Service Layer?

```mermaid
graph LR
    LC["Livewire Component<br/>(thin controller)"] --> SVC["Service Class<br/>(business logic)"]
    SVC --> MDL["Eloquent Model<br/>(data access)"]
    SVC --> EXT["External API<br/>(Midtrans, Emsifa)"]

    LC -.->|"❌ TIDAK langsung"| MDL
    LC -.->|"❌ TIDAK langsung"| EXT

    style LC fill:#1d232a,stroke:#37cdbe,color:#fff
    style SVC fill:#065f46,stroke:#37cdbe,color:#fff
    style MDL fill:#1e293b,stroke:#94a3b8,color:#fff
    style EXT fill:#7c2d12,stroke:#fb923c,color:#fff
```

> Livewire component hanya bertanggung jawab atas **UI state** dan **user interaction**.  
> Semua business logic ada di Service layer → lebih mudah di-test dan di-reuse.

---

## Laravel MCP Server

BersihinAja menyediakan **Model Context Protocol (MCP)** server agar bisa diintegrasikan dengan AI agent.

**Endpoint:** `GET/POST /mcp/bersihinaja`

### Tools
| Tool | Fungsi |
|---|---|
| `ListServicesTool` | Menampilkan daftar layanan yang tersedia |
| `GetOrderStatusTool` | Cek status pesanan berdasarkan nomor order |
| `CreateOrderTool` | Membuat pesanan baru via AI |
| `ListAvailableWorkersTool` | Daftar pekerja yang tersedia per wilayah |
| `GetOrderHistoryTool` | Riwayat pesanan user |

### Resources
| Resource | Fungsi |
|---|---|
| `ServiceCatalogResource` | Expose katalog layanan |
| `PricingGuideResource` | Expose informasi harga |

---

## Setup & Instalasi

### Prerequisites
- PHP 8.3+
- Composer 2.x
- Node.js 20+ & npm
- PostgreSQL 15+

### Quick Start

```bash
# 1. Clone repository
git clone https://github.com/BersihinAja/BersihinAja.git
cd BersihinAja

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi database (edit .env)
#    DB_CONNECTION=pgsql
#    DB_DATABASE=bersihinaja
#    DB_USERNAME=postgres
#    DB_PASSWORD=your_password

# 5. Jalankan migrasi & seeder
php artisan migrate --seed

# 6. Link storage
php artisan storage:link

# 7. Build frontend
npm run build

# 8. Jalankan development server
composer dev
# Atau manual:
# php artisan serve    (terminal 1)
# npm run dev          (terminal 2)
```

### Default Admin Account
| Field | Value |
|---|---|
| Email | `admin@bersihinaja.com` |
| Password | `password` |

---

## Environment Variables

| Variable | Deskripsi | Contoh |
|---|---|---|
| `DB_CONNECTION` | Driver database | `pgsql` |
| `DB_DATABASE` | Nama database | `bersihinaja` |
| `MIDTRANS_SERVER_KEY` | Server key Midtrans | `SB-Mid-server-xxx` |
| `MIDTRANS_CLIENT_KEY` | Client key Midtrans | `SB-Mid-client-xxx` |
| `MIDTRANS_IS_PRODUCTION` | Mode production | `false` |
| `GOOGLE_CLIENT_ID` | Google OAuth client ID | `xxx.apps.googleusercontent.com` |
| `GOOGLE_CLIENT_SECRET` | Google OAuth client secret | `GOCSPX-xxx` |
| `GOOGLE_REDIRECT_URI` | Callback URL Google | `http://localhost:8000/auth/google/callback` |

---

## Deployment

```mermaid
graph LR
    DEV["💻 Local Dev"] -->|"git push"| GH["GitHub<br/>BersihinAja/BersihinAja"]
    GH -->|"CI/CD"| PROD["🚀 Production Server"]
    PROD --> NGINX["Nginx"]
    NGINX --> PHP["PHP-FPM 8.3"]
    PHP --> PG[("PostgreSQL")]
    PROD --> MT["Midtrans API"]

    style DEV fill:#1d232a,stroke:#37cdbe,color:#fff
    style GH fill:#0d1117,stroke:#8b949e,color:#fff
    style PROD fill:#065f46,stroke:#37cdbe,color:#fff
```

### Production Checklist
- [ ] Set `APP_ENV=production` dan `APP_DEBUG=false`
- [ ] Set `MIDTRANS_IS_PRODUCTION=true` dengan production keys
- [ ] Konfigurasi Google OAuth dengan production redirect URI
- [ ] Jalankan `php artisan config:cache && php artisan route:cache && php artisan view:cache`
- [ ] Setup SSL/HTTPS
- [ ] Konfigurasi queue worker untuk background jobs
- [ ] Setup backup database berkala

---

## Kredit

Proyek ini bermula sebagai tugas kelompok kuliah dan memenangkan kompetisi.  
Ditulis ulang sepenuhnya menggunakan teknologi modern.

**Repository asli:** [kayrinth/BersihinAja](https://github.com/kayrinth/BersihinAja) (CodeIgniter 3)  
**Rewrite oleh:** Tim BersihinAja — Laravel 13, Livewire 4, PostgreSQL

---

<p align="center">
  <strong>BersihinAja</strong> — Bersih Itu Mudah 🧹✨
</p>
