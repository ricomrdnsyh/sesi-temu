<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Wedding of {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#2B1B12] text-[#F8EFE2] min-h-screen">
    @include('komponen-undangan.bar-pratinjau-demo')
    <main class="max-w-3xl mx-auto px-6 py-24 text-center">
        <p class="text-xs uppercase tracking-widest text-champagne font-semibold">Pawiwahan Ageng</p>
        <h1 class="mt-3 font-serif text-5xl font-bold">{{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}</h1>
        <p class="mt-4 text-sm text-[#F8EFE2]/80">Kepada Yth. <strong>{{ $namaTamu }}</strong></p>
    </main>
</body>
</html>
