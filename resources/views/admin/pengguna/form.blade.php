@extends('admin.kerangka')

@section('judul', ($modeEdit ? 'Edit Pengguna' : 'Tambah Pengguna').' — Admin SesiTemu')

@section('isi_admin')
<div class="w-full max-w-3xl rounded-2xl bg-white p-6 sm:p-8 shadow-sm ring-1 ring-champagne/20">
    <div class="flex items-center justify-between gap-4 mb-6 pb-4 border-b border-champagne/20">
        <div>
            <h1 class="font-serif text-2xl sm:text-3xl font-bold text-charcoal">
                {{ $modeEdit ? 'Edit Data Pengguna' : 'Tambah Pengguna Baru' }}
            </h1>
            <p class="text-sm text-charcoal/65 mt-1">
                {{ $modeEdit ? 'Perbarui profil, peran akun, atau atur ulang kata sandi pengguna secara langsung.' : 'Buat akun baru untuk tim Administrator atau akun Client.' }}
            </p>
        </div>

        <a href="{{ route('admin.pengguna.index') }}" class="text-sm font-semibold text-charcoal/70 hover:underline shrink-0">← Kembali</a>
    </div>

    <form
        action="{{ $modeEdit ? route('admin.pengguna.update', $pengguna) : route('admin.pengguna.store') }}"
        method="POST"
        class="space-y-5"
        data-swal-loading
        data-swal-loading-title="{{ $modeEdit ? 'Memperbarui Pengguna...' : 'Menyimpan Pengguna Baru...' }}"
        data-swal-loading-text="Sedang menyimpan data akun pengguna..."
    >
        @csrf
        @if ($modeEdit)
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="nama" class="block text-sm font-medium text-charcoal">Nama Lengkap</label>
                <input
                    id="nama"
                    type="text"
                    name="nama"
                    required
                    value="{{ old('nama', $pengguna->nama) }}"
                    placeholder="Contoh: Admin Tim / Dimas &amp; Rani"
                    class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none"
                >
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-charcoal">Alamat Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    required
                    value="{{ old('email', $pengguna->email) }}"
                    placeholder="nama@domain.com"
                    class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none"
                >
            </div>

            <div>
                <label for="nomor_wa" class="block text-sm font-medium text-charcoal">Nomor WhatsApp</label>
                <input
                    id="nomor_wa"
                    type="text"
                    name="nomor_wa"
                    value="{{ old('nomor_wa', $pengguna->nomor_wa) }}"
                    placeholder="Contoh: 081234567890"
                    class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm font-mono focus:border-champagne focus:bg-white focus:outline-none"
                >
                <p class="mt-1 text-xs text-charcoal/55">Opsional untuk Admin; awalan 0 otomatis dinormalisasi ke 62.</p>
            </div>

            <div>
                <label for="peran" class="block text-sm font-medium text-charcoal">Peran Akun</label>
                <select
                    id="peran"
                    name="peran"
                    class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none"
                >
                    <option value="client" @selected(old('peran', $pengguna->peran) === 'client')>Client (Pembuat Undangan)</option>
                    <option value="admin" @selected(old('peran', $pengguna->peran) === 'admin')>Administrator (Pengelola Panel)</option>
                </select>
            </div>
        </div>

        <div class="rounded-xl border border-champagne/25 bg-ivory/50 p-4">
            <label for="kata_sandi" class="block text-sm font-semibold text-charcoal">
                {{ $modeEdit ? 'Kata Sandi Baru (Opsional / Reset Sandi)' : 'Kata Sandi' }}
            </label>
            <input
                id="kata_sandi"
                type="password"
                name="kata_sandi"
                minlength="8"
                @if (! $modeEdit) required @endif
                placeholder="{{ $modeEdit ? 'Kosongkan jika tidak ingin mengubah kata sandi (min 8 karakter)' : 'Minimal 8 karakter' }}"
                class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-white px-4 py-2.5 text-sm focus:border-champagne focus:outline-none"
            >
            <p class="mt-1 text-xs text-charcoal/60">
                {{ $modeEdit ? 'Isi kolom ini hanya jika Anda ingin mengganti atau mereset kata sandi akun ini.' : 'Minimal 8 karakter untuk login akun baru.' }}
            </p>
        </div>

        <div class="pt-2 flex items-center justify-end gap-3">
            <a href="{{ route('admin.pengguna.index') }}" class="rounded-xl border border-charcoal/15 px-5 py-2.5 text-sm font-semibold text-charcoal hover:bg-ivory transition">
                Batal
            </a>
            <button type="submit" class="rounded-xl bg-sage px-6 py-2.5 text-sm font-semibold text-white hover:bg-sage/90 cursor-pointer transition">
                {{ $modeEdit ? 'Simpan Perubahan' : 'Simpan Pengguna' }}
            </button>
        </div>
    </form>
</div>
@endsection
