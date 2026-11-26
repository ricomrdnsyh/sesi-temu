<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Undangan;
use Illuminate\Support\Carbon;

class DataTemaUndangan
{
    /**
     * Menyiapkan seluruh data terstruktur yang dipakai bersama oleh tema-tema mandiri,
     * termasuk kustomisasi foto penuh, hashtag, jadwal kalender, dan fitur pelengkap.
     *
     * @return array<string, mixed>
     */
    public static function siapkan(
        Undangan $undangan,
        bool $modeDemo = false,
        bool $modePratinjau = false,
        string $tierBawaan = 'premium',
        string $latarDefaultUrl = ''
    ): array {
        $acaraPertama = $undangan->daftarAcara->first();
        $tanggalTitik = $acaraPertama?->tanggal_acara?->format('d . m . y') ?? now()->format('d . m . y');
        $tanggalLengkap = $acaraPertama?->tanggal_acara
            ? $acaraPertama->tanggal_acara->locale('id')->translatedFormat('l, d F Y')
            : now()->locale('id')->translatedFormat('l, d F Y');

        $tanpaFoto = $undangan->modeTanpaFoto();
        $urlFotoSampul = $tanpaFoto ? null : $undangan->urlFotoSampul();
        $pakaiFotoSampul = ! $tanpaFoto && ! empty($urlFotoSampul);
        $urlFotoPembuka = $tanpaFoto ? null : $undangan->urlFotoPembuka();
        $daftarUrlFotoHitungMundur = $tanpaFoto ? [] : $undangan->daftarUrlFotoHitungMundur();
        $urlFotoHitungMundur = $daftarUrlFotoHitungMundur[0] ?? null;
        $urlFotoPenutup = $tanpaFoto ? null : $undangan->urlFotoPenutup();
        $urlFotoLatarCustom = $tanpaFoto ? null : $undangan->urlFotoLatarCustom();
        $urlFotoLatar = $urlFotoLatarCustom ?? $latarDefaultUrl;

        $urutanTier = ['basic' => 1, 'premium' => 2, 'eksklusif' => 3];
        $tierDb = $undangan->tema?->tier ? $undangan->tema->tierKode() : $tierBawaan;
        $tierAktif = ($urutanTier[$tierDb] ?? 1) >= ($urutanTier[$tierBawaan] ?? 1) ? $tierDb : $tierBawaan;

        $pengaturan = $undangan->pengaturan ?? [];
        $ceritaList = $pengaturan['cerita_cinta'] ?? [];
        $live = $pengaturan['live_streaming'] ?? [];
        $live['aktif'] = $undangan->fiturAktif('live_streaming');
        $alamatKado = trim((string) ($pengaturan['alamat_kado_fisik'] ?? ''));

        $instagramPria = $undangan->instagramPria();
        $instagramWanita = $undangan->instagramWanita();
        $dressCodeCatatan = $undangan->dressCodeCatatan();
        $dressCodeWarna = $undangan->dressCodeWarna();
        $adaDressCode = $undangan->fiturAktif('dress_code') && ($dressCodeCatatan !== '' || ! empty($dressCodeWarna));
        $turutWanita = $undangan->turutMengundangWanita();
        $turutPria = $undangan->turutMengundangPria();
        $adaTurutMengundang = $undangan->fiturAktif('turut_mengundang') && (! empty($turutWanita) || ! empty($turutPria));

        $galeriPanggungKanan = collect();
        $fotoGaleriSlideshow = collect();
        if (! $tanpaFoto) {
            $galeriPanggungKanan = $undangan->daftarGaleri
                ->take(3)
                ->map(static fn($item) => [
                    'url' => $item->urlFoto(),
                    'keterangan' => (string) ($item->keterangan ?? ''),
                ])
                ->filter(static fn($item) => ! empty($item['url']))
                ->values();

            if ($undangan->fiturAktif('hitung_mundur')) {
                if (! empty($daftarUrlFotoHitungMundur)) {
                    $fotoGaleriSlideshow = collect($daftarUrlFotoHitungMundur)->values();
                } elseif ($modeDemo) {
                    $fotoGaleriSlideshow = $undangan->daftarGaleri
                        ->take(4)
                        ->map(static fn($item) => $item->urlFoto())
                        ->filter()
                        ->values();

                    if ($fotoGaleriSlideshow->isEmpty()) {
                        foreach ([$urlFotoPembuka, $urlFotoPenutup] as $fotoAlternatif) {
                            if (! empty($fotoAlternatif)) {
                                $fotoGaleriSlideshow->push($fotoAlternatif);
                            }
                        }
                    }
                }
            }

            if ($galeriPanggungKanan->isEmpty()) {
                foreach ([$urlFotoPembuka, $urlFotoPenutup] as $fotoAlternatif) {
                    if (! empty($fotoAlternatif)) {
                        $galeriPanggungKanan->push([
                            'url' => $fotoAlternatif,
                            'keterangan' => "{$undangan->nama_panggilan_pria} & {$undangan->nama_panggilan_wanita}",
                        ]);
                    }
                }
            }
        }

        $isoTarget = null;
        $googleCalUrl = null;
        if ($acaraPertama) {
            $offset = match ($acaraPertama->zona_waktu) {
                'WITA' => '+08:00',
                'WIT' => '+09:00',
                default => '+07:00',
            };
            $tanggalStr = $acaraPertama->tanggal_acara->format('Y-m-d');
            $waktuMulai = substr($acaraPertama->waktu_mulai, 0, 8);
            if (strlen($waktuMulai) === 5) {
                $waktuMulai .= ':00';
            }
            $isoTarget = "{$tanggalStr}T{$waktuMulai}{$offset}";

            $tz = match ($acaraPertama->zona_waktu) {
                'WITA' => 'Asia/Makassar',
                'WIT' => 'Asia/Jayapura',
                default => 'Asia/Jakarta',
            };
            $mulaiUtc = Carbon::parse("{$tanggalStr} {$waktuMulai}", $tz)->utc();
            $selesaiUtc = $acaraPertama->waktu_selesai
                ? Carbon::parse("{$tanggalStr} " . $acaraPertama->waktu_selesai, $tz)->utc()
                : $mulaiUtc->copy()->addHours(2);

            $googleCalUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
                . '&text=' . urlencode("Pernikahan {$undangan->nama_panggilan_pria} & {$undangan->nama_panggilan_wanita} ({$acaraPertama->nama_acara})")
                . '&dates=' . $mulaiUtc->format('Ymd\THis\Z') . '/' . $selesaiUtc->format('Ymd\THis\Z')
                . '&details=' . urlencode("Undangan Pernikahan {$undangan->nama_lengkap_pria} & {$undangan->nama_lengkap_wanita} via SesiTemu.id")
                . '&location=' . urlencode($acaraPertama->nama_tempat . ', ' . $acaraPertama->alamat_lengkap);
        }

        $daftarUcapanAwal = $undangan->bukuTamu
            ->values()
            ->map(static fn($ucapan, int $idx) => [
                'id' => 'awal-' . ($ucapan->id ?? ($idx + 1)),
                'nama_tamu' => (string) $ucapan->nama_tamu,
                'status_kehadiran' => (string) $ucapan->status_kehadiran,
                'jumlah_tamu' => (int) ($ucapan->jumlah_tamu ?? 1),
                'ucapan_doa' => (string) $ucapan->ucapan_doa,
                'waktu' => $ucapan->created_at
                    ? $ucapan->created_at->locale('id')->diffForHumans()
                    : 'Baru saja',
            ])
            ->all();

        return [
            'acaraPertama' => $acaraPertama,
            'tanggalTitik' => $tanggalTitik,
            'tanggalLengkap' => $tanggalLengkap,
            'hashtagPasangan' => $undangan->hashtagPasangan(),
            'tanpaFoto' => $tanpaFoto,
            'urlFotoSampul' => $urlFotoSampul,
            'pakaiFotoSampul' => $pakaiFotoSampul,
            'urlFotoPembuka' => $urlFotoPembuka,
            'urlFotoHitungMundur' => $urlFotoHitungMundur,
            'urlFotoPenutup' => $urlFotoPenutup,
            'urlFotoLatarCustom' => $urlFotoLatarCustom,
            'urlFotoLatar' => $urlFotoLatar,
            'tierAktif' => $tierAktif,
            'isEksklusif' => $tierAktif === 'eksklusif',
            'isPremiumAtas' => in_array($tierAktif, ['premium', 'eksklusif'], true),
            'ceritaList' => $ceritaList,
            'live' => $live,
            'alamatKado' => $alamatKado,
            'instagramPria' => $instagramPria,
            'instagramWanita' => $instagramWanita,
            'dressCodeCatatan' => $dressCodeCatatan,
            'dressCodeWarna' => $dressCodeWarna,
            'adaDressCode' => $adaDressCode,
            'turutWanita' => $turutWanita,
            'turutPria' => $turutPria,
            'adaTurutMengundang' => $adaTurutMengundang,
            'galeriPanggungKanan' => $galeriPanggungKanan,
            'fotoGaleriSlideshow' => $fotoGaleriSlideshow,
            'daftarUcapanAwal' => $daftarUcapanAwal,
            'isoTarget' => $isoTarget,
            'googleCalUrl' => $googleCalUrl,
            'tampilBarDemo' => false,
            'modeDemo' => $modeDemo,
            'modePratinjau' => $modePratinjau,
        ];
    }

