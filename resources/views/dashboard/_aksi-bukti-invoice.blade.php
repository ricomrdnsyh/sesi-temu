@php
    $adalahMobile = ($mode ?? 'desktop') === 'mobile';
    $urlBukti = $trx->urlBukti();
@endphp

@if ($urlBukti)
    <a
        href="{{ $urlBukti }}"
        target="_blank"
        rel="noopener"
        @click.prevent="galeriLightbox = { url: @js($urlBukti), caption: @js('Bukti Pembayaran — '.$trx->kode_invoice) }"
        class="{{ $adalahMobile ? 'w-full justify-center py-2' : 'px-3 py-1.5' }} inline-flex items-center gap-1.5 rounded-xl border border-sage/30 bg-sage/10 text-xs font-semibold text-sage hover:bg-sage hover:text-white transition"
    >
        <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
            <circle cx="12" cy="12" r="3"/>
        </svg>
        Lihat Bukti
    </a>
@elseif ($trx->total_bayar === 0)
    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700">
        Gratis via Voucher
    </span>
@elseif ($trx->status === 'lunas')
    <span class="text-xs text-charcoal/55">Terverifikasi Admin</span>
@elseif ($trx->status === 'ditolak')
    <span class="text-xs font-medium text-rose-600">Ajukan Ulang di Atas</span>
@else
    <span class="text-xs text-charcoal/55">Belum Ada Bukti</span>
@endif
