<div>
    <div>
        <p class="text-[10px] font-black tracking-[0.4em] text-mint">// MASUK</p>
        <h1 class="mt-3 text-4xl font-black tracking-tighter">Selamat Datang</h1>
        <p class="mt-2 text-sm font-medium text-charcoal/60">Masuk ke akun BersihinAja Anda</p>
    </div>

    {{-- Session Status --}}
    <x-auth-session-status class="mt-4 rounded-xl bg-mint/10 px-4 py-3 text-sm font-medium text-charcoal" :status="session('status')" />

    <form wire:submit="login" class="mt-8 space-y-5">
        {{-- Email --}}
        <div>
            <label for="email" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">EMAIL</label>
            <input id="email" type="email" wire:model="email" required autofocus autocomplete="username"
                class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream-alt px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">PASSWORD</label>
            <input id="password" type="password" wire:model="password" required autocomplete="current-password"
                class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream-alt px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Remember + Forgot --}}
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2">
                <input id="remember_me" type="checkbox" wire:model="remember"
                    class="h-4 w-4 rounded border-charcoal/20 text-mint focus:ring-mint/30">
                <span class="text-xs font-bold text-charcoal/50">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate class="text-xs font-bold text-mint ease-premium hover:text-purple">Lupa password?</a>
            @endif
        </div>

        {{-- Submit --}}
        <button type="submit" class="w-full rounded-full bg-charcoal px-8 py-4 text-sm font-black uppercase tracking-wide text-cream ease-premium hover:bg-mint hover:text-charcoal">
            <span wire:loading.remove wire:target="login">Masuk</span>
            <span wire:loading wire:target="login" class="flex items-center justify-center gap-2">
                <iconify-icon icon="lucide:loader" class="animate-spin text-base"></iconify-icon> Memproses...
            </span>
        </button>
    </form>

    {{-- Divider --}}
    <div class="my-8 flex items-center gap-4">
        <div class="h-px flex-1 bg-charcoal/10"></div>
        <span class="text-[10px] font-black tracking-[0.2em] text-charcoal/30">ATAU</span>
        <div class="h-px flex-1 bg-charcoal/10"></div>
    </div>

    {{-- Google OAuth --}}
    <a href="{{ route('auth.google') }}" class="flex w-full items-center justify-center gap-3 rounded-full border-2 border-charcoal/10 px-8 py-4 text-sm font-bold text-charcoal ease-premium hover:border-mint hover:bg-cream-alt">
        <svg class="h-5 w-5" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
        Masuk dengan Google
    </a>

    {{-- Register Link --}}
    <p class="mt-8 text-center text-sm font-medium text-charcoal/50">
        Belum punya akun?
        <a href="{{ route('register') }}" wire:navigate class="font-black text-mint ease-premium hover:text-purple">Daftar sekarang</a>
    </p>
</div>
