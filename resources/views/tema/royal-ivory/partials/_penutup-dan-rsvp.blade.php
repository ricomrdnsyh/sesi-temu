{{-- SEKSI 9: AMPLOP DIGITAL ROYAL (BUKA-TUTUP KARTU BANK GLOSSY + SALIN ALAMAT) --}}
@if ($undangan->fiturAktif('amplop_digital') && ($undangan->daftarAmplop->isNotEmpty() || $alamatKado !== ''))
<section id="elegan-amplop" data-layout-amplop data-kartu-tumpuk x-data="{ amplopTerbuka: false }" class="royal-kartu-tumpuk relative bg-[#FBF8F3] px-4 py-12 overflow-hidden">
    <div class="max-w-md mx-auto rounded-3xl bg-white border border-[#9E7B4F]/55 p-2 shadow-xl kartu-3d">
        <div class="rounded-[1.25rem] border border-dashed border-[#9E7B4F]/45 px-5 py-7 text-center space-y-5">
            <div class="space-y-1.5">
                <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Tanda Kasih</p>
                <h2 data-gsap="naik" data-gsap-delay="0.05" class="font-serif text-3xl font-bold text-[#3B2E25]">{{ $undangan->teksKustom('judul_amplop', 'Amplop Digital') }}</h2>
                <p data-gsap="teks" data-gsap-delay="0.09" class="text-xs text-[#3B2E25]/76 leading-relaxed max-w-xs mx-auto">
                    {{ $undangan->teksKustom('pengantar_amplop', 'Doa restu dan kehadiran Bapak/Ibu/Saudara/i adalah kado terindah. Apabila berkenan memberikan tanda kasih, dapat melalui:') }}
                </p>
            </div>

            <div data-gsap="mekar" data-gsap-delay="0.10">
                <button
                    type="button"
                    @click="amplopTerbuka = !amplopTerbuka; window.SesiTemuSinema?.refresh(360)"
                    :aria-expanded="amplopTerbuka.toString()"
                    class="royal-tombol inline-flex items-center justify-center gap-2 rounded-full px-7 py-2.5 text-xs font-bold uppercase tracking-wider transition active:scale-95 cursor-pointer"
                >
                    <svg class="h-3.5 w-3.5 shrink-0 text-[#E5C99B]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                    </svg>
                    <span x-text="amplopTerbuka ? 'Tutup Amplop Digital' : 'Buka Amplop Digital'">Buka Amplop Digital</span>
                    <svg class="h-3.5 w-3.5 shrink-0 transition-transform duration-300" :class="amplopTerbuka ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </button>
            </div>

            <div
                x-show="amplopTerbuka"
                x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2 scale-[0.98]"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-y-2 scale-[0.98]"
                class="pt-2 space-y-4 text-left panggung-3d"
            >
                <div class="h-px w-full bg-gradient-to-r from-transparent via-[#9E7B4F]/40 to-transparent" aria-hidden="true"></div>

                @foreach ($undangan->daftarAmplop as $amplop)
                    @include('komponen-undangan.kartu-bank-amplop', ['amplop' => $amplop])
                @endforeach

                @if ($alamatKado !== '')
                    <div x-data="{ alamatTersalin: false }" class="rounded-2xl bg-[#FBF8F3] border border-[#9E7B4F]/45 p-4 text-center space-y-2">
                        <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#9E7B4F]">Alamat Pengiriman Kado</p>
                        <p class="text-xs text-[#3B2E25]/85 leading-relaxed">{{ $alamatKado }}</p>
                        <button
                            type="button"
                            @click="navigator.clipboard?.writeText(@js($alamatKado)); alamatTersalin = true; setTimeout(() => alamatTersalin = false, 2200)"
                            class="royal-tombol inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-[11px] font-semibold transition active:scale-95 cursor-pointer"
                        >
                            <span x-show="!alamatTersalin">Salin Alamat</span>
                            <span x-show="alamatTersalin" x-cloak>Alamat Tersalin!</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

