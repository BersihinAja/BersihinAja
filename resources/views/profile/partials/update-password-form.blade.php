<section>
    <header>
        <h2 class="text-xl font-black tracking-tighter text-charcoal">Ubah Password</h2>
        <p class="mt-1 text-sm font-medium text-charcoal/50">Gunakan password yang panjang dan acak agar tetap aman.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">PASSWORD SAAT INI</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">PASSWORD BARU</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">KONFIRMASI PASSWORD</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="rounded-full bg-charcoal px-8 py-3 text-sm font-black uppercase tracking-wide text-cream ease-premium hover:bg-mint hover:text-charcoal">Ubah Password</button>
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-bold text-[#36D399]">Tersimpan.</p>
            @endif
        </div>
    </form>
</section>
