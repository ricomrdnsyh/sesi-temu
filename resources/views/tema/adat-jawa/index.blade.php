<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    @include('komponen-undangan.meta-opengraph')
</head>
<body
    x-data="temaUndangan()"
    :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="bg-[#23150E] text-[#F8EFE2] antialiased relative"
>
    @include('komponen-undangan.bar-pratinjau-demo')

    {{-- Ornamen Gunungan Jawa Bergerak --}}
    <img src="{{ asset('aset-tema/adat-jawa/ornamen-gunungan.webp') }}" alt="" class="pointer-events-none fixed top-0 left-0 w-28 sm:w-36 opacity-50 z-20 animasi-goyang">
    <img src="{{ asset('aset-tema/adat-jawa/ornamen-gunungan.webp') }}" alt="" class="pointer-events-none fixed bottom-0 right-0 w-28 sm:w-36 opacity-50 z-20 rotate-180 animasi-goyang">

    {{-- COVER GATE KERATON JAWA --}}
    <section
        class="fixed inset-0 z-40 flex flex-col items-center justify-center bg-[#1C100A] px-6 text-center transition-transform duration-1000 ease-in-out"
        :style="undanganTerbuka ? 'transform: translateY(-100%); pointer-events: none;' : 'transform: translateY(0);'"
    >
        <div class="max-w-lg w-full rounded-3xl bg-[#2E1C12] p-8 sm:p-12 shadow-2xl border-2 border-champagne/50 space-y-5">
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-champagne">Pawiwahan Ageng</p>
            <h1 class="font-serif text-5xl sm:text-6xl font-bold text-[#FBF4E9]">
                {{ $undangan->nama_panggilan_pria }} <span class="text-champagne">&amp;</span> {{ $undangan->nama_panggilan_wanita }}
            </h1>

            @if ($undangan->daftarAcara->first())
                <p class="text-sm text-champagne/90">
                    {{ $undangan->daftarAcara->first()->tanggal_acara->translatedFormat('l, d F Y') }}
                </p>
            @endif

            <div class="pt-4 border-t border-champagne/25 space-y-2">
                <p class="text-xs uppercase tracking-widest text-[#F8EFE2]/65">Katur Dhumateng</p>
                <p class="font-serif text-2xl font-semibold text-champagne">Kepada Yth. {{ $namaTamu }}</p>
            </div>

            <div class="pt-4">
                <button
                    type="button"
                    @click="bukaUndangan()"
                    class="rounded-full bg-champagne px-8 py-3.5 text-sm font-bold text-[#1C100A] shadow-lg hover:bg-champagne/90 transition cursor-pointer"
                >
                    Buka Undangan
                </button>
            </div>
        </div>
    </section>

    <main class="relative z-10 pt-14">
        <section data-aos="fade-up" data-aos-duration="1000" class="py-16 sm:py-20 px-4 text-center max-w-3xl mx-auto">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-champagne">Atur Pambagya Harja</p>
            <h2 class="mt-3 font-serif text-5xl sm:text-6xl font-bold text-[#FBF4E9]">
                {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
            </h2>

            @if ($undangan->kutipan_ayat)
                <blockquote class="mt-8 rounded-2xl bg-[#2E1C12] p-6 sm:p-8 border border-champagne/35 italic text-sm sm:text-base text-[#F8EFE2]/85 leading-relaxed">
                    "{{ $undangan->kutipan_ayat }}"
                </blockquote>
            @endif
        </section>

        {{-- Mempelai --}}
        <section data-aos="fade-up" data-aos-duration="1000" class="py-12 px-4 max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div data-aos="fade-right" data-aos-duration="1000" class="rounded-3xl bg-[#2E1C12] p-8 text-center border border-champagne/35">
                    @if ($undangan->urlFotoPria())
                        <img src="{{ $undangan->urlFotoPria() }}" alt="{{ $undangan->nama_lengkap_pria }}" class="w-40 h-40 mx-auto rounded-full object-cover ring-4 ring-champagne/50">
                    @endif
                    <h3 class="mt-5 font-serif text-3xl font-bold text-champagne">{{ $undangan->nama_lengkap_pria }}</h3>
                    @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                        <p class="mt-2 text-sm text-[#F8EFE2]/75">Putra saking {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}</p>
                    @endif
                </div>

                <div data-aos="fade-up" data-aos-duration="1000" class="rounded-3xl bg-[#2E1C12] p-8 text-center border border-champagne/35">
                    @if ($undangan->urlFotoWanita())
                        <img src="{{ $undangan->urlFotoWanita() }}" alt="{{ $undangan->nama_lengkap_wanita }}" class="w-40 h-40 mx-auto rounded-full object-cover ring-4 ring-champagne/50">
                    @endif
                    <h3 class="mt-5 font-serif text-3xl font-bold text-champagne">{{ $undangan->nama_lengkap_wanita }}</h3>
                    @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                        <p class="mt-2 text-sm text-[#F8EFE2]/75">Putri saking {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}</p>
                    @endif
                </div>
            </div>
        </section>

        @include('komponen-undangan.hitung-mundur', [
            'kelasAksen' => 'text-champagne',
            'kelasKartu' => 'bg-[#2E1C12] border border-champagne/35 text-[#F8EFE2]',
            'kelasTombol' => 'bg-champagne text-[#1C100A] hover:bg-champagne/90',
        ])

        {{-- Acara --}}
        @if ($undangan->daftarAcara->isNotEmpty())
        <section data-aos="fade-up" data-aos-duration="1000" class="py-12 px-4 max-w-4xl mx-auto">
            <div class="text-center mb-8">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-champagne">Wekdal &amp; Papan</p>
                <h2 class="mt-2 font-serif text-3xl sm:text-4xl font-bold">Rangkaian Acara</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($undangan->daftarAcara as $acara)
                    <div data-aos="zoom-in" data-aos-duration="1000" class="rounded-3xl bg-[#2E1C12] p-7 text-center border border-champagne/35 space-y-3">
                        <h3 class="font-serif text-2xl font-bold text-champagne">{{ $acara->nama_acara }}</h3>
                        <p class="text-sm font-semibold">{{ $acara->tanggal_acara->translatedFormat('l, d F Y') }}</p>
                        <p class="text-sm text-champagne">
                            {{ substr($acara->waktu_mulai, 0, 5) }}
                            @if ($acara->waktu_selesai) - {{ substr($acara->waktu_selesai, 0, 5) }} @endif
                            {{ $acara->zona_waktu }}
                        </p>
                        <div class="pt-2">
                            <p class="font-semibold">{{ $acara->nama_tempat }}</p>
                            <p class="text-xs text-[#F8EFE2]/70 mt-1">{{ $acara->alamat_lengkap }}</p>
                        </div>
                        @if ($acara->link_maps)
                            <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="inline-block mt-2 rounded-full border border-champagne px-5 py-2 text-xs font-semibold text-champagne hover:bg-champagne hover:text-[#1C100A] transition">
                                Peta Lokasi (Maps)
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
        @endif

        @php $ceritaList = $undangan->pengaturan['cerita_cinta'] ?? []; @endphp
        @if ($undangan->fiturAktif('cerita_cinta') && !empty($ceritaList))
        <section data-aos="fade-up" data-aos-duration="1000" class="py-12 px-4 max-w-3xl mx-auto">
            <div class="text-center mb-8">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-champagne">Carita Tresna</p>
                <h2 class="mt-2 font-serif text-3xl sm:text-4xl font-bold">Cerita Cinta</h2>
            </div>

            <div class="space-y-4">
                @foreach ($ceritaList as $cerita)
                    <div data-aos="fade-up" data-aos-duration="1000" class="rounded-2xl bg-[#2E1C12] p-6 border border-champagne/30">
                        <div class="flex items-center justify-between gap-2">
                            <h3 class="font-serif text-xl font-bold text-champagne">{{ $cerita['judul'] ?? '' }}</h3>
                            <span class="rounded-full bg-champagne/20 px-3 py-0.5 text-xs font-semibold text-champagne">{{ $cerita['tanggal'] ?? '' }}</span>
                        </div>
                        <p class="mt-2 text-sm text-[#F8EFE2]/80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </section>
        @endif

        @if ($undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
        <section data-aos="fade-up" data-aos-duration="1000" class="py-12 px-4 max-w-4xl mx-auto">
            <div class="text-center mb-8">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-champagne">Galeri Foto</p>
                <h2 class="mt-2 font-serif text-3xl sm:text-4xl font-bold">Momen Sakral</h2>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach ($undangan->daftarGaleri as $galeri)
                    <button
                        type="button"
                        data-aos="zoom-in"
                        data-aos-duration="1000"
                        @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                        class="group aspect-square rounded-2xl overflow-hidden border border-champagne/35 cursor-pointer"
                    >
                        <img src="{{ $galeri->urlFoto() }}" alt="{{ $galeri->keterangan ?? 'Galeri' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </button>
                @endforeach
            </div>
        </section>
        @endif

        @include('komponen-undangan.amplop-dan-tamu', [
            'kelasAksen' => 'text-champagne',
            'kelasKartu' => 'bg-[#2E1C12] border border-champagne/35 text-[#F8EFE2]',
            'kelasTombol' => 'bg-champagne text-[#1C100A] hover:bg-champagne/90',
        ])

        <footer class="py-8 text-center text-xs text-[#F8EFE2]/60">
            Undangan Adat Jawa Keraton oleh <a href="{{ route('beranda') }}" class="font-semibold text-champagne hover:underline">SesiTemu.id</a>
        </footer>
    </main>

    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>
</html>
