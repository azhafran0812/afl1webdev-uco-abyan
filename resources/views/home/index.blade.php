<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col items-center justify-center">
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg text-center">
            <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">
                Selamat Datang di Home!
            </h1>
            <p class="text-gray-600 dark:text-gray-300 mb-6">
                Silahkan lanjut ke halaman produk
            </p>

            <a href="{{ url('/products') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition">
                Lihat Produk
            </a>
        </div>
    </div>
</body>
</html>
