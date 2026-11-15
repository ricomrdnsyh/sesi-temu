@props([
    'efekMotion' => 'kilau',
    'konteks' => 'panggung',
])

@if ($efekMotion === 'bintang')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-16 left-1/2 -translate-x-1/2 w-72 h-72 rounded-full bg-[#D9B664]/12 blur-3xl"></div>
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
            <span class="absolute rounded-full {{ $ukuran }} animasi-bintang shadow-[0_0_8px_rgba(243,229,171,0.85)]" style="{{ $posisi }} animation-delay: {{ $jeda }};"></span>
        @endforeach

        {{-- Bintang Jatuh Periodik --}}
        <span
            class="absolute top-[14%] right-[8%] w-24 h-[1.5px] rounded-full bg-gradient-to-r from-white via-[#F3E5AB] to-transparent animasi-bintang-jatuh"
            style="animation-delay: 1s;"
        ></span>
        @if ($konteks === 'panggung')
            <span
                class="absolute top-[30%] right-[28%] w-32 h-[1.5px] rounded-full bg-gradient-to-r from-[#F3E5AB] via-[#D9B664] to-transparent animasi-bintang-jatuh"
                style="animation-delay: 4.8s;"
            ></span>
        @endif
    </div>
@elseif ($efekMotion === 'kelopak-kunang')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-64 h-64 rounded-full bg-[#C8A464]/10 blur-3xl"></div>
        @foreach ([
            ['left: 12%;', 'w-3 h-2 bg-[#EEDAD4]/65 rounded-tl-full rounded-br-full', '0s', '10s'],
            ['left: 28%;', 'w-2.5 h-2 bg-[#C8A464]/70 rounded-tl-full rounded-br-full', '2.2s', '12s'],
            ['left: 48%;', 'w-3.5 h-2.5 bg-[#EEDAD4]/55 rounded-tr-full rounded-bl-full', '4.1s', '11s'],
            ['left: 68%;', 'w-2.5 h-2 bg-[#C8A464]/65 rounded-tl-full rounded-br-full', '1.4s', '13s'],
            ['left: 84%;', 'w-3 h-2 bg-[#EEDAD4]/60 rounded-tr-full rounded-bl-full', '5.3s', '10.5s'],
        ] as [$posisi, $bentuk, $jeda, $durasi])
            <span class="absolute -top-6 {{ $bentuk }} animasi-kelopak-jatuh" style="{{ $posisi }} animation-delay: {{ $jeda }}; animation-duration: {{ $durasi }};"></span>
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
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-80 h-56 rounded-full bg-[#D4AF37]/10 blur-3xl"></div>
        @foreach ([
            ['bottom: 12%; left: 14%;', 'w-1.5 h-1.5', '0s'],
            ['bottom: 24%; left: 28%;', 'w-2 h-2', '1.1s'],
            ['bottom: 18%; left: 46%;', 'w-1 h-1', '2.3s'],
            ['bottom: 30%; right: 28%;', 'w-2 h-2', '0.6s'],
            ['bottom: 15%; right: 16%;', 'w-1.5 h-1.5', '1.9s'],
            ['bottom: 42%; left: 34%;', 'w-1.5 h-1.5', '3.1s'],
            ['bottom: 48%; right: 22%;', 'w-2 h-2', '2.7s'],
            ['bottom: 8%; left: 62%;', 'w-1.5 h-1.5', '1.5s'],
        ] as [$posisi, $ukuran, $jeda])
            <span class="absolute rounded-full {{ $ukuran }} bg-[#F3E5AB] shadow-[0_0_10px_rgba(212,175,55,0.85)] animasi-debu-emas" style="{{ $posisi }} animation-delay: {{ $jeda }};"></span>
        @endforeach
    </div>
@elseif ($efekMotion === 'melati')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
        @foreach ([
            ['left: 16%;', 'w-2.5 h-2 bg-white/80 rounded-tl-full rounded-br-full', '0s'],
            ['left: 44%;', 'w-2 h-2 bg-[#F7F1E5]/85 rounded-tr-full rounded-bl-full', '2.5s'],
            ['left: 72%;', 'w-2.5 h-2 bg-[#E6C77E]/70 rounded-tl-full rounded-br-full', '4.2s'],
            ['left: 88%;', 'w-2 h-2 bg-white/75 rounded-tr-full rounded-bl-full', '1.4s'],
        ] as [$posisi, $bentuk, $jeda])
            <span class="absolute -top-6 {{ $bentuk }} animasi-kelopak-jatuh" style="{{ $posisi }} animation-delay: {{ $jeda }}; animation-duration: 12s;"></span>
        @endforeach
    </div>
@elseif ($efekMotion === 'kelopak')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
        <span class="absolute top-[18%] left-[16%] w-3 h-3 rounded-full bg-[#EEDAD4]/55 blur-[1px] animasi-melayang"></span>
        <span class="absolute top-[35%] right-[24%] w-3.5 h-3.5 rounded-full bg-[#C8A464]/55 blur-[1px] animasi-melayang" style="animation-delay: 1.3s;"></span>
        <span class="absolute top-[52%] left-[32%] w-2.5 h-2.5 rounded-full bg-[#EEDAD4]/60 animasi-melayang" style="animation-delay: 2.1s;"></span>
    </div>
@elseif ($efekMotion === 'kilau')
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
        <span class="absolute top-[20%] left-[20%] w-2 h-2 rounded-full bg-[#D4AF37]/65 animasi-kilau"></span>
        <span class="absolute top-[38%] right-[18%] w-2 h-2 rounded-full bg-[#F3E5AB]/70 animasi-kilau" style="animation-delay: 1.4s;"></span>
        <span class="absolute bottom-[28%] left-[28%] w-1.5 h-1.5 rounded-full bg-[#D4AF37]/60 animasi-kilau" style="animation-delay: 2.2s;"></span>
    </div>
@endif
