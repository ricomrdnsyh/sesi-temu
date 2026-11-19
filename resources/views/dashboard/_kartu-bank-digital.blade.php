@php
    $modeLive = !empty($modeLive);
    $tanpaHapus = !empty($tanpaHapus);
    if (! $modeLive) {
        $namaBankKartu = $namaBank ?? $amplop->nama_bank;
        $nomorRekeningKartu = $nomorRekening ?? $amplop->nomor_rekening;
        $atasNamaKartu = $atasNama ?? $amplop->atas_nama;
        $gaya = \App\Support\GayaKartuBank::untukNamaBank($namaBankKartu);
        $nomorTampil = \App\Support\GayaKartuBank::formatNomor($nomorRekeningKartu);
        $adalahEwallet = $gaya['jenis'] === 'ewallet';
    }
@endphp

@if ($modeLive)
    <div
        :style="'background: ' + gayaKartuLive().gradient_css"
        class="relative aspect-[1.586/1] w-full rounded-2xl p-5 sm:p-6 text-white shadow-xl overflow-hidden select-none flex flex-col justify-between transition-all duration-300 ring-1 ring-black/15"
    >
        {{-- Efek kilau & ornamen geometris permukaan kartu --}}
        <div aria-hidden="true" class="pointer-events-none absolute -top-12 -right-12 w-44 h-44 rounded-full bg-white/10 blur-xl"></div>
        <div aria-hidden="true" class="pointer-events-none absolute -bottom-16 -left-10 w-48 h-48 rounded-full bg-white/10"></div>
        <div
            aria-hidden="true"
            class="pointer-events-none absolute top-0 inset-x-0 h-1.5 opacity-90"
            :style="'background: ' + gayaKartuLive().aksen_hex"
        ></div>

        {{-- Baris Atas: Nama Bank & Badge Jenis --}}
        <div class="relative z-10 flex items-start justify-between gap-2">
            <div class="min-w-0">
                <p class="text-[10px] uppercase tracking-[0.22em] text-white/75" x-text="gayaKartuLive().label_jenis"></p>
                <p class="font-logo text-lg sm:text-xl font-bold tracking-wide truncate drop-shadow-xs" x-text="bankBaru.trim() || gayaKartuLive().singkatan"></p>
            </div>
            <span class="rounded-lg bg-white/15 backdrop-blur-xs border border-white/25 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-white shrink-0" x-text="gayaKartuLive().singkatan"></span>
        </div>

        {{-- Baris Tengah: Chip EMV / Ikon Wallet & Contactless --}}
        <div class="relative z-10 flex items-center justify-between my-1">
            <template x-if="gayaKartuLive().jenis === 'ewallet'">
                <div class="inline-flex items-center gap-2 rounded-xl bg-white/15 backdrop-blur-xs border border-white/25 px-3 py-1.5">
                    <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/>
                        <path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/>
                    </svg>
                    <span class="text-[10px] font-bold uppercase tracking-wider">Dompet Digital</span>
                </div>
            </template>
            <template x-if="gayaKartuLive().jenis !== 'ewallet'">
                <div
                    class="w-11 h-8 rounded-md shadow-inner border border-white/30 relative overflow-hidden"
                    :style="gayaKartuLive().chip_gaya === 'perak'
                        ? 'background: linear-gradient(135deg, #F3F4F6 0%, #D1D5DB 50%, #9CA3AF 100%)'
                        : 'background: linear-gradient(135deg, #FEF08A 0%, #EAB308 55%, #A16207 100%)'"
                >
                    <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 h-px bg-black/25"></div>
                    <div class="absolute inset-y-0 left-1/3 w-px bg-black/25"></div>
                    <div class="absolute inset-y-0 right-1/3 w-px bg-black/25"></div>
                </div>
            </template>

            <svg class="h-5 w-5 text-white/70 rotate-90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                <path d="M2 8.5a15 15 0 0 1 20 0"/>
                <path d="M5 12.5a10 10 0 0 1 14 0"/>
                <path d="M8.5 16.5a5 5 0 0 1 7 0"/>
            </svg>
        </div>

        {{-- Baris Bawah: Nomor Rekening & Atas Nama --}}
        <div class="relative z-10 space-y-2">
            <p class="font-mono text-lg sm:text-xl font-bold tracking-[0.16em] tabular-nums drop-shadow-xs truncate" x-text="formatNomorLive(nomorBaru)"></p>
            <div class="flex items-end justify-between gap-2 text-xs">
                <div class="min-w-0">
                    <p class="text-[9px] uppercase tracking-[0.2em] text-white/70">Atas Nama</p>
                    <p class="font-semibold uppercase tracking-wide truncate" x-text="atasNamaBaru.trim() || @js($undangan->nama_lengkap_pria)"></p>
                </div>
                <span class="text-[9px] font-bold uppercase tracking-[0.2em] text-white/75 shrink-0">SesiTemu</span>
            </div>
        </div>
    </div>
