@extends('layouts.aplikasi')

@section('judul', $judulTab)

@section('konten')
    <div class="min-h-screen flex flex-col bg-ivory text-charcoal pb-20 md:pb-0">
        {{-- Header Minimalis --}}
        <header class="sticky top-0 z-40 bg-ivory/95 backdrop-blur-md border-b border-champagne/20">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 h-14 md:h-16 flex items-center justify-between gap-3">
                <a href="{{ route('beranda') }}" class="flex items-center group shrink-0">
                    <img src="{{ asset('logo/logo-horizontal.webp') }}" alt="Logo SesiTemu"
                        class="h-9 sm:h-10 w-auto object-contain transition-transform duration-200 group-hover:scale-[1.03]">
                    <span class="sr-only">SesiTemu</span>
                </a>

                <a href="{{ route('beranda') }}"
                    class="inline-flex items-center gap-1.5 rounded-xl border border-champagne/40 bg-white px-3.5 py-2 text-xs sm:text-sm font-semibold text-charcoal hover:border-sage hover:text-sage transition">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m12 19-7-7 7-7" />
                        <path d="M19 12H5" />
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </header>

        {{-- Konten Dokumen Legal --}}
        <main class="flex-1 py-10 sm:py-14 px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                {{-- Switcher Kebijakan Privasi & Syarat Ketentuan --}}
                <div class="inline-flex items-center rounded-xl bg-white p-1 ring-1 ring-champagne/30 shadow-2xs mb-7">
                    <a href="{{ route('halaman.kebijakan-privasi') }}"
                        class="rounded-lg px-4 py-2 text-xs sm:text-sm font-semibold transition {{ $halamanAktif === 'privasi' ? 'bg-sage text-white shadow-xs' : 'text-charcoal/70 hover:text-charcoal' }}">
                        Kebijakan Privasi
                    </a>
                    <a href="{{ route('halaman.syarat-ketentuan') }}"
                        class="rounded-lg px-4 py-2 text-xs sm:text-sm font-semibold transition {{ $halamanAktif === 'syarat' ? 'bg-sage text-white shadow-xs' : 'text-charcoal/70 hover:text-charcoal' }}">
                        Syarat &amp; Ketentuan
                    </a>
                </div>

                <article class="rounded-3xl bg-white p-6 sm:p-10 shadow-sm ring-1 ring-champagne/25">
                    <div class="border-b border-champagne/20 pb-6">
                        <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#8A6D33]">{{ $labelBadge }}</span>
                        <h1 class="mt-2 font-logo text-3xl sm:text-4xl font-bold text-charcoal leading-tight">
                            {{ $judul }}
                        </h1>
                        <p class="mt-2.5 text-sm text-charcoal/70 leading-relaxed">
                            {{ $subjudul }}
                        </p>
                    </div>

                    <div class="mt-7 space-y-7">
                        @foreach ($pasal as $bagian)
                            <section class="space-y-2.5">
                                <h2 class="font-logo text-lg sm:text-xl font-bold text-[#1D3B2C]">
                                    {{ $bagian['judul'] }}
                                </h2>
                                @foreach ($bagian['isi'] as $paragraf)
                                    <p class="text-sm text-charcoal/75 leading-relaxed">
                                        {{ $paragraf }}
                                    </p>
                                @endforeach
                            </section>
                        @endforeach
                    </div>

                    <div class="mt-9 pt-6 border-t border-champagne/20 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <p class="text-xs text-charcoal/60 leading-relaxed">
                            Ada pertanyaan terkait ketentuan atau privasi data Anda? Tim Admin SesiTemu siap membantu.
                        </p>
                        <a href="{{ $urlWaAdmin }}" target="_blank" rel="noopener"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-sage px-4 py-2.5 text-xs sm:text-sm font-semibold text-white hover:bg-[#3b5047] transition shrink-0">
                            <span>Hubungi Admin WhatsApp</span>
                        </a>
                    </div>
                </article>
            </div>
        </main>

        {{-- Footer Ringkas --}}
        <footer class="border-t border-champagne/20 bg-white/70 py-6 px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
                <p class="text-xs text-charcoal/55">
                    &copy; {{ now()->format('Y') }} <span class="font-semibold text-[#1D3B2C]">SesiTemu.id</span>. Seluruh hak cipta dilindungi.
                </p>
                <nav aria-label="Tautan Legal" class="flex items-center gap-4 text-xs font-medium text-charcoal/65">
                    <a href="{{ route('halaman.kebijakan-privasi') }}" class="{{ $halamanAktif === 'privasi' ? 'text-sage font-semibold' : 'hover:text-sage' }} transition">
                        Kebijakan Privasi
                    </a>
                    <span aria-hidden="true" class="text-champagne/60">&bull;</span>
                    <a href="{{ route('halaman.syarat-ketentuan') }}" class="{{ $halamanAktif === 'syarat' ? 'text-sage font-semibold' : 'hover:text-sage' }} transition">
                        Syarat &amp; Ketentuan
                    </a>
                </nav>
            </div>
        </footer>

        <x-bottom-nav-publik halaman="legal" :dalam-beranda="false" />
    </div>
@endsection