{{-- SEKSI 10: BUKU TAMU — UCAPAN & RSVP --}}
<section id="buku-tamu" data-kartu-tumpuk class="royal-kartu-tumpuk relative bg-[#EFE7DA] px-4 py-13 border-b border-[#9E7B4F]/25 overflow-hidden">
    <div class="max-w-md mx-auto">
        <div class="text-center space-y-2 mb-6">
            <img src="{{ $asetRoyal['katedral'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" data-gsap="turun" class="w-11 mx-auto opacity-90">
            <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Buku Tamu Kehormatan</p>
            <h2 data-gsap="mekar" data-gsap-delay="0.05" class="font-serif text-3xl font-bold text-[#3B2E25]">{{ $undangan->teksKustom('judul_buku_tamu', 'RSVP & Wishes') }}</h2>
            <p data-gsap="teks" data-gsap-delay="0.08" class="text-xs text-[#3B2E25]/76 max-w-xs mx-auto leading-relaxed">
                Kami mempersilakan Bapak/Ibu/Saudara/i menyampaikan ucapan selamat, doa terbaik, serta konfirmasi kehadiran.
            </p>
        </div>

        <div data-gsap="naik" class="rounded-3xl bg-white border border-[#9E7B4F]/50 p-6 shadow-xl space-y-5 kartu-3d">
            @if (session('sukses_ucapan'))
                <div data-swal-success="{{ session('sukses_ucapan') }}" hidden aria-hidden="true"></div>
            @endif

            @if ($errors->any())
                <div data-swal-errors="{{ json_encode($errors->all(), JSON_UNESCAPED_UNICODE) }}" hidden aria-hidden="true"></div>
            @endif

            @if (! empty($modeDemo))
                <div x-data="bukuTamuDemo(@js($daftarUcapanAwal), @js($namaTamu))" class="space-y-5">
                    <form @submit.prevent="kirimUcapanDemo()" class="space-y-3.5 text-left">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#58432B]/80">Nama Tamu</label>
                            <input type="text" x-model="namaTamu" required placeholder="Masukkan nama Anda" class="mt-1 w-full rounded-xl border border-[#9E7B4F]/45 bg-[#FBF8F3] px-3.5 py-2.5 text-sm">
                        </div>
                        <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#58432B]/80">Kehadiran</label>
                                <select x-ref="selectKehadiran" x-model="statusKehadiran" @change="statusKehadiran = $event.target.value" class="mt-1 w-full rounded-xl border border-[#9E7B4F]/45 bg-[#FBF8F3] px-3 py-2.5 text-sm">
                                    <option value="hadir">Hadir</option>
                                    <option value="ragu">Masih Ragu</option>
                                    <option value="tidak_hadir">Berhalangan</option>
                                </select>
                            </div>
                            <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#58432B]/80">Jumlah</label>
                                <input type="number" x-model.number="jumlahTamu" min="1" max="20" :required="statusKehadiran === 'hadir'" :disabled="statusKehadiran !== 'hadir'" class="mt-1 w-full rounded-xl border border-[#9E7B4F]/45 bg-[#FBF8F3] px-3.5 py-2.5 text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#58432B]/80">Ucapan &amp; Doa</label>
                            <textarea x-model="ucapanDoa" rows="3" required placeholder="Tuliskan ucapan &amp; doa terbaik untuk kedua mempelai..." class="mt-1 w-full rounded-xl border border-[#9E7B4F]/45 bg-[#FBF8F3] px-3.5 py-2.5 text-sm"></textarea>
                        </div>
                        <button type="submit" class="royal-tombol w-full rounded-full py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer">
                            Kirim Konfirmasi &amp; Doa
                        </button>
                        <p x-show="pesanGalat" x-cloak x-text="pesanGalat" class="text-xs font-semibold text-rose-700 text-center"></p>
                        <p x-show="pesanSukses" x-cloak x-text="pesanSukses" class="rounded-xl bg-emerald-50 border border-emerald-200 px-3 py-2 text-[11px] font-semibold text-emerald-800 text-center"></p>
                    </form>

                    <div class="pt-4 border-t border-[#9E7B4F]/30 space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <h3 class="font-serif text-base font-bold text-[#3B2E25]">
                                Doa &amp; Ucapan (<span x-text="daftarUcapan.length">{{ count($daftarUcapanAwal) }}</span>)
                            </h3>
                            <span class="text-[10px] uppercase tracking-wider text-[#9E7B4F]">Gulir untuk lainnya</span>
                        </div>
                        <div x-ref="daftarUcapanScroll" data-lenis-prevent class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                            <template x-for="ucapan in daftarUcapan" :key="ucapan.id">
                                <div
                                    class="rounded-2xl bg-[#FBF8F3] border p-3.5 space-y-1.5 transition"
                                    :class="ucapan.baru ? 'border-[#7B603F]/65 ring-1 ring-[#9E7B4F]/30' : 'border-[#9E7B4F]/25'"
                                >
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-bold text-xs text-[#3B2E25]" x-text="ucapan.nama_tamu"></p>
                                        <span class="shrink-0 rounded-full px-2.5 py-0.5 text-[10px] font-semibold" :class="kelasStatus(ucapan.status_kehadiran, false, 'bg-[#9E7B4F]/15 text-[#7B603F]')" x-text="labelStatus(ucapan.status_kehadiran)"></span>
                                    </div>
                                    <p class="text-xs text-[#3B2E25]/80 leading-relaxed" x-text="ucapan.ucapan_doa"></p>
                                    <p class="text-[10px] text-[#9E7B4F]/80" x-text="ucapan.waktu"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            @else
                @if (! empty($modePratinjau) || ! $undangan->sudahAktifPublik())
                    <div class="rounded-2xl bg-[#FBF8F3] border border-[#9E7B4F]/40 px-4 py-3 text-center text-xs font-semibold text-[#58432B]">
                        Mode Pratinjau — Buku Tamu &amp; RSVP Dikunci
                    </div>
                @else
                    <form x-data="{ statusKehadiran: @js(old('status_kehadiran', 'hadir')) }" method="POST" action="{{ route('undangan.ucapan', $undangan->slug) }}" class="space-y-3.5 text-left">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#58432B]/80">Nama Tamu</label>
                            <input type="text" name="nama_tamu" value="{{ old('nama_tamu', $namaTamu !== 'Tamu Undangan' ? $namaTamu : '') }}" required class="mt-1 w-full rounded-xl border border-[#9E7B4F]/45 bg-[#FBF8F3] px-3.5 py-2.5 text-sm">
                        </div>
                        <div class="grid gap-3" :class="statusKehadiran === 'hadir' ? 'grid-cols-2' : 'grid-cols-1'">
                            <div>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#58432B]/80">Kehadiran</label>
                                <select name="status_kehadiran" x-model="statusKehadiran" @change="statusKehadiran = $event.target.value" class="mt-1 w-full rounded-xl border border-[#9E7B4F]/45 bg-[#FBF8F3] px-3 py-2.5 text-sm">
                                    <option value="hadir" @selected(old('status_kehadiran', 'hadir') === 'hadir')>Hadir</option>
                                    <option value="ragu" @selected(old('status_kehadiran') === 'ragu')>Masih Ragu</option>
                                    <option value="tidak_hadir" @selected(old('status_kehadiran') === 'tidak_hadir')>Berhalangan</option>
                                </select>
                            </div>
                            <div x-show="statusKehadiran === 'hadir'" x-cloak>
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-[#58432B]/80">Jumlah</label>
                                <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}" min="1" max="20" :required="statusKehadiran === 'hadir'" :disabled="statusKehadiran !== 'hadir'" class="mt-1 w-full rounded-xl border border-[#9E7B4F]/45 bg-[#FBF8F3] px-3.5 py-2.5 text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-[#58432B]/80">Ucapan &amp; Doa</label>
                            <textarea name="ucapan_doa" rows="3" required placeholder="Tuliskan ucapan &amp; doa terbaik untuk kedua mempelai..." class="mt-1 w-full rounded-xl border border-[#9E7B4F]/45 bg-[#FBF8F3] px-3.5 py-2.5 text-sm">{{ old('ucapan_doa') }}</textarea>
                        </div>
                        <button type="submit" class="royal-tombol w-full rounded-full py-3 text-xs font-bold uppercase tracking-wider transition cursor-pointer">
                            Kirim Konfirmasi &amp; Doa
                        </button>
                    </form>
                @endif

                <div class="pt-4 border-t border-[#9E7B4F]/30 space-y-3">
                    <h3 class="font-serif text-base font-bold text-[#3B2E25]">Doa &amp; Ucapan ({{ $undangan->bukuTamu->count() }})</h3>
                    <div data-lenis-prevent class="buku-tamu-scroll max-h-80 overflow-y-auto pr-1.5 space-y-2.5">
                        @forelse ($undangan->bukuTamu as $ucapan)
                            <div class="rounded-2xl bg-[#FBF8F3] border border-[#9E7B4F]/25 p-3.5 space-y-1">
                                <div class="flex items-center justify-between gap-2">
                                    <p class="font-bold text-xs text-[#3B2E25]">{{ $ucapan->nama_tamu }}</p>
                                    <span class="rounded-full bg-[#9E7B4F]/15 px-2.5 py-0.5 text-[10px] font-semibold text-[#7B603F]">
                                        {{ str_replace('_', ' ', ucfirst($ucapan->status_kehadiran)) }}
                                    </span>
                                </div>
                                <p class="text-xs text-[#3B2E25]/80 leading-relaxed">{{ $ucapan->ucapan_doa }}</p>
                            </div>
                        @empty
                            <p class="text-xs text-[#3B2E25]/60 text-center">Jadilah yang pertama memberikan doa restu.</p>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- SEKSI 11: DOA UNTUK PENGANTIN & TURUT MENGUNDANG (URUTAN SERAGAM SEMUA KATEGORI) --}}
@if ($undangan->fiturAktif('doa_pengantin') || $adaTurutMengundang)
<section data-kartu-tumpuk class="royal-kartu-tumpuk relative bg-[#FBF8F3] px-4 py-12 space-y-6 overflow-hidden">
    {{-- Kartu Doa Untuk Pengantin --}}
    @if ($undangan->fiturAktif('doa_pengantin'))
        @php
            $doaPengantin = $undangan->doaPengantin([
                'arab' => '',
                'latin' => 'Semoga Tuhan Yang Maha Esa senantiasa melimpahkan kasih, ketenteraman, dan keberkahan bagi kedua mempelai dalam mengarungi bahtera rumah tangga.',
                'isi' => 'Kiranya pernikahan ini menjadi ikatan yang harmonis, penuh rasa syukur, serta senantiasa diberkahi dalam suka maupun duka hingga akhir hayat.',
            ]);
        @endphp
        <div data-section-doa-pengantin="katedral" class="max-w-md mx-auto rounded-3xl bg-white border border-[#9E7B4F]/55 p-2 shadow-lg kartu-3d">
            <div class="rounded-[1.25rem] border border-dashed border-[#9E7B4F]/45 px-6 py-7 text-center space-y-3.5">
                <img data-gsap="turun" src="{{ $asetRoyal['katedral'] }}" alt="" aria-hidden="true" loading="lazy" decoding="async" class="w-10 mx-auto opacity-90">
                <p data-gsap="mekar" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Untaian Doa Restu</p>
                <h2 data-gsap="naik" class="font-serif text-2xl font-bold text-[#3B2E25]">{{ $doaPengantin['judul'] }}</h2>
                @if ($doaPengantin['arab'] !== '')
                    <p data-gsap="mekar" data-gsap-delay="0.05" class="text-xl leading-loose text-[#3B2E25]" style="font-family: 'Amiri', serif;" dir="rtl">
                        {{ $doaPengantin['arab'] }}
                    </p>
                @endif
                @if ($doaPengantin['latin'] !== '')
                    <p data-gsap="teks" data-gsap-delay="0.06" class="font-serif italic text-sm sm:text-[15px] text-[#58432B] leading-relaxed max-w-xs mx-auto">
                        &ldquo;{{ $doaPengantin['latin'] }}&rdquo;
                    </p>
                @endif
                <div data-gsap="garis" class="flex items-center justify-center gap-3 px-10" aria-hidden="true">
                    <span class="h-px flex-1 bg-[#9E7B4F]/45"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-[#9E7B4F]"></span>
                    <span class="h-px flex-1 bg-[#9E7B4F]/45"></span>
                </div>
                <p data-gsap="teks" data-gsap-delay="0.10" class="text-xs text-[#3B2E25]/78 leading-relaxed max-w-xs mx-auto">
                    {{ $doaPengantin['isi'] }}
                </p>
            </div>
        </div>
    @endif

    {{-- Kartu Turut Mengundang --}}
    @if ($adaTurutMengundang)
        <div data-section-turut-mengundang="katedral" class="max-w-md mx-auto rounded-3xl bg-[#EFE7DA]/75 border border-[#9E7B4F]/45 p-6 text-center shadow-md kartu-3d space-y-4">
            <div class="space-y-1">
                <p data-gsap="turun" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#9E7B4F]">Keluarga Besar</p>
                <h2 data-gsap="naik" data-gsap-delay="0.05" class="font-serif text-2xl font-bold text-[#3B2E25]">{{ $undangan->teksKustom('judul_turut_mengundang', 'Turut Mengundang') }}</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 text-xs">
                @if (! empty($turutPria))
                    <div data-gsap="kiri" data-gsap-delay="0.08" class="rounded-2xl bg-[#FBF8F3] border border-[#9E7B4F]/35 p-3.5 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#7B603F] text-[10px] pb-1 border-b border-[#9E7B4F]/20">Pihak {{ $undangan->nama_panggilan_pria }}</p>
                        @foreach ($turutPria as $baris)
                            <p class="text-[#3B2E25]/85 leading-relaxed">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
                @if (! empty($turutWanita))
                    <div data-gsap="kanan" data-gsap-delay="0.10" class="rounded-2xl bg-[#FBF8F3] border border-[#9E7B4F]/35 p-3.5 space-y-1">
                        <p class="font-bold uppercase tracking-wider text-[#7B603F] text-[10px] pb-1 border-b border-[#9E7B4F]/20">Pihak {{ $undangan->nama_panggilan_wanita }}</p>
                        @foreach ($turutWanita as $baris)
                            <p class="text-[#3B2E25]/85 leading-relaxed">{{ $baris }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
</section>
@endif

{{-- SEKSI 12: KAPSUL PENUTUP ROYAL IVORY & FOOTER --}}
{{-- SEKSI 12: PENUTUP FULL-BLEED CINEMATIC CURTAIN-CALL POSTCARD & FOOTER --}}
<div data-kartu-tumpuk class="royal-kartu-tumpuk bg-[#2F241D]">
<section
    data-layout-penutup="katedral"
    data-penutup-sinematik-elegan="ivory"
    class="relative bg-gradient-to-b from-[#EFE7DA] via-[#DFD2BE] to-[#3B2E25] px-4 pt-9 pb-11 overflow-hidden"
>
    @if ($urlFotoPenutup)
        <article class="relative max-w-md mx-auto min-h-[520px] rounded-2xl overflow-hidden border border-[#C5A46D]/45 shadow-[0_26px_54px_-16px_rgba(35,27,21,0.72)] flex flex-col justify-between bg-[#261D17] kartu-3d">
            {{-- Foto Penutup Full-Bleed Bergradasi Senja Espresso-Sampanye --}}
            <img
                src="{{ $urlFotoPenutup }}"
                alt="Foto Penutup {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}"
                loading="lazy"
                decoding="async"
                class="pointer-events-none absolute inset-0 w-full h-full object-cover object-top"
            >
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0"
                style="background: linear-gradient(180deg, rgba(35,27,21,0.34) 0%, rgba(35,27,21,0.06) 34%, rgba(35,27,21,0.68) 64%, rgba(28,21,16,0.96) 100%);"
            ></div>

            {{-- Garis Bingkai Dalam Tipis 1px Khas Kartu Undangan Hotel Bintang Lima --}}
            <span aria-hidden="true" class="pointer-events-none absolute inset-3 rounded-xl border border-[#F3E5AB]/30 z-10"></span>

            {{-- Pita Monogram & Tanggal Melayang di Atas --}}
            <div data-gsap="turun" class="relative z-20 pt-6 px-6 flex items-center justify-between gap-2">
                <span class="inline-flex items-center gap-2 rounded-full bg-[#231B15]/65 backdrop-blur-md border border-[#E5C99B]/40 px-3 py-1 text-[9.5px] font-semibold uppercase tracking-[0.26em] text-[#FAF6EE]">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#E5C99B]"></span>
                    <span>{{ $undangan->inisialPria() }} &amp; {{ $undangan->inisialWanita() }}</span>
                </span>
                <span class="rounded-full bg-[#231B15]/65 backdrop-blur-md border border-[#E5C99B]/35 px-3 py-1 text-[9.5px] font-semibold uppercase tracking-[0.22em] text-[#E5C99B]">
                    {{ $tanggalTitik }}
                </span>
            </div>

            {{-- Panel Bawah Overlaid: Ucapan Terima Kasih & Tanda Tangan Pasangan --}}
            <div class="relative z-20 mt-auto pt-24 pb-7 px-6 text-center space-y-4 text-[#FAF6EE]">
                <div data-gsap="garis" class="flex items-center justify-center gap-3 px-6" aria-hidden="true">
                    <span class="h-px flex-1 bg-gradient-to-r from-transparent to-[#E5C99B]/65"></span>
                    <span class="w-1.5 h-1.5 rotate-45 bg-[#E5C99B]"></span>
                    <span class="h-px flex-1 bg-gradient-to-l from-transparent to-[#E5C99B]/65"></span>
                </div>

                <div class="space-y-1.5">
                    <p data-gsap="naik" class="text-[9.5px] font-bold uppercase tracking-[0.34em] text-[#E5C99B]">{{ $undangan->teksKustom('judul_penutup', 'Terima Kasih') }}</p>
                    <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-[13px] text-[#FAF6EE]/88 leading-relaxed max-w-xs mx-auto">
                        {{ $undangan->teksKustom('ucapan_penutup', 'Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir serta memberikan doa restu pada hari bahagia kami.') }}
                    </p>
                </div>

                <div class="pt-3 border-t border-[#E5C99B]/22 flex flex-col items-center space-y-1">
                    <p data-gsap="naik" data-gsap-delay="0.1" class="text-[9.5px] uppercase tracking-[0.28em] text-[#E5C99B]/85">{{ $undangan->teksKustom('label_penutup', 'Kami Yang Berbahagia') }}</p>
                    <p data-gsap="mekar" data-gsap-delay="0.13" class="font-kaligrafi text-[2.75rem] sm:text-5xl text-[#FAF6EE] leading-tight drop-shadow">
                        {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                    </p>
                    <p data-gsap="naik" data-gsap-delay="0.16" class="text-[10px] uppercase tracking-[0.24em] text-[#E5C99B]/90">
                        {{ $hashtagPasangan }}
                    </p>
                </div>
            </div>
        </article>
    @else
        {{-- Varian Tanpa Foto: Plakat Beludru Perunggu Persegi Panjang Modern --}}
        <article class="relative max-w-md mx-auto rounded-2xl bg-gradient-to-b from-[#3B2E25] via-[#2D221B] to-[#231B15] border border-[#E5C99B]/40 px-6 py-11 text-center shadow-2xl space-y-5 text-[#FAF6EE] kartu-3d">
            <span aria-hidden="true" class="pointer-events-none absolute inset-3 rounded-xl border border-[#E5C99B]/22"></span>
            <div data-gsap="potret" class="relative z-10 mx-auto w-20 h-20 rounded-full bg-[#9E7B4F]/25 border border-[#E5C99B]/65 shadow-lg flex items-center justify-center animasi-segel">
                <span class="font-serif text-lg font-bold tracking-widest text-[#FAF6EE]">{{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}</span>
            </div>
            <div class="relative z-10 space-y-2">
                <p data-gsap="mekar" class="text-[10px] font-bold uppercase tracking-[0.34em] text-[#E5C99B]">{{ $undangan->teksKustom('judul_penutup', 'Terima Kasih') }}</p>
                <p data-gsap="teks" data-gsap-delay="0.06" class="text-xs sm:text-sm text-[#FAF6EE]/85 leading-relaxed max-w-xs mx-auto">
                    {{ $undangan->teksKustom('ucapan_penutup', 'Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir serta memberikan doa restu pada hari bahagia kami.') }}
                </p>
            </div>
            <div class="relative z-10 pt-3 border-t border-[#E5C99B]/22 space-y-1">
                <p data-gsap="naik" data-gsap-delay="0.1" class="text-[9.5px] uppercase tracking-[0.28em] text-[#E5C99B]/80">{{ $undangan->teksKustom('label_penutup', 'Kami Yang Berbahagia') }}</p>
                <p data-gsap="mekar" data-gsap-delay="0.13" class="font-kaligrafi text-5xl text-[#FAF6EE] leading-tight">
                    {{ $undangan->nama_panggilan_pria }} &amp; {{ $undangan->nama_panggilan_wanita }}
                </p>
                <p data-gsap="naik" data-gsap-delay="0.16" class="text-[10.5px] uppercase tracking-[0.22em] text-[#E5C99B]">
                    {{ $hashtagPasangan }}
                </p>
            </div>
        </article>
    @endif
</section>

@include('komponen-undangan.footer-tema', [
    'gelap' => true,
    'warnaOrnamen' => '#E5C99B',
    'kelasLatar' => 'bg-gradient-to-b from-[#3B2E25] via-[#2F241D] to-[#231B15] border-t border-[#C5A46D]/40 pb-24',
    'kelasTeks' => 'text-[#FAF6EE]/85',
    'kelasAksen' => 'text-[#E5C99B]',
    'kelasTombol' => 'bg-[#FAF6EE]/10 text-[#E5C99B] border border-[#E5C99B]/40 hover:-translate-y-0.5 hover:bg-[#E5C99B] hover:text-[#3B2E25]',
])
</div>
