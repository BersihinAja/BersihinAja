<x-admin-layout>
    <x-slot:title>Tambah Layanan</x-slot:title>

    <div class="max-w-3xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center gap-2 text-sm text-base-content/60 mb-2">
                <a href="{{ route('admin.services.index') }}" class="hover:text-base-content">Layanan</a>
                <span>/</span>
                <span>Tambah</span>
            </div>
            <h1 class="text-3xl font-bold text-base-content">Tambah Layanan Baru</h1>
        </div>

        <!-- Form -->
        <div class="bg-base-100 rounded-box shadow p-6">
            <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text font-medium">Nama Layanan <span class="text-error">*</span></span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" class="input input-bordered w-full @error('name') input-error @enderror" placeholder="contoh: Deep Cleaning" required />
                        @error('name')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Harga (Rp) <span class="text-error">*</span></span>
                        </label>
                        <input type="number" name="price" value="{{ old('price') }}" class="input input-bordered w-full @error('price') input-error @enderror" placeholder="150000" min="0" step="1000" required />
                        @error('price')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Room Size -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Ukuran Ruangan <span class="text-error">*</span></span>
                        </label>
                        <input type="text" name="room_size" value="{{ old('room_size') }}" class="input input-bordered w-full @error('room_size') input-error @enderror" placeholder="contoh: 20-40 m²" required />
                        @error('room_size')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Max Hours -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Maksimal Jam <span class="text-error">*</span></span>
                        </label>
                        <input type="number" name="max_hours" value="{{ old('max_hours') }}" class="input input-bordered w-full @error('max_hours') input-error @enderror" placeholder="3" min="1" required />
                        @error('max_hours')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Estimation -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Estimasi <span class="text-error">*</span></span>
                        </label>
                        <input type="text" name="estimation" value="{{ old('estimation') }}" class="input input-bordered w-full @error('estimation') input-error @enderror" placeholder="contoh: 2-3 jam" required />
                        @error('estimation')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Cleaners Required -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Jumlah Pekerja <span class="text-error">*</span></span>
                        </label>
                        <input type="number" name="cleaners_required" value="{{ old('cleaners_required', 1) }}" class="input input-bordered w-full @error('cleaners_required') input-error @enderror" min="1" required />
                        @error('cleaners_required')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Estimation (second col spacer used) -->

                    <!-- Description -->
                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text font-medium">Deskripsi</span>
                        </label>
                        <textarea name="description" class="textarea textarea-bordered w-full h-24 @error('description') textarea-error @enderror" placeholder="Deskripsi layanan (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Image -->
                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text font-medium">Gambar</span>
                        </label>
                        <input type="file" name="image" class="file-input file-input-bordered w-full @error('image') file-input-error @enderror" accept="image/*" />
                        @error('image')
                            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>

                    <!-- Packages -->
                    @if($packages->count() > 0)
                        <div class="form-control md:col-span-2">
                            <label class="label">
                                <span class="label-text font-medium">Paket Tersedia</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-base-200 rounded-lg">
                                @foreach($packages as $package)
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" name="package_ids[]" value="{{ $package->id }}"
                                               class="checkbox checkbox-primary checkbox-sm"
                                               {{ in_array($package->id, old('package_ids', [])) ? 'checked' : '' }} />
                                        <div>
                                            <span class="font-medium text-sm">{{ $package->name }}</span>
                                            <span class="text-xs text-base-content/50 ml-1">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-base-300">
                    <a href="{{ route('admin.services.index') }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Layanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
