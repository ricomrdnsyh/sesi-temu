<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use App\Models\Pengguna;
use App\Models\Tema;
use App\Models\Undangan;
use App\Support\PengaturanSesiTemu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * @var list<string>
     */
    private const SLUG_TERCADANG = [
        'masuk',
        'daftar',
        'keluar',
        'dashboard',
        'admin',
        'demo',
        'cek-link',
        'up',
    ];
    public function ringkasan(): View
    {
        $totalClient = Pengguna::where('peran', 'client')->count();
        $totalTemaAktif = Tema::where('aktif', true)->count();

        $totalUndanganAktif = Undangan::where('status_publikasi', true)
            ->where(function ($query): void {
                $query->whereNull('berlaku_sampai')
                    ->orWhere('berlaku_sampai', '>=', now());
            })
            ->count();

        $totalDraft = Undangan::where('status_publikasi', false)->count();

        $totalKedaluwarsa = Undangan::whereNotNull('berlaku_sampai')
            ->where('berlaku_sampai', '<', now())
            ->count();

        $totalUcapan = BukuTamu::count();

        $undanganTerbaru = Undangan::with(['pengguna', 'tema'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.ringkasan', [
            'totalClient' => $totalClient,
            'totalTemaAktif' => $totalTemaAktif,
            'totalUndanganAktif' => $totalUndanganAktif,
            'totalDraft' => $totalDraft,
            'totalKedaluwarsa' => $totalKedaluwarsa,
            'totalUcapan' => $totalUcapan,
            'undanganTerbaru' => $undanganTerbaru,
        ]);
    }

    public function daftarUndangan(Request $request): View
    {
        $pencarian = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', 'semua');

        $query = Undangan::with(['pengguna', 'tema'])->latest();

        if ($pencarian !== '') {
            $query->where(function ($sub) use ($pencarian): void {
                $sub->where('slug', 'like', "%{$pencarian}%")
                    ->orWhere('nama_panggilan_pria', 'like', "%{$pencarian}%")
                    ->orWhere('nama_panggilan_wanita', 'like', "%{$pencarian}%")
                    ->orWhereHas('pengguna', function ($penggunaQuery) use ($pencarian): void {
                        $penggunaQuery->where('nama', 'like', "%{$pencarian}%")
                            ->orWhere('email', 'like', "%{$pencarian}%");
                    });
            });
        }

        if ($status === 'draft') {
            $query->where('status_publikasi', false);
        } elseif ($status === 'aktif') {
            $query->where('status_publikasi', true)
                ->where(function ($sub): void {
                    $sub->whereNull('berlaku_sampai')
                        ->orWhere('berlaku_sampai', '>=', now());
                });
        } elseif ($status === 'kedaluwarsa') {
            $query->whereNotNull('berlaku_sampai')
                ->where('berlaku_sampai', '<', now());
        }

        $daftarUndangan = $query->get();
        $daftarClient = Pengguna::where('peran', 'client')->orderBy('nama')->get(['id', 'nama', 'email']);
        $daftarTema = Tema::where('aktif', true)->orderBy('id')->get();

        return view('admin.undangan.index', [
            'daftarUndangan' => $daftarUndangan,
            'daftarClient' => $daftarClient,
            'daftarTema' => $daftarTema,
            'pencarian' => $pencarian,
            'status' => $status,
        ]);
    }

    public function simpanUndangan(Request $request): RedirectResponse
    {
        $tervalidasi = $request->validate([
            'pengguna_id' => ['required', 'integer', Rule::exists('pengguna', 'id')->where('peran', 'client')],
            'tema_id' => ['required', 'integer', Rule::exists('tema', 'id')->where('aktif', true)],
            'slug' => ['required', 'string', 'max:100'],
            'nama_panggilan_pria' => ['required', 'string', 'max:80'],
            'nama_lengkap_pria' => ['required', 'string', 'max:150'],
            'nama_panggilan_wanita' => ['required', 'string', 'max:80'],
            'nama_lengkap_wanita' => ['required', 'string', 'max:150'],
        ], [
            'pengguna_id.required' => 'Client pemilik undangan wajib dipilih.',
            'pengguna_id.exists' => 'Akun client tidak ditemukan atau bukan akun client.',
            'tema_id.required' => 'Tema undangan wajib dipilih.',
            'tema_id.exists' => 'Tema tidak valid atau sedang tidak aktif.',
            'slug.required' => 'Slug link undangan wajib diisi.',
        ]);

        $slug = Str::slug($tervalidasi['slug']);

        if ($slug === '' || in_array($slug, self::SLUG_TERCADANG, true)) {
            return back()->withErrors(['slug' => 'Nama link tidak valid atau merupakan kata yang dicadangkan sistem.'])->withInput();
        }

        if (Undangan::where('slug', $slug)->exists()) {
            return back()->withErrors(['slug' => "Link sesitemu.id/{$slug} sudah dipakai. Gunakan nama link lain."])->withInput();
        }

        $client = Pengguna::findOrFail((int) $tervalidasi['pengguna_id']);
        $temaDipilih = Tema::findOrFail((int) $tervalidasi['tema_id']);

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $temaDipilih->id,
            'slug' => $slug,
            'nama_panggilan_pria' => $tervalidasi['nama_panggilan_pria'],
            'nama_lengkap_pria' => $tervalidasi['nama_lengkap_pria'],
            'nama_panggilan_wanita' => $tervalidasi['nama_panggilan_wanita'],
            'nama_lengkap_wanita' => $tervalidasi['nama_lengkap_wanita'],
            'musik_latar' => Tema::musikBawaanUntukSlug($temaDipilih->slug),
            'pengaturan' => Undangan::pengaturanBawaan(),
            'status_publikasi' => false,
        ]);

        return redirect()
            ->route('dashboard.undangan.kelola', $undangan)
            ->with('sukses', "Draft undangan untuk {$client->nama} berhasil dibuat! Silakan lengkapi isian undangan.");
    }

    public function aktifkanUndangan(Undangan $undangan): RedirectResponse
    {
        $durasiBulan = PengaturanSesiTemu::masaAktifBulan();

        $undangan->update([
            'status_publikasi' => true,
            'berlaku_sampai' => now()->addMonths($durasiBulan),
        ]);

        return back()->with('sukses', "Undangan sesitemu.id/{$undangan->slug} berhasil diaktifkan selama {$durasiBulan} bulan.");
    }

    public function nonaktifkanUndangan(Undangan $undangan): RedirectResponse
    {
        $undangan->update([
            'status_publikasi' => false,
        ]);

        return back()->with('sukses', "Undangan sesitemu.id/{$undangan->slug} dikembalikan ke mode Draft.");
    }

    public function bersihkanKedaluwarsa(): RedirectResponse
    {
        Artisan::call('undangan:bersihkan-kedaluwarsa');
        $pesan = trim(Artisan::output()) ?: 'Pembersihan storage kedaluwarsa selesai dijalankan.';

        return back()->with('sukses', $pesan);
    }

    public function daftarPengguna(Request $request): View
    {
        $pencarian = trim((string) $request->query('q', ''));

        $query = Pengguna::where('peran', 'client')
            ->withCount('undangan')
            ->latest();

        if ($pencarian !== '') {
            $query->where(function ($sub) use ($pencarian): void {
                $sub->where('nama', 'like', "%{$pencarian}%")
                    ->orWhere('email', 'like', "%{$pencarian}%")
                    ->orWhere('nomor_wa', 'like', "%{$pencarian}%");
            });
        }

        $daftarPengguna = $query->get();

        return view('admin.pengguna.index', [
            'daftarPengguna' => $daftarPengguna,
            'pencarian' => $pencarian,
        ]);
    }

    public function resetSandiPengguna(Request $request, Pengguna $pengguna): RedirectResponse
    {
        $tervalidasi = $request->validate([
            'kata_sandi_baru' => ['required', 'string', 'min:8'],
        ], [
            'kata_sandi_baru.required' => 'Kata sandi baru wajib diisi.',
            'kata_sandi_baru.min' => 'Kata sandi baru minimal 8 karakter.',
        ]);

        $pengguna->update([
            'kata_sandi' => Hash::make($tervalidasi['kata_sandi_baru']),
        ]);

        return back()->with('sukses', "Kata sandi untuk {$pengguna->nama} ({$pengguna->email}) berhasil direset.");
    }
}
