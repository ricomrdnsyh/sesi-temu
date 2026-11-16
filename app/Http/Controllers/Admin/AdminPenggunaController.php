<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminPenggunaController extends Controller
{
    public function index(Request $request): View
    {
        $pencarian = trim((string) $request->query('q', ''));
        $peran = (string) $request->query('peran', 'semua');

        $query = Pengguna::withCount(['undangan', 'transaksi'])->latest();

        if (in_array($peran, ['admin', 'client'], true)) {
            $query->where('peran', $peran);
        }

        if ($pencarian !== '') {
            $query->where(function ($sub) use ($pencarian): void {
                $sub->where('nama', 'like', "%{$pencarian}%")
                    ->orWhere('email', 'like', "%{$pencarian}%")
                    ->orWhere('nomor_wa', 'like', "%{$pencarian}%");
            });
        }

        $daftarPengguna = $query->get();

        $editId = (int) $request->query('edit', 0);
        $penggunaEditAwal = $editId > 0 ? Pengguna::find($editId) : null;

        return view('admin.pengguna.index', [
            'daftarPengguna' => $daftarPengguna,
            'pencarian' => $pencarian,
            'peran' => $peran,
            'totalSemua' => Pengguna::count(),
            'totalAdmin' => Pengguna::where('peran', 'admin')->count(),
            'totalClient' => Pengguna::where('peran', 'client')->count(),
            'penggunaEditAwal' => $penggunaEditAwal,
        ]);
    }

    public function create(): View
    {
        return view('admin.pengguna.form', [
            'pengguna' => new Pengguna(['peran' => 'client']),
            'modeEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $tervalidasi = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:pengguna,email'],
            'nomor_wa' => ['nullable', 'string', 'max:20'],
            'peran' => ['required', Rule::in(['admin', 'client'])],
            'kata_sandi' => ['required', 'string', 'min:8'],
        ], [
            'nama.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar pada akun lain.',
            'peran.required' => 'Silakan pilih peran pengguna.',
            'kata_sandi.required' => 'Kata sandi wajib diisi saat membuat akun baru.',
            'kata_sandi.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $pengguna = Pengguna::create([
            'nama' => $tervalidasi['nama'],
            'email' => $tervalidasi['email'],
            'nomor_wa' => $this->normalisasiWa($tervalidasi['nomor_wa'] ?? null),
            'peran' => $tervalidasi['peran'],
            'kata_sandi' => Hash::make($tervalidasi['kata_sandi']),
        ]);

        return redirect()
            ->route('admin.pengguna.index')
            ->with('sukses', "Akun {$pengguna->peran} \"{$pengguna->nama}\" berhasil ditambahkan.");
    }

    public function show(Pengguna $pengguna): View
    {
        $pengguna->load([
            'undangan' => fn ($query) => $query->with('tema')->latest(),
            'transaksi' => fn ($query) => $query->with(['undangan', 'tema', 'promo'])->latest(),
        ]);

        return view('admin.pengguna.show', [
            'pengguna' => $pengguna,
        ]);
    }

    public function edit(Pengguna $pengguna): View
    {
        return view('admin.pengguna.form', [
            'pengguna' => $pengguna,
            'modeEdit' => true,
        ]);
    }

    public function update(Request $request, Pengguna $pengguna): RedirectResponse
    {
        $tervalidasi = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('pengguna', 'email')->ignore($pengguna->id)],
            'nomor_wa' => ['nullable', 'string', 'max:20'],
            'peran' => ['required', Rule::in(['admin', 'client'])],
            'kata_sandi' => ['nullable', 'string', 'min:8'],
        ], [
            'nama.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan akun lain.',
            'kata_sandi.min' => 'Kata sandi baru minimal 8 karakter.',
        ]);

        if ($request->user()->id === $pengguna->id && $tervalidasi['peran'] !== 'admin') {
            return back()
                ->withErrors(['peran' => 'Anda tidak dapat menurunkan peran akun yang sedang digunakan.'])
                ->withInput();
        }

        if (
            $pengguna->peran === 'admin'
            && $tervalidasi['peran'] !== 'admin'
            && Pengguna::where('peran', 'admin')->count() <= 1
        ) {
            return back()
                ->withErrors(['peran' => 'Platform minimal harus memiliki 1 akun Admin aktif.'])
                ->withInput();
        }

        $dataUpdate = [
            'nama' => $tervalidasi['nama'],
            'email' => $tervalidasi['email'],
            'nomor_wa' => $this->normalisasiWa($tervalidasi['nomor_wa'] ?? null),
            'peran' => $tervalidasi['peran'],
        ];

        if ($request->filled('kata_sandi')) {
            $dataUpdate['kata_sandi'] = Hash::make((string) $tervalidasi['kata_sandi']);
        }

        $pengguna->update($dataUpdate);

        $pesanSandi = $request->filled('kata_sandi') ? ' beserta kata sandi baru' : '';

        return redirect()
            ->route('admin.pengguna.index')
            ->with('sukses', "Data {$pengguna->nama} berhasil diperbarui{$pesanSandi}.");
    }

    public function destroy(Request $request, Pengguna $pengguna): RedirectResponse
    {
        if ($request->user()->id === $pengguna->id) {
            return back()->withErrors(['pengguna' => 'Anda tidak dapat menghapus akun Anda sendiri yang sedang login.']);
        }

        if ($pengguna->peran === 'admin' && Pengguna::where('peran', 'admin')->count() <= 1) {
            return back()->withErrors(['pengguna' => 'Tidak dapat menghapus satu-satunya akun Admin yang tersisa.']);
        }

        $nama = $pengguna->nama;
        $pengguna->delete();

        return back()->with('sukses', "Akun \"{$nama}\" berhasil dihapus.");
    }

    private function normalisasiWa(?string $nomorWa): ?string
    {
        $bersih = preg_replace('/[^0-9]/', '', (string) ($nomorWa ?? ''));
        if ($bersih === '') {
            return null;
        }

        if (str_starts_with($bersih, '0')) {
            return '62'.substr($bersih, 1);
        }

        return $bersih;
    }
}
