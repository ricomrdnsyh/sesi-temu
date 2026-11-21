@php
    $acaraPertama = $undangan->daftarAcara->first();
    $isoTarget = null;
    $googleCalUrl = null;
    $gaya = $gayaTataLetak ?? 'klasik';
    $sudutTajam = !empty($sudutEditorial) || $gaya === 'editorial';
    $ekstraKartu = $kelasEkstraKartu ?? '';

    if ($acaraPertama) {
        $offset = match ($acaraPertama->zona_waktu) {
            'WITA' => '+08:00',
            'WIT' => '+09:00',
            default => '+07:00',
        };
        $tanggalStr = $acaraPertama->tanggal_acara->format('Y-m-d');
        $waktuMulai = substr($acaraPertama->waktu_mulai, 0, 8);
        if (strlen($waktuMulai) === 5) {
            $waktuMulai .= ':00';
        }
        $isoTarget = "{$tanggalStr}T{$waktuMulai}{$offset}";

        $mulaiUtc = \Illuminate\Support\Carbon::parse("{$tanggalStr} {$waktuMulai}", match ($acaraPertama->zona_waktu) {
            'WITA' => 'Asia/Makassar',
            'WIT' => 'Asia/Jayapura',
            default => 'Asia/Jakarta',
        })->utc();

        $selesaiUtc = $acaraPertama->waktu_selesai
            ? \Illuminate\Support\Carbon::parse("{$tanggalStr} ".$acaraPertama->waktu_selesai, match ($acaraPertama->zona_waktu) {
                'WITA' => 'Asia/Makassar',
                'WIT' => 'Asia/Jayapura',
                default => 'Asia/Jakarta',
            })->utc()
            : $mulaiUtc->copy()->addHours(2);

        $googleCalUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
            .'&text='.urlencode("Pernikahan {$undangan->nama_panggilan_pria} & {$undangan->nama_panggilan_wanita} ({$acaraPertama->nama_acara})")
            .'&dates='.$mulaiUtc->format('Ymd\THis\Z').'/'.$selesaiUtc->format('Ymd\THis\Z')
            .'&details='.urlencode("Undangan Pernikahan {$undangan->nama_lengkap_pria} & {$undangan->nama_lengkap_wanita} via SesiTemu.id")
            .'&location='.urlencode($acaraPertama->nama_tempat.', '.$acaraPertama->alamat_lengkap);
    }

    $latarBagian = match ($gaya) {
        'keraton' => 'bg-[#472A1C] text-[#FAF3E6]',
        'priangan' => 'bg-[#5A1E1E] text-[#FAF4E8]',
        'editorial' => 'bg-[#111113] text-[#FAF9F6]',
        'artdeco' => 'bg-[#09090D] text-[#F5EFE6]',
        'taman' => 'bg-[#132623] text-[#F4F8F6]',
        'celestial' => 'bg-[#091322] text-[#E6EEF8]',
        'katedral' => 'bg-[#EFE7DA] text-[#3B2E25]',
        'mihrab' => 'bg-[#133D38] text-[#F4FAF6]',
        default => 'bg-[#3E5349] text-[#FDFBF7]',
    };
@endphp

@if ($undangan->fiturAktif('hitung_mundur') && $acaraPertama && $isoTarget)
<section
    data-aos="fade-up"
    data-aos-duration="950"
    data-layout-countdown="{{ $gaya }}"
    x-data="{
        targetMs: new Date(@js($isoTarget)).getTime(),
        hari: '00',
        jam: '00',
        menit: '00',
        detik: '00',
        perbarui() {
            const selisih = Math.max(0, this.targetMs - Date.now());
            this.hari = String(Math.floor(selisih / 86400000)).padStart(2, '0');
            this.jam = String(Math.floor((selisih % 86400000) / 3600000)).padStart(2, '0');
            this.menit = String(Math.floor((selisih % 3600000) / 60000)).padStart(2, '0');
            this.detik = String(Math.floor((selisih % 60000) / 1000)).padStart(2, '0');
        },
        init() {
            this.perbarui();
            setInterval(() => this.perbarui(), 1000);
        }
    }"
    class="relative py-12 px-5 text-center overflow-hidden {{ $latarBagian }}"
