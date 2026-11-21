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
        $urlFotoPenutup = $tanpaFoto ? null : $undangan->urlFotoPenutup();
        $urlFotoLatarCustom = $tanpaFoto ? null : $undangan->urlFotoLatarCustom();
        $urlFotoLatar = $urlFotoLatarCustom ?? $latarDefaultUrl;

        $urutanTier = ['basic' => 1, 'premium' => 2, 'eksklusif' => 3];
        $tierDb = $undangan->tema?->tier ? $undangan->tema->tierKode() : $tierBawaan;
        $tierAktif = ($urutanTier[$tierDb] ?? 1) >= ($urutanTier[$tierBawaan] ?? 1) ? $tierDb : $tierBawaan;

        $pengaturan = $undangan->pengaturan ?? [];
        $ceritaList = $pengaturan['cerita_cinta'] ?? [];
        $live = $pengaturan['live_streaming'] ?? [];
        $alamatKado = trim((string) ($pengaturan['alamat_kado_fisik'] ?? ''));

        $instagramPria = $undangan->instagramPria();
        $instagramWanita = $undangan->instagramWanita();
        $dressCodeCatatan = $undangan->dressCodeCatatan();
        $dressCodeWarna = $undangan->dressCodeWarna();
        $adaDressCode = $dressCodeCatatan !== '' || ! empty($dressCodeWarna);
        $turutWanita = $undangan->turutMengundangWanita();
        $turutPria = $undangan->turutMengundangPria();
        $adaTurutMengundang = ! empty($turutWanita) || ! empty($turutPria);

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
                ? Carbon::parse("{$tanggalStr} ".$acaraPertama->waktu_selesai, $tz)->utc()
                : $mulaiUtc->copy()->addHours(2);

            $googleCalUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
                .'&text='.urlencode("Pernikahan {$undangan->nama_panggilan_pria} & {$undangan->nama_panggilan_wanita} ({$acaraPertama->nama_acara})")
                .'&dates='.$mulaiUtc->format('Ymd\THis\Z').'/'.$selesaiUtc->format('Ymd\THis\Z')
                .'&details='.urlencode("Undangan Pernikahan {$undangan->nama_lengkap_pria} & {$undangan->nama_lengkap_wanita} via SesiTemu.id")
                .'&location='.urlencode($acaraPertama->nama_tempat.', '.$acaraPertama->alamat_lengkap);
        }

        return [
            'acaraPertama' => $acaraPertama,
            'tanggalTitik' => $tanggalTitik,
            'tanggalLengkap' => $tanggalLengkap,
            'hashtagPasangan' => $undangan->hashtagPasangan(),
            'tanpaFoto' => $tanpaFoto,
            'urlFotoSampul' => $urlFotoSampul,
            'pakaiFotoSampul' => $pakaiFotoSampul,
            'urlFotoPembuka' => $urlFotoPembuka,
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
            'isoTarget' => $isoTarget,
            'googleCalUrl' => $googleCalUrl,
            'tampilBarDemo' => $modeDemo && ! request()->boolean('embed'),
            'modeDemo' => $modeDemo,
            'modePratinjau' => $modePratinjau,
        ];
    }
}
