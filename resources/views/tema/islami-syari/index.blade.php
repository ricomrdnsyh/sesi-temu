<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    @include('komponen-undangan.meta-opengraph')
</head>
<body
    x-data="temaUndangan()"
    :class="undanganTerbuka ? 'overflow-x-hidden' : 'overflow-hidden h-screen'"
    class="bg-[#F4FAF6] text-[#184D47] antialiased relative"
>
    @include('komponen-undangan.bar-pratinjau-demo')

    {{-- Ornamen Arabesque Bergerak --}}
    <img src="{{ asset('aset-tema/islami-syari/ornamen-arabesque.webp') }}" alt="" class="pointer-events-none fixed top-0 left-0 w-28 sm:w-36 opacity-60 z-20 animasi-goyang">
    <img src="{{ asset('aset-tema/islami-syari/ornamen-arabesque.webp') }}" alt="" class="pointer-events-none fixed bottom-0 right-0 w-28 sm:w-36 opacity-60 z-20 rotate-180 animasi-goyang">

    {{-- COVER GATE ISLAMI SYARI --}}
    <section
        class="fixed inset-0 z-40 flex flex-col items-center justify-center bg-[#F4FAF6] px-6 text-center transition-transform duration-1000 ease-in-out"
        :style="undanganTerbuka ? 'transform: translateY(-100%); pointer-events: none;' : 'transform: translateY(0);'"
    >
        <div class="max-w-lg w-full rounded-t-[8rem] rounded-b-3xl bg-white p-8 sm:p-12 shadow-xl border-2 border-[#184D47]/20 space-y-5">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-champagne">Bismillahirrahmanirrahim</p>
            <p class="text-xs uppercase tracking-[0.3em] text-[#184D47]/70">Walimatul Ursy</p>
            <h1 class="font-serif text-5xl sm:text-6xl font-bold text-[#184D47]">
                {{ $undangan->nama_panggilan_pria }} <span class="text-champagne">&amp;</span> {{ $undangan->nama_panggilan_wanita }}
            </h1>

            @if ($undangan->daftarAcara->first())
                <p class="text-sm text-[#184D47]/75">
                    {{ $undangan->daftarAcara->first()->tanggal_acara->translatedFormat('l, d F Y') }}
                </p>
            @endif

            <div class="pt-4 border-t border-[#184D47]/15 space-y-2">
                <p class="text-xs uppercase tracking-widest text-[#184D47]/60">Kepada Yth. Saudara/i</p>
                <p class="font-serif text-2xl font-semibold text-[#184D47]">Kepada Yth. {{ $namaTamu }}</p>
            </div>

            <div class="pt-4">
                <button
                    type="button"
                    @click="bukaUndangan()"
                    class="rounded-full bg-[#184D47] px-8 py-3.5 text-sm font-semibold text-white shadow-md hover:bg-[#133D38] transition cursor-pointer"
                >
                    Buka Undangan
                </button>
            </div>
        </div>
    </section>

    <main class="relative z-10 pt-14">
        <section data-aos="fade-up" data-aos-duration="1000" class="py-16 sm:py-20 px-4 text-center max-w-3xl mx-auto">
            <p class="text-sm font-semibold text-champagne">Assalamu'alaikum Warahmatullahi Wabarakatuh</p>
            <h2 class="mt-3 font-serif text-5xl sm:text-6xl font-bold text-[#184D47]">
                {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
            </h2>

            @if ($undangan->kutipan_ayat)
                <blockquote class="mt-8 rounded-2xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-[#184D47]/15 italic text-sm sm:text-base text-[#184D47]/85 leading-relaxed">
                    "{{ $undangan->kutipan_ayat }}"
                </blockquote>
            @endif
        </section>

        {{-- Mempelai --}}
        <section data-aos="fade-up" data-aos-duration="1000" class="py-12 px-4 max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div data-aos="fade-right" data-aos-duration="1000" class="rounded-t-[5rem] rounded-b-3xl bg-white p-8 text-center shadow-sm ring-1 ring-[#184D47]/15">
                    @if ($undangan->urlFotoPria())
                        <img src="{{ $undangan->urlFotoPria() }}" alt="{{ $undangan->nama_lengkap_pria }}" class="w-40 h-40 mx-auto rounded-full object-cover ring-4 ring-champagne/40">
                    @endif
                    <h3 class="mt-5 font-serif text-3xl font-bold text-[#184D47]">{{ $undangan->nama_lengkap_pria }}</h3>
                    @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                        <p class="mt-2 text-sm text-[#184D47]/75">Putra dari {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}</p>
                    @endif
                </div>

                <div data-aos="fade-up" data-aos-duration="1000" class="rounded-t-[5rem] rounded-b-3xl bg-white p-8 text-center shadow-sm ring-1 ring-[#184D47]/15">
                    @if ($undangan->urlFotoWanita())
                        <img src="{{ $undangan->urlFotoWanita() }}" alt="{{ $undangan->nama_lengkap_wanita }}" class="w-40 h-40 mx-auto rounded-full object-cover ring-4 ring-champagne/40">
                    @endif
                    <h3 class="mt-5 font-serif text-3xl font-bold text-[#184D47]">{{ $undangan->nama_lengkap_wanita }}</h3>
                    @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                        <p class="mt-2 text-sm text-[#184D47]/75">Putri dari {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}</p>
                    @endif
                </div>
            </div>
        </section>

        @include('komponen-undangan.hitung-mundur', [
            'kelasAksen' => 'text-champagne',
            'kelasKartu' => 'bg-white ring-1 ring-[#184D47]/15 text-[#184D47]',
            'kelasTombol' => 'bg-[#184D47] text-white hover:bg-[#133D38]',
        ])

        {{-- Acara --}}
        @if ($undangan->daftarAcara->isNotEmpty())
        <section data-aos="fade-up" data-aos-duration="1000" class="py-12 px-4 max-w-4xl mx-auto">
            <div class="text-center mb-8">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-champagne">InsyaAllah Dilaksanakan Pada</p>
                <h2 class="mt-2 font-serif text-3xl sm:text-4xl font-bold">Jadwal Akad &amp; Walimah</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($undangan->daftarAcara as $acara)
                    <div data-aos="zoom-in" data-aos-duration="1000" class="rounded-3xl bg-white p-7 text-center shadow-sm ring-1 ring-[#184D47]/15 space-y-3">
                        <h3 class="font-serif text-2xl font-bold text-[#184D47]">{{ $acara->nama_acara }}</h3>
                        <p class="text-sm font-semibold">{{ $acara->tanggal_acara->translatedFormat('l, d F Y') }}</p>
                        <p class="text-sm text-champagne font-semibold">
                            {{ substr($acara->waktu_mulai, 0, 5) }}
                            @if ($acara->waktu_selesai) - {{ substr($acara->waktu_selesai, 0, 5) }} @endif
                            {{ $acara->zona_waktu }}
                        </p>
                        <div class="pt-2">
                            <p class="font-semibold">{{ $acara->nama_tempat }}</p>
                            <p class="text-xs text-[#184D47]/70 mt-1">{{ $acara->alamat_lengkap }}</p>
                        </div>
                        @if ($acara->link_maps)
                            <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="inline-block mt-2 rounded-full border border-[#184D47] px-5 py-2 text-xs font-semibold text-[#184D47] hover:bg-[#184D47] hover:text-white transition">
                                Buka Peta Lokasi
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
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-champagne">Perjalanan Ta'aruf</p>
                <h2 class="mt-2 font-serif text-3xl sm:text-4xl font-bold">Kisah Pertemuan</h2>
            </div>

            <div class="space-y-4">
                @foreach ($ceritaList as $cerita)
                    <div data-aos="fade-up" data-aos-duration="1000" class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-[#184D47]/15">
                        <div class="flex items-center justify-between gap-2">
                            <h3 class="font-serif text-xl font-bold text-[#184D47]">{{ $cerita['judul'] ?? '' }}</h3>
                            <span class="rounded-full bg-champagne/15 px-3 py-0.5 text-xs font-semibold text-champagne">{{ $cerita['tanggal'] ?? '' }}</span>
                        </div>
                        <p class="mt-2 text-sm text-[#184D47]/80 leading-relaxed">{{ $cerita['cerita'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </section>
        @endif

        @if ($undangan->fiturAktif('galeri') && $undangan->daftarGaleri->isNotEmpty())
        <section data-aos="fade-up" data-aos-duration="1000" class="py-12 px-4 max-w-4xl mx-auto">
            <div class="text-center mb-8">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-champagne">Galeri Kenangan</p>
                <h2 class="mt-2 font-serif text-3xl sm:text-4xl font-bold">Momen Terindah</h2>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                @foreach ($undangan->daftarGaleri as $galeri)
                    <button
                        type="button"
                        data-aos="zoom-in"
                        data-aos-duration="1000"
                        @click="bukaGaleri(@js($galeri->urlFoto()), @js($galeri->keterangan))"
                        class="group aspect-square rounded-2xl overflow-hidden bg-white ring-1 ring-[#184D47]/15 cursor-pointer"
                    >
                        <img src="{{ $galeri->urlFoto() }}" alt="{{ $galeri->keterangan ?? 'Galeri' }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </button>
                @endforeach
            </div>
        </section>
        @endif

        @include('komponen-undangan.amplop-dan-tamu', [
            'kelasAksen' => 'text-champagne',
            'kelasKartu' => 'bg-white ring-1 ring-[#184D47]/15 text-[#184D47]',
            'kelasTombol' => 'bg-[#184D47] text-white hover:bg-[#133D38]',
        ])

        <footer class="py-8 text-center text-xs text-[#184D47]/65">
            Wassalamu'alaikum Warahmatullahi Wabarakatuh • <a href="{{ route('beranda') }}" class="font-semibold text-[#184D47] hover:underline">SesiTemu.id</a>
        </footer>
    </main>

    @include('komponen-undangan.pemutar-musik')
    @include('komponen-undangan.modal-galeri')
    @include('komponen-undangan.skrip-tema')
</body>
</html>
