@extends('admin.kerangka')

@section('judul', 'Manajemen Pengguna — Admin SesiTemu')

@section('isi_admin')
@php
    $adaGalat = $errors->any();
    $modeAwalEdit = $adaGalat
        ? old('_modal_mode') === 'edit'
        : $penggunaEditAwal !== null;

    $modalInit = [
        'modalTerbuka' => $adaGalat || $penggunaEditAwal !== null,
        'modeEdit' => $modeAwalEdit,
        'editId' => $adaGalat ? old('_edit_id') : $penggunaEditAwal?->id,
        'form' => [
            'nama' => (string) ($adaGalat ? old('nama', '') : ($penggunaEditAwal?->nama ?? '')),
            'email' => (string) ($adaGalat ? old('email', '') : ($penggunaEditAwal?->email ?? '')),
            'nomor_wa' => (string) ($adaGalat ? old('nomor_wa', '') : ($penggunaEditAwal?->nomor_wa ?? '')),
            'peran' => (string) ($adaGalat ? old('peran', 'client') : ($penggunaEditAwal?->peran ?? 'client')),
        ],
        'storeUrl' => route('admin.pengguna.store'),
        'updateBaseUrl' => url('/admin/pengguna'),
    ];
@endphp

<div
    x-data="{
        modalTerbuka: false,
        modeEdit: false,
        editId: null,
        form: { nama: '', email: '', nomor_wa: '', peran: 'client' },
        storeUrl: '',
        updateBaseUrl: '',
        init() {
            const initEl = document.getElementById('pengguna-modal-init');
            if (initEl) {
                const data = JSON.parse(initEl.textContent);
                this.modalTerbuka = Boolean(data.modalTerbuka);
                this.modeEdit = Boolean(data.modeEdit);
                this.editId = data.editId ?? null;
                this.form = { ...this.form, ...(data.form ?? {}) };
                this.storeUrl = data.storeUrl ?? '';
                this.updateBaseUrl = data.updateBaseUrl ?? '';
            }

            this.$el.addEventListener('click', (event) => {
                const tombolEdit = event.target.closest('[data-buka-modal-edit]');
                if (!tombolEdit) {
                    return;
                }

                const payload = JSON.parse(tombolEdit.dataset.pengguna || '{}');
                this.bukaModalEdit(payload);
            });
        },
        bukaModalTambah() {
            this.modeEdit = false;
            this.editId = null;
            this.form = { nama: '', email: '', nomor_wa: '', peran: 'client' };
            this.modalTerbuka = true;
        },
        bukaModalEdit(pengguna) {
            this.modeEdit = true;
            this.editId = pengguna.id;
            this.form = {
                nama: pengguna.nama || '',
                email: pengguna.email || '',
                nomor_wa: pengguna.nomor_wa || '',
                peran: pengguna.peran || 'client',
            };
            this.modalTerbuka = true;
        },
        tutupModal() {
            this.modalTerbuka = false;
        },
        actionForm() {
            return this.modeEdit && this.editId
                ? `${this.updateBaseUrl}/${this.editId}`
                : this.storeUrl;
        },
    }"
    @keydown.escape.window="if (!window.Swal?.isVisible()) tutupModal()"
    class="space-y-6"
