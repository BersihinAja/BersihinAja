# BersihinAja Design System

## Design Philosophy
Premium, fresh-clean home cleaning service platform. Bold geometric typography with mint-teal accent (#37CDBE) as the signature pop color. Trustworthy yet luxury editorial feel. Clean, grayscale-to-color image interactions. Smooth cubic-bezier animations throughout. All copy in Bahasa Indonesia.

## Color Palette
- **Primary Background**: #FAFCFB (warm off-white)
- **Secondary Background**: #F0F5F3 (soft mint-tinted white)
- **Primary Text**: #1D232A (deep charcoal)
- **Accent Color**: #37CDBE (mint-teal) — primary pop color, used for CTAs, highlights, hover states
- **Secondary Accent**: #570DF8 (purple) — used ONLY for primary CTA buttons and important badges
- **Success**: #36D399
- **Warning**: #FBBD23 (star ratings)
- **Error**: #F87272

## Typography
- **Font Family**: League Spartan (sans-serif, all elements)
- **Headings**: font-weight 700-900, tracking-tighter (letter-spacing: -0.03em), line-height 0.85
- **Body Text**: font-weight 400-600, standard line-height
- **Utility Labels**: font-size 10px, font-weight 900, tracking 0.4em
- **Menu Items**: font-size 10px, font-weight 900, tracking 0.2em (20% letter-spacing)

## Animation & Transitions
- **Premium Easing**: cubic-bezier(0.16, 1, 0.3, 1)
- **Standard Duration**: 1s for all transitions
- **Image Hover**: grayscale(100%) → grayscale(0%) + scale(1.08)
- **Bounce Animation**: 4s ease-in-out infinite, translateY from -5% to 5%
- **Reveal (scroll-triggered)**: opacity 0→1, translateY 40px→0, using intersection observer (threshold: 0.15)

## Spacing & Layout
- **Grid System**: 12-column layout, max-width 1344px (1440px - 96px padding)
- **Section Padding**: 24px (mobile) to 32px (desktop)
- **Negative Space**: Generous, minimal density

## Special Effects
- **Glassmorphism Navigation**: background rgba(250, 252, 251, 0.85), backdrop-filter blur(12px), 1px border #1D232A/5% opacity
- **Image Grayscale**: All portfolio/hero images start grayscale, reveal color on hover/interaction
- **Hover States**: Smooth ease-premium transition, color/shadow/scale changes

---

# Reusable Components

## Navigation Bar
\`\`\`html
<header class="fixed inset-x-0 top-0 z-50 h-20 border-b border-[#1D232A]/5 bg-[rgba(250,252,251,0.85)] backdrop-blur-xl">
  <nav class="mx-auto flex h-full max-w-[1440px] items-center justify-between px-6 lg:px-12" aria-label="Navigasi utama">
    <a href="#beranda" class="flex items-center gap-2 text-lg font-black tracking-tighter">
      <iconify-icon icon="lucide:sparkles" class="text-xl text-[#37CDBE]"></iconify-icon> BERSIHINAJA
    </a>
    <div class="hidden items-center gap-8 text-[10px] font-black tracking-[0.2em] lg:flex">
      <a href="#beranda" class="ease-premium hover:text-[#37CDBE]">BERANDA</a>
      <a href="#layanan" class="ease-premium hover:text-[#37CDBE]">LAYANAN</a>
      <a href="#cara-kerja" class="ease-premium hover:text-[#37CDBE]">CARA KERJA</a>
      <a href="#kontak" class="ease-premium hover:text-[#37CDBE]">KONTAK</a>
    </div>
    <a href="#layanan" class="rounded-full bg-[#37CDBE] px-5 py-3 text-[10px] font-bold tracking-wide ease-premium hover:bg-[#570DF8] hover:text-white lg:px-8">PESAN SEKARANG</a>
  </nav>
</header>
\`\`\`

## Service Card (3-Column Grid)
\`\`\`html
<article class="group flex min-h-[420px] flex-col border-b border-[#1D232A]/10 bg-[#FAFCFB] p-8 ease-premium hover:bg-[#37CDBE] md:border-b-0 md:border-r lg:p-10">
  <iconify-icon icon="lucide:spray-can" class="text-5xl text-[#37CDBE] ease-premium group-hover:text-[#1D232A]"></iconify-icon>
  <h3 class="mt-12 text-3xl font-black uppercase tracking-tighter">Small</h3>
  <p class="mt-4 text-sm font-medium leading-relaxed text-[#1D232A]/70">Ruangan 5×5<br>~2 jam · 1 pekerja</p>
  <div class="mt-auto">
    <div class="flex items-start">
      <span class="mt-2 text-[10px] font-black tracking-[0.2em]">Rp</span>
      <span class="text-5xl font-black tracking-tighter">50.000</span>
    </div>
    <a href="#kontak" class="mt-5 inline-flex border-b-2 border-[#1D232A] pb-1 text-xs font-black uppercase tracking-widest">
      Pesan <iconify-icon icon="lucide:arrow-up-right" class="ml-2 text-base"></iconify-icon>
    </a>
  </div>
</article>
\`\`\`

## Process Step Circle
\`\`\`html
<div class="relative">
  <div class="flex h-20 w-20 items-center justify-center rounded-full border-2 border-[#37CDBE] bg-[#FAFCFB] text-2xl font-black ease-premium hover:bg-[#37CDBE]">01</div>
  <h3 class="mt-7 text-sm font-black uppercase tracking-wide">Pilih Layanan</h3>
  <p class="mt-3 max-w-[180px] text-sm leading-relaxed text-[#1D232A]/60">Pilih paket yang paling sesuai kebutuhan rumah Anda.</p>
</div>
\`\`\`

## Add-on Package Card
\`\`\`html
<article class="border-l-4 border-transparent bg-[#FAFCFB] p-7 shadow-sm ease-premium hover:-translate-y-2 hover:border-[#37CDBE]">
  <iconify-icon icon="lucide:armchair" class="text-3xl text-[#37CDBE]"></iconify-icon>
  <h3 class="mt-8 text-xl font-black">Cuci Sofa</h3>
  <p class="mt-2 text-sm text-[#1D232A]/60">Segar tanpa noda membandel.</p>
  <p class="mt-7 text-xl font-black">Rp50.000</p>
</article>
\`\`\`

## Portfolio Image Card (Staggered)
\`\`\`html
<article class="group reveal">
  <div class="relative aspect-[3/4] overflow-hidden rounded-2xl">
    <img src="[image-url]" alt="[description]" class="h-full w-full object-cover grayscale ease-premium group-hover:scale-[1.08] group-hover:grayscale-0">
    <div class="absolute inset-0 flex items-center justify-center opacity-0 ease-premium group-hover:opacity-100">
      <span class="flex h-24 w-24 items-center justify-center rounded-full bg-[#37CDBE] text-center text-[10px] font-black uppercase tracking-wide text-white">Lihat<br>Detail</span>
    </div>
  </div>
  <p class="mt-5 text-[10px] font-black tracking-[0.3em] text-[#37CDBE]">RUANG TAMU</p>
  <h3 class="mt-2 text-3xl font-black tracking-tighter">Kembali Bernapas</h3>
  <p class="mt-2 text-xs text-[#1D232A]/50">Deep clean <span class="mx-2">•</span> Jakarta Selatan</p>
</article>
\`\`\`

## Floating Service Badge
\`\`\`html
<div class="bounce-slow absolute -bottom-8 -left-8 flex h-32 w-32 flex-col items-center justify-center rounded-full bg-[#37CDBE] text-center shadow-xl sm:h-40 sm:w-40">
  <span class="text-4xl leading-none">✦</span>
  <span class="mt-2 text-[10px] font-black tracking-[0.2em]">3 PAKET<br>BERSIH</span>
</div>
\`\`\`

## Footer
\`\`\`html
<footer class="bg-[#F0F5F3] px-6 pb-8 pt-20 lg:px-12">
  <div class="mx-auto max-w-[1344px]">
    <div class="grid gap-12 lg:grid-cols-12">
      <div class="lg:col-span-5">
        <a href="#beranda" class="flex items-center gap-2 text-2xl font-black tracking-tighter">
          <iconify-icon icon="lucide:sparkles" class="text-[#37CDBE]"></iconify-icon>BERSIHINAJA
        </a>
        <p class="mt-5 max-w-xs text-lg font-medium leading-relaxed text-[#1D232A]/60">Platform layanan kebersihan rumah terpercaya di Indonesia.</p>
      </div>
      <div class="grid grid-cols-3 gap-6 lg:col-span-7">
        <div>
          <h3 class="border-b-2 border-[#37CDBE] pb-2 text-[10px] font-black tracking-[0.2em] text-[#37CDBE]">NAVIGASI</h3>
          <div class="mt-5 space-y-3 text-xs font-bold">
            <a href="#beranda" class="block">Beranda</a>
            <a href="#layanan" class="block">Layanan</a>
            <a href="#" class="block">Riwayat Pesanan</a>
            <a href="#" class="block">Profil</a>
          </div>
        </div>
        <div>
          <h3 class="border-b-2 border-[#37CDBE] pb-2 text-[10px] font-black tracking-[0.2em] text-[#37CDBE]">LAYANAN</h3>
          <div class="mt-5 space-y-3 text-xs font-bold">
            <a href="#layanan" class="block">Small</a>
            <a href="#layanan" class="block">Medium</a>
            <a href="#layanan" class="block">Large</a>
            <a href="#layanan" class="block">Paket Tambahan</a>
          </div>
        </div>
        <div>
          <h3 class="border-b-2 border-[#37CDBE] pb-2 text-[10px] font-black tracking-[0.2em] text-[#37CDBE]">KONTAK</h3>
          <div class="mt-5 space-y-3 text-xs font-bold">
            <a href="mailto:halo@bersihinaja.id" class="block">Email</a>
            <a href="https://wa.me/6281234567890" class="block">WhatsApp</a>
            <a href="https://instagram.com" class="block">Instagram</a>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-20 flex flex-col justify-between gap-4 border-t border-[#1D232A]/10 pt-6 text-[9px] font-bold tracking-wide text-[#1D232A]/30 sm:flex-row">
      <p>© 2026 BERSIHINAJA. SEMUA HAK DILINDUNGI.</p>
      <div class="flex gap-5">
        <a href="#">KEBIJAKAN PRIVASI</a>
        <a href="#">SYARAT & KETENTUAN</a>
      </div>
    </div>
  </div>
</footer>
\`\`\`

## Reveal Animation (CSS + JS)
\`\`\`css
.ease-premium { transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); }
.reveal { opacity: 0; transform: translateY(40px); transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); }
.reveal.active { opacity: 1; transform: translateY(0); }
@keyframes bounce-slow { 0%,100% { transform: translateY(-5%); } 50% { transform: translateY(5%); } }
.bounce-slow { animation: bounce-slow 4s ease-in-out infinite; }
\`\`\`

\`\`\`javascript
const observer = new IntersectionObserver((entries) => { 
  entries.forEach((entry) => { 
    if (entry.isIntersecting) entry.target.classList.add('active'); 
  }); 
}, { threshold: 0.15 });
document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));
\`\`\`