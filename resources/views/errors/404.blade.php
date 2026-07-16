<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | BersihinAja</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/dist/full.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .error-code {
            background: linear-gradient(135deg, oklch(var(--p)), oklch(var(--s)));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-base-200">
    <div class="text-center px-6">
        <div class="float-animation mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-24 w-24 text-info" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
            </svg>
        </div>
        <h1 class="text-9xl font-extrabold error-code">404</h1>
        <h2 class="text-3xl font-bold mt-4 text-base-content">Halaman Tidak Ditemukan</h2>
        <p class="text-base-content/60 mt-3 max-w-md mx-auto text-lg">
            Halaman yang Anda cari tidak ada atau telah dipindahkan.
        </p>
        <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="/" class="btn btn-primary btn-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1" />
                </svg>
                Kembali ke Beranda
            </a>
            <button onclick="history.back()" class="btn btn-outline btn-lg">
                Halaman Sebelumnya
            </button>
        </div>
        <p class="text-base-content/40 text-sm mt-12">&copy; {{ date('Y') }} BersihinAja. Semua hak dilindungi.</p>
    </div>
</body>
</html>
