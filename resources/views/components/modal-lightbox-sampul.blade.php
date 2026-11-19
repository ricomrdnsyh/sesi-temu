@props([
    'daftarTema',
    'modeKatalogClient' => false,
])

<div
    x-show="sampulLightboxSlug !== null"
    x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="tutupLightboxSampul()"
    @keydown.escape.window="if (sampulLightboxSlug !== null) tutupLightboxSampul()"
    role="dialog"
    aria-modal="true"
    aria-label="Pratinjau sampul tema"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/85 backdrop-blur-xs p-4 sm:p-6 overflow-y-auto"
>
    {{-- Tombol Tutup Kanan Atas --}}
    <button
        type="button"
        @click.stop="tutupLightboxSampul()"
        aria-label="Tutup pratinjau sampul"
        class="fixed top-4 right-4 sm:top-6 sm:right-6 z-50 inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/12 text-white hover:bg-white/25 ring-1 ring-white/20 transition cursor-pointer"
    >
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M18 6 6 18" />
            <path d="m6 6 12 12" />
        </svg>
    </button>

    {{-- Poster Sampul Diperbesar + Bar Aksi Langsung --}}
    <div @click.stop class="w-full max-w-[440px] sm:max-w-[520px] my-auto">
        @foreach ($daftarTema as $temaLightbox)
            <template x-if="sampulLightboxSlug === '{{ $temaLightbox->slug }}'">
                <div class="w-full space-y-3.5">
                    <div class="w-full overflow-hidden rounded-2xl shadow-[0_24px_60px_rgba(0,0,0,0.55)] ring-1 ring-white/15">
                        <x-poster-sampul-tema :tema="$temaLightbox" />
                    </div>

                    <div class="rounded-2xl bg-white/10 backdrop-blur-md px-4 py-3 text-white ring-1 ring-white/15 flex flex-wrap items-center justify-between gap-3">
                        <div class="min-w-0">
                            <p class="font-logo text-base sm:text-lg font-bold text-white truncate">
                                {{ $temaLightbox->nama_tema }}
                            </p>
                            <div class="mt-0.5 flex flex-wrap items-center gap-2 text-xs text-white/80">
                                @if ($temaLightbox->adaDiskon())
                                    <span class="font-sans tabular-nums line-through text-white/50">{{ $temaLightbox->hargaAsliFormatted() }}</span>
                                    <span class="font-sans tabular-nums font-bold text-rose-300">{{ $temaLightbox->hargaFormatted() }}</span>
                                @else
                                    <span class="font-sans tabular-nums font-bold text-champagne">{{ $temaLightbox->hargaFormatted() }}</span>
                                @endif
                                <span class="text-white/40">&bull;</span>
                                <span>{{ $temaLightbox->tierLabel() }}</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
                            <a
                                href="{{ route('tema.demo', $modeKatalogClient ? ['slugTema' => $temaLightbox->slug, 'dari' => 'katalog'] : ['slugTema' => $temaLightbox->slug]) }}"
                                @if (! $modeKatalogClient) target="_blank" @endif
                                class="inline-flex items-center gap-1.5 rounded-xl bg-white/15 hover:bg-white/25 px-3 py-2 text-xs font-semibold text-white transition"
                            >
                                Pakai Foto
                            </a>
                            <a
                                href="{{ route('tema.demo', $modeKatalogClient ? ['slugTema' => $temaLightbox->slug, 'tf' => 1, 'dari' => 'katalog'] : ['slugTema' => $temaLightbox->slug, 'tf' => 1]) }}"
                                @if (! $modeKatalogClient) target="_blank" @endif
                                class="inline-flex items-center gap-1.5 rounded-xl bg-white/15 hover:bg-white/25 px-3 py-2 text-xs font-semibold text-white transition"
                            >
                                Tanpa Foto
                            </a>

                            @if ($modeKatalogClient)
                                @php
                                    $payloadPakaiLightbox = [
                                        'id' => $temaLightbox->id,
                                        'nama_tema' => $temaLightbox->nama_tema,
                                        'kategori' => $temaLightbox->kategoriLabel(),
                                        'tier' => $temaLightbox->tierLabel(),
                                        'harga' => $temaLightbox->hargaFormatted(),
                                        'harga_asli' => $temaLightbox->adaDiskon() ? $temaLightbox->hargaAsliFormatted() : null,
                                        'badge_diskon' => $temaLightbox->labelBadgeDiskon(),
                                        'gambar_url' => $temaLightbox->urlGambarPratinjau(),
                                    ];
                                @endphp
                                <button
                                    type="button"
                                    @click="tutupLightboxSampul(); bukaModalPakai(@js($payloadPakaiLightbox))"
                                    class="inline-flex items-center justify-center rounded-xl bg-sage hover:bg-sage/90 px-3.5 py-2 text-xs font-semibold text-white shadow-sm transition cursor-pointer"
                                >
                                    Pakai Tema Ini
                                </button>
                            @else
                                <a
                                    href="{{ auth()->check() ? route('dasbor.katalog', ['pakai' => $temaLightbox->id]) : route('daftar', ['tema' => $temaLightbox->id]) }}"
                                    class="inline-flex items-center justify-center rounded-xl bg-sage hover:bg-sage/90 px-3.5 py-2 text-xs font-semibold text-white shadow-sm transition"
                                >
                                    Pakai Tema Ini
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </template>
        @endforeach
    </div>
</div>
