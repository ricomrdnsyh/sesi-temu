@if (!empty($modeDemo))
    <div class="fixed top-0 inset-x-0 z-50 bg-charcoal/95 text-ivory border-b border-champagne/40 px-4 py-2.5 shadow-md">
        <div class="max-w-5xl mx-auto flex flex-wrap items-center justify-between gap-3 text-xs sm:text-sm">
            <div class="flex items-center gap-2">
                <span class="rounded-full bg-champagne px-2.5 py-0.5 text-[11px] font-bold uppercase text-charcoal">Live Demo</span>
                <span>Tema: <strong>{{ $undangan->tema?->nama_tema }}</strong></span>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('beranda') }}#katalog-tema" class="rounded-lg border border-ivory/25 px-3 py-1.5 text-xs font-semibold hover:bg-white/10 transition">
                    Kembali
                </a>
                <a href="{{ route('daftar', ['tema' => $undangan->tema?->id]) }}" class="rounded-lg bg-champagne px-3.5 py-1.5 text-xs font-bold text-charcoal hover:bg-champagne/90 transition">
                    Pakai Tema Ini
                </a>
            </div>
        </div>
    </div>
@elseif (!empty($modePratinjau) || ! $undangan->status_publikasi)
    <div class="fixed top-0 inset-x-0 z-50 bg-amber-600 text-white px-4 py-2.5 shadow-md text-center text-xs sm:text-sm font-semibold tracking-wide">
        MODE PRATINJAU SESITEMU.ID — UNDANGAN BELUM AKTIF
    </div>
@endif
