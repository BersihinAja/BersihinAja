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

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black tracking-tighter text-charcoal">Yakin ingin menghapus akun?</h2>
            <p class="mt-2 text-sm font-medium text-charcoal/50">Semua data akan dihapus secara permanen. Masukkan password untuk konfirmasi.</p>

            <div class="mt-6">
                <label for="password" class="block text-[10px] font-black tracking-[0.2em] text-charcoal/50">PASSWORD</label>
                <input id="password" name="password" type="password" placeholder="Password Anda"
                    class="mt-2 w-full rounded-xl border border-charcoal/10 bg-cream-alt px-5 py-4 text-sm font-bold text-charcoal outline-none ease-premium focus:border-[#F87272] focus:ring-2 focus:ring-[#F87272]/20">
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="rounded-full border border-charcoal/10 px-6 py-3 text-sm font-bold text-charcoal ease-premium hover:bg-cream-alt">Batal</button>
                <button type="submit" class="rounded-full bg-[#F87272] px-6 py-3 text-sm font-black uppercase tracking-wide text-white ease-premium hover:bg-[#F87272]/80">Hapus Akun</button>
            </div>
        </form>
    </x-modal>
</section>