>
    @if ($gaya === 'editorial')
        {{-- EDITORIAL MONOKROM: Ticker Angka Raksasa Bergaris Vertikal Tipis (Tanpa Kotak) --}}
        <div class="max-w-md mx-auto space-y-6 fx-rise">
            <div class="flex items-center justify-between text-[10px] uppercase tracking-[0.34em] text-white/55 border-b border-white/15 pb-3">
                <span>Countdown</span>
                <span>{{ $acaraPertama->tanggal_acara->format('d . m . Y') }}</span>
            </div>

            <h2 class="font-serif text-3xl font-bold uppercase tracking-[0.18em] text-white">Save The Date</h2>

            <div class="grid grid-cols-4 divide-x divide-white/20 border-y border-white/20 py-5 panggung-3d">
                @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                    <div class="px-1.5">
                        <div
                            class="font-serif text-3xl sm:text-4xl font-bold leading-none text-white"
                            x-text="{{ $var }}"
                            x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                        >00</div>
                        <div class="mt-2 text-[9px] uppercase tracking-[0.22em] text-white/60">{{ $label }}</div>
                    </div>
                @endforeach
            </div>

            @if ($googleCalUrl)
                <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 border border-white/60 px-6 py-2.5 text-xs font-semibold uppercase tracking-[0.22em] text-white hover:bg-white hover:text-[#111113] transition">
                    Simpan ke Kalender
                </a>
            @endif
        </div>

    @elseif ($gaya === 'priangan')
        {{-- SUNDA SIGER HERITAGE: Pita Marun-Emas dengan 4 Medali Bundar Ganda --}}
        <div class="max-w-md mx-auto space-y-5 fx-rise">
            @if (! empty($ornamenUrl))
                <img src="{{ $ornamenUrl }}" alt="" class="w-14 mx-auto opacity-90 drop-shadow animasi-ayun-3d">
            @endif
            <div>
                <p class="text-[10px] font-semibold uppercase tracking-[0.32em] text-[#F3E5AB]">Nuju Dinten Bagja</p>
                <h2 class="mt-1 font-kaligrafi text-4xl sm:text-5xl text-white leading-tight">Save The Date</h2>
            </div>

            <div class="grid grid-cols-4 gap-2 sm:gap-3 pt-1 panggung-3d">
                @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                    <div class="aspect-square rounded-full bg-[#FFFBF4] text-[#4A2020] ring-2 ring-[#C59B43] ring-offset-2 ring-offset-[#5A1E1E] flex flex-col items-center justify-center shadow-lg">
                        <div
                            class="font-serif text-lg sm:text-2xl font-bold leading-none"
                            x-text="{{ $var }}"
                            x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                        >00</div>
                        <div class="mt-1 text-[9px] uppercase tracking-wider text-[#6E2C2C]/75 font-semibold">{{ $label }}</div>
                    </div>
                @endforeach
            </div>

            @if ($googleCalUrl)
                <div class="pt-2">
                    <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-[#C59B43] px-6 py-2.5 text-xs sm:text-sm font-bold text-[#2D1010] hover:bg-[#DFB962] shadow-md transition">
                        Simpan ke Kalender
                    </a>
                </div>
            @endif
        </div>

    @elseif ($gaya === 'taman')
        {{-- VELVET GARDEN MOTION: 4 Kapsul Botani Vertikal Tinggi --}}
        <div class="max-w-md mx-auto rounded-3xl border border-[#C8A464]/40 bg-[#1B3532]/85 backdrop-blur-md p-6 sm:p-7 shadow-2xl kartu-3d masuk-3d {{ $ekstraKartu }}">
            <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#EEDAD4]">Menuju Hari Bahagia</p>
            <h2 class="mt-1 font-kaligrafi text-4xl sm:text-5xl text-[#F3DFA2] leading-tight">Save The Date</h2>

            <div class="mt-6 grid grid-cols-4 gap-2.5 panggung-3d">
                @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                    <div class="rounded-full bg-[#FDFBF7] text-[#1F3431] py-4 px-1.5 border border-[#C8A464]/60 shadow-md">
                        <div
                            class="font-serif text-xl sm:text-2xl font-bold leading-none"
                            x-text="{{ $var }}"
                            x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                        >00</div>
                        <div class="mt-1.5 text-[9px] uppercase tracking-wider text-[#3E5A5C] font-semibold">{{ $label }}</div>
                    </div>
                @endforeach
            </div>

            @if ($googleCalUrl)
                <div class="mt-6">
                    <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-[#C8A464] px-6 py-2.5 text-xs sm:text-sm font-bold text-[#132623] hover:bg-[#DFC080] shadow transition">
                        Simpan ke Kalender
                    </a>
                </div>
            @endif
        </div>

    @elseif ($gaya === 'celestial')
        {{-- ISLAMIC HEAVENLY: 4 Kubah Mini Safir-Emas --}}
        <div class="max-w-md mx-auto rounded-t-[4rem] rounded-b-3xl border border-[#D9B664]/45 bg-[#12243B]/90 backdrop-blur-md p-6 sm:p-7 shadow-2xl kartu-3d masuk-3d {{ $ekstraKartu }}">
            <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#D9B664]">Menuju Hari Bahagia</p>
            <h2 class="mt-1 font-kaligrafi text-4xl sm:text-5xl text-[#F3E5AB] leading-tight">Save The Date</h2>

            <div class="mt-6 grid grid-cols-4 gap-2 panggung-3d">
                @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                    <div class="rounded-t-full rounded-b-xl bg-[#0B1726] border border-[#D9B664]/50 pt-4 pb-3 px-1.5 shadow-inner">
                        <div
                            class="font-serif text-xl sm:text-2xl font-bold leading-none text-[#F3E5AB]"
                            x-text="{{ $var }}"
                            x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                        >00</div>
                        <div class="mt-1.5 text-[9px] uppercase tracking-wider text-[#D9B664]/80">{{ $label }}</div>
                    </div>
                @endforeach
            </div>

            @if ($googleCalUrl)
                <div class="mt-6">
                    <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-[#D9B664] px-6 py-2.5 text-xs sm:text-sm font-bold text-[#09131F] hover:bg-[#E7C87D] shadow transition">
                        Simpan ke Kalender
                    </a>
                </div>
            @endif
        </div>

    @elseif ($gaya === 'artdeco')
        {{-- LUXURY NOIR: Panel Gala Art Deco Bersiku Emas --}}
        <div class="max-w-md mx-auto relative rounded-xl border border-[#D4AF37]/50 bg-[#121218]/95 p-6 sm:p-7 shadow-2xl kartu-3d masuk-3d {{ $ekstraKartu }}">
            <span aria-hidden="true" class="pointer-events-none absolute top-2 left-2 h-4 w-4 border-t-2 border-l-2 border-[#D4AF37]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute top-2 right-2 h-4 w-4 border-t-2 border-r-2 border-[#D4AF37]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-2 left-2 h-4 w-4 border-b-2 border-l-2 border-[#D4AF37]"></span>
            <span aria-hidden="true" class="pointer-events-none absolute bottom-2 right-2 h-4 w-4 border-b-2 border-r-2 border-[#D4AF37]"></span>

            <p class="text-[10px] font-semibold uppercase tracking-[0.34em] text-[#D4AF37]">Counting Down To Forever</p>
            <h2 class="mt-1 font-kaligrafi text-4xl sm:text-5xl text-[#F3E5AB] leading-tight">Save The Date</h2>

            <div class="mt-6 grid grid-cols-4 gap-2 panggung-3d">
                @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                    <div class="rounded-lg bg-black/60 border border-[#D4AF37]/40 py-3 px-1.5">
                        <div
                            class="font-serif text-xl sm:text-2xl font-bold leading-none text-[#F3E5AB]"
                            x-text="{{ $var }}"
                            x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                        >00</div>
                        <div class="mt-1.5 text-[9px] uppercase tracking-widest text-[#D4AF37]/80">{{ $label }}</div>
                    </div>
                @endforeach
            </div>

            @if ($googleCalUrl)
                <div class="mt-6">
                    <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#C59B38] via-[#E8CC75] to-[#C59B38] px-6 py-2.5 text-xs sm:text-sm font-bold text-[#0D0D10] hover:brightness-110 shadow transition">
                        Simpan ke Kalender
                    </a>
                </div>
            @endif
        </div>

    @elseif ($gaya === 'katedral')
        {{-- ROYAL IVORY CATHEDRAL: Papan Surat Kerajaan Bersegel Lilin --}}
        <div class="max-w-md mx-auto rounded-3xl bg-white border border-[#9E7B4F]/45 p-2 shadow-xl kartu-3d masuk-3d">
            <div class="rounded-[1.25rem] border border-dashed border-[#9E7B4F]/40 p-6 space-y-5">
                <span aria-hidden="true" class="mx-auto inline-flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-[#A68353] to-[#6E5332] text-[#FAF6EE] font-serif text-xs font-bold shadow animasi-segel">
                    {{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}
                </span>

                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#9E7B4F]">Menuju Hari Bahagia</p>
                    <h2 class="mt-1 font-kaligrafi text-4xl text-[#58432B] leading-tight">Save The Date</h2>
                </div>

                <div class="grid grid-cols-4 divide-x divide-[#9E7B4F]/25 border-y border-[#9E7B4F]/25 py-4 panggung-3d">
                    @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                        <div class="px-1">
                            <div
                                class="font-serif text-2xl sm:text-3xl font-bold leading-none text-[#58432B]"
                                x-text="{{ $var }}"
                                x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                            >00</div>
                            <div class="mt-1.5 text-[9px] uppercase tracking-wider text-[#9E7B4F] font-semibold">{{ $label }}</div>
                        </div>
                    @endforeach
                </div>

                @if ($googleCalUrl)
                    <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-[#7B603F] px-6 py-2.5 text-xs sm:text-sm font-semibold text-[#FAF6EE] hover:bg-[#58432B] shadow-sm transition">
                        Simpan ke Kalender
                    </a>
                @endif
            </div>
        </div>

    @elseif ($gaya === 'keraton')
        {{-- ADAT JAWA KERATON: Ground Espresso Gelap + Gunungan + 4 Ubin Emas Sampanye (Gaya Java Heritage) --}}
        <div class="max-w-md mx-auto space-y-5 fx-rise">
            @if (! empty($ornamenUrl))
                <img src="{{ $ornamenUrl }}" alt="" class="w-16 mx-auto drop-shadow-lg animasi-ayun-3d">
            @endif
            <div>
                <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#D7BB83]">Menuju Hari Bahagia</p>
                <h2 class="mt-1 font-kaligrafi text-4xl sm:text-5xl text-white leading-tight">Save The Date</h2>
            </div>

            <div class="grid grid-cols-4 gap-2 sm:gap-2.5 panggung-3d">
                @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                    <div class="rounded-2xl bg-[#D7BB83] text-[#2A170D] p-3 shadow-lg border border-[#F3E5AB]/50">
                        <div
                            class="font-serif text-2xl font-bold leading-none"
                            x-text="{{ $var }}"
                            x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                        >00</div>
                        <div class="mt-1.5 text-[10px] uppercase tracking-wider font-semibold opacity-80">{{ $label }}</div>
                    </div>
                @endforeach
            </div>

            <p class="text-xs text-[#FAF3E6]/80 max-w-xs mx-auto leading-relaxed">
                Merupakan kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.
            </p>

            @if ($googleCalUrl)
                <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-[#D7BB83] px-6 py-2.5 text-xs sm:text-sm font-bold text-[#2A170D] hover:bg-[#E7CE9B] shadow-md transition">
                    Simpan ke Kalender
                </a>
            @endif
        </div>

    @else
        {{-- BASIC: RUSTIC FLORAL & ISLAMI SYAR'I EMERALD --}}
        <div class="max-w-md mx-auto rounded-3xl p-6 sm:p-7 bg-white/10 backdrop-blur-sm border border-white/20 shadow-xl kartu-3d masuk-3d">
            @if ($gaya === 'mihrab')
                <svg class="w-8 h-8 mx-auto mb-2 text-[#F3E5AB] animasi-orbit" style="animation-duration: 32s;" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
                    <rect x="7" y="7" width="18" height="18"/>
                    <rect x="7" y="7" width="18" height="18" transform="rotate(45 16 16)"/>
                    <circle cx="16" cy="16" r="2.5" fill="currentColor"/>
                </svg>
            @else
                <svg class="w-8 h-8 mx-auto mb-2 opacity-85" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
                    <path d="M12 21c-3.5-2.8-6-5.7-6-9a6 6 0 0 1 12 0c0 3.3-2.5 6.2-6 9Z" />
                    <path d="M12 10.5c1.6-2 4-2.5 5.5-1.5M12 10.5c-1.6-2-4-2.5-5.5-1.5" />
                </svg>
            @endif

            <p class="text-[11px] font-semibold uppercase tracking-[0.28em] opacity-85">Menuju Hari Bahagia</p>
            <h2 class="mt-1.5 font-kaligrafi text-4xl sm:text-5xl font-normal leading-tight">Save The Date</h2>

            <div class="mt-6 grid grid-cols-4 gap-2 sm:gap-2.5 panggung-3d">
                @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                    <div class="rounded-2xl p-2.5 sm:p-3.5 {{ $kelasKotakCountdown ?? 'bg-white text-[#1F2937] shadow-sm' }}">
                        <div
                            class="font-serif text-xl sm:text-2xl font-bold leading-none"
                            x-text="{{ $var }}"
                            x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                        >00</div>
                        <div class="mt-1.5 text-[10px] uppercase tracking-wider opacity-75">{{ $label }}</div>
                    </div>
                @endforeach
            </div>

            @if ($googleCalUrl)
                <div class="mt-6">
                    <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-xs sm:text-sm font-semibold transition {{ $kelasTombolCountdown ?? 'bg-white text-[#1F2937]' }}">
                        Simpan ke Kalender
                    </a>
                </div>
            @endif
        </div>
    @endif
</section>
@endif
