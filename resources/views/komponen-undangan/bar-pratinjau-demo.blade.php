@if (!empty($modeDemo))
    @php
        $demoTanpaFoto = $undangan->modeTanpaFoto();
        $demoFontTerpilih = $undangan->kodeGayaFontTerpilih();
    @endphp
    <div class="fixed top-0 inset-x-0 z-50 bg-charcoal/95 text-ivory border-b border-champagne/40 px-4 py-2 shadow-md">
        <div class="max-w-6xl mx-auto flex flex-wrap items-center justify-between gap-2 text-xs sm:text-sm">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('beranda') }}" title="SesiTemu" class="inline-flex items-center gap-1.5 rounded-full bg-[#FBF3E6] px-2 py-0.5 text-charcoal shrink-0">
                    <img src="{{ asset('aset-demo/logo-sesi-temu-ikon.webp') }}" alt="Logo SesiTemu" class="h-4 w-4 object-contain">
                    <span class="text-[11px] font-bold tracking-tight">SesiTemu</span>
                </a>
                <span class="rounded-full bg-champagne px-2.5 py-0.5 text-[11px] font-bold uppercase text-charcoal">Live Demo</span>
                <span>Tema: <strong>{{ $undangan->tema?->nama_tema }}</strong></span>
                <span class="hidden md:inline-block rounded-full bg-white/10 px-2.5 py-0.5 text-[11px] text-champagne">
                    {{ $undangan->tema?->kategoriLabel() }}
                </span>
                @if ($undangan->tema)
                    <span class="hidden sm:inline-block rounded-full bg-champagne/20 px-2.5 py-0.5 text-[11px] font-semibold text-champagne">
                        {{ $undangan->tema->tierLabel() }} • {{ $undangan->tema->hargaFormatted() }}
                    </span>
                @endif
            </div>

            <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap items-center gap-2">
                <input type="hidden" name="to" value="{{ $namaTamu }}">
                <input type="hidden" name="tf" value="{{ $demoTanpaFoto ? '1' : '0' }}">
                <select
                    name="font"
                    aria-label="Pilih Desain Font Demo"
                    onchange="this.form.submit()"
                    class="rounded-lg border border-ivory/25 bg-charcoal px-2.5 py-1 text-xs text-ivory focus:border-champagne focus:outline-none [&>option]:bg-charcoal [&>option]:text-ivory"
                >
                    @foreach (\App\Models\Undangan::GAYA_FONT_TERSEDIA as $kodeFont => $infoFont)
                        <option value="{{ $kodeFont }}" @selected($demoFontTerpilih === $kodeFont)>
                            Font: {{ $infoFont['label'] }}
                        </option>
                    @endforeach
                </select>

                <a
                    href="{{ request()->fullUrlWithQuery(['tf' => $demoTanpaFoto ? '0' : '1', 'font' => $demoFontTerpilih, 'to' => $namaTamu]) }}"
                    class="rounded-lg border px-2.5 py-1 text-xs font-semibold transition {{ $demoTanpaFoto ? 'border-champagne bg-champagne/20 text-champagne' : 'border-ivory/25 text-ivory/85 hover:bg-white/10' }}"
                >
                    {{ $demoTanpaFoto ? 'Mode: Tanpa Foto (TF)' : 'Coba Tanpa Foto (TF)' }}
                </a>

                <a href="{{ route('beranda') }}#katalog-tema" class="rounded-lg border border-ivory/25 px-3 py-1 text-xs font-semibold hover:bg-white/10 transition">
                    Kembali
                </a>
                <a href="{{ route('daftar', ['tema' => $undangan->tema?->id]) }}" class="rounded-lg bg-champagne px-3.5 py-1 text-xs font-bold text-charcoal hover:bg-champagne/90 transition">
                    Pakai Tema Ini
                </a>
            </form>
        </div>
    </div>
@elseif (!empty($modePratinjau) || ! $undangan->status_publikasi)
    <div class="fixed top-0 inset-x-0 z-50 bg-amber-600 text-white px-4 py-2.5 shadow-md text-center text-xs sm:text-sm font-semibold tracking-wide">
        MODE PRATINJAU SESITEMU.ID — UNDANGAN BELUM AKTIF
    </div>
@endif
