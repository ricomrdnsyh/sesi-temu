@php
    $acaraPertama = $undangan->daftarAcara->first();
    $isoTarget = null;
    $googleCalUrl = null;
    $sudutTajam = !empty($sudutEditorial);
    $kelasRadiusBox = $sudutTajam ? 'rounded-none' : 'rounded-2xl';
    $kelasRadiusTombol = $sudutTajam ? 'rounded-none' : 'rounded-full';
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
    class="py-12 px-4 text-center"
>
    <p class="text-xs font-semibold uppercase tracking-[0.25em] {{ $kelasAksen ?? 'text-champagne' }}">Menuju Hari Bahagia</p>
    <h2 class="mt-2 font-serif text-3xl sm:text-4xl font-bold">Hitung Mundur Acara</h2>

    <div class="mt-7 max-w-md mx-auto grid grid-cols-4 gap-2 sm:gap-3 panggung-3d">
        @foreach (['hari' => 'Hari', 'jam' => 'Jam', 'menit' => 'Menit', 'detik' => 'Detik'] as $var => $label)
            <div class="{{ $kelasRadiusBox }} p-3 sm:p-4 kartu-3d masuk-3d {{ $ekstraKartu }} {{ $kelasKartu ?? 'bg-white ring-1 ring-champagne/25 text-charcoal' }}">
                <div
                    class="font-serif text-2xl sm:text-3xl font-bold"
                    x-text="{{ $var }}"
                    x-effect="if ({{ $var }}) { $el.classList.remove('angka-flip-3d'); void $el.offsetWidth; $el.classList.add('angka-flip-3d'); }"
                >00</div>
                <div class="mt-1 text-[10px] uppercase tracking-widest opacity-70">{{ $label }}</div>
            </div>
        @endforeach
    </div>

    @if ($googleCalUrl)
        <div class="mt-7">
            <a
                href="{{ $googleCalUrl }}"
                target="_blank"
                rel="noopener"
                class="inline-flex items-center gap-2 {{ $kelasRadiusTombol }} px-6 py-3 text-sm font-semibold shadow-sm transition {{ $kelasTombol ?? 'bg-sage text-white hover:bg-sage/90' }}"
            >
                <span>Simpan ke Kalender</span>
            </a>
        </div>
    @endif
</section>
@endif
