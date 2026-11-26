@php
    $tanpaHapus = !empty($tanpaHapus);
    $namaBankKartu = $namaBank ?? $amplop->nama_bank;
    $nomorRekeningKartu = $nomorRekening ?? $amplop->nomor_rekening;
    $atasNamaKartu = $atasNama ?? $amplop->atas_nama;
    $gaya = \App\Support\GayaKartuBank::untukNamaBank($namaBankKartu);
    $nomorTampil = \App\Support\GayaKartuBank::formatNomor($nomorRekeningKartu);
@endphp

<div
    x-data="{ tersalin: false }"
    aria-label="{{ $gaya['subjudul'] }}"
    style="--warna-bank: {{ $gaya['warna_utama'] }};"
    class="group relative aspect-[1.68/1] w-full rounded-2xl p-4 text-[#1F2937] bg-gradient-to-br from-[#FAFAFB] via-[#FFFFFF] to-[#F1F3F5] shadow-[0_10px_24px_-10px_rgba(15,23,42,0.16),0_2px_5px_-1px_rgba(15,23,42,0.06)] hover:shadow-[0_14px_28px_-10px_rgba(15,23,42,0.2)] ring-1 ring-black/[0.08] overflow-hidden flex flex-col justify-between transition-all duration-300"
>
    {{-- Tekstur titik halus & kurva pita satin perak ala kartu ATM modern --}}
    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0 opacity-75"
        style="background-image: radial-gradient(rgba(148, 163, 184, 0.24) 1px, transparent 1px); background-size: 7px 7px; -webkit-mask-image: radial-gradient(ellipse 70% 75% at 36% 42%, #000 0%, transparent 78%); mask-image: radial-gradient(ellipse 70% 75% at 36% 42%, #000 0%, transparent 78%);"
    ></div>
    <svg aria-hidden="true" viewBox="0 0 400 248" preserveAspectRatio="none" class="pointer-events-none absolute inset-0 h-full w-full">
        <path d="M-10 56 C82 94, 96 184, 178 258 L-10 258 Z" fill="#E5E7EB" fill-opacity="0.46"/>
        <path d="M-10 86 C64 128, 72 204, 134 258 L-10 258 Z" fill="#FFFFFF" fill-opacity="0.72"/>
        <path d="M118 258 C178 166, 294 150, 412 224 L412 258 Z" fill="#E2E8F0" fill-opacity="0.52"/>
        <path d="M148 258 C202 184, 304 176, 412 240 L412 258 Z" fill="#FFFFFF" fill-opacity="0.65"/>
        <path d="M326 -10 C346 58, 378 96, 412 116 L412 -10 Z" fill="#F1F5F9" fill-opacity="0.7"/>
    </svg>

    {{-- Baris Atas: Aksi Resmi / Hapus (Kiri) + Logo Bank Resmi (Kanan) --}}
    <div class="relative z-10 flex items-start justify-between gap-2 min-h-[30px]">
        <div class="flex items-center gap-1.5 shrink-0">
            @if ($tanpaHapus)
                <span class="inline-flex items-center gap-1 rounded-lg bg-emerald-50 border border-emerald-200 px-2 py-0.5 text-[10px] font-semibold text-emerald-700">
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
                        class="rounded-lg bg-rose-50 hover:bg-rose-600 border border-rose-200/90 px-2.5 py-1 text-[10px] font-semibold text-rose-600 hover:text-white transition cursor-pointer"
                    >
                        Hapus
                    </button>
                </form>
            @endif
        </div>

        <div class="flex items-center justify-end" title="{{ $gaya['subjudul'] }}">
            @if (! empty($gaya['logo_url']))
                <img
                    src="{{ $gaya['logo_url'] }}"
                    alt="{{ $namaBankKartu }}"
                    loading="lazy"
                    decoding="async"
                    class="h-6 max-w-[110px] w-auto object-contain object-right"
                >
            @else
                <span class="font-sans text-sm font-extrabold tracking-tight text-[#1F2937] uppercase truncate max-w-[140px]">
                    {{ $namaBankKartu }}
                </span>
            @endif
        </div>
    </div>

    {{-- Baris Tengah: Chip EMV Emas Realistis --}}
    <div class="relative z-10 flex items-center">
        <div
            class="w-9 h-[26px] rounded-[5px] border border-[#B78B36]/65 shadow-[inset_0_1px_1px_rgba(255,255,255,0.7),0_1px_2px_rgba(15,23,42,0.12)] overflow-hidden"
            style="background: linear-gradient(135deg, #F6E2A8 0%, #E0B55A 48%, #C49336 100%);"
            aria-hidden="true"
        >
            <svg viewBox="0 0 44 32" fill="none" class="h-full w-full">
                <rect x="14" y="7" width="16" height="18" rx="3" stroke="#8C641D" stroke-opacity="0.55" stroke-width="1"/>
                <line x1="0" y1="11" x2="14" y2="11" stroke="#8C641D" stroke-opacity="0.55" stroke-width="1"/>
                <line x1="0" y1="21" x2="14" y2="21" stroke="#8C641D" stroke-opacity="0.55" stroke-width="1"/>
                <line x1="30" y1="11" x2="44" y2="11" stroke="#8C641D" stroke-opacity="0.55" stroke-width="1"/>
                <line x1="30" y1="21" x2="44" y2="21" stroke="#8C641D" stroke-opacity="0.55" stroke-width="1"/>
                <line x1="22" y1="0" x2="22" y2="7" stroke="#8C641D" stroke-opacity="0.55" stroke-width="1"/>
                <line x1="22" y1="25" x2="22" y2="32" stroke="#8C641D" stroke-opacity="0.55" stroke-width="1"/>
            </svg>
        </div>
    </div>

    {{-- Baris Bawah: Nomor Rekening & Nama Pemilik (Kiri) + Tombol Copy Gelap (Kanan) --}}
    <div class="relative z-10 flex items-end justify-between gap-2.5">
        <div class="min-w-0 flex-1">
            <p
                class="font-mono text-sm sm:text-[15px] font-semibold tracking-[0.11em] text-[#1F2937] tabular-nums truncate leading-tight"
                data-nomor-asli="{{ $nomorRekeningKartu }}"
            >
                {{ $nomorTampil }}
            </p>
            <p class="mt-0.5 text-[11px] sm:text-xs font-medium text-[#4B5563] truncate">
                {{ $atasNamaKartu }}
            </p>
        </div>

        <button
            type="button"
            @click="navigator.clipboard?.writeText(@js($nomorRekeningKartu)); tersalin = true; setTimeout(() => tersalin = false, 2000)"
            class="shrink-0 inline-flex items-center gap-1 rounded-md bg-[#2B2B2B] hover:bg-[#171717] px-2.5 py-1 text-[11px] font-semibold text-white shadow-xs transition cursor-pointer"
        >
            <svg class="h-3 w-3 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
            </svg>
            <span x-show="!tersalin">Copy</span>
            <span x-show="tersalin" x-cloak class="text-emerald-300">Tersalin!</span>
        </button>
    </div>
</div>