>
    <script type="application/json" id="pengguna-modal-init">{!! json_encode($modalInit, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}</script>

    {{-- 3 KPI Ringkas Pengguna --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-champagne/20">
            <p class="text-xs font-medium text-charcoal/60">Total Semua Pengguna</p>
            <p class="mt-1.5 text-2xl font-bold text-charcoal">{{ $totalSemua }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-champagne/30">
            <p class="text-xs font-medium text-charcoal/60">Akun Administrator</p>
            <p class="mt-1.5 text-2xl font-bold text-charcoal">{{ $totalAdmin }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-sage/25">
            <p class="text-xs font-medium text-charcoal/60">Akun Client</p>
            <p class="mt-1.5 text-2xl font-bold text-sage">{{ $totalClient }}</p>
        </div>
    </div>

    <div class="rounded-2xl bg-white p-5 sm:p-6 shadow-sm ring-1 ring-champagne/20">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 mb-5 border-b border-champagne/20">
            <div>
                <h1 class="text-base sm:text-lg font-bold text-charcoal">Manajemen Pengguna</h1>
                <p class="text-xs text-charcoal/60 mt-0.5">Kelola akun Admin &amp; Client, tambah atau edit data beserta reset kata sandi langsung via modal.</p>
            </div>

            <button
                type="button"
                @click="bukaModalTambah()"
                data-buka-modal-tambah
                class="inline-flex items-center justify-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs bg-sage font-semibold text-white hover:bg-sage/90 cursor-pointer transition shrink-0"
            >
                <svg class="h-4 w-4 sm:h-3.5 sm:w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <line x1="19" x2="19" y1="8" y2="14"/>
                    <line x1="22" x2="16" y1="11" y2="11"/>
                </svg>
                <span>+ Tambah Pengguna</span>
            </button>
        </div>

        {{-- Kotak Filter Data --}}
        <form action="{{ route('admin.pengguna.index') }}" method="GET" class="rounded-xl border border-dashed border-sage/50 bg-ivory/50 p-4 mb-5">
            <div class="flex items-center gap-1.5 text-xs font-bold text-sage mb-3">
                <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M3 4a1 1 0 0 1 1-1h16a1 1 0 0 1 .78 1.625L15 11.85V19a1 1 0 0 1-1.447.894l-4-2A1 1 0 0 1 9 17v-5.15L3.22 4.625A1 1 0 0 1 3 4Z" />
                </svg>
                <span>Filter Data</span>
            </div>

            <div>
                <label for="filter_peran_pengguna" class="block text-xs font-medium text-charcoal/75 mb-1.5">Peran:</label>
                <select
                    id="filter_peran_pengguna"
                    name="peran"
                    data-auto-submit
                    class="w-full rounded-xl px-3.5 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-white"
                >
                    <option value="semua" @selected($peran === 'semua')>Semua Peran</option>
                    <option value="admin" @selected($peran === 'admin')>Admin</option>
                    <option value="client" @selected($peran === 'client')>Client</option>
                </select>
            </div>
        </form>

        <table data-datatable data-page-length="10" data-empty-message="Belum ada pengguna yang cocok dengan filter." class="w-full text-sm">
            <thead>
                <tr class="border-b border-champagne/20 text-left text-xs uppercase text-charcoal/60">
                    <th data-no-sort class="py-3 dt-center text-center">Aksi</th>
                    <th class="py-3 pr-4">Nama &amp; Email</th>
                    <th class="py-3 pr-4">Peran</th>
                    <th class="py-3 pr-4">WhatsApp</th>
                    <th class="py-3 pr-4 dt-left">Undangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-champagne/15">
                @foreach ($daftarPengguna as $pengguna)
                    @php
                        $waBersih = preg_replace('/[^0-9]/', '', (string) $pengguna->nomor_wa);
                        if ($waBersih && str_starts_with($waBersih, '0')) {
                            $waBersih = '62'.substr($waBersih, 1);
                        }
                        $akunSendiri = auth()->id() === $pengguna->id;
                        $payloadEdit = json_encode([
                            'id' => $pengguna->id,
                            'nama' => $pengguna->nama,
                            'email' => $pengguna->email,
                            'nomor_wa' => (string) ($pengguna->nomor_wa ?? ''),
                            'peran' => $pengguna->peran,
                        ], JSON_UNESCAPED_UNICODE);
                    @endphp
                    <tr>
                        <td class="py-3.5 dt-center text-center whitespace-nowrap">
                            <div class="inline-flex items-center justify-center gap-1.5">
                                <a
                                    href="{{ route('admin.pengguna.show', $pengguna) }}"
                                    title="Lihat Detail Pengguna"
                                    aria-label="Lihat Detail Pengguna"
                                    class="inline-flex h-8 w-8 sm:h-7 sm:w-7 items-center justify-center rounded-lg border border-charcoal/15 bg-white text-charcoal/75 hover:border-sage/40 hover:bg-sage/5 hover:text-sage transition"
                                >
                                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </a>

                                <button
                                    type="button"
                                    data-buka-modal-edit
                                    data-pengguna="{{ $payloadEdit }}"
                                    title="Edit Data &amp; Reset Kata Sandi"
                                    aria-label="Edit Data &amp; Reset Kata Sandi"
                                    class="inline-flex h-8 w-8 sm:h-7 sm:w-7 items-center justify-center rounded-lg border border-champagne/50 bg-champagne/10 text-amber-700 hover:bg-champagne/25 cursor-pointer transition"
                                >
                                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>
                                    </svg>
                                </button>

                                @if (! $akunSendiri)
                                    <form
                                        action="{{ route('admin.pengguna.destroy', $pengguna) }}"
                                        method="POST"
                                        data-swal-title="Hapus Pengguna?"
                                        data-swal-confirm="Yakin ingin menghapus akun {{ $pengguna->nama }} ({{ $pengguna->email }})?"
                                        data-swal-icon="warning"
                                        data-swal-confirm-button="Ya, Hapus"
                                        data-swal-confirm-color="#DC2626"
                                        data-swal-loading-title="Menghapus Pengguna..."
                                        data-swal-loading-text="Sedang menghapus akun pengguna..."
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            title="Hapus Pengguna"
                                            aria-label="Hapus Pengguna"
                                            class="inline-flex h-8 w-8 sm:h-7 sm:w-7 items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-700 hover:bg-red-100 cursor-pointer transition"
                                        >
                                            <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M3 6h18"/>
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                        <td class="py-3.5 pr-4">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-charcoal">{{ $pengguna->nama }}</span>
                                @if ($akunSendiri)
                                    <span class="rounded-full bg-champagne/25 px-2 py-0.5 text-[10px] font-bold text-charcoal">Akun Anda</span>
                                @endif
                            </div>
                            <p class="text-xs text-charcoal/65">{{ $pengguna->email }}</p>
                        </td>
                        <td class="py-3.5 pr-4">
                            @if ($pengguna->peran === 'admin')
                                <span class="rounded-full bg-charcoal px-2.5 py-0.5 text-xs font-semibold text-champagne">Admin</span>
                            @else
                                <span class="rounded-full bg-sage/15 px-2.5 py-0.5 text-xs font-semibold text-sage">Client</span>
                            @endif
                        </td>
                        <td class="py-3.5 pr-4">
                            @if ($waBersih)
                                <a
                                    href="https://wa.me/{{ $waBersih }}?text={{ urlencode('Halo Kak '.$pengguna->nama.', kami dari tim SesiTemu siap membantu Anda.') }}"
                                    target="_blank"
                                    rel="noopener"
                                    class="inline-flex items-center gap-1 rounded-lg bg-sage/10 px-2.5 py-1.5 sm:px-2 sm:py-1 text-xs font-semibold text-sage hover:bg-sage/20 transition"
                                >
                                    <svg class="h-3.5 w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>
                                    </svg>
                                    <span>Chat {{ $pengguna->nomor_wa }}</span>
                                </a>
                            @else
                                <span class="text-xs text-charcoal/50">-</span>
                            @endif
                        </td>
                        <td class="py-3.5 pr-4 font-semibold dt-left">{{ $pengguna->undangan_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal Form Tambah & Edit Pengguna --}}
    <div
        x-show="modalTerbuka"
        x-cloak
        x-transition.opacity.duration.150ms
        @click.self="tutupModal()"
        role="dialog"
        aria-modal="true"
        aria-labelledby="judul-modal-pengguna"
        class="fixed inset-0 z-50 flex items-center justify-center bg-charcoal/60 backdrop-blur-xs p-4 overflow-y-auto"
    >
        <div class="w-full max-w-2xl lg:max-w-3xl rounded-2xl bg-white px-5 pt-5 pb-4 sm:px-6 sm:pt-5 sm:pb-4 shadow-2xl ring-1 ring-champagne/25 my-8">
            <div class="flex items-start justify-between gap-4 pb-5 border-b border-champagne/20">
                <div>
                    <h2 id="judul-modal-pengguna" class="font-serif text-2xl sm:text-3xl font-bold text-charcoal" x-text="modeEdit ? 'Edit Data Pengguna' : 'Tambah Pengguna Baru'"></h2>
                    <p class="text-sm text-charcoal/65 mt-1" x-text="modeEdit ? 'Perbarui profil, peran akun, atau atur ulang kata sandi pengguna.' : 'Buat akun baru untuk tim Administrator atau akun Client.'"></p>
                </div>

                <button
                    type="button"
                    @click="tutupModal()"
                    aria-label="Tutup modal"
                    class="rounded-lg p-1.5 text-charcoal/55 hover:bg-ivory hover:text-charcoal cursor-pointer transition"
                >
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form
                :action="actionForm()"
                method="POST"
                class="mt-6 space-y-5"
                data-swal-loading
                :data-swal-loading-title="modeEdit ? 'Memperbarui Pengguna...' : 'Menyimpan Pengguna Baru...'"
                data-swal-loading-text="Sedang menyimpan data akun pengguna..."
            >
                @csrf
                <template x-if="modeEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>
                <input type="hidden" name="_modal_mode" :value="modeEdit ? 'edit' : 'create'">
                <input type="hidden" name="_edit_id" :value="editId ?? ''">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label for="modal_nama" class="block text-xs font-semibold text-charcoal/80 mb-1">Nama Lengkap</label>
                        <input
                            id="modal_nama"
                            type="text"
                            name="nama"
                            required
                            x-model="form.nama"
                            placeholder="Contoh: Admin Tim / Dimas &amp; Rani"
                            class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:bg-white focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="modal_email" class="block text-xs font-semibold text-charcoal/80 mb-1">Alamat Email</label>
                        <input
                            id="modal_email"
                            type="email"
                            name="email"
                            required
                            x-model="form.email"
                            placeholder="nama@domain.com"
                            class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:bg-white focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="modal_nomor_wa" class="block text-xs font-semibold text-charcoal/80 mb-1">Nomor WhatsApp</label>
                        <input
                            id="modal_nomor_wa"
                            type="text"
                            name="nomor_wa"
                            x-model="form.nomor_wa"
                            placeholder="Contoh: 081234567890"
                            class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 font-mono focus:border-champagne focus:bg-white focus:outline-none"
                        >
                    </div>

                    <div>
                        <label for="modal_peran" class="block text-xs font-semibold text-charcoal/80 mb-1">Peran Akun</label>
                        <select
                            id="modal_peran"
                            name="peran"
                            x-model="form.peran"
                            class="w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-ivory/60 focus:border-champagne focus:bg-white focus:outline-none"
                        >
                            <option value="client">Client (Pembuat Undangan)</option>
                            <option value="admin">Administrator (Pengelola Panel)</option>
                        </select>
                    </div>
                </div>

                <div class="rounded-xl border border-champagne/25 bg-ivory/50 p-4">
                    <label
                        for="modal_kata_sandi"
                        class="block text-xs font-semibold text-charcoal"
                        x-text="modeEdit ? 'Kata Sandi Baru (Opsional / Reset Sandi)' : 'Kata Sandi'"
                    ></label>
                    <input
                        id="modal_kata_sandi"
                        type="password"
                        name="kata_sandi"
                        minlength="8"
                        :required="!modeEdit"
                        :placeholder="modeEdit ? 'Kosongkan jika tidak mengubah kata sandi (min 8)' : 'Minimal 8 karakter'"
                        class="mt-1.5 w-full rounded-xl px-3.5 py-2.5 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 bg-white focus:border-champagne focus:outline-none"
                    >
                    <p
                        class="mt-1 text-[11px] text-charcoal/60"
                        x-text="modeEdit ? 'Isi kolom ini hanya jika ingin mengganti atau mereset kata sandi pengguna.' : 'Minimal 8 karakter untuk login akun baru.'"
                    ></p>
                </div>

                <div class="pt-3.5 border-t border-champagne/20 flex items-center justify-end gap-2">
                    <button
                        type="button"
                        @click="tutupModal()"
                        class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3 sm:py-1.5 sm:text-xs border border-charcoal/15 font-semibold text-charcoal hover:bg-ivory cursor-pointer transition"
                    >
                        <svg class="h-4 w-4 sm:h-3.5 sm:w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                        <span>Batal</span>
                    </button>
                    <button
                        type="submit"
                        class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-sm sm:rounded-lg sm:px-3.5 sm:py-1.5 sm:text-xs bg-sage font-semibold text-white hover:bg-sage/90 cursor-pointer transition"
                    >
                        <svg class="h-4 w-4 sm:h-3.5 sm:w-3.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                            <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                            <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                        </svg>
                        <span x-text="modeEdit ? 'Simpan Perubahan' : 'Simpan Pengguna'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