@else
    <div
        x-data="{ tersalin: false }"
        style="background: {{ $gaya['gradient_css'] }}"
        class="group relative aspect-[1.586/1] w-full rounded-2xl p-5 text-white shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between ring-1 ring-black/15"
    >
        {{-- Kilau & strip warna ciri khas bank --}}
        <div aria-hidden="true" class="pointer-events-none absolute -top-12 -right-12 w-40 h-40 rounded-full bg-white/10 blur-xl"></div>
        <div aria-hidden="true" class="pointer-events-none absolute -bottom-16 -left-10 w-44 h-44 rounded-full bg-white/10"></div>
        <div aria-hidden="true" class="pointer-events-none absolute top-0 inset-x-0 h-1.5 opacity-95" style="background: {{ $gaya['aksen_hex'] }}"></div>

        {{-- Baris Atas: Nama Bank + Tombol Hapus (jika mode daftar rekening client) --}}
        <div class="relative z-10 flex items-start justify-between gap-2">
            <div class="min-w-0">
                <p class="text-[10px] uppercase tracking-[0.2em] text-white/75">{{ $gaya['label_jenis'] }}</p>
                <h3 class="font-logo text-lg font-bold tracking-wide truncate drop-shadow-xs">{{ $namaBankKartu }}</h3>
            </div>

            <div class="flex items-center gap-1.5 shrink-0">
                <span class="rounded-lg bg-white/15 backdrop-blur-xs border border-white/20 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider">
                    {{ $gaya['singkatan'] }}
                </span>

                @if ($tanpaHapus)
                    <span class="inline-flex items-center gap-1 rounded-lg bg-emerald-400/20 backdrop-blur-xs border border-emerald-200/35 px-2 py-0.5 text-[10px] font-semibold text-white">
                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Resmi
                    </span>
                @elseif (isset($amplop))
                    <form
                        action="{{ route('dashboard.amplop.hapus', [$undangan, $amplop]) }}"
                        method="POST"
                        data-swal-title="Hapus Rekening?"
                        data-swal-confirm="Yakin ingin menghapus kartu {{ $amplop->nama_bank }} ({{ $amplop->nomor_rekening }})?"
                        data-swal-icon="warning"
                        data-swal-confirm-button="Ya, Hapus"
                        data-swal-confirm-color="#DC2626"
                        data-swal-loading-title="Menghapus Rekening..."
                        data-swal-loading-text="Menghapus kartu rekening dari amplop digital..."
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            title="Hapus Rekening"
                            class="rounded-lg bg-black/30 hover:bg-rose-600 backdrop-blur-xs border border-white/15 px-2.5 py-1 text-[10px] font-semibold text-white transition cursor-pointer"
                        >
                            Hapus
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Baris Tengah: Chip EMV / E-Wallet + Salin --}}
        <div class="relative z-10 flex items-center justify-between">
            @if ($adalahEwallet)
                <div class="inline-flex items-center gap-1.5 rounded-xl bg-white/15 backdrop-blur-xs border border-white/25 px-2.5 py-1">
                    <svg class="h-3.5 w-3.5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/>
                        <path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/>
                    </svg>
                    <span class="text-[10px] font-bold uppercase tracking-wider">E-Wallet</span>
                </div>
            @else
                <div
                    class="w-10 h-7 rounded-md shadow-inner border border-white/30 relative overflow-hidden"
                    style="{{ $gaya['chip_gaya'] === 'perak'
                        ? 'background: linear-gradient(135deg, #F3F4F6 0%, #D1D5DB 50%, #9CA3AF 100%)'
                        : 'background: linear-gradient(135deg, #FEF08A 0%, #EAB308 55%, #A16207 100%)' }}"
                >
                    <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 h-px bg-black/25"></div>
                    <div class="absolute inset-y-0 left-1/3 w-px bg-black/25"></div>
                    <div class="absolute inset-y-0 right-1/3 w-px bg-black/25"></div>
                </div>
            @endif

            <button
                type="button"
                @click="navigator.clipboard?.writeText(@js($nomorRekeningKartu)); tersalin = true; setTimeout(() => tersalin = false, 2000)"
                class="inline-flex items-center gap-1 rounded-full bg-white/15 hover:bg-white/25 backdrop-blur-xs border border-white/25 px-2.5 py-1 text-[10px] font-semibold text-white transition cursor-pointer"
            >
                <span x-show="!tersalin">Salin No.</span>
                <span x-show="tersalin" x-cloak class="text-[#FDE047]">Tersalin!</span>
            </button>
        </div>

        {{-- Baris Bawah: Nomor Rekening & Atas Nama --}}
        <div class="relative z-10 space-y-1.5">
            <p
                class="font-mono text-base sm:text-lg font-bold tracking-[0.14em] tabular-nums drop-shadow-xs truncate"
                data-nomor-asli="{{ $nomorRekeningKartu }}"
            >
                {{ $nomorTampil }}
            </p>
            <div class="flex items-end justify-between gap-2">
                <div class="min-w-0">
                    <p class="text-[9px] uppercase tracking-[0.2em] text-white/70">Atas Nama</p>
                    <p class="text-xs font-semibold uppercase tracking-wide truncate">a.n. {{ $atasNamaKartu }}</p>
                </div>
                <span class="text-[9px] font-bold uppercase tracking-[0.18em] text-white/65 shrink-0">{{ $gaya['subjudul'] }}</span>
            </div>
        </div>
    </div>
@endif
