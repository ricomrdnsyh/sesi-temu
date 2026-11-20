{{-- Modal Buat Draft Undangan Baru (Floating centered di mobile & desktop) --}}
<div
    x-show="modalBuatBaru"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-charcoal/60 backdrop-blur-sm p-4"
    @keydown.escape.window="if (!window.Swal?.isVisible()) modalBuatBaru = false"
>
    <div @click.away="if (!window.Swal?.isVisible() && !$event.target?.closest('.swal2-container')) modalBuatBaru = false" class="w-full max-w-lg rounded-3xl sm:rounded-2xl bg-white p-5 sm:p-6 shadow-2xl ring-1 ring-champagne/30 max-h-[88dvh] overflow-y-auto">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-wider text-sage">Draft Gratis</p>
                <h3 class="mt-0.5 font-sans text-lg sm:text-xl font-bold text-charcoal tracking-tight">Buat Draft Undangan Baru</h3>
                <p class="mt-1 text-xs sm:text-sm text-charcoal/70">Isi data singkat awal; detail lengkap dapat diatur di editor 7-tab.</p>
            </div>
            <button type="button" @click="modalBuatBaru = false" aria-label="Tutup modal buat draft" class="rounded-lg p-1.5 text-charcoal/55 hover:bg-ivory cursor-pointer">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>

        <form
            action="{{ route('dashboard.undangan.simpan') }}"
            method="POST"
            class="mt-5 space-y-4"
            data-swal-loading
            data-swal-loading-title="Membuat Draft Undangan..."
            data-swal-loading-text="Menyiapkan link dan halaman editor undangan Anda..."
        >
            @csrf

            <div>
                <label for="tema_id" class="block text-sm font-medium text-charcoal">Pilih Tema</label>
                <select id="tema_id" name="tema_id" x-model="temaTerpilihModal" required class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-4 py-2.5 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                    @foreach ($daftarTema as $tema)
                        <option value="{{ $tema->id }}">{{ $tema->nama_tema }} ({{ $tema->kategoriLabel() }} • {{ $tema->tierLabel() }} — {{ $tema->hargaFormatted() }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="slug_baru" class="block text-sm font-medium text-charcoal">Link Undangan</label>
                <div class="mt-1.5 flex items-center rounded-xl border @error('slug') border-rose-400 ring-2 ring-rose-500/15 @else border-charcoal/15 @enderror bg-ivory/60 px-3.5 py-2.5 focus-within:border-champagne focus-within:bg-white">
                    <span class="text-sm text-charcoal/50">sesitemu.id/</span>
                    <input id="slug_baru" name="slug" type="text" value="{{ old('slug', request()->query('slug', '')) }}" required placeholder="raka-maya" class="w-full bg-transparent text-sm font-semibold focus:outline-none ml-0.5">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nama_panggilan_pria" class="block text-sm font-medium text-charcoal">Panggilan Pria</label>
                    <input id="nama_panggilan_pria" name="nama_panggilan_pria" type="text" value="{{ old('nama_panggilan_pria') }}" required placeholder="Raka" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                </div>
                <div>
                    <label for="nama_lengkap_pria" class="block text-sm font-medium text-charcoal">Nama Lengkap Pria</label>
                    <input id="nama_lengkap_pria" name="nama_lengkap_pria" type="text" value="{{ old('nama_lengkap_pria') }}" required placeholder="Raka Wijaya" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="nama_panggilan_wanita" class="block text-sm font-medium text-charcoal">Panggilan Wanita</label>
                    <input id="nama_panggilan_wanita" name="nama_panggilan_wanita" type="text" value="{{ old('nama_panggilan_wanita') }}" required placeholder="Maya" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                </div>
                <div>
                    <label for="nama_lengkap_wanita" class="block text-sm font-medium text-charcoal">Nama Lengkap Wanita</label>
                    <input id="nama_lengkap_wanita" name="nama_lengkap_wanita" type="text" value="{{ old('nama_lengkap_wanita') }}" required placeholder="Maya Sari" class="mt-1.5 w-full rounded-xl border border-charcoal/15 bg-ivory/60 px-3.5 py-2 text-sm focus:border-champagne focus:bg-white focus:outline-none">
                </div>
            </div>

            <div class="pt-2 flex justify-end gap-2.5">
                <button type="button" @click="modalBuatBaru = false" class="rounded-xl border border-charcoal/20 bg-white px-4 py-2 text-sm font-semibold text-charcoal/75 hover:bg-ivory hover:border-charcoal/30 active:scale-95 transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-sage px-5 py-2 text-sm font-semibold text-white hover:bg-[#3b5047] active:scale-95 transition cursor-pointer">
                    <svg class="h-4 w-4 text-champagne shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z" />
                        <path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7" />
                        <path d="M7 3v4a1 1 0 0 0 1 1h7" />
                    </svg>
                    <span>Simpan Draft</span>
                </button>
            </div>
        </form>
    </div>
</div>
