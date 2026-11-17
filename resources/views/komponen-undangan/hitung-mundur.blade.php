@php
    $acaraPertama = $undangan->daftarAcara->first();
    $isoTarget = null;
    $googleCalUrl = null;
    $sudutTajam = !empty($sudutEditorial);
    $kelasRadiusBand = $sudutTajam ? 'rounded-none' : 'rounded-3xl';
    $kelasRadiusBox = $sudutTajam ? 'rounded-none' : 'rounded-2xl';
    $kelasRadiusTombol = $sudutTajam ? 'rounded-none' : 'rounded-full';
    $ekstraKartu = $kelasEkstraKartu ?? '';
    $bandCountdown = $kelasBandCountdown ?? 'bg-[#4B6358] text-white';
    $kotakCountdown = $kelasKotakCountdown ?? 'bg-white/95 text-[#1F2937] shadow-sm';
    $tombolCountdown = $kelasTombolCountdown ?? 'bg-white text-[#1F2937] hover:bg-ivory shadow-sm';

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
@endphp

@if ($undangan->fiturAktif('hitung_mundur') && $acaraPertama && $isoTarget)
<section
    data-aos="fade-up"
    data-aos-duration="1000"
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
    class="py-10 px-5 text-center"
>
    <div class="max-w-md mx-auto {{ $kelasRadiusBand }} p-6 sm:p-8 shadow-xl relative overflow-hidden kartu-3d masuk-3d {{ $ekstraKartu }} {{ $bandCountdown }}">
        <svg class="w-8 h-8 mx-auto mb-2 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
            <path d="M12 21c-3.5-2.8-6-5.7-6-9a6 6 0 0 1 12 0c0 3.3-2.5 6.2-6 9Z" />
            <path d="M12 10.5c1.6-2 4-2.5 5.5-1.5M12 10.5c-1.6-2-4-2.5-5.5-1.5" />
        </svg>

        <p class="text-[11px] font-semibold uppercase tracking-[0.28em] opacity-80">Menuju Hari Bahagia</p>
        <h2 class="{{ $sudutTajam ? 'mt-2 font-serif text-3xl font-bold uppercase tracking-[0.14em]' : 'mt-1.5 font-kaligrafi text-4xl sm:text-5xl font-normal leading-tight' }}">Save The Date</h2>

        <div class="mt-6 grid grid-cols-4 gap-2 sm:gap-2.5 panggung-3d">
            @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
                <div class="{{ $kelasRadiusBox }} p-2.5 sm:p-3.5 {{ $kotakCountdown }}">
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
                <a
                    href="{{ $googleCalUrl }}"
                    target="_blank"
                    rel="noopener"
                    class="inline-flex items-center gap-2 {{ $kelasRadiusTombol }} px-6 py-2.5 text-xs sm:text-sm font-semibold transition {{ $tombolCountdown }}"
                >
                    <span>Simpan ke Kalender</span>
                </a>
            </div>
        @endif
    </div>
</section>
@endif
