<div class="px-6 pb-16 pt-28 lg:px-12">
    <div class="mx-auto max-w-[800px]">
        {{-- Header --}}
        <div class="reveal active">
            <p class="text-[10px] font-black tracking-[0.4em] text-mint">// AKUN SAYA</p>
            <h1 class="mt-3 text-5xl font-black tracking-tighter">Profil</h1>
        </div>

        <div class="mt-10 space-y-6">
            {{-- Profile Information --}}
            <div class="rounded-3xl bg-cream-alt p-8 lg:p-10 reveal active">
                <section>
                    <header>
                        <h2 class="text-xl font-black tracking-tighter text-charcoal">Informasi Profil</h2>
                        <p class="mt-1 text-sm font-medium text-charcoal/50">Perbarui nama dan alamat email akun Anda.</p>
                    </header>

                    <form wire:submit="updateProfile" class="mt-6 space-y-5">
                        <div>
                            <label for="name" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">NAMA</label>
                            <input id="name" wire:model="name" type="text" required autofocus autocomplete="name"
                                class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <label for="email" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">EMAIL</label>
                            <input id="email" wire:model="email" type="email" required autocomplete="username"
                                class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div class="flex items-center gap-4 pt-2">
                            <button type="submit" class="rounded-full bg-charcoal px-8 py-3 text-sm font-black uppercase tracking-wide text-cream ease-premium hover:bg-mint hover:text-charcoal flex items-center gap-2">
                                <span wire:loading.remove wire:target="updateProfile">Simpan</span>
                                <span wire:loading wire:target="updateProfile" class="flex items-center gap-2">
                                    <iconify-icon icon="lucide:loader" class="animate-spin"></iconify-icon> Menyimpan...
                                </span>
                            </button>
                            @if (session('profile-status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-bold text-[#36D399]">Tersimpan.</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>

            {{-- Update Password --}}
            <div class="rounded-3xl bg-cream-alt p-8 lg:p-10 reveal active">
                <section>
                    <header>
                        <h2 class="text-xl font-black tracking-tighter text-charcoal">Ubah Password</h2>
                        <p class="mt-1 text-sm font-medium text-charcoal/50">Gunakan password yang panjang dan acak agar tetap aman.</p>
                    </header>

                    <form wire:submit="updatePassword" class="mt-6 space-y-5">
                        <div>
                            <label for="current_password" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">PASSWORD SAAT INI</label>
                            <input id="current_password" wire:model="current_password" type="password" autocomplete="current-password"
                                class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
                            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                        </div>

                        <div>
                            <label for="password" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">PASSWORD BARU</label>
                            <input id="password" wire:model="password" type="password" autocomplete="new-password"
                                class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">KONFIRMASI PASSWORD</label>
                            <input id="password_confirmation" wire:model="password_confirmation" type="password" autocomplete="new-password"
                                class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-mint focus:ring-2 focus:ring-mint/20">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4 pt-2">
                            <button type="submit" class="rounded-full bg-charcoal px-8 py-3 text-sm font-black uppercase tracking-wide text-cream ease-premium hover:bg-mint hover:text-charcoal flex items-center gap-2">
                                <span wire:loading.remove wire:target="updatePassword">Ubah Password</span>
                                <span wire:loading wire:target="updatePassword" class="flex items-center gap-2">
                                    <iconify-icon icon="lucide:loader" class="animate-spin"></iconify-icon> Mengubah...
                                </span>
                            </button>
                            @if (session('password-status') === 'password-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-bold text-[#36D399]">Tersimpan.</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>

            {{-- Delete Account --}}
            <div class="rounded-3xl border-2 border-[#F87272]/20 bg-cream p-8 lg:p-10 reveal active">
                <section class="space-y-6">
                    <header>
                        <h2 class="text-xl font-black tracking-tighter text-[#F87272]">Hapus Akun</h2>
                        <p class="mt-1 text-sm font-medium text-charcoal/50">Setelah akun dihapus, semua data akan hilang secara permanen. Pastikan Anda telah mengunduh data yang ingin disimpan.</p>
                    </header>

                    <button
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                        class="rounded-full border-2 border-[#F87272] px-8 py-3 text-sm font-black uppercase tracking-wide text-[#F87272] ease-premium hover:bg-[#F87272] hover:text-white"
                    >Hapus Akun</button>

                    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
                        <form wire:submit="deleteAccount" class="p-8">
                            <h2 class="text-xl font-black tracking-tighter text-charcoal">Yakin ingin menghapus akun?</h2>
                            <p class="mt-2 text-sm font-medium text-charcoal/50">Semua data akan dihapus secara permanen. Masukkan password untuk konfirmasi.</p>

                            <div class="mt-6">
                                <label for="delete_password" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">PASSWORD</label>
                                <input id="delete_password" wire:model="delete_password" type="password" placeholder="Password Anda"
                                    class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream-alt px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-[#F87272] focus:ring-2 focus:ring-[#F87272]/20">
                                <x-input-error :messages="$errors->get('delete_password')" class="mt-2" />
                            </div>

                            <div class="mt-8 flex justify-end gap-3">
                                <button type="button" x-on:click="$dispatch('close')" class="rounded-full border border-charcoal/10 px-6 py-3 text-sm font-bold text-charcoal ease-premium hover:bg-cream-alt">Batal</button>
                                <button type="submit" class="rounded-full bg-[#F87272] px-6 py-3 text-sm font-black uppercase tracking-wide text-white ease-premium hover:bg-[#F87272]/80">Hapus Akun</button>
                            </div>
                        </form>
                    </x-modal>
                </section>
            </div>
        </div>
    </div>
</div>
