<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 10 + Tailwind CSS</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md text-center">
        <h1 class="text-2xl font-bold text-blue-600">Halo, Laravel + Tailwind!</h1>
        <p class="mt-2 text-gray-600">Ini adalah tampilan sederhana dengan Tailwind CSS.</p>

        <button class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
            Klik Saya
        </button>
    </div>

</body>

</html>
