@props([
    'efekMotion' => 'kilau',
    'konteks' => 'panggung',
])

@if ($efekMotion === 'bintang')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden lapis-3d" style="--depth: 18px; --pz: 28px;">
        <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-80 h-80 rounded-full bg-[#D9B664]/16 blur-3xl"></div>
        <div class="absolute -top-24 left-[18%] w-36 h-[130%] bg-gradient-to-b from-[#F3E5AB]/14 via-[#F3E5AB]/4 to-transparent blur-xl animasi-sinar"></div>
        @foreach ([
            ['top: 10%; left: 16%;', 'w-2 h-2 bg-[#F3E5AB]', '0s'],
            ['top: 18%; right: 20%;', 'w-2.5 h-2.5 bg-[#D9B664]', '0.7s'],
            ['top: 28%; left: 42%;', 'w-1.5 h-1.5 bg-white', '1.4s'],
            ['top: 34%; right: 34%;', 'w-2 h-2 bg-[#F3E5AB]', '2.1s'],
            ['top: 46%; left: 22%;', 'w-1.5 h-1.5 bg-[#D9B664]', '0.4s'],
            ['top: 52%; right: 14%;', 'w-2 h-2 bg-white/90', '1.9s'],
            ['top: 64%; left: 62%;', 'w-1.5 h-1.5 bg-[#F3E5AB]', '2.8s'],
            ['top: 22%; left: 72%;', 'w-2 h-2 bg-[#D9B664]', '1.1s'],
            ['top: 74%; left: 28%;', 'w-1.5 h-1.5 bg-white/80', '0.5s'],
            ['top: 82%; right: 26%;', 'w-2 h-2 bg-[#F3E5AB]', '2.4s'],
        ] as [$posisi, $ukuran, $jeda])
            <span class="absolute rounded-full {{ $ukuran }} animasi-bintang shadow-[0_0_10px_rgba(243,229,171,0.9)]" style="{{ $posisi }} animation-delay: {{ $jeda }};"></span>
        @endforeach

        {{-- Bintang Jatuh Periodik --}}
        <span
            class="absolute top-[14%] right-[8%] w-28 h-[1.5px] rounded-full bg-gradient-to-r from-white via-[#F3E5AB] to-transparent animasi-bintang-jatuh"
            style="animation-delay: 1s;"
        ></span>
        @if ($konteks === 'panggung')
            <span
                class="absolute top-[30%] right-[28%] w-36 h-[1.5px] rounded-full bg-gradient-to-r from-[#F3E5AB] via-[#D9B664] to-transparent animasi-bintang-jatuh"
                style="animation-delay: 4.8s;"
            ></span>
        @endif
    </div>
@elseif ($efekMotion === 'kelopak-kunang')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden lapis-3d" style="--depth: 22px; --pz: 30px;">
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-72 h-72 rounded-full bg-[#C8A464]/14 blur-3xl"></div>
        <div class="absolute -top-16 right-[14%] w-32 h-[120%] bg-gradient-to-b from-[#F3DFA2]/12 via-transparent to-transparent blur-xl animasi-sinar"></div>
        @foreach ([
            ['left: 10%;', 'w-3.5 h-2.5 bg-[#EEDAD4]/75 rounded-tl-full rounded-br-full', '0s', '10.5s'],
            ['left: 26%;', 'w-3 h-2 bg-[#C8A464]/75 rounded-tl-full rounded-br-full', '2.1s', '12.2s'],
            ['left: 46%;', 'w-3.5 h-2.5 bg-[#EEDAD4]/65 rounded-tr-full rounded-bl-full', '3.8s', '11s'],
            ['left: 66%;', 'w-3 h-2 bg-[#C8A464]/70 rounded-tl-full rounded-br-full', '1.4s', '13s'],
            ['left: 84%;', 'w-3.5 h-2 bg-[#EEDAD4]/70 rounded-tr-full rounded-bl-full', '5.1s', '10.8s'],
        ] as [$posisi, $bentuk, $jeda, $durasi])
            <span class="absolute -top-6 {{ $bentuk }} animasi-kelopak-3d" style="{{ $posisi }} animation-delay: {{ $jeda }}; animation-duration: {{ $durasi }};"></span>
        @endforeach

        @foreach ([
            ['top: 22%; left: 18%;', 'w-2 h-2', '0s'],
            ['top: 38%; right: 20%;', 'w-2.5 h-2.5', '1.2s'],
            ['top: 54%; left: 32%;', 'w-2 h-2', '2.1s'],
            ['top: 66%; right: 34%;', 'w-1.5 h-1.5', '0.8s'],
            ['top: 78%; left: 22%;', 'w-2 h-2', '3.0s'],
            ['top: 30%; left: 66%;', 'w-2 h-2', '1.7s'],
        ] as [$posisi, $ukuran, $jeda])
            <span class="absolute rounded-full {{ $ukuran }} bg-[#F3DFA2] shadow-[0_0_12px_rgba(243,223,162,0.95)] animasi-kunang" style="{{ $posisi }} animation-delay: {{ $jeda }};"></span>
        @endforeach

        <span class="absolute top-[18%] left-[16%] w-3 h-3 rounded-full bg-[#EEDAD4]/55 blur-[1px] animasi-melayang"></span>
        <span class="absolute top-[42%] right-[22%] w-3.5 h-3.5 rounded-full bg-[#C8A464]/55 blur-[1px] animasi-melayang" style="animation-delay: 1.5s;"></span>
    </div>
@elseif ($efekMotion === 'debu-emas')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden lapis-3d" style="--depth: 20px; --pz: 26px;">
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-80 h-60 rounded-full bg-[#D4AF37]/14 blur-3xl"></div>
        <div class="absolute -top-20 left-[22%] w-40 h-[125%] bg-gradient-to-b from-[#F3E5AB]/14 via-[#D4AF37]/5 to-transparent blur-2xl animasi-sinar"></div>
        @foreach ([
            ['bottom: 12%; left: 14%;', 'w-1.5 h-1.5', '0s'],
            ['bottom: 24%; left: 28%;', 'w-2 h-2', '1.1s'],
            ['bottom: 18%; left: 46%;', 'w-1.5 h-1.5', '2.3s'],
            ['bottom: 30%; right: 28%;', 'w-2 h-2', '0.6s'],
            ['bottom: 15%; right: 16%;', 'w-1.5 h-1.5', '1.9s'],
            ['bottom: 42%; left: 34%;', 'w-1.5 h-1.5', '3.1s'],
            ['bottom: 48%; right: 22%;', 'w-2 h-2', '2.7s'],
            ['bottom: 8%; left: 62%;', 'w-1.5 h-1.5', '1.5s'],
        ] as [$posisi, $ukuran, $jeda])
            <span class="absolute rounded-full {{ $ukuran }} bg-[#F3E5AB] shadow-[0_0_10px_rgba(212,175,55,0.9)] animasi-debu-emas" style="{{ $posisi }} animation-delay: {{ $jeda }};"></span>
        @endforeach
    </div>
@elseif ($efekMotion === 'wayang-flora' || $efekMotion === 'melati' || $efekMotion === 'melati-burung')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden lapis-3d" style="--depth: 22px; --pz: 32px;">
        <div class="absolute -top-16 left-[18%] w-36 h-[120%] bg-gradient-to-b from-[#F7E5B7]/14 via-transparent to-transparent blur-xl animasi-sinar"></div>
        @foreach ([
            ['left: 12%;', $efekMotion === 'wayang-flora' ? 'w-3.5 h-2 bg-[#A3333D]/70 rounded-tl-full rounded-br-full' : 'w-3 h-2 bg-white/85 rounded-tl-full rounded-br-full', '0s', '10.5s'],
            ['left: 34%;', 'w-2.5 h-2 bg-[#E6C77E]/80 rounded-tr-full rounded-bl-full', '2.4s', '12.5s'],
            ['left: 58%;', $efekMotion === 'wayang-flora' ? 'w-3 h-2 bg-[#D4AF37]/75 rounded-tl-full rounded-br-full' : 'w-2.5 h-2 bg-[#F7F1E5]/90 rounded-tl-full rounded-br-full', '4.2s', '11.5s'],
            ['left: 78%;', 'w-3 h-2 bg-white/80 rounded-tr-full rounded-bl-full', '1.2s', '13s'],
            ['left: 90%;', 'w-2.5 h-2 bg-[#E6C77E]/75 rounded-tl-full rounded-br-full', '5.4s', '10.8s'],
        ] as [$posisi, $bentuk, $jeda, $durasi])
            <span class="absolute -top-6 {{ $bentuk }} animasi-kelopak-3d" style="{{ $posisi }} animation-delay: {{ $jeda }}; animation-duration: {{ $durasi }};"></span>
        @endforeach

        @if ($efekMotion === 'melati' || $efekMotion === 'melati-burung')
            <div class="absolute top-[16%] right-[12%] w-44 h-14 rounded-full bg-white/15 blur-xl animasi-awan"></div>
        @endif

        @if ($konteks === 'panggung' || $konteks === 'utama')
            {{-- Sepasang Burung Terbang Melintasi Langit Heritage --}}
            <div class="absolute top-[22%] left-0 animasi-burung text-[#F3E5AB]/75" style="animation-delay: 0.5s;">
                <svg class="w-8 h-5 animasi-kepak drop-shadow" viewBox="0 0 36 18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                    <path d="M2 12 Q10 2 18 10 Q26 2 34 12" />
                </svg>
            </div>
            <div class="absolute top-[28%] left-0 animasi-burung text-[#F3E5AB]/60" style="animation-delay: 4.5s; animation-duration: 21s;">
                <svg class="w-6 h-4 animasi-kepak drop-shadow" viewBox="0 0 36 18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
                    <path d="M2 12 Q10 2 18 10 Q26 2 34 12" />
                </svg>
            </div>
        @endif
    </div>
@elseif ($efekMotion === 'katedral-cahaya' || $efekMotion === 'zaitun-kilau' || $efekMotion === 'kilau')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden lapis-3d" style="--depth: 18px; --pz: 24px;">
        <div class="absolute -top-20 left-1/3 w-44 h-[125%] bg-gradient-to-b from-[#F3E5AB]/16 via-white/5 to-transparent blur-xl animasi-sinar"></div>
        @foreach ([
            ['left: 16%;', 'w-2.5 h-2 bg-[#EAD3C1]/75 rounded-tl-full rounded-br-full', '0s', '11s'],
            ['left: 48%;', 'w-3 h-2 bg-[#D4AF37]/65 rounded-tr-full rounded-bl-full', '3.1s', '13s'],
            ['left: 76%;', 'w-2.5 h-2 bg-[#EAD3C1]/70 rounded-tl-full rounded-br-full', '1.7s', '12s'],
        ] as [$posisi, $bentuk, $jeda, $durasi])
            <span class="absolute -top-6 {{ $bentuk }} animasi-kelopak-3d" style="{{ $posisi }} animation-delay: {{ $jeda }}; animation-duration: {{ $durasi }};"></span>
        @endforeach
        <span class="absolute top-[20%] left-[20%] w-2 h-2 rounded-full bg-[#D4AF37]/75 animasi-kilau"></span>
        <span class="absolute top-[38%] right-[18%] w-2.5 h-2.5 rounded-full bg-[#F3E5AB]/80 animasi-kilau" style="animation-delay: 1.4s;"></span>
        <span class="absolute bottom-[28%] left-[28%] w-1.5 h-1.5 rounded-full bg-[#D4AF37]/70 animasi-kilau" style="animation-delay: 2.2s;"></span>
    </div>
@elseif ($efekMotion === 'kelopak')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden lapis-3d" style="--depth: 20px; --pz: 24px;">
        <div class="absolute -top-16 right-[20%] w-36 h-[120%] bg-gradient-to-b from-[#F5E6D3]/16 via-transparent to-transparent blur-xl animasi-sinar"></div>
        @foreach ([
            ['left: 15%;', 'w-3 h-2 bg-[#EEDAD4]/80 rounded-tl-full rounded-br-full', '0.4s', '10.5s'],
            ['left: 42%;', 'w-2.5 h-2 bg-[#C8A464]/75 rounded-tr-full rounded-bl-full', '2.8s', '12.5s'],
            ['left: 69%;', 'w-3 h-2 bg-[#EEDAD4]/75 rounded-tl-full rounded-br-full', '1.2s', '11.5s'],
            ['left: 86%;', 'w-2.5 h-2 bg-[#9EB29C]/75 rounded-tr-full rounded-bl-full', '4.3s', '13s'],
        ] as [$posisi, $bentuk, $jeda, $durasi])
            <span class="absolute -top-6 {{ $bentuk }} animasi-kelopak-3d" style="{{ $posisi }} animation-delay: {{ $jeda }}; animation-duration: {{ $durasi }};"></span>
        @endforeach
        <span class="absolute top-[18%] left-[16%] w-3 h-3 rounded-full bg-[#EEDAD4]/60 blur-[1px] animasi-melayang"></span>
        <span class="absolute top-[35%] right-[24%] w-3.5 h-3.5 rounded-full bg-[#C8A464]/55 blur-[1px] animasi-melayang" style="animation-delay: 1.3s;"></span>
    </div>
@elseif ($efekMotion === 'halus')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden lapis-3d" style="--depth: 14px; --pz: 18px;">
        <div class="absolute -top-16 left-[28%] w-32 h-[125%] bg-gradient-to-b from-white/12 via-transparent to-transparent blur-xl animasi-sinar"></div>
        <span class="absolute top-[24%] left-[18%] w-2 h-2 rounded-full bg-white/45 animasi-melayang"></span>
        <span class="absolute top-[46%] right-[22%] w-2.5 h-2.5 rounded-full bg-white/35 animasi-melayang" style="animation-delay: 1.8s;"></span>
    </div>
@endif
