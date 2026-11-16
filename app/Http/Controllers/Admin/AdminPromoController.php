<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminPromoController extends Controller
{
    public function index(): View
    {
        $daftarPromo = Promo::withCount('transaksi')->latest()->get();

        return view('admin.promo.index', [
            'daftarPromo' => $daftarPromo,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $kode = Str::upper(preg_replace('/\s+/', '', (string) $request->input('kode', '')));
        $request->merge(['kode' => $kode]);

        $tervalidasi = $request->validate([
            'kode' => ['required', 'string', 'max:40', 'alpha_dash', 'unique:promo,kode'],
            'nama_promo' => ['required', 'string', 'max:120'],
            'tipe_diskon' => ['required', Rule::in(['nominal', 'persen'])],
            'nilai_diskon' => ['required', 'integer', 'min:1'],
            'maksimal_diskon' => ['nullable', 'integer', 'min:1000'],
            'kuota' => ['nullable', 'integer', 'min:1'],
            'berlaku_mulai' => ['nullable', 'date'],
            'berlaku_sampai' => ['nullable', 'date', 'after_or_equal:berlaku_mulai'],
        ], [
            'kode.required' => 'Kode voucher wajib diisi.',
            'kode.alpha_dash' => 'Kode voucher hanya boleh huruf, angka, garis bawah, atau tanda hubung.',
            'kode.unique' => 'Kode voucher sudah digunakan.',
            'berlaku_sampai.after_or_equal' => 'Tanggal berakhir tidak boleh sebelum tanggal mulai.',
        ]);

        if ($tervalidasi['tipe_diskon'] === 'persen' && (int) $tervalidasi['nilai_diskon'] > 100) {
            return back()->withErrors(['nilai_diskon' => 'Diskon persentase maksimal 100%.'])->withInput();
        }

        $promo = Promo::create([
            'kode' => $tervalidasi['kode'],
            'nama_promo' => $tervalidasi['nama_promo'],
            'tipe_diskon' => $tervalidasi['tipe_diskon'],
            'nilai_diskon' => (int) $tervalidasi['nilai_diskon'],
            'maksimal_diskon' => $tervalidasi['maksimal_diskon'] ?? null,
            'kuota' => $tervalidasi['kuota'] ?? null,
            'berlaku_mulai' => $tervalidasi['berlaku_mulai'] ?? null,
            'berlaku_sampai' => $tervalidasi['berlaku_sampai'] ?? null,
            'aktif' => true,
        ]);

        return back()->with('sukses', "Kode promo {$promo->kode} berhasil dibuat.");
    }

    public function toggle(Promo $promo): RedirectResponse
    {
        $promo->update([
            'aktif' => ! $promo->aktif,
        ]);

        $status = $promo->aktif ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('sukses', "Kode promo {$promo->kode} berhasil {$status}.");
    }

    public function destroy(Promo $promo): RedirectResponse
    {
        $kode = $promo->kode;
        $promo->delete();

        return back()->with('sukses', "Kode promo {$kode} berhasil dihapus.");
    }
}
