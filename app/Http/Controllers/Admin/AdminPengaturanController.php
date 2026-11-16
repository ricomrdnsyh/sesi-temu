<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\PengaturanSesiTemu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPengaturanController extends Controller
{
    public function index(): View
    {
        return view('admin.pengaturan.index', [
            'pengaturan' => PengaturanSesiTemu::semua(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $tervalidasi = $request->validate([
            'nomor_wa_admin' => ['required', 'string', 'min:9', 'max:20'],
            'masa_aktif_bulan' => ['required', 'integer', 'min:1', 'max:36'],
            'biaya_terima_beres' => ['required', 'integer', 'min:0', 'max:10000000'],
            'nama_bank_pembayaran' => ['required', 'string', 'max:80'],
            'nomor_rekening_pembayaran' => ['required', 'string', 'max:80'],
            'atas_nama_rekening' => ['required', 'string', 'max:120'],
            'catatan_pembayaran' => ['nullable', 'string', 'max:500'],
        ], [
            'nomor_wa_admin.required' => 'Nomor WhatsApp admin wajib diisi.',
            'masa_aktif_bulan.required' => 'Masa aktif bawaan wajib diisi.',
            'biaya_terima_beres.required' => 'Biaya Paket Terima Beres wajib diisi.',
            'nama_bank_pembayaran.required' => 'Nama bank pembayaran wajib diisi.',
            'nomor_rekening_pembayaran.required' => 'Nomor rekening pembayaran wajib diisi.',
            'atas_nama_rekening.required' => 'Atas nama rekening wajib diisi.',
        ]);

        $waBersih = preg_replace('/[^0-9]/', '', (string) $tervalidasi['nomor_wa_admin']);
        if ($waBersih && str_starts_with($waBersih, '0')) {
            $waBersih = '62'.substr($waBersih, 1);
        }

        $tervalidasi['nomor_wa_admin'] = $waBersih ?: PengaturanSesiTemu::BAWAAN['nomor_wa_admin'];

        PengaturanSesiTemu::simpanBulk($tervalidasi);

        return back()->with('sukses', 'Pengaturan platform SesiTemu berhasil diperbarui.');
    }
}
