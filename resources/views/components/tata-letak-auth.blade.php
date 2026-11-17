@props([
    'mode' => 'masuk',
    'judulHalaman' => 'Masuk ke Akun Anda',
    'subjudul' => 'Kelola undangan pernikahan digital dan pantau buku tamu Anda.',
    'temaTerpilih' => null,
    'durasiBulan' => null,
])

@php
    $durasi = $durasiBulan ?? \App\Support\PengaturanSesiTemu::masaAktifBulan();
    $adalahMasuk = $mode === 'masuk';
@endphp

<div class="min-h-screen w-full bg-ivory relative flex flex-col justify-between overflow-hidden">
    {{-- Latar Atmosfer Editorial: Cahaya Lembut + Titik Kertas Halus + Siluet Lengkungan SesiTemu --}}
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_75%_55%_at_50%_-5%,rgba(191,161,95,0.18),transparent),radial-gradient(circle_at_12%_88%,rgba(75,99,88,0.10),transparent_44%),radial-gradient(circle_at_88%_82%,rgba(191,161,95,0.12),transparent_44%)]"
    ></div>

    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0 opacity-65"
        style="background-image: radial-gradient(rgba(191, 161, 95, 0.24) 1px, transparent 1px); background-size: 24px 24px; mask-image: radial-gradient(ellipse 76% 74% at 50% 50%, #000 34%, transparent 100%); -webkit-mask-image: radial-gradient(ellipse 76% 74% at 50% 50%, #000 34%, transparent 100%);"
    ></div>

    <div aria-hidden="true" class="pointer-events-none hidden sm:flex absolute inset-0 items-center justify-center">
        <div class="relative flex items-center justify-center -translate-y-2">
            <div class="w-[580px] h-[640px] rounded-t-full border border-champagne/20"></div>
            <div class="absolute w-[530px] h-[590px] rounded-t-full border border-sage/10"></div>
        </div>
    </div>

    {{-- Panggung Utama Terpusat dengan Aksen Kartu Kiri & Kanan --}}
    <main class="relative z-10 flex-1 flex items-center justify-center px-4 sm:px-6 pt-6 pb-24 md:py-8">
        <div class="w-full max-w-6xl mx-auto flex items-center justify-center gap-5 xl:gap-9">
            {{-- Aksen Kartu Kiri (Desktop) --}}
            <aside aria-hidden="true" class="hidden lg:flex flex-col gap-4 w-[210px] xl:w-[255px] shrink-0 select-none">
                @if ($adalahMasuk)
                    <div class="rounded-2xl bg-white/85 backdrop-blur-md p-4 ring-1 ring-champagne/25 shadow-[0_14px_38px_-16px_rgba(29,59,44,0.14)] -rotate-2 hover:rotate-0 transition-transform duration-300">
                        <div class="flex items-center justify-between gap-2">
                            <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wider text-sage">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                RSVP Masuk
                            </span>
                            <span class="text-[10px] text-charcoal/45">Baru saja</span>
                        </div>
                        <div class="mt-2.5 flex items-center justify-between gap-2">
                            <p class="text-xs font-bold text-charcoal truncate">Budi Santoso</p>
                            <span class="shrink-0 rounded-full bg-sage/10 px-2 py-0.5 text-[10px] font-semibold text-sage">
                                Hadir
                            </span>
                        </div>
                        <p class="mt-1.5 text-[11px] text-charcoal/60 leading-relaxed italic">
                            &ldquo;Selamat menempuh hidup baru, semoga selalu berbahagia.&rdquo;
                        </p>
                    </div>

                    <div class="ml-4 rounded-2xl bg-white/85 backdrop-blur-md px-3.5 py-3 ring-1 ring-champagne/25 shadow-[0_12px_30px_-14px_rgba(29,59,44,0.12)] rotate-1 hover:rotate-0 transition-transform duration-300 flex items-center gap-3">
                        <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-champagne/15 text-[#8A6D33]">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-[11px] font-mono font-semibold text-charcoal/85 truncate">sesitemu.id/dimas-rani</p>
                            <p class="text-[10px] text-charcoal/50">Link personal siap sebar</p>
                        </div>
                    </div>
                @else
                    <div class="rounded-2xl bg-white/85 backdrop-blur-md p-4 ring-1 ring-champagne/25 shadow-[0_14px_38px_-16px_rgba(29,59,44,0.14)] -rotate-2 hover:rotate-0 transition-transform duration-300 space-y-2.5">
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-sage">3 Langkah Praktis</p>
                        <div class="space-y-2 text-[11px] text-charcoal/80">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-sage/12 text-[10px] font-bold text-sage">1</span>
                                <span>Buat akun &amp; pilih tema</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-sage/12 text-[10px] font-bold text-sage">2</span>
                                <span>Lengkapi data &amp; galeri</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-sage/12 text-[10px] font-bold text-sage">3</span>
                                <span>Bagikan link via WhatsApp</span>
                            </div>
                        </div>
                    </div>

                    <div class="ml-4 rounded-2xl bg-white/85 backdrop-blur-md px-3.5 py-3 ring-1 ring-champagne/25 shadow-[0_12px_30px_-14px_rgba(29,59,44,0.12)] rotate-1 hover:rotate-0 transition-transform duration-300 flex items-center gap-3">
                        <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-sage/12 text-sage">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-charcoal/85">Edit &amp; Pratinjau Gratis</p>
                            <p class="text-[10px] text-charcoal/50">Bayar saat siap disebar</p>
                        </div>
                    </div>
                @endif
            </aside>

            {{-- Kartu Form Utama (Lebih Lebar & Berdiri Sendiri Tanpa Tab Gabungan) --}}
            <div class="w-full {{ $adalahMasuk ? 'max-w-[465px] xl:max-w-[500px]' : 'max-w-[500px] xl:max-w-[540px]' }}">
                <div class="relative bg-white/95 backdrop-blur-md rounded-[1.85rem] p-6 sm:p-8 xl:px-10 shadow-[0_24px_70px_-20px_rgba(29,59,44,0.14),0_8px_24px_-10px_rgba(191,161,95,0.18)] ring-1 ring-champagne/30 overflow-hidden">
                    {{-- Aksen Garis Champagne di Tepi Atas Kartu --}}
                    <div aria-hidden="true" class="pointer-events-none absolute inset-x-14 top-0 h-[2px] bg-gradient-to-r from-transparent via-champagne/80 to-transparent"></div>

                    {{-- Logo + Tajuk Halaman Terpisah --}}
                    <div class="text-center">
                        <a href="{{ route('beranda') }}" class="inline-flex flex-col items-center justify-center group">
                            <img
                                src="{{ asset('aset-demo/logo-sesi-temu-lengkap.webp') }}"
                                alt="Logo SesiTemu"
                                class="h-14 sm:h-16 w-auto object-contain transition-transform duration-200 group-hover:scale-[1.03]"
                            >
                            <span class="sr-only">SesiTemu</span>
                        </a>

                        <div class="mt-4 flex items-center justify-center gap-2.5">
                            <span class="h-px w-7 bg-champagne/45" aria-hidden="true"></span>
                            <span class="text-[10px] sm:text-[11px] font-semibold uppercase tracking-[0.2em] text-[#8A6D33]">
                                {{ $adalahMasuk ? 'Portal Akun' : 'Registrasi Akun' }}
                            </span>
                            <span class="h-px w-7 bg-champagne/45" aria-hidden="true"></span>
                        </div>

                        <h1 class="mt-2.5 font-logo text-2xl sm:text-[1.75rem] font-bold text-charcoal tracking-tight leading-snug">
                            {{ $judulHalaman }}
                        </h1>
                        <p class="mt-1.5 text-xs sm:text-[13px] text-charcoal/60 leading-relaxed max-w-[38ch] mx-auto">
                            {{ $subjudul }}
                        </p>
                    </div>

                    <div class="mt-5">
                        {{ $slot }}

                        <div class="mt-3 text-center">
                            <a
                                href="{{ route('beranda') }}"
                                class="group inline-flex items-center gap-1.5 rounded-full px-3.5 py-1.5 text-xs font-medium text-charcoal/55 hover:text-sage hover:bg-ivory transition"
                            >
                                <svg class="w-3.5 h-3.5 transition-transform duration-200 group-hover:-translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="m12 19-7-7 7-7" />
                                    <path d="M19 12H5" />
                                </svg>
                                <span>Kembali ke Beranda</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Aksen Kartu Kanan (Desktop) --}}
            <aside aria-hidden="true" class="hidden lg:flex flex-col gap-4 w-[210px] xl:w-[255px] shrink-0 select-none">
                @if ($adalahMasuk)
                    <div class="rounded-2xl bg-white/85 backdrop-blur-md p-4 ring-1 ring-champagne/25 shadow-[0_14px_38px_-16px_rgba(29,59,44,0.14)] rotate-2 hover:rotate-0 transition-transform duration-300">
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-[#8A6D33]">Dasbor Undangan</p>
                        <div class="mt-2.5 grid grid-cols-2 gap-2">
                            <div class="rounded-xl bg-[#FAF7F0] px-2.5 py-2 ring-1 ring-champagne/15">
                                <p class="font-logo text-base font-bold text-charcoal leading-none">148</p>
                                <p class="mt-1 text-[10px] text-charcoal/55">Tamu Hadir</p>
                            </div>
                            <div class="rounded-xl bg-[#FAF7F0] px-2.5 py-2 ring-1 ring-champagne/15">
                                <p class="font-logo text-base font-bold text-sage leading-none">9 Tema</p>
                                <p class="mt-1 text-[10px] text-charcoal/55">Bebas Ganti</p>
                            </div>
                        </div>
                        <div class="mt-3 h-1.5 w-full rounded-full bg-champagne/20 overflow-hidden">
                            <div class="h-full w-4/5 rounded-full bg-gradient-to-r from-sage to-champagne"></div>
                        </div>
                        <p class="mt-1.5 text-[10px] text-charcoal/50">Galeri WebP &amp; Musik Latar</p>
                    </div>

                    <div class="mr-4 rounded-2xl bg-white/85 backdrop-blur-md px-3.5 py-3 ring-1 ring-champagne/25 shadow-[0_12px_30px_-14px_rgba(29,59,44,0.12)] -rotate-1 hover:rotate-0 transition-transform duration-300 flex items-center gap-3">
                        <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-sage/12 text-sage">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10" />
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-charcoal/85">Aktif {{ $durasi }} Bulan</p>
                            <p class="text-[10px] text-charcoal/50">Ubah data kapan saja</p>
                        </div>
                    </div>
                @else
                    <div class="rounded-2xl bg-white/85 backdrop-blur-md p-4 ring-1 ring-champagne/25 shadow-[0_14px_38px_-16px_rgba(29,59,44,0.14)] rotate-2 hover:rotate-0 transition-transform duration-300">
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-[#8A6D33]">Fitur Lengkap</p>
                        <ul class="mt-2.5 space-y-1.5 text-[11px] text-charcoal/75">
                            <li class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-champagne"></span>
                                <span>Buku Tamu &amp; RSVP</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-champagne"></span>
                                <span>Galeri Otomatis WebP</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-champagne"></span>
                                <span>Amplop Digital &amp; Musik</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-champagne"></span>
                                <span>Mode Tanpa Foto</span>
                            </li>
                        </ul>
                    </div>

                    <div class="mr-4 rounded-2xl bg-white/85 backdrop-blur-md px-3.5 py-3 ring-1 ring-champagne/25 shadow-[0_12px_30px_-14px_rgba(29,59,44,0.12)] -rotate-1 hover:rotate-0 transition-transform duration-300 flex items-center gap-3">
                        <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-champagne/15 text-[#8A6D33]">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                        </span>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-charcoal/85">Masa Aktif {{ $durasi }} Bulan</p>
                            <p class="text-[10px] text-charcoal/50">Sekali aktivasi, bebas ganti tema</p>
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </main>

    <x-bottom-nav-publik :halaman="$mode" />
</div>
