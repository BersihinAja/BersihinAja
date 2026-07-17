<section>
    <header>
        <h2 class="text-xl font-black tracking-tighter text-charcoal">Informasi Profil</h2>
        <p class="mt-1 text-sm font-medium text-charcoal/50">Perbarui nama dan alamat email akun Anda.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">NAMA</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">EMAIL</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-sm font-medium text-charcoal/70">
                        Email belum terverifikasi.
                        <button form="send-verification" class="font-bold text-mint ease-premium hover:text-purple">Kirim ulang verifikasi.</button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-bold text-[#36D399]">Link verifikasi baru telah dikirim.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" class="rounded-full bg-charcoal px-8 py-3 text-sm font-black uppercase tracking-wide text-cream ease-premium hover:bg-mint hover:text-charcoal">Simpan</button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-bold text-[#36D399]">Tersimpan.</p>
            @endif
        </div>
    </form>
</section>
