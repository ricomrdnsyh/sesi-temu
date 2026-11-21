{{-- BAGIAN 3: PROFIL KEDUA MEMPELAI — 9 ARSITEKTUR UNIK PER TEMA + ORNAMEN 3-LAPIS BERAYUN --}}
<section
    data-aos="fade-up"
    data-aos-duration="950"
    data-layout-mempelai="{{ $gayaTataLetak }}"
    class="relative py-12 px-5 overflow-hidden"
>
    @if ($gayaTataLetak === 'keraton')
        {{-- ADAT JAWA KERATON: Kapsul Raksasa Berbingkai Emas (rounded-[500px]) + Potret Oval 3-Lapis Gunungan & Flora --}}
        <div class="relative mx-auto max-w-[390px] rounded-[500px] bg-[#FCF7EB]/92 backdrop-blur-md border-2 border-[#D7BB83] px-6 py-14 text-center text-[#332012] shadow-2xl overflow-hidden kartu-3d">
            <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 top-0 h-20 opacity-20" style="background-image: url(&quot;{{ $polaDataUri }}&quot;);"></div>
            <div aria-hidden="true" class="pointer-events-none absolute inset-x-0 bottom-0 h-20 opacity-20" style="background-image: url(&quot;{{ $polaDataUri }}&quot;);"></div>

            <div class="relative z-10 space-y-6">
                @if ($ornamenUrl)
                    <img src="{{ $ornamenUrl }}" alt="" class="fx-rise-down w-16 mx-auto drop-shadow-md animasi-ayun-3d">
                @endif

                <div class="space-y-2">
                    <h2 class="fx-rise font-kaligrafi text-4xl leading-tight text-[#8C6823]">We Are Getting Married!</h2>
                    <p class="text-xs opacity-75 leading-relaxed px-2">
                        Dengan memohon rahmat dan ridho-Nya, kami bermaksud menyelenggarakan pawiwahan putra-putri kami:
                    </p>
                </div>

                {{-- Mempelai Pria (3-Lapis: Gunungan Belakang + Potret Oval + Ornamen Depan Berayun) --}}
                <div class="space-y-3 pt-2">
                    <div class="relative mx-auto w-fit py-2">
                        @if ($ornamenUrl)
                            <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none absolute -top-3 -right-9 w-20 opacity-55 z-0 ayun-kanan">
                        @endif
                        @if (! $tanpaFoto && $undangan->urlFotoPria())
                            <img
                                src="{{ $undangan->urlFotoPria() }}"
                                alt="{{ $undangan->nama_lengkap_pria }}"
                                class="fx-scale-out relative z-10 mx-auto w-40 h-56 rounded-full object-cover object-top border-2 border-[#D7BB83] shadow-xl"
                            >
                        @else
                            <div class="fx-scale-out relative z-10 mx-auto w-32 h-44 rounded-full border-2 border-[#D7BB83] bg-[#472A1C] text-[#F3E5AB] flex items-center justify-center shadow-xl">
                                <span class="font-serif text-4xl font-bold">{{ $undangan->inisialPria() }}</span>
                            </div>
                        @endif
                        @if ($ornamenUrl)
                            <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none absolute -bottom-4 -left-7 w-16 opacity-90 z-20 drop-shadow-lg ayun-kiri">
                        @endif
                    </div>

                    <div class="fx-rise pt-2">
                        <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#8C6823]">Mempelai Pria</p>
                        <p class="mt-1 font-kaligrafi text-3xl text-[#7A1E24]">{{ $undangan->nama_panggilan_pria }}</p>
                        <h3 class="mt-0.5 font-serif text-xl font-bold text-[#332012]">{{ $undangan->nama_lengkap_pria }}</h3>
                        @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                            <p class="mt-1 text-xs opacity-75">{{ $labelPutra }} {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}</p>
                        @endif
                    </div>
                </div>

                <div class="fx-scale-in font-kaligrafi text-5xl text-[#B89246] py-1">&amp;</div>

                {{-- Mempelai Wanita (3-Lapis Berlawanan Arah) --}}
                <div class="space-y-3 pb-2">
                    <div class="relative mx-auto w-fit py-2">
                        @if ($ornamenUrl)
                            <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none absolute -top-3 -left-9 w-20 opacity-55 z-0 ayun-kiri">
                        @endif
                        @if (! $tanpaFoto && $undangan->urlFotoWanita())
                            <img
                                src="{{ $undangan->urlFotoWanita() }}"
                                alt="{{ $undangan->nama_lengkap_wanita }}"
                                class="fx-scale-out relative z-10 mx-auto w-40 h-56 rounded-full object-cover object-top border-2 border-[#D7BB83] shadow-xl"
                            >
                        @else
                            <div class="fx-scale-out relative z-10 mx-auto w-32 h-44 rounded-full border-2 border-[#D7BB83] bg-[#472A1C] text-[#F3E5AB] flex items-center justify-center shadow-xl">
                                <span class="font-serif text-4xl font-bold">{{ $undangan->inisialWanita() }}</span>
                            </div>
                        @endif
                        @if ($ornamenUrl)
                            <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none absolute -bottom-4 -right-7 w-16 opacity-90 z-20 drop-shadow-lg ayun-kanan">
                        @endif
                    </div>

                    <div class="fx-rise pt-2">
                        <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#8C6823]">Mempelai Wanita</p>
                        <p class="mt-1 font-kaligrafi text-3xl text-[#7A1E24]">{{ $undangan->nama_panggilan_wanita }}</p>
                        <h3 class="mt-0.5 font-serif text-xl font-bold text-[#332012]">{{ $undangan->nama_lengkap_wanita }}</h3>
                        @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                            <p class="mt-1 text-xs opacity-75">{{ $labelPutri }} {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @elseif ($gayaTataLetak === 'priangan')
        {{-- SUNDA SIGER HERITAGE: Paviliun Kembar Berdampingan Bermahkota Siger + Awan Mega Mendung --}}
        <div class="space-y-6">
            <div class="text-center space-y-2">
                @if ($ornamenUrl)
                    <img src="{{ $ornamenUrl }}" alt="" class="fx-rise-down w-16 mx-auto drop-shadow animasi-ayun-3d">
                @endif
                <h2 class="fx-rise font-kaligrafi text-4xl sm:text-[2.6rem] leading-tight text-[#6E2C2C]">We Are Getting Married!</h2>
                <p class="text-xs opacity-75 max-w-sm mx-auto leading-relaxed">
                    Sampurasun, kalayan ngaharepkeun rahmat Allah SWT, kami ngulem Bapa/Ibu dina acara nikah putra-putri kami:
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3 relative items-stretch">
                {{-- Paviliun Kiri: Pria --}}
                <div class="fx-slide-left rounded-t-[5.5rem] rounded-b-2xl bg-[#FFFBF4]/95 border-2 border-[#C59B43]/55 px-3 pt-7 pb-5 text-center shadow-lg flex flex-col justify-between kartu-3d">
                    <div>
                        <div class="relative mx-auto w-fit">
                            @if (! $tanpaFoto && $undangan->urlFotoPria())
                                <img src="{{ $undangan->urlFotoPria() }}" alt="{{ $undangan->nama_lengkap_pria }}" class="mx-auto w-24 h-32 rounded-t-full rounded-b-xl object-cover object-top ring-2 ring-[#C59B43] shadow-md">
                            @else
                                <div class="mx-auto w-24 h-32 rounded-t-full rounded-b-xl border-2 border-[#C59B43] bg-[#6E2C2C] text-[#FAF4E8] flex items-center justify-center">
                                    <span class="font-serif text-3xl font-bold">{{ $undangan->inisialPria() }}</span>
                                </div>
                            @endif
                        </div>
                        <p class="mt-3 text-[9px] font-bold uppercase tracking-[0.22em] text-[#B58931]">Panganten Pameget</p>
                        <p class="mt-0.5 font-kaligrafi text-2xl text-[#6E2C2C] leading-none">{{ $undangan->nama_panggilan_pria }}</p>
                        <h3 class="mt-1 font-serif text-base font-bold text-[#4A2020] leading-snug">{{ $undangan->nama_lengkap_pria }}</h3>
                    </div>
                    @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                        <p class="mt-2 pt-2 border-t border-[#C59B43]/30 text-[10px] opacity-75 leading-snug">{{ $labelPutra }} {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}</p>
                    @endif
                </div>

                {{-- Paviliun Kanan: Wanita --}}
                <div class="fx-slide-right rounded-t-[5.5rem] rounded-b-2xl bg-[#FFFBF4]/95 border-2 border-[#C59B43]/55 px-3 pt-7 pb-5 text-center shadow-lg flex flex-col justify-between kartu-3d">
                    <div>
                        <div class="relative mx-auto w-fit">
                            @if (! $tanpaFoto && $undangan->urlFotoWanita())
                                <img src="{{ $undangan->urlFotoWanita() }}" alt="{{ $undangan->nama_lengkap_wanita }}" class="mx-auto w-24 h-32 rounded-t-full rounded-b-xl object-cover object-top ring-2 ring-[#C59B43] shadow-md">
                            @else
                                <div class="mx-auto w-24 h-32 rounded-t-full rounded-b-xl border-2 border-[#C59B43] bg-[#6E2C2C] text-[#FAF4E8] flex items-center justify-center">
                                    <span class="font-serif text-3xl font-bold">{{ $undangan->inisialWanita() }}</span>
                                </div>
                            @endif
                        </div>
                        <p class="mt-3 text-[9px] font-bold uppercase tracking-[0.22em] text-[#B58931]">Panganten Istri</p>
                        <p class="mt-0.5 font-kaligrafi text-2xl text-[#6E2C2C] leading-none">{{ $undangan->nama_panggilan_wanita }}</p>
                        <h3 class="mt-1 font-serif text-base font-bold text-[#4A2020] leading-snug">{{ $undangan->nama_lengkap_wanita }}</h3>
                    </div>
                    @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                        <p class="mt-2 pt-2 border-t border-[#C59B43]/30 text-[10px] opacity-75 leading-snug">{{ $labelPutri }} {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}</p>
                    @endif
                </div>

                {{-- Medali Penghubung & di Tengah --}}
                <div aria-hidden="true" class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20 h-10 w-10 rounded-full bg-[#6E2C2C] text-[#F3E5AB] border-2 border-[#C59B43] shadow-lg flex items-center justify-center font-kaligrafi text-2xl">
                    &amp;
                </div>
            </div>
        </div>

    @elseif ($gayaTataLetak === 'editorial')
        {{-- EDITORIAL MONOKROM: Spread Majalah High-Fashion Asimetris Kiri/Kanan --}}
        <div class="space-y-8">
            <div class="border-b border-[#18181B]/20 pb-4 flex items-end justify-between gap-2">
                <div>
                    <p class="text-[10px] font-semibold uppercase tracking-[0.35em] text-[#52525B]">Feature &bull; Couple</p>
                    <h2 class="mt-1 font-serif text-2xl sm:text-3xl font-bold uppercase tracking-[0.12em] text-[#18181B]">
                        We Are Getting Married!
                    </h2>
                </div>
                <span class="font-serif text-xs uppercase tracking-[0.25em] text-[#52525B]">01—02</span>
            </div>

            {{-- 01 / The Groom (Foto Kiri, Tipografi Kanan) --}}
            <div class="fx-slide-left relative grid grid-cols-12 gap-4 items-center bg-white/95 border border-[#18181B]/20 p-4 kartu-3d masuk-3d">
                <span aria-hidden="true" class="pointer-events-none absolute top-2 right-3 font-serif text-5xl font-bold text-[#18181B]/[0.06] leading-none">01</span>
                <div class="col-span-5">
                    @if (! $tanpaFoto && $undangan->urlFotoPria())
                        <img src="{{ $undangan->urlFotoPria() }}" alt="{{ $undangan->nama_lengkap_pria }}" class="w-full aspect-[3/4] object-cover object-top grayscale hover:grayscale-0 transition duration-700 border border-[#18181B]/20">
                    @else
                        <div class="w-full aspect-[3/4] bg-[#18181B] text-[#FAF9F6] flex items-center justify-center font-serif text-4xl font-bold">{{ $undangan->inisialPria() }}</div>
                    @endif
                </div>
                <div class="col-span-7 text-left space-y-1.5">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.28em] text-[#52525B]">01 / The Groom</p>
                    <p class="font-serif text-2xl font-bold text-[#18181B] leading-tight">{{ $undangan->nama_panggilan_pria }}</p>
                    <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-[#18181B]/80">{{ $undangan->nama_lengkap_pria }}</h3>
                    @if ($undangan->nama_ayah_pria || $undangan->nama_ibu_pria)
                        <p class="pt-2 border-t border-[#18181B]/15 text-[11px] text-[#52525B] leading-relaxed">{{ $labelPutra }} {{ $undangan->nama_ayah_pria }} &amp; {{ $undangan->nama_ibu_pria }}</p>
                    @endif
                </div>
            </div>

            {{-- 02 / The Bride (Tipografi Kiri, Foto Kanan) --}}
            <div class="fx-slide-right relative grid grid-cols-12 gap-4 items-center bg-white/95 border border-[#18181B]/20 p-4 kartu-3d masuk-3d">
                <span aria-hidden="true" class="pointer-events-none absolute top-2 left-3 font-serif text-5xl font-bold text-[#18181B]/[0.06] leading-none">02</span>
                <div class="col-span-7 text-right space-y-1.5">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.28em] text-[#52525B]">02 / The Bride</p>
                    <p class="font-serif text-2xl font-bold text-[#18181B] leading-tight">{{ $undangan->nama_panggilan_wanita }}</p>
                    <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-[#18181B]/80">{{ $undangan->nama_lengkap_wanita }}</h3>
                    @if ($undangan->nama_ayah_wanita || $undangan->nama_ibu_wanita)
                        <p class="pt-2 border-t border-[#18181B]/15 text-[11px] text-[#52525B] leading-relaxed">{{ $labelPutri }} {{ $undangan->nama_ayah_wanita }} &amp; {{ $undangan->nama_ibu_wanita }}</p>
                    @endif
                </div>
                <div class="col-span-5">
                    @if (! $tanpaFoto && $undangan->urlFotoWanita())
                        <img src="{{ $undangan->urlFotoWanita() }}" alt="{{ $undangan->nama_lengkap_wanita }}" class="w-full aspect-[3/4] object-cover object-top grayscale hover:grayscale-0 transition duration-700 border border-[#18181B]/20">
                    @else
                        <div class="w-full aspect-[3/4] bg-[#18181B] text-[#FAF9F6] flex items-center justify-center font-serif text-4xl font-bold">{{ $undangan->inisialWanita() }}</div>
                    @endif
                </div>
            </div>
        </div>

    @elseif ($gayaTataLetak === 'artdeco')
        {{-- LUXURY NOIR: Bingkai Gala Art Deco Sudut Siku Emas + Cincin Orbit Monogram 3D --}}
        <div class="space-y-6">
            <div class="text-center space-y-2">
                <p class="text-[10px] font-semibold uppercase tracking-[0.38em] text-[#D4AF37]">The Grand Celebration</p>
                <h2 class="fx-rise font-kaligrafi text-4xl sm:text-[2.75rem] leading-tight text-[#F3E5AB]">We Are Getting Married!</h2>
                <p class="text-xs opacity-75 max-w-sm mx-auto leading-relaxed">
                    Dengan penuh sukacita, kami mengundang kehadiran Bapak/Ibu/Saudara/i pada perayaan pernikahan kami:
                </p>
            </div>

            @foreach ([
                ['peran' => 'The Groom', 'panggilan' => $undangan->nama_panggilan_pria, 'lengkap' => $undangan->nama_lengkap_pria, 'foto' => $undangan->urlFotoPria(), 'inisial' => $undangan->inisialPria(), 'labelOrtu' => $labelPutra, 'ayah' => $undangan->nama_ayah_pria, 'ibu' => $undangan->nama_ibu_pria, 'fx' => 'fx-flip-in'],
                ['peran' => 'The Bride', 'panggilan' => $undangan->nama_panggilan_wanita, 'lengkap' => $undangan->nama_lengkap_wanita, 'foto' => $undangan->urlFotoWanita(), 'inisial' => $undangan->inisialWanita(), 'labelOrtu' => $labelPutri, 'ayah' => $undangan->nama_ayah_wanita, 'ibu' => $undangan->nama_ibu_wanita, 'fx' => 'fx-flip-in'],
            ] as $idx => $m)
                <div class="{{ $m['fx'] }} relative rounded-2xl bg-[#111116]/92 backdrop-blur-md border border-[#D4AF37]/45 p-6 text-center shadow-2xl kartu-3d masuk-3d {{ $ekstraKartu }}">
                    {{-- Siku Art Deco 4 Sudut --}}
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 left-2.5 h-5 w-5 border-t-2 border-l-2 border-[#D4AF37]/80"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute top-2.5 right-2.5 h-5 w-5 border-t-2 border-r-2 border-[#D4AF37]/80"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 left-2.5 h-5 w-5 border-b-2 border-l-2 border-[#D4AF37]/80"></span>
                    <span aria-hidden="true" class="pointer-events-none absolute bottom-2.5 right-2.5 h-5 w-5 border-b-2 border-r-2 border-[#D4AF37]/80"></span>

                    <div class="mx-auto w-fit relative">
                        <span aria-hidden="true" class="pointer-events-none absolute -inset-3 rounded-full border border-dashed border-[#D4AF37]/55 animasi-orbit"></span>
                        <span aria-hidden="true" class="pointer-events-none absolute -inset-1.5 rounded-full border border-[#F3E5AB]/40 animasi-orbit-balik"></span>
                        @if (! $tanpaFoto && $m['foto'])
                            <img src="{{ $m['foto'] }}" alt="{{ $m['lengkap'] }}" class="relative z-10 w-36 h-36 rounded-full object-cover object-top ring-2 ring-[#D4AF37]">
                        @else
                            <div class="relative z-10 w-32 h-32 rounded-full border-2 border-[#D4AF37] bg-black/50 flex items-center justify-center font-serif text-4xl font-bold text-[#F3E5AB]">{{ $m['inisial'] }}</div>
                        @endif
                    </div>

                    <p class="mt-5 text-[10px] font-semibold uppercase tracking-[0.34em] text-[#D4AF37]">{{ $m['peran'] }}</p>
                    <p class="mt-1 font-kaligrafi text-3xl text-[#F3E5AB]">{{ $m['panggilan'] }}</p>
                    <h3 class="mt-1 font-serif text-xl font-bold text-white">{{ $m['lengkap'] }}</h3>
                    @if ($m['ayah'] || $m['ibu'])
                        <p class="mt-1.5 text-xs text-white/70">{{ $m['labelOrtu'] }} {{ $m['ayah'] }} &amp; {{ $m['ibu'] }}</p>
                    @endif
                </div>

                @if ($idx === 0)
                    <div class="mx-auto w-14 h-14 relative flex items-center justify-center fx-scale-in">
                        <span class="absolute inset-0 rotate-45 border border-[#D4AF37]/60 bg-[#0B0B0F]"></span>
                        <span class="relative z-10 font-kaligrafi text-3xl text-[#F3E5AB]">&amp;</span>
                    </div>
                @endif
            @endforeach
        </div>

    @elseif ($gayaTataLetak === 'taman')
        {{-- VELVET GARDEN MOTION: Kubah Rumah Kaca Botani (Conservatory Arch) + Daun Foreground 3D --}}
        <div class="space-y-6">
            <div class="text-center space-y-2">
                <h2 class="fx-rise font-kaligrafi text-4xl sm:text-[2.75rem] leading-tight text-[#F3DFA2]">We Are Getting Married!</h2>
                <p class="text-xs text-[#EEDAD4]/85 max-w-sm mx-auto leading-relaxed">
                    Di bawah naungan kasih &amp; keindahan taman, kami mengundang kehadiran Bapak/Ibu/Saudara/i:
                </p>
            </div>

            @foreach ([
                ['label' => 'Mempelai Pria', 'panggilan' => $undangan->nama_panggilan_pria, 'lengkap' => $undangan->nama_lengkap_pria, 'foto' => $undangan->urlFotoPria(), 'inisial' => $undangan->inisialPria(), 'labelOrtu' => $labelPutra, 'ayah' => $undangan->nama_ayah_pria, 'ibu' => $undangan->nama_ibu_pria, 'sisi' => 'kiri'],
                ['label' => 'Mempelai Wanita', 'panggilan' => $undangan->nama_panggilan_wanita, 'lengkap' => $undangan->nama_lengkap_wanita, 'foto' => $undangan->urlFotoWanita(), 'inisial' => $undangan->inisialWanita(), 'labelOrtu' => $labelPutri, 'ayah' => $undangan->nama_ayah_wanita, 'ibu' => $undangan->nama_ibu_wanita, 'sisi' => 'kanan'],
            ] as $idx => $m)
                <div class="fx-scale-in relative rounded-t-[10rem] rounded-b-3xl bg-[#FDFBF7]/92 backdrop-blur-md border-2 border-[#C8A464]/55 px-6 pt-9 pb-7 text-center text-[#1F3431] shadow-2xl overflow-hidden kartu-3d masuk-3d {{ $ekstraKartu }}">
                    @if ($ornamenUrl)
                        <img src="{{ $ornamenUrl }}" alt="" class="pointer-events-none absolute -bottom-5 {{ $m['sisi'] === 'kiri' ? '-left-6 ayun-kanan' : '-right-6 ayun-kiri' }} w-24 opacity-80 z-20 drop-shadow">
                    @endif
                    <div class="relative mx-auto w-fit">
                        <span aria-hidden="true" class="pointer-events-none absolute -inset-2 rounded-t-full rounded-b-3xl border border-dashed border-[#C8A464]/70 animasi-kilau"></span>
                        @if (! $tanpaFoto && $m['foto'])
                            <img src="{{ $m['foto'] }}" alt="{{ $m['lengkap'] }}" class="relative z-10 w-36 h-48 rounded-t-full rounded-b-3xl object-cover object-top ring-4 ring-[#C8A464]/35 shadow-lg">
                        @else
                            <div class="relative z-10 w-32 h-44 rounded-t-full rounded-b-3xl border-2 border-[#C8A464] bg-[#1D3532] text-[#F3DFA2] flex items-center justify-center font-serif text-4xl font-bold">{{ $m['inisial'] }}</div>
                        @endif
                    </div>

                    <span class="mt-4 inline-block rounded-full bg-[#1D3532]/10 px-3 py-0.5 text-[10px] font-bold uppercase tracking-[0.25em] text-[#1D3532]">{{ $m['label'] }}</span>
                    <p class="mt-1.5 font-kaligrafi text-3xl sm:text-4xl text-[#9E7E41] leading-none">{{ $m['panggilan'] }}</p>
                    <h3 class="mt-1 font-serif text-xl font-bold">{{ $m['lengkap'] }}</h3>
                    @if ($m['ayah'] || $m['ibu'])
                        <p class="mt-1.5 text-xs opacity-75">{{ $m['labelOrtu'] }} {{ $m['ayah'] }} &amp; {{ $m['ibu'] }}</p>
                    @endif
                </div>

                @if ($idx === 0)
                    <div class="text-center font-kaligrafi text-4xl text-[#F3DFA2] fx-scale-in">&amp;</div>
                @endif
            @endforeach
        </div>

    @elseif ($gayaTataLetak === 'celestial')
        {{-- ISLAMIC HEAVENLY: Kubah Mihrab Malam Bercahaya + Bintang 8-Sudut --}}
        <div class="space-y-6">
            <div class="text-center space-y-2">
                <p class="text-base text-[#F3E5AB]" style="font-family: 'Amiri', serif;">بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ</p>
                <h2 class="fx-rise font-kaligrafi text-4xl sm:text-[2.75rem] leading-tight text-[#D9B664]">We Are Getting Married!</h2>
                <p class="text-xs text-[#E6EEF8]/80 max-w-sm mx-auto leading-relaxed">
                    Maha Suci Allah yang telah menciptakan makhluk-Nya berpasang-pasangan. Perkenankan kami menikahkan putra-putri kami:
                </p>
            </div>

            @foreach ([
                ['label' => 'Mempelai Pria', 'panggilan' => $undangan->nama_panggilan_pria, 'lengkap' => $undangan->nama_lengkap_pria, 'foto' => $undangan->urlFotoPria(), 'inisial' => $undangan->inisialPria(), 'labelOrtu' => $labelPutra, 'ayah' => $undangan->nama_ayah_pria, 'ibu' => $undangan->nama_ibu_pria],
                ['label' => 'Mempelai Wanita', 'panggilan' => $undangan->nama_panggilan_wanita, 'lengkap' => $undangan->nama_lengkap_wanita, 'foto' => $undangan->urlFotoWanita(), 'inisial' => $undangan->inisialWanita(), 'labelOrtu' => $labelPutri, 'ayah' => $undangan->nama_ayah_wanita, 'ibu' => $undangan->nama_ibu_wanita],
            ] as $idx => $m)
                <div class="fx-rise relative rounded-t-[11rem] rounded-b-3xl bg-[#112236]/92 backdrop-blur-md border border-[#D9B664]/50 px-6 pt-10 pb-7 text-center text-[#E6EEF8] shadow-2xl kartu-3d masuk-3d {{ $ekstraKartu }}">
                    <div aria-hidden="true" class="pointer-events-none absolute top-3 left-1/2 -translate-x-1/2 text-[#D9B664]/80">
                        <svg class="w-6 h-6 animasi-orbit" style="animation-duration: 32s;" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.3">
                            <rect x="7" y="7" width="18" height="18"/>
                            <rect x="7" y="7" width="18" height="18" transform="rotate(45 16 16)"/>
                        </svg>
                    </div>

                    <div class="mx-auto w-fit relative mt-2">
                        <span aria-hidden="true" class="pointer-events-none absolute -inset-2 rounded-t-full rounded-b-3xl border border-dashed border-[#D9B664]/60 animasi-kilau"></span>
                        @if (! $tanpaFoto && $m['foto'])
                            <img src="{{ $m['foto'] }}" alt="{{ $m['lengkap'] }}" class="relative z-10 w-36 h-48 rounded-t-full rounded-b-3xl object-cover object-top ring-2 ring-[#D9B664]/70">
                        @else
                            <div class="relative z-10 w-30 h-40 rounded-t-full rounded-b-3xl border-2 border-[#D9B664]/65 bg-[#091322] text-[#F3E5AB] flex items-center justify-center font-serif text-4xl font-bold">{{ $m['inisial'] }}</div>
                        @endif
                    </div>

                    <p class="mt-4 text-[10px] font-semibold uppercase tracking-[0.3em] text-[#D9B664]">{{ $m['label'] }}</p>
                    <p class="mt-1 font-kaligrafi text-3xl text-[#F3E5AB]">{{ $m['panggilan'] }}</p>
                    <h3 class="mt-1 font-serif text-xl font-bold text-white">{{ $m['lengkap'] }}</h3>
                    @if ($m['ayah'] || $m['ibu'])
                        <p class="mt-1.5 text-xs text-[#E6EEF8]/75">{{ $m['labelOrtu'] }} {{ $m['ayah'] }} &amp; {{ $m['ibu'] }}</p>
                    @endif
                </div>

                @if ($idx === 0)
                    <div class="flex items-center justify-center gap-3 fx-scale-in">
                        <span class="h-px w-12 bg-gradient-to-r from-transparent to-[#D9B664]/60"></span>
                        <span class="font-kaligrafi text-4xl text-[#D9B664]">&amp;</span>
                        <span class="h-px w-12 bg-gradient-to-l from-transparent to-[#D9B664]/60"></span>
                    </div>
                @endif
            @endforeach
        </div>

    @elseif ($gayaTataLetak === 'katedral')
        {{-- ROYAL IVORY CATHEDRAL: Surat Istana Katedral Ganda + Segel Lilin Monogram Tengah --}}
        <div class="space-y-5">
            <div class="text-center space-y-2">
                <p class="text-[10px] font-semibold uppercase tracking-[0.32em] text-[#9E7B4F]">The Royal Union</p>
                <h2 class="fx-rise font-kaligrafi text-4xl sm:text-[2.75rem] leading-tight text-[#7B603F]">We Are Getting Married!</h2>
                <p class="text-xs opacity-75 max-w-sm mx-auto leading-relaxed">
                    Dengan penuh kehormatan, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri hari bahagia kami:
                </p>
            </div>

            <div class="relative space-y-4">
                @foreach ([
                    ['label' => 'Mempelai Pria', 'panggilan' => $undangan->nama_panggilan_pria, 'lengkap' => $undangan->nama_lengkap_pria, 'foto' => $undangan->urlFotoPria(), 'inisial' => $undangan->inisialPria(), 'labelOrtu' => $labelPutra, 'ayah' => $undangan->nama_ayah_pria, 'ibu' => $undangan->nama_ibu_pria],
                    ['label' => 'Mempelai Wanita', 'panggilan' => $undangan->nama_panggilan_wanita, 'lengkap' => $undangan->nama_lengkap_wanita, 'foto' => $undangan->urlFotoWanita(), 'inisial' => $undangan->inisialWanita(), 'labelOrtu' => $labelPutri, 'ayah' => $undangan->nama_ayah_wanita, 'ibu' => $undangan->nama_ibu_wanita],
                ] as $idx => $m)
                    <div class="fx-rise rounded-3xl bg-white/95 border border-[#9E7B4F]/40 p-2 shadow-xl kartu-3d masuk-3d">
                        <div class="rounded-[1.25rem] border border-dashed border-[#9E7B4F]/40 px-5 py-7 text-center">
                            @if (! $tanpaFoto && $m['foto'])
                                <img src="{{ $m['foto'] }}" alt="{{ $m['lengkap'] }}" class="mx-auto w-36 h-48 rounded-t-full rounded-b-2xl object-cover object-top ring-4 ring-[#9E7B4F]/25 shadow-md">
                            @else
                                <div class="mx-auto w-28 h-36 rounded-t-full rounded-b-2xl border-2 border-[#9E7B4F]/45 bg-[#FBF8F3] text-[#7B603F] flex items-center justify-center font-serif text-4xl font-bold">{{ $m['inisial'] }}</div>
                            @endif
                            <p class="mt-4 text-[10px] font-semibold uppercase tracking-[0.28em] text-[#9E7B4F]">{{ $m['label'] }}</p>
                            <p class="mt-1 font-kaligrafi text-3xl text-[#7B603F]">{{ $m['panggilan'] }}</p>
                            <h3 class="mt-1 font-serif text-xl font-bold text-[#3B2E25]">{{ $m['lengkap'] }}</h3>
                            @if ($m['ayah'] || $m['ibu'])
                                <p class="mt-1.5 text-xs text-[#3B2E25]/70">{{ $m['labelOrtu'] }} {{ $m['ayah'] }} &amp; {{ $m['ibu'] }}</p>
                            @endif
                        </div>
                    </div>

                    @if ($idx === 0)
                        {{-- Segel Lilin Kerajaan --}}
                        <div class="flex justify-center -my-2 relative z-20 fx-scale-in">
                            <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-[#A68353] to-[#6E5332] text-[#FAF6EE] shadow-lg ring-4 ring-[#FBF8F3] font-serif text-sm font-bold tracking-widest animasi-segel">
                                {{ $undangan->inisialPria() }}&amp;{{ $undangan->inisialWanita() }}
                            </span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

    @elseif ($gayaTataLetak === 'mihrab')
        {{-- ISLAMI SYAR'I EMERALD: Bingkai Mihrab Zamrud Santun (Optimal Foto & Mode Tanpa Foto) --}}
        <div class="space-y-6">
            <div class="text-center space-y-2">
                <p class="text-base text-[#184D47]" style="font-family: 'Amiri', serif;">بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ</p>
                <h2 class="fx-rise font-kaligrafi text-4xl sm:text-[2.6rem] leading-tight text-[#184D47]">We Are Getting Married!</h2>
                <p class="text-xs opacity-75 max-w-sm mx-auto leading-relaxed">
                    Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud menyelenggarakan walimatul ursy putra-putri kami:
                </p>
            </div>

            <div class="rounded-t-[10.5rem] rounded-b-3xl bg-white/95 border-2 border-[#184D47]/20 px-6 pt-12 pb-8 text-center shadow-xl space-y-6 kartu-3d">
                @foreach ([
                    ['label' => 'Mempelai Pria', 'panggilan' => $undangan->nama_panggilan_pria, 'lengkap' => $undangan->nama_lengkap_pria, 'foto' => $undangan->urlFotoPria(), 'inisial' => $undangan->inisialPria(), 'labelOrtu' => $labelPutra, 'ayah' => $undangan->nama_ayah_pria, 'ibu' => $undangan->nama_ibu_pria],
                    ['label' => 'Mempelai Wanita', 'panggilan' => $undangan->nama_panggilan_wanita, 'lengkap' => $undangan->nama_lengkap_wanita, 'foto' => $undangan->urlFotoWanita(), 'inisial' => $undangan->inisialWanita(), 'labelOrtu' => $labelPutri, 'ayah' => $undangan->nama_ayah_wanita, 'ibu' => $undangan->nama_ibu_wanita],
                ] as $idx => $m)
                    <div class="fx-rise space-y-2">
                        @if (! $tanpaFoto && $m['foto'])
                            <img src="{{ $m['foto'] }}" alt="{{ $m['lengkap'] }}" class="mx-auto w-32 h-40 rounded-t-full rounded-b-2xl object-cover object-top ring-4 ring-[#184D47]/15">
                        @else
                            <div class="mx-auto w-24 h-28 rounded-t-full rounded-b-2xl border-2 border-[#BFA15F]/55 bg-[#F4FAF6] text-[#184D47] flex items-center justify-center font-serif text-3xl font-bold">{{ $m['inisial'] }}</div>
                        @endif
                        <p class="pt-1 text-[10px] font-bold uppercase tracking-[0.26em] text-[#9E7D40]">{{ $m['label'] }}</p>
                        <p class="font-kaligrafi text-3xl text-[#184D47] leading-none">{{ $m['panggilan'] }}</p>
                        <h3 class="font-serif text-xl font-bold text-[#184D47]">{{ $m['lengkap'] }}</h3>
                        @if ($m['ayah'] || $m['ibu'])
                            <p class="text-xs text-[#184D47]/75">{{ $m['labelOrtu'] }} {{ $m['ayah'] }} &amp; {{ $m['ibu'] }}</p>
                        @endif
                    </div>

                    @if ($idx === 0)
                        <div class="flex items-center justify-center gap-3">
                            <span class="h-px flex-1 bg-[#BFA15F]/35"></span>
                            <span class="font-kaligrafi text-3xl text-[#BFA15F]">&amp;</span>
                            <span class="h-px flex-1 bg-[#BFA15F]/35"></span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

    @else
        {{-- RUSTIC FLORAL (BASIC): Kartu Scrapbook Floral Hangat & Bersih --}}
        <div class="space-y-6">
            <div class="text-center space-y-2 pb-1">
                <h2 class="fx-rise font-kaligrafi text-4xl sm:text-[2.75rem] leading-tight {{ $kelasAksen }}">We Are Getting Married!</h2>
                <p class="text-xs opacity-75 max-w-sm mx-auto leading-relaxed">
                    Dengan memohon rahmat dan ridho-Nya, kami bermaksud menyelenggarakan akad serta resepsi pernikahan putra-putri kami:
                </p>
            </div>

            @foreach ([
                ['label' => 'Mempelai Pria', 'panggilan' => $undangan->nama_panggilan_pria, 'lengkap' => $undangan->nama_lengkap_pria, 'foto' => $undangan->urlFotoPria(), 'inisial' => $undangan->inisialPria(), 'labelOrtu' => $labelPutra, 'ayah' => $undangan->nama_ayah_pria, 'ibu' => $undangan->nama_ibu_pria],
                ['label' => 'Mempelai Wanita', 'panggilan' => $undangan->nama_panggilan_wanita, 'lengkap' => $undangan->nama_lengkap_wanita, 'foto' => $undangan->urlFotoWanita(), 'inisial' => $undangan->inisialWanita(), 'labelOrtu' => $labelPutri, 'ayah' => $undangan->nama_ayah_wanita, 'ibu' => $undangan->nama_ibu_wanita],
            ] as $idx => $m)
                <div class="fx-rise rounded-3xl p-6 text-center kartu-3d masuk-3d {{ $kelasKartu }}">
                    <div class="mx-auto w-fit relative p-1.5 rounded-full border border-dashed border-[#BFA15F]/65">
                        @if (! $tanpaFoto && $m['foto'])
                            <img src="{{ $m['foto'] }}" alt="{{ $m['lengkap'] }}" class="w-36 h-44 rounded-full object-cover object-top shadow-md">
                        @else
                            <div class="w-28 h-36 rounded-full bg-[#FDFBF7] border border-[#BFA15F]/40 flex items-center justify-center font-serif text-4xl font-bold {{ $aksenKartu }}">{{ $m['inisial'] }}</div>
                        @endif
                    </div>
                    <p class="mt-4 text-[10px] font-semibold uppercase tracking-[0.3em] {{ $aksenKartu }}">{{ $m['label'] }}</p>
                    <p class="mt-1 font-kaligrafi text-3xl sm:text-4xl leading-none {{ $aksenKartu }}">{{ $m['panggilan'] }}</p>
                    <h3 class="mt-1 font-serif text-xl sm:text-2xl font-bold">{{ $m['lengkap'] }}</h3>
                    @if ($m['ayah'] || $m['ibu'])
                        <p class="mt-1.5 text-xs opacity-75">{{ $m['labelOrtu'] }} {{ $m['ayah'] }} &amp; {{ $m['ibu'] }}</p>
                    @endif
                </div>

                @if ($idx === 0)
                    <div class="text-center font-kaligrafi text-4xl {{ $kelasAksen }} fx-scale-in">&amp;</div>
                @endif
            @endforeach
        </div>
    @endif
</section>
