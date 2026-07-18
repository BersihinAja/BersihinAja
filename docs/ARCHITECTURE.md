# BersihinAja — Technical Architecture Documentation

> Web-based professional home cleaning service platform.  
> Fully rewritten from CodeIgniter 3 to **Laravel 13** + **Livewire 4** + **PostgreSQL**.

---

## Table of Contents

- [System Showcase & UI Gallery](#system-showcase--ui-gallery)
- [Tech Stack](#tech-stack)
- [System Architecture](#system-architecture)
- [Request Lifecycle (Livewire SPA)](#request-lifecycle-livewire-spa)
- [Order & Payment Lifecycle](#order--payment-lifecycle)
- [Worker KYC & Verification Lifecycle](#worker-kyc--verification-lifecycle)
- [Directory Structure](#directory-structure)
- [Database Schema (ERD)](#database-schema-erd)
- [Feature Matrices per Role](#feature-matrices-per-role)
- [Route Mappings](#route-mappings)
- [Model Context Protocol (MCP) Integration](#model-context-protocol-mcp-integration)
- [Setup & Installation](#setup--installation)

---

## System Showcase & UI Gallery

Below are the key interfaces of the BersihinAja application, demonstrating multi-role capabilities, geolocation tracking, payment gateway integration, and responsive design systems.

### 1. Landing Page (First Impression)
A clean, premium modern interface showcasing available services with custom typography and real-time regional support availability checks.
![Landing Page](screenshots/landing_page.png)

### 2. Order Creation & Geolocation
Shows regional service selection, distance check computation, live GPS coordinate pin drop on the map, worker list filtering, and price estimation calculations.
![Order Creation](screenshots/order_creation.png)

### 3. Midtrans Payment Gateway Integration
Demonstrates full sandbox integration via the Midtrans Snap modal overlay. Supports secure transactions, checkout flow status hooks, and automated success redirection.
![Midtrans Payment](screenshots/midtrans_payment.png)

### 4. Worker Order Pool & Job Claims
Presents the regional job pool where verified cleaners can view and claim available jobs located in their specific regency (Sleman in this case).
![Pekerja Pool](screenshots/pekerja_pool.png)

### 5. Administrator Dashboard
A comprehensive dashboard displaying site-wide performance metrics, bento-style cards, pending/active worker KYC review workflows, and transactional histories.
![Admin Dashboard](screenshots/admin_dashboard.png)

---

## Tech Stack

### Backend
*   **PHP:** 8.3+
*   **Laravel Framework:** 13.x
*   **Livewire:** 4.x (Powering reactive single-page updates without page reloads)
*   **Spatie Laravel Permission:** 8.x (Role-based access control: `admin`, `pelanggan`, `pekerja`)
*   **Laravel Socialite:** 5.x (Google OAuth authentication)
*   **Midtrans PHP SDK:** 2.x (Core payment gateway integration)
*   **Laravel MCP:** 0.8.x (Model Context Protocol server)

### Frontend
*   **Tailwind CSS:** 3.x
*   **DaisyUI:** 5.x
*   **Alpine.js:** 3.x (Lightweight inline state, GPS capture, drawer states)
*   **Vite:** 8.x (Asset bundling and Hot Module Replacement)
*   **Iconify:** for premium Lucide vector icon styling

### Database & External Services
*   **PostgreSQL:** Relational database storage
*   **Emsifa API:** Third-party Indonesian administrative boundary REST API
*   **HTML5 Geolocation API:** Native browser API for worker and customer GPS capture
*   **Google Maps URL Scheme:** Direct redirection for worker navigation

---

## System Architecture

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
    LW -->|"GPS coords ↔ Distance Check"| GMAPS
    MW -.->|"guards"| LW
    MCP -->|"expose tools"| MDL

    style CLIENT fill:#1d232a,stroke:#37cdbe,color:#fff
    style SERVER fill:#0f172a,stroke:#37cdbe,color:#fff
    style DATA fill:#1e293b,stroke:#94a3b8,color:#fff
```

---

## Request Lifecycle (Livewire SPA)

Every page operates as a **Livewire Full-Page Component** loaded with `wire:navigate`. This achieves a complete Single Page Application (SPA) feel.

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

## Order & Payment Lifecycle

Our matching mechanism follows a regional pool design with a geofenced completion loop:

```mermaid
flowchart TD
    A["👤 Customer chooses service"] --> B["Checkout form<br/>(captures text address + GPS coords)"]
    B --> C["Order created in PostgreSQL<br/>(status: pending, payment: unpaid)"]
    C --> D["Midtrans Snap Token generated"]
    D --> E["Customer completes payment"]
    E --> F["Midtrans Webhook triggers<br/>(payment_status -> paid)"]
    F --> G["Order is pushed to regional pool<br/>(regency matching)"]
    G --> H["Worker claims order<br/>(locks row database to prevent race conditions)"]
    H --> I["Worker clicks 'Mulai Perjalanan'<br/>(order_status -> on_the_way)"]
    I --> J["Worker clicks 'Mulai Bekerja'<br/>(validates GPS distance < 200m)"]
    J -->|Verified| K["Worker cleans house<br/>(order_status -> working)"]
    J -->|Too far| L["Action blocked"]
    K --> M["Worker clicks 'Selesai Kerja'<br/>(order_status -> completed)"]
    M --> N["Customer rates the job ⭐"]

    style A fill:#1d232a,stroke:#37cdbe,color:#fff
    style F fill:#065f46,stroke:#37cdbe,color:#fff
    style K fill:#065f46,stroke:#37cdbe,color:#fff
    style M fill:#065f46,stroke:#37cdbe,color:#fff
```

---

## Worker KYC & Verification Lifecycle

To minimize registration drop-off while securing quality, workers undergo a post-login verification loop:

```mermaid
flowchart TD
    A["Pekerja registers easily<br/>(Name, Email, Role, Password)"] --> B["Pekerja logs in and enters dashboard"]
    B --> C{"Check Pekerja Status?"}
    C -->|pending_verification / rejected| D["Dashboard is locked<br/>(Show KYC form: Upload Selfie + KTP card)"]
    C -->|under_review| E["Show Under Review screen<br/>(Wait for admin check)"]
    C -->|available / busy| F["Open normal dashboard stats"]
    
    D -->|Submit documents| G["Save images, status -> under_review"]
    G --> E
    
    E --> H["Admin UserManager panel"]
    H --> I{"Admin choice?"}
    I -->|Approve| J["status -> available<br/>(worker unlocked)"]
    I -->|Reject| K["status -> rejected<br/>(saves feedback reason)"]
    
    K --> D
    J --> F
```

---

## Database Schema (ERD)

```mermaid
erDiagram
    users {
        bigint id PK
        string name
        string email UK
        string password "nullable"
        string phone "nullable"
        text address "nullable"
        string ktp_number "nullable"
        string avatar "nullable (Selfie)"
        string ktp_image "nullable"
        string google_id UK "nullable"
        string province_id "nullable"
        string regency_id "nullable"
        string province_name "nullable"
        string regency_name "nullable"
        string status "default: available"
        text rejection_reason "nullable"
        timestamp deleted_at
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
        timestamp deleted_at
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
        decimal latitude "10,8"
        decimal longitude "11,8"
        string payment_status "default: unpaid"
        string order_status "default: pending"
        string snap_token "nullable"
        timestamp scheduled_at "nullable"
        timestamp completed_at "nullable"
        timestamp deleted_at
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
        int rating
        text comment "nullable"
    }

    roles {
        bigint id PK
        string name
    }

    users ||--o{ orders : "places"
    users ||--o{ order_workers : "assigned"
    users ||--o{ reviews : "writes"
    services ||--o{ orders : "ordered"
    services ||--o{ service_packages : "has"
    packages ||--o{ service_packages : "belongs to"
    orders ||--o{ order_workers : "assigned to"
    orders ||--o{ order_packages : "includes"
    orders ||--o| reviews : "reviewed"
    packages ||--o{ order_packages : "added to"
    users }o--o{ roles : "has"
```

---

## Directory Structure

```
BersihinAja/
├── app/
│   ├── Http/Controllers/
│   │   ├── Api/RegionController.php
│   │   ├── Auth/SocialiteController.php
│   │   └── PaymentController.php
│   │
│   ├── Livewire/                              # All views rendered as SPA
│   │   ├── Admin/
│   │   │   ├── Dashboard.php
│   │   │   ├── OrderManager.php
│   │   │   ├── ServiceManager.php
│   │   │   └── UserManager.php                # KYC Approvals & Rejections
│   │   ├── Auth/
│   │   │   ├── Login.php
│   │   │   └── Register.php                   # Fast sign-up (no KYC here)
│   │   ├── Forms/
│   │   │   └── OrderForm.php
│   │   ├── Orders/
│   │   │   ├── CreateOrder.php
│   │   │   ├── OrderConfirm.php
│   │   │   ├── OrderHistory.php               # Dynamic worker rating display
│   │   │   └── OrderReceipt.php
│   │   ├── Pekerja/
│   │   │   ├── CustomerList.php
│   │   │   ├── Dashboard.php                  # Post-login KYC Submission Form
│   │   │   └── OrderList.php                  # Claim Pool & GPS geofencing
│   │   ├── Profile/
│   │   │   └── ProfileEdit.php
│   │   ├── HomePage.php
│   │   ├── ServiceList.php
│   │   └── ServiceDetail.php
│   │
│   ├── Mcp/Servers/
│   │   └── BersihinAjaServer.php
│   │
│   ├── Models/
│   │   └── User.php                           # dynamic rating scopes
│   │
│   └── Services/
│       ├── MidtransService.php
│       ├── OrderService.php
│       └── RegionService.php
```

---

## Feature Matrices per Role

### 👤 Customer (Pelanggan)
*   Register & Login (Standard credentials or Google login).
*   Browse cleaning services and add-on packages.
*   Checkout with HTML5 Geolocation capture.
*   Secure payments via Midtrans.
*   Review assigned worker credentials, profile picture, and dynamic rating scores.
*   Write ulasan (reviews & ratings).

### 🛡️ Admin
*   Dashboard statistics (revenue, total orders, users).
*   Manage cleaning services (CRUD & file upload).
*   UserManager (Approve/Reject worker KYC files with feedback reason).
*   OrderManager (Assign backups, update parameters).

### 🧹 Worker (Pekerja)
*   KYC verification form (uploads Selfie, KTP image, WA, working region).
*   Rejection feedback handler (see rejection reason, re-upload documents).
*   View regional job pool and claim orders (safely locked from race conditions).
*   Step-by-step order tracking with GPS radius verification (< 200m to begin job).

---

## Route Mappings

### Public Routes
*   `GET /` → `HomePage`
*   `GET /services` → `ServiceList`
*   `GET /services/{slug}` → `ServiceDetail`

### Auth (Customer)
*   `GET /orders/create/{slug}` → `Orders\CreateOrder`
*   `GET /orders/{id}/confirm` → `Orders\OrderConfirm`
*   `GET /orders/{id}/receipt` → `Orders\OrderReceipt`
*   `GET /orders/history` → `Orders\OrderHistory`
*   `GET /profile` → `Profile\ProfileEdit`

### Auth (Admin)
*   `GET /admin/dashboard` → `Admin\Dashboard`
*   `GET /admin/services` → `Admin\ServiceManager`
*   `GET /admin/orders` → `Admin\OrderManager`
*   `GET /admin/users` → `Admin\UserManager`

### Auth (Pekerja)
*   `GET /pekerja/dashboard` → `Pekerja\Dashboard`
*   `GET /pekerja/orders` → `Pekerja\OrderList`
*   `GET /pekerja/customers` → `Pekerja\CustomerList`

---

## Model Context Protocol (MCP) Integration

BersihinAja exposes dynamic data interfaces via an MCP server endpoint at `ANY /mcp/bersihinaja`.

### Provided Tools
*   `ListServicesTool`: Exposes available catalog list.
*   `GetOrderStatusTool`: Queries real-time transaction updates.
*   `CreateOrderTool`: Prompts dynamic bookings.
*   `ListAvailableWorkersTool`: Checks regional worker counts.

---

## Setup & Installation

Detailed local setup and build instructions are outlined in the root [README.md](../README.md).
