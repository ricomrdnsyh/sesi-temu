@if (request()->boolean('embed') || !empty($modeDemo))
    {{-- Mode live demo & embed tampil penuh tanpa header atas agar fokus pada tampilan undangan --}}
@elseif (!empty($modePratinjau) || ! $undangan->status_publikasi)
    <div data-bar-pratinjau class="fixed top-0 inset-x-0 z-50 bg-amber-600 text-white px-4 py-2.5 shadow-md text-center text-xs sm:text-sm font-semibold tracking-wide">
        <span>MODE PRATINJAU SESITEMU.ID — UNDANGAN BELUM AKTIF</span>
        <span class="hidden sm:inline font-normal opacity-95"> • Hanya terlihat oleh pemilik &amp; admin, tamu belum dapat mengakses link ini</span>
    </div>
@endif
