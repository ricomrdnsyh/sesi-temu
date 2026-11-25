@props([
    'titanium' => 'black',
    'statusGelap' => false,
    'homeGelap' => false,
    'posisiStyle' => '',
    'zClass' => 'z-10',
    'bayangan' => '0 2cqw 4.2cqw rgba(0,0,0,0.42)',
    'peran' => 'utama',
])

@php
    $gayaTitanium = match ($titanium) {
        'desert' => [
            'rangka' => 'linear-gradient(145deg, #DECDB1 0%, #9E8B6E 28%, #5F523E 54%, #C8B494 82%, #7D6C53 100%)',
            'tombol' => 'linear-gradient(180deg, #D9C8AC 0%, #8E7B5E 50%, #6A5B44 100%)',
            'kilau' => 'inset 0 0 0 0.14cqw rgba(255,248,232,0.52)',
        ],
        'natural' => [
            'rangka' => 'linear-gradient(145deg, #E2E2E6 0%, #9A9AA0 28%, #55555B 54%, #C6C6CC 82%, #74747A 100%)',
            'tombol' => 'linear-gradient(180deg, #DCDCE0 0%, #8F8F96 50%, #68686F 100%)',
            'kilau' => 'inset 0 0 0 0.14cqw rgba(255,255,255,0.55)',
        ],
        default => [
            'rangka' => 'linear-gradient(145deg, #6E6E77 0%, #323238 28%, #151519 54%, #505059 82%, #202026 100%)',
            'tombol' => 'linear-gradient(180deg, #5F5F68 0%, #2C2C32 50%, #1B1B20 100%)',
            'kilau' => 'inset 0 0 0 0.14cqw rgba(255,255,255,0.28)',
        ],
    };

    $warnaStatus = $statusGelap ? '#18181B' : '#FFFFFF';
    $bayanganStatus = $statusGelap ? 'none' : '0 0.15cqw 0.45cqw rgba(0,0,0,0.45)';
    $warnaHome = $homeGelap ? 'rgba(24,24,27,0.42)' : 'rgba(255,255,255,0.78)';
@endphp

<div
    data-iphone-frame="{{ $peran }}"
    data-iphone-titanium="{{ $titanium }}"
    class="absolute {{ $zClass }}"
    style="{{ $posisiStyle }} border-radius: 5.95cqw; padding: 0.42cqw; background: {{ $gayaTitanium['rangka'] }}; box-shadow: {{ $bayangan }}, {{ $gayaTitanium['kilau'] }};"
