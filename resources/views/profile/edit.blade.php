<x-guest-public-layout>
    <x-slot:title>Profil - BersihinAja</x-slot:title>

    <section class="px-6 pb-16 pt-28 lg:px-12">
        <div class="mx-auto max-w-[800px]">
            {{-- Header --}}
            <div class="reveal">
                <p class="text-[10px] font-black tracking-[0.4em] text-mint">// AKUN SAYA</p>
                <h1 class="mt-3 text-5xl font-black tracking-tighter">Profil</h1>
            </div>

            <div class="mt-10 space-y-6">
                {{-- Profile Information --}}
                <div class="rounded-3xl bg-cream-alt p-8 lg:p-10 reveal">
                    @include('profile.partials.update-profile-information-form')
                </div>

                {{-- Update Password --}}
                <div class="rounded-3xl bg-cream-alt p-8 lg:p-10 reveal">
                    @include('profile.partials.update-password-form')
                </div>

                {{-- Delete Account --}}
                <div class="rounded-3xl border-2 border-[#F87272]/20 bg-cream p-8 lg:p-10 reveal">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </section>
</x-guest-public-layout>