    /**
     * Menghasilkan kelas grid & rasio aspek bervariasi (editorial bento/mozaik) untuk galeri foto
     * agar tidak seragam kotak semua dan tetap menutup baris rapi untuk jumlah foto 1–10.
     */
    public static function kelasGridGaleri(int $index, int $total, string $gaya = 'bento'): string
    {
        $isLast = ($index === $total - 1);

        if ($gaya === 'artdeco') {
            $slot = $index % 10;

            return match ($slot) {
                0 => 'col-span-2 aspect-[16/10] rounded-2xl',
                1 => $isLast ? 'col-span-2 aspect-[16/10] rounded-2xl' : 'aspect-[3/4] rounded-xl',
                2 => 'aspect-[3/4] rounded-xl',
                3 => 'col-span-2 aspect-[4/3] rounded-2xl',
                4 => $isLast ? 'col-span-2 aspect-[16/10] rounded-2xl' : 'aspect-[4/5] rounded-xl',
                5 => 'aspect-[4/5] rounded-xl',
                6 => 'col-span-2 aspect-[16/9] rounded-2xl',
                7 => $isLast ? 'col-span-2 aspect-[16/10] rounded-2xl' : 'aspect-square rounded-xl',
                8 => 'aspect-square rounded-xl',
                default => 'col-span-2 aspect-[16/10] rounded-2xl',
            };
        }

        if ($gaya === 'mihrab') {
            $slot = $index % 10;

            return match ($slot) {
                0 => 'col-span-12 aspect-[16/10] rounded-3xl',
                1 => $isLast ? 'col-span-12 aspect-[16/10] rounded-3xl' : 'col-span-7 aspect-[4/5] rounded-t-[4rem] rounded-b-2xl',
                2 => 'col-span-5 h-full min-h-[190px] rounded-t-[3.25rem] rounded-b-2xl',
                3 => 'col-span-12 aspect-[4/3] rounded-2xl',
                4 => $isLast ? 'col-span-12 aspect-[16/10] rounded-3xl' : 'col-span-5 h-full min-h-[190px] rounded-2xl',
                5 => 'col-span-7 aspect-[4/5] rounded-t-[4rem] rounded-b-2xl',
                6 => 'col-span-12 aspect-[16/9] rounded-3xl',
                7 => $isLast ? 'col-span-12 aspect-[16/10] rounded-3xl' : 'col-span-6 aspect-square rounded-2xl',
                8 => 'col-span-6 aspect-square rounded-t-[3.5rem] rounded-b-2xl',
                default => 'col-span-12 aspect-[16/10] rounded-t-[3.5rem] rounded-b-2xl',
            };
        }

        if ($gaya === 'keraton') {
            $slot = $index % 10;

            return match ($slot) {
                0 => 'col-span-12 aspect-[16/9] rounded-2xl',
                1 => $isLast ? 'col-span-12 aspect-[16/10] rounded-2xl' : 'col-span-5 h-full min-h-[195px] rounded-2xl',
                2 => 'col-span-7 aspect-[4/5] rounded-2xl',
                3 => $isLast ? 'col-span-12 aspect-[4/3] rounded-2xl' : 'col-span-6 aspect-square rounded-2xl',
                4 => 'col-span-6 aspect-square rounded-2xl',
                5 => 'col-span-12 aspect-[4/3] rounded-2xl',
                6 => $isLast ? 'col-span-12 aspect-[16/10] rounded-2xl' : 'col-span-7 aspect-[4/5] rounded-2xl',
                7 => 'col-span-5 h-full min-h-[195px] rounded-2xl',
                8 => $isLast ? 'col-span-12 aspect-[16/10] rounded-2xl' : 'col-span-6 aspect-[3/4] rounded-2xl',
                default => 'col-span-6 aspect-[3/4] rounded-2xl',
            };
        }

        if ($gaya === 'editorial') {
            $slot = $index % 10;

            return match ($slot) {
                0 => 'col-span-12 aspect-[16/9] rounded-none',
                1 => $isLast ? 'col-span-12 aspect-[16/10] rounded-none' : 'col-span-7 aspect-[3/4] rounded-none',
                2 => 'col-span-5 h-full min-h-[200px] rounded-none',
                3 => 'col-span-12 aspect-[4/3] rounded-none',
                4 => $isLast ? 'col-span-12 aspect-[16/10] rounded-none' : 'col-span-6 aspect-square rounded-none',
                5 => 'col-span-6 aspect-square rounded-none',
                6 => 'col-span-12 aspect-[16/10] rounded-none',
                7 => $isLast ? 'col-span-12 aspect-[16/10] rounded-none' : 'col-span-5 h-full min-h-[200px] rounded-none',
                8 => 'col-span-7 aspect-[4/5] rounded-none',
                default => 'col-span-12 aspect-[16/10] rounded-none',
            };
        }

        if ($gaya === 'priangan') {
            $slot = $index % 10;

            return match ($slot) {
                0 => 'col-span-12 aspect-[16/10] rounded-t-[3.5rem] rounded-b-2xl',
                1 => $isLast ? 'col-span-12 aspect-[16/10] rounded-2xl' : 'col-span-7 aspect-[4/5] rounded-2xl',
                2 => 'col-span-5 h-full min-h-[190px] rounded-t-[3rem] rounded-b-2xl',
                3 => 'col-span-12 aspect-[4/3] rounded-2xl',
                4 => $isLast ? 'col-span-12 aspect-[16/10] rounded-2xl' : 'col-span-5 h-full min-h-[190px] rounded-2xl',
                5 => 'col-span-7 aspect-[4/5] rounded-t-[3.5rem] rounded-b-2xl',
                6 => 'col-span-12 aspect-[16/9] rounded-2xl',
                7 => $isLast ? 'col-span-12 aspect-[16/10] rounded-2xl' : 'col-span-6 aspect-square rounded-2xl',
                8 => 'col-span-6 aspect-square rounded-2xl',
                default => 'col-span-12 aspect-[16/10] rounded-t-[3.5rem] rounded-b-2xl',
            };
        }

        // Default 'bento' (rustic-floral, royal-ivory, velvet-garden, fallback)
        $slot = $index % 10;

        return match ($slot) {
            0 => 'col-span-12 aspect-[16/10]',
            1 => $isLast ? 'col-span-12 aspect-[16/10]' : 'col-span-7 aspect-[4/5]',
            2 => 'col-span-5 h-full min-h-[190px]',
            3 => 'col-span-12 aspect-[4/3]',
            4 => $isLast ? 'col-span-12 aspect-[16/10]' : 'col-span-5 h-full min-h-[190px]',
            5 => 'col-span-7 aspect-[4/5]',
            6 => 'col-span-12 aspect-[16/9]',
            7 => $isLast ? 'col-span-12 aspect-[16/10]' : 'col-span-6 aspect-square',
            8 => 'col-span-6 aspect-square',
            default => 'col-span-12 aspect-[16/10]',
        };
    }
}
