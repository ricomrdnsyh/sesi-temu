<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Tema;
use App\Models\Undangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AutentikasiController extends Controller
{
    public function formMasuk(): View
    {
        return view('autentikasi.masuk');
    }

    public function prosesMasuk(Request $request): RedirectResponse
    {
        $kredensial = $request->validate([
            'email' => ['required', 'email'],
            'kata_sandi' => ['required', 'string'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'kata_sandi.required' => 'Kata sandi wajib diisi.',
        ]);

        $pengguna = Pengguna::where('email', $kredensial['email'])->first();

        if (! $pengguna || ! Hash::check($kredensial['kata_sandi'], $pengguna->kata_sandi)) {
            return back()
                ->withErrors(['email' => 'Email atau kata sandi yang Anda masukkan tidak sesuai.'])
                ->onlyInput('email');
        }

        Auth::login($pengguna, $request->boolean('ingat_saya'));
        $request->session()->regenerate();

        if ($pengguna->adalahAdmin()) {
            return redirect()->intended('/admin');
        }

        return redirect()->intended('/dashboard');
    }

    public function formDaftar(Request $request): View
    {
        if ($request->filled('slug')) {
            $request->session()->put('draft_awal.slug', Str::slug((string) $request->query('slug')));
        }

        if ($request->filled('tema')) {
            $request->session()->put('draft_awal.tema_id', (int) $request->query('tema'));
        }

        $slugTerpilih = (string) ($request->query('slug')
            ? Str::slug((string) $request->query('slug'))
            : $request->session()->get('draft_awal.slug', ''));

        $temaTerpilihId = $request->query('tema')
            ? (int) $request->query('tema')
            : $request->session()->get('draft_awal.tema_id');

        $temaTerpilih = $temaTerpilihId
            ? Tema::where('aktif', true)->find($temaTerpilihId)
            : null;

        return view('autentikasi.daftar', [
            'slugTerpilih' => $slugTerpilih,
            'temaTerpilih' => $temaTerpilih,
        ]);
    }

    public function prosesDaftar(Request $request): RedirectResponse
    {
        $tervalidasi = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:pengguna,email'],
            'nomor_wa' => ['nullable', 'string', 'max:20'],
            'kata_sandi' => ['required', 'string', 'min:8', 'confirmed'],
            'slug' => ['nullable', 'string', 'max:120'],
            'tema_id' => ['nullable', 'integer'],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar. Silakan masuk ke akun Anda.',
            'kata_sandi.required' => 'Kata sandi wajib diisi.',
            'kata_sandi.min' => 'Kata sandi minimal terdiri dari 8 karakter.',
            'kata_sandi.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $pengguna = Pengguna::create([
            'nama' => $tervalidasi['nama'],
            'email' => $tervalidasi['email'],
            'nomor_wa' => $tervalidasi['nomor_wa'] ?? null,
            'kata_sandi' => Hash::make($tervalidasi['kata_sandi']),
            'peran' => 'client',
        ]);

        Auth::login($pengguna);
        $request->session()->regenerate();

        $slugInput = Str::slug((string) ($tervalidasi['slug'] ?? $request->session()->get('draft_awal.slug', '')));
        $temaInput = (int) ($tervalidasi['tema_id'] ?? $request->session()->get('draft_awal.tema_id', 0));

        if ($slugInput !== '' || $temaInput > 0) {
            $this->buatDraftUndanganAwal($pengguna, $slugInput, $temaInput);
        }

        $request->session()->forget('draft_awal');

        return redirect('/dashboard')->with('sukses', 'Selamat datang di SesiTemu! Akun Anda berhasil dibuat.');
    }

    public function keluar(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function buatDraftUndanganAwal(Pengguna $pengguna, string $slugInput, int $temaId): void
    {
        $tema = ($temaId > 0 ? Tema::where('aktif', true)->find($temaId) : null)
            ?? Tema::where('aktif', true)->first();

        if (! $tema) {
            return;
        }

        $slugDasar = $slugInput !== '' ? $slugInput : Str::slug($pengguna->nama).'-undangan';
        if ($slugDasar === '') {
            $slugDasar = 'undangan-pasangan';
        }

        $slugFinal = $slugDasar;
        $penghitung = 1;
        while (Undangan::where('slug', $slugFinal)->exists()) {
            $slugFinal = $slugDasar.'-'.$penghitung;
            $penghitung++;
        }

        $namaDepan = Str::before(trim($pengguna->nama), ' ');

        Undangan::create([
            'pengguna_id' => $pengguna->id,
            'tema_id' => $tema->id,
            'slug' => $slugFinal,
            'nama_panggilan_pria' => $namaDepan !== '' ? $namaDepan : 'Mempelai Pria',
            'nama_lengkap_pria' => $pengguna->nama,
            'nama_panggilan_wanita' => 'Pasangan',
            'nama_lengkap_wanita' => 'Nama Lengkap Pasangan',
            'pengaturan' => Undangan::pengaturanBawaan(),
            'status_publikasi' => false,
        ]);
    }
}