>
    {{-- Tombol Sisi Kiri iPhone: Action Button + Volume Naik & Turun --}}
    <span
        aria-hidden="true"
        class="pointer-events-none absolute"
        style="left: -0.38cqw; top: 15.8%; width: 0.38cqw; height: 3.4%; border-radius: 0.28cqw 0 0 0.28cqw; background: {{ $gayaTitanium['tombol'] }};"
    ></span>
    <span
        aria-hidden="true"
        class="pointer-events-none absolute"
        style="left: -0.4cqw; top: 22.8%; width: 0.4cqw; height: 6.8%; border-radius: 0.28cqw 0 0 0.28cqw; background: {{ $gayaTitanium['tombol'] }};"
    ></span>
    <span
        aria-hidden="true"
        class="pointer-events-none absolute"
        style="left: -0.4cqw; top: 31.6%; width: 0.4cqw; height: 6.8%; border-radius: 0.28cqw 0 0 0.28cqw; background: {{ $gayaTitanium['tombol'] }};"
    ></span>

    {{-- Tombol Sisi Kanan iPhone: Side Power Button --}}
    <span
        aria-hidden="true"
        class="pointer-events-none absolute"
        style="right: -0.4cqw; top: 25.5%; width: 0.4cqw; height: 10.4%; border-radius: 0 0.28cqw 0.28cqw 0; background: {{ $gayaTitanium['tombol'] }};"
    ></span>

    {{-- Bezel Kaca Hitam OLED Tipis --}}
    <div
        class="relative w-full h-full"
        style="border-radius: 5.52cqw; padding: 0.92cqw; background-color: #08080A; box-shadow: inset 0 0 0 0.12cqw rgba(255,255,255,0.12);"
    >
        {{-- Layar Super Retina XDR --}}
        <div
            class="relative w-full h-full overflow-hidden"
            style="border-radius: 4.58cqw;"
        >
            {{-- Status Bar iOS + Dynamic Island (Grid 1fr-auto-1fr agar Dynamic Island Tepat di Tengah Layar) --}}
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-x-0 top-0 z-30 grid grid-cols-[1fr_auto_1fr] items-center"
                style="padding: 1.25cqw 1.55cqw 0; color: {{ $warnaStatus }}; text-shadow: {{ $bayanganStatus }};"
            >
                <span
                    class="justify-self-center font-sans font-bold leading-none tabular-nums"
                    style="font-size: 1.38cqw; letter-spacing: -0.02em;"
                >
                    9:41
                </span>

                {{-- Dynamic Island Khas iPhone Pro dengan Lensa Kamera Depan --}}
                <div
                    data-dynamic-island="true"
                    class="relative justify-self-center flex items-center justify-end rounded-full"
                    style="width: 9.4cqw; height: 2.3cqw; padding-right: 0.65cqw; background-color: #050507; box-shadow: 0 0 0 0.1cqw rgba(255,255,255,0.1);"
                >
                    <span
                        class="block rounded-full"
                        style="width: 1.02cqw; height: 1.02cqw; background: radial-gradient(circle at 35% 32%, #3B66A8 0%, #111F3A 56%, #04060A 100%); box-shadow: inset 0 0 0 0.12cqw rgba(255,255,255,0.18);"
                    ></span>
                </div>

                {{-- Ikon Sinyal & Baterai iOS Ringkas --}}
                <div class="justify-self-center flex items-center" style="gap: 0.55cqw;">
                    <svg
                        viewBox="0 0 18 12"
                        fill="currentColor"
                        style="width: 1.95cqw; height: 1.15cqw; filter: {{ $statusGelap ? 'none' : 'drop-shadow(0 0.12cqw 0.35cqw rgba(0,0,0,0.45))' }};"
                    >
                        <rect x="0.5" y="7.5" width="2.8" height="4" rx="0.8" />
                        <rect x="5" y="5.2" width="2.8" height="6.3" rx="0.8" />
                        <rect x="9.5" y="2.8" width="2.8" height="8.7" rx="0.8" />
                        <rect x="14" y="0.6" width="2.8" height="10.9" rx="0.8" />
                    </svg>
                    <svg
                        viewBox="0 0 26 13"
                        fill="none"
                        style="width: 2.85cqw; height: 1.25cqw; filter: {{ $statusGelap ? 'none' : 'drop-shadow(0 0.12cqw 0.35cqw rgba(0,0,0,0.45))' }};"
                    >
                        <rect x="0.8" y="1" width="21" height="11" rx="3.2" stroke="currentColor" stroke-width="1.6" stroke-opacity="0.72" />
                        <rect x="3" y="3.1" width="15.8" height="6.8" rx="1.6" fill="currentColor" />
                        <path d="M23.4 4.3v4.4a1.6 1.6 0 0 0 0-4.4Z" fill="currentColor" fill-opacity="0.68" />
                    </svg>
                </div>
            </div>

            {{-- Konten Layar Undangan --}}
            {{ $slot }}

            {{-- Kilau Kaca Layar Halus (Studio Reflection) --}}
            <div
                aria-hidden="true"
                class="pointer-events-none absolute inset-0 z-20"
                style="background: linear-gradient(128deg, rgba(255,255,255,0.11) 0%, rgba(255,255,255,0.025) 24%, transparent 44%);"
            ></div>

            {{-- Garis Home Indicator iOS Bawah --}}
            <div
                aria-hidden="true"
                class="pointer-events-none absolute left-1/2 -translate-x-1/2 z-30 rounded-full"
                style="bottom: 1.02cqw; width: 12.2cqw; height: 0.52cqw; background-color: {{ $warnaHome }};"
            ></div>
        </div>
    </div>
</div>
