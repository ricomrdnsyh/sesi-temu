@if ($undangan->daftarAcara->isNotEmpty())
<section
    data-aos="fade-up"
    data-aos-duration="950"
    data-layout-acara="{{ $gayaTataLetak }}"
    class="relative py-12 px-5 {{ $gayaTataLetak === 'keraton' ? 'bg-[#472A1C] text-[#FAF3E6]' : '' }}"
>
    <div class="text-center mb-7 space-y-1.5">
        <p class="text-[11px] font-semibold uppercase tracking-[0.28em] {{ $gayaTataLetak === 'keraton' ? 'text-[#D7BB83]' : $kelasAksen }}">{{ $subLabelAcara }}</p>
        <h2 class="fx-rise font-serif text-3xl font-bold">{{ $labelAcara }}</h2>
    </div>

    <div class="space-y-6">
        @foreach ($undangan->daftarAcara as $acara)
            @if ($gayaTataLetak === 'keraton')
                {{-- ADAT JAWA KERATON: Kartu Double-Framed Letterpress (Bingkai Luar Ilustrasi + Kartu Krem Emas Dalam) --}}
                <div class="fx-scale-in relative rounded-3xl p-3 overflow-hidden shadow-2xl border border-[#D7BB83]/50 kartu-3d masuk-3d">
                    <img src="{{ $latarUtamaUrl }}" alt="" aria-hidden="true" class="pointer-events-none absolute inset-0 w-full h-full object-cover">
                    <div class="relative z-10 rounded-2xl bg-[#FCF7EB]/90 backdrop-blur-sm border-2 border-[#D7BB83] px-5 py-7 text-center text-[#332012] space-y-3">
                        <h3 class="fx-scale-in font-kaligrafi text-4xl leading-tight text-[#7A1E24]">{{ $acara->nama_acara }}</h3>
                        <p class="font-serif text-base font-bold uppercase tracking-wider text-[#332012]">
                            {{ $acara->tanggal_acara->translatedFormat('l, d F Y') }}
                        </p>
                        <p class="inline-block rounded-full bg-[#472A1C] px-4 py-1 text-xs font-semibold text-[#F3E5AB]">
                            {{ substr($acara->waktu_mulai, 0, 5) }}
                            @if ($acara->waktu_selesai) - {{ substr($acara->waktu_selesai, 0, 5) }} @endif
                            {{ $acara->zona_waktu }}
                        </p>

                        <div class="flex items-center justify-center gap-2 py-1 text-[#8C6823]" aria-hidden="true">
                            <span class="h-px w-12 bg-[#D7BB83]"></span>
                            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span class="h-px w-12 bg-[#D7BB83]"></span>
                        </div>

                        <div>
                            <p class="font-serif text-base font-bold">{{ $acara->nama_tempat }}</p>
                            <p class="text-xs opacity-75 mt-1 leading-relaxed">{{ $acara->alamat_lengkap }}</p>
                        </div>

                        @if ($acara->link_maps)
                            <div class="pt-1">
                                <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-full bg-[#D7BB83] px-6 py-2 text-xs font-bold text-[#2A170D] hover:bg-[#E7CE9B] shadow transition">
                                    Buka Google Maps
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

            @elseif ($gayaTataLetak === 'priangan')
                {{-- SUNDA SIGER HERITAGE: Kartu Piagam / Tiket Priangan Berpita Marun --}}
                <div class="fx-rise relative rounded-3xl overflow-hidden bg-[#FFFBF4]/95 border-2 border-[#C59B43]/60 shadow-xl kartu-3d masuk-3d">
                    <div class="bg-gradient-to-r from-[#5A1E1E] via-[#742828] to-[#5A1E1E] px-5 py-4 text-center text-[#FAF4E8] border-b-2 border-[#C59B43]">
                        <h3 class="font-kaligrafi text-3xl sm:text-4xl text-[#F3E5AB] leading-tight">{{ $acara->nama_acara }}</h3>
                    </div>
                    <div class="relative px-6 py-6 text-center text-[#4A2020] space-y-2.5">
                        <span aria-hidden="true" class="pointer-events-none absolute -top-3 -left-3 h-6 w-6 rounded-full bg-[#FAF4E8] border-r-2 border-[#C59B43]/60"></span>
                        <span aria-hidden="true" class="pointer-events-none absolute -top-3 -right-3 h-6 w-6 rounded-full bg-[#FAF4E8] border-l-2 border-[#C59B43]/60"></span>

                        <p class="font-serif text-base font-bold uppercase tracking-wide">{{ $acara->tanggal_acara->translatedFormat('l, d F Y') }}</p>
                        <p class="text-xs font-bold text-[#B58931]">
                            {{ substr($acara->waktu_mulai, 0, 5) }}
                            @if ($acara->waktu_selesai) - {{ substr($acara->waktu_selesai, 0, 5) }} @endif
                            {{ $acara->zona_waktu }}
                        </p>
                        <div class="pt-3 border-t border-dashed border-[#C59B43]/55">
                            <p class="font-semibold text-sm">{{ $acara->nama_tempat }}</p>
                            <p class="text-xs opacity-75 mt-1">{{ $acara->alamat_lengkap }}</p>
                        </div>
                        @if ($acara->link_maps)
                            <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="inline-block mt-2 rounded-full px-6 py-2 text-xs font-semibold transition {{ $kelasTombol }}">
                                Buka Google Maps
                            </a>
                        @endif
                    </div>
                </div>

            @elseif ($gayaTataLetak === 'editorial')
                {{-- EDITORIAL MONOKROM: Kartu Invitation Pass 2-Kolom dengan Garis Perforasi --}}
                <div class="fx-slide-left grid grid-cols-12 bg-white/95 border border-[#18181B]/25 text-[#18181B] shadow-md kartu-3d masuk-3d">
                    <div class="col-span-4 bg-[#18181B] text-[#FAF9F6] p-4 flex flex-col items-center justify-center text-center border-r border-dashed border-white/30">
                        <span class="text-[9px] uppercase tracking-[0.28em] text-white/65">{{ $acara->tanggal_acara->translatedFormat('D') }}</span>
                        <span class="font-serif text-4xl font-bold leading-none my-1">{{ $acara->tanggal_acara->format('d') }}</span>
                        <span class="text-[10px] uppercase tracking-[0.22em] text-white/80">{{ $acara->tanggal_acara->translatedFormat('M Y') }}</span>
                    </div>
                    <div class="col-span-8 p-4 sm:p-5 text-left space-y-2">
                        <h3 class="font-serif text-xl font-bold uppercase tracking-wider">{{ $acara->nama_acara }}</h3>
                        <p class="text-xs font-semibold tracking-wider text-[#52525B]">
                            {{ substr($acara->waktu_mulai, 0, 5) }}
                            @if ($acara->waktu_selesai) - {{ substr($acara->waktu_selesai, 0, 5) }} @endif
                            {{ $acara->zona_waktu }}
                        </p>
                        <div class="pt-2 border-t border-[#18181B]/15">
                            <p class="font-semibold text-xs sm:text-sm">{{ $acara->nama_tempat }}</p>
                            <p class="text-[11px] text-[#52525B] mt-0.5 leading-relaxed">{{ $acara->alamat_lengkap }}</p>
                        </div>
                        @if ($acara->link_maps)
                            <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="inline-block mt-1 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.2em] transition {{ $kelasTombol }}">
                                Buka Google Maps
                            </a>
                        @endif
                    </div>
                </div>

            @elseif ($gayaTataLetak === 'artdeco')
                {{-- LUXURY NOIR: Kartu Gala Ballroom Berborder Ganda & Siku Emas --}}
                <div class="fx-flip-in relative rounded-2xl bg-[#111116]/94 backdrop-blur-md border border-[#D4AF37]/50 p-6 sm:p-7 text-center text-[#F5EFE6] shadow-2xl kartu-3d masuk-3d {{ $ekstraKartu }}">
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-5 w-5 border-t-2 border-l-2 border-[#D4AF37]"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-5 w-5 border-t-2 border-r-2 border-[#D4AF37]"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-5 w-5 border-b-2 border-l-2 border-[#D4AF37]"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-5 w-5 border-b-2 border-r-2 border-[#D4AF37]"></span>

                    <span class="inline-block rounded-full bg-[#D4AF37]/15 border border-[#D4AF37]/45 px-3.5 py-1 text-[10px] font-bold uppercase tracking-[0.22em] text-[#F3E5AB]">
                        {{ substr($acara->waktu_mulai, 0, 5) }}
                        @if ($acara->waktu_selesai) - {{ substr($acara->waktu_selesai, 0, 5) }} @endif
                        {{ $acara->zona_waktu }}
                    </span>

                    <h3 class="mt-3 font-kaligrafi text-4xl text-[#F3E5AB] leading-tight">{{ $acara->nama_acara }}</h3>
                    <p class="mt-1 font-serif text-sm font-bold uppercase tracking-[0.18em] text-white">{{ $acara->tanggal_acara->translatedFormat('l, d F Y') }}</p>

                    <div class="mt-3 pt-3 border-t border-[#D4AF37]/30">
                        <p class="font-semibold text-sm text-white">{{ $acara->nama_tempat }}</p>
                        <p class="text-xs text-white/70 mt-1">{{ $acara->alamat_lengkap }}</p>
                    </div>
                    @if ($acara->link_maps)
                        <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="inline-block mt-4 rounded-full px-6 py-2 text-xs font-bold transition {{ $kelasTombol }}">
                            Buka Google Maps
                        </a>
                    @endif
                </div>

            @else
                {{-- KUBAH ARSITEKTUR: VELVET GARDEN, ISLAMIC HEAVENLY, ROYAL IVORY, ISLAMI SYAR'I, RUSTIC FLORAL --}}
                <div class="fx-scale-in relative rounded-t-[10.5rem] rounded-b-3xl pt-12 pb-8 px-6 text-center space-y-2.5 kartu-3d masuk-3d {{ $ekstraKartu }} {{ $kelasKartu }}">
                    @if ($gayaTataLetak === 'taman' && $ornamenUrl)
                        <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none absolute -top-2 -right-3 w-16 opacity-65 ayun-kanan">
                    @elseif ($gayaTataLetak === 'celestial')
                        <span aria-hidden="true" class="mx-auto inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#D9B664]/15 border border-[#D9B664]/45 text-[#F3E5AB] text-xs">&#9790;</span>
                    @elseif ($gayaTataLetak === 'katedral')
                        <span aria-hidden="true" class="mx-auto inline-block w-12 h-0.5 bg-[#9E7B4F]/50 mb-1"></span>
                    @endif

                    <h3 class="font-kaligrafi text-3xl sm:text-4xl font-normal leading-tight {{ $aksenKartu }}">{{ $acara->nama_acara }}</h3>
                    <p class="text-sm font-bold uppercase tracking-wide">{{ $acara->tanggal_acara->translatedFormat('l, d F Y') }}</p>
                    <p class="inline-block rounded-full px-3.5 py-1 text-xs font-semibold {{ $kelasBadge }}">
                        {{ substr($acara->waktu_mulai, 0, 5) }}
                        @if ($acara->waktu_selesai) - {{ substr($acara->waktu_selesai, 0, 5) }} @endif
                        {{ $acara->zona_waktu }}
                    </p>
                    <div class="pt-3 border-t {{ $kelasBatas }}">
                        <p class="font-semibold text-sm">{{ $acara->nama_tempat }}</p>
                        <p class="text-xs opacity-75 mt-1">{{ $acara->alamat_lengkap }}</p>
                    </div>
                    @if ($acara->link_maps)
                        <a href="{{ $acara->link_maps }}" target="_blank" rel="noopener" class="inline-block mt-2 {{ $radiusTombol }} px-6 py-2 text-xs font-semibold transition {{ $kelasTombol }}">
                            Buka Google Maps
                        </a>
                    @endif
                </div>
            @endif
        @endforeach
    </div>
</section>
@endif
