<?php

namespace Tests\Feature;

use App\Models\AcaraUndangan;
use App\Models\Pengguna;
use App\Models\Tema;
use App\Models\Undangan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TemaMotion3DTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Memastikan seluruh 9 tema memakai sampul fade halus (tanpa buka buku/belah pintu)
     * dan merender panggung 3D Diorama serta ornamen WebP valid.
     */
    public function test_semua_tema_merender_diorama_3d_fade_halus_dan_ornamen_valid(): void
    {
        $daftarTema = [
            [
                'slug' => 'adat-jawa',
                'nama' => 'Adat Jawa Keraton',
                'kategori' => 'adat',
                'tier' => 'premium',
                'gaya' => 'keraton',
                'ornamen' => 'aset-tema/adat-jawa/ornamen-gunungan.webp',
                'penandaGerak' => 'animasi-burung',
            ],
            [
                'slug' => 'sunda-heritage',
                'nama' => 'Sunda Siger Heritage',
                'kategori' => 'adat',
                'tier' => 'premium',
                'gaya' => 'priangan',
                'ornamen' => 'aset-tema/sunda-heritage/ornamen-siger.webp',
                'penandaGerak' => 'animasi-burung',
            ],
            [
                'slug' => 'islamic-heavenly',
                'nama' => 'Islamic Heavenly',
                'kategori' => 'islami',
                'tier' => 'eksklusif',
                'gaya' => 'celestial',
                'ornamen' => 'aset-tema/islamic-heavenly/ornamen-sabit.webp',
                'penandaGerak' => 'animasi-bintang-jatuh',
            ],
            [
                'slug' => 'islami-syari',
                'nama' => 'Islami Syari Emerald',
                'kategori' => 'islami',
                'tier' => 'basic',
                'gaya' => 'mihrab',
                'ornamen' => 'aset-tema/islami-syari/ornamen-arabesque.webp',
                'penandaGerak' => 'animasi-sinar',
            ],
            [
                'slug' => 'luxury-noir',
                'nama' => 'Luxury Noir Gold',
                'kategori' => 'elegan',
                'tier' => 'eksklusif',
                'gaya' => 'artdeco',
                'ornamen' => 'aset-tema/luxury-noir/ornamen-emas.webp',
                'penandaGerak' => 'animasi-debu-emas',
            ],
            [
                'slug' => 'royal-ivory',
                'nama' => 'Royal Ivory Cathedral',
                'kategori' => 'elegan',
                'tier' => 'premium',
                'gaya' => 'katedral',
                'ornamen' => 'aset-tema/royal-ivory/ornamen-katedral.webp',
                'penandaGerak' => 'animasi-sinar',
            ],
            [
                'slug' => 'velvet-garden',
                'nama' => 'Velvet Garden Motion',
                'kategori' => 'floral',
                'tier' => 'eksklusif',
                'gaya' => 'taman',
                'ornamen' => 'aset-tema/velvet-garden/ornamen-botani.webp',
                'penandaGerak' => 'animasi-kelopak-3d',
            ],
            [
                'slug' => 'rustic-floral',
                'nama' => 'Rustic Floral',
                'kategori' => 'floral',
                'tier' => 'basic',
                'gaya' => 'klasik',
                'ornamen' => 'aset-tema/rustic-floral/ornamen-sudut.webp',
                'penandaGerak' => 'animasi-kelopak-3d',
            ],
            [
                'slug' => 'editorial-monokrom',
                'nama' => 'Editorial Monokrom',
                'kategori' => 'modern',
                'tier' => 'premium',
                'gaya' => 'editorial',
                'ornamen' => 'aset-tema/editorial-monokrom/ornamen-bingkai.webp',
                'penandaGerak' => 'animasi-sinar',
            ],
        ];

        foreach ($daftarTema as $item) {
            $pathOrnamen = public_path($item['ornamen']);
            $this->assertFileExists($pathOrnamen);
            $this->assertGreaterThan(10000, filesize($pathOrnamen));

            Tema::create([
                'nama_tema' => $item['nama'],
                'slug' => $item['slug'],
                'kategori' => $item['kategori'],
                'tier' => $item['tier'],
                'lokasi_view' => 'tema.'.$item['slug'].'.index',
                'aktif' => true,
            ]);

            $respon = $this->get('/demo/'.$item['slug'].'?kanvas=1');
            $respon->assertOk()
                ->assertSee('panggung-3d', false)
                ->assertSee('kartu-3d', false)
                ->assertSee('animasi-ayun-3d', false)
                ->assertSee('data-panggung-3d', false)
                ->assertSee('data-diorama-3d="'.$item['tier'].'"', false)
                ->assertSee('data-intro-pembuka="'.$item['slug'].'"', false)
                ->assertSee('data-intro-keluar="fade-halus"', false)
                ->assertSee('data-intro-keluar-ms="1350"', false)
                ->assertSee('intro-seragam-panggung', false)
                ->assertSee('data-transisi-sampul="fade-halus"', false)
                ->assertSee('tirai-fade-halus', false)
                ->assertSee('data-autoscroll-dock', false)
                ->assertSee('data-scroll-scrub', false)
                ->assertSee('data-sinema-gsap=', false)
                ->assertSee('data-gsap="potret"', false)
                ->assertSee('data-lenis-prevent', false)
                ->assertSee('data-layout-mempelai="'.$item['gaya'].'"', false)
                ->assertSee('data-layout-countdown="'.$item['gaya'].'"', false)
                ->assertSee('data-layout-acara="'.$item['gaya'].'"', false)
                ->assertSee('data-layout-penutup="'.$item['gaya'].'"', false)
                ->assertSee('fx-slide-left', false)
                ->assertSee('fx-slide-right', false)
                ->assertSee('Buka Undangan', false)
                ->assertSee('We Are Getting Married!', false)
                ->assertSee('Save The Date', false)
                ->assertSee('Kami Yang Berbahagia', false)
                ->assertSee('--s2-dropdown-bg:', false)
                ->assertSee('--s2-option-selected-bg:', false)
                ->assertSee($item['ornamen'], false)
                ->assertSee($item['penandaGerak'], false);

            $konten = $respon->getContent();

            // Pastikan seluruh tema bebas dari animasi buka buku / belah pintu / lipat katedral
            $this->assertStringNotContainsString('panel-gerbang-kiri', $konten);
            $this->assertStringNotContainsString('panel-gerbang-kanan', $konten);
            $this->assertStringNotContainsString('lipat-katedral-3d', $konten);
            $this->assertStringNotContainsString('halaman-editorial-3d', $konten);
            $this->assertStringNotContainsString('rotateY(-108deg)', $konten);
            $this->assertStringNotContainsString('rotateY(-112deg)', $konten);
            $this->assertStringNotContainsString('rotateX(78deg)', $konten);

            $this->assertStringNotContainsString('&amp;bull;', $konten);
            $this->assertStringNotContainsString('&amp;amp;', $konten);
            $this->assertStringNotContainsString('rekeningTersalin ===  ?', $konten);

            if (preg_match('/<div[^>]+lg:w-\[(?:445|460)px\][^>]*>/', $konten, $cocokKolom)) {
                $this->assertStringNotContainsString('panggung-3d', $cocokKolom[0]);
            }

            if ($item['slug'] === 'adat-jawa') {
                $respon->assertSee('rounded-[500px]', false)
                    ->assertSee('diorama-kamera-3d', false)
                    ->assertSee('intro-seragam-panggung', false)
                    ->assertSee('data-sinema-gsap="jawa"', false)
                    ->assertSee('data-gsap="potret"', false)
                    ->assertSee('data-lenis-prevent', false);

                // Mode embed (Studio Ganti Tema) tidak merender intro splash agar pergantian tema instan
                $this->get('/demo/'.$item['slug'].'?kanvas=1&embed=1')
                    ->assertOk()
                    ->assertDontSee('class="intro-pembuka-tirai', false)
                    ->assertDontSee('intro-seragam-panggung', false);
            } elseif ($item['slug'] === 'sunda-heritage') {
                $respon->assertSee('diorama-kamera-3d', false)
                    ->assertSee('rounded-t-[10.5rem]', false)
                    ->assertSee('sunda-motion-hero.mp4?v=3', false)
                    ->assertSee('data-start-at="0"', false)
                    ->assertSee('data-playback-rate="1.2"', false)
                    ->assertSee('data-reveal-at="20.4"', false)
                    ->assertSee('data-settled-at="22.8"', false)
                    ->assertSee('data-sinema-gsap="sunda"', false)
                    ->assertSee('data-gsap="potret"', false)
                    ->assertSee('data-gsap="garis"', false)
                    ->assertSee('data-lenis-prevent', false);
            } elseif ($item['tier'] === 'eksklusif' || $item['tier'] === 'premium') {
                $respon->assertSee('diorama-kamera-3d', false);
                if ($item['slug'] !== 'editorial-monokrom') {
                    $respon->assertSee('rounded-t-[10.5rem]', false);
                }
            } else {
                $respon->assertSee('diorama-latar-basic', false)
                    ->assertSee('rounded-t-[10.5rem]', false);
            }
        }
    }

    /**
     * Memastikan flagship Adat Jawa Keraton memiliki 10 aset WebP berlapis valid,
     * merender seluruh 13 seksi termasuk fitur baru, serta aman pada Mode Tanpa Foto (TF).
     */
    public function test_flagship_adat_jawa_merender_10_aset_berlapis_13_seksi_dan_mode_tanpa_foto(): void
    {
        $asetWajib = [
            'aset-tema/adat-jawa/latar-hutan-jawa.webp',
            'aset-tema/adat-jawa/pendopo-joglo.webp',
            'aset-tema/adat-jawa/gunungan-pembuka.webp',
            'aset-tema/adat-jawa/bingkai-ukiran.webp',
            'aset-tema/adat-jawa/janur-kuning.webp',
            'aset-tema/adat-jawa/sayap-wayang.webp',
            'aset-tema/adat-jawa/bunga-depan.webp',
            'aset-tema/adat-jawa/bunga-lili.webp',
            'aset-tema/adat-jawa/motif-kawung-atas.webp',
            'aset-tema/adat-jawa/motif-kawung-bawah.webp',
        ];

        foreach ($asetWajib as $jalur) {
            $penuh = public_path($jalur);
            $this->assertFileExists($penuh);
            $this->assertGreaterThan(10000, filesize($penuh));
        }

        Tema::create([
            'nama_tema' => 'Adat Jawa Keraton',
            'slug' => 'adat-jawa',
            'kategori' => 'adat',
            'tier' => 'premium',
            'lokasi_view' => 'tema.adat-jawa.index',
            'aktif' => true,
        ]);

        $respon = $this->get('/demo/adat-jawa?kanvas=1&to=Raden+Bagus');
        $respon->assertOk()
            ->assertSee('Raden Bagus', false)
            ->assertSee('Pinyon+Script', false)
            ->assertSee('Cormorant+Infant', false)
            ->assertSee('jawa-sapu-kiri', false)
            ->assertSee('jawa-bingkai-masuk', false)
            ->assertSee('jawa-janur-kiri', false)
            ->assertSee('data-section-dress-code="keraton"', false)
            ->assertSee('data-section-doa-pengantin="keraton"', false)
            ->assertSee('data-section-turut-mengundang="keraton"', false)
            ->assertSee('Doa Untuk Pengantin', false)
            ->assertSee('Turut Mengundang', false)
            ->assertSee('akmal.hadiningrat', false)
            ->assertSee('aisyah.kusumo', false);

        foreach ($asetWajib as $jalur) {
            $respon->assertSee($jalur, false);
        }

        // Mode Tanpa Foto (?tf=1) menyembunyikan foto mempelai & galeri tanpa merusak diorama
        $this->get('/demo/adat-jawa?kanvas=1&tf=1')
            ->assertOk()
            ->assertSee('jawa-bingkai-masuk', false)
            ->assertSee('Akmal', false)
            ->assertSee('Aisyah', false)
            ->assertDontSee('mempelai-pria.webp', false)
            ->assertDontSee('mempelai-wanita.webp', false)
            ->assertDontSee('sampul-jawa.webp', false)
            ->assertDontSee('galeri-cincin-mawar.webp', false);
    }

    /**
     * Memastikan client dapat menyimpan Instagram mempelai, Dress Code, dan Turut Mengundang
     * melalui dashboard dan tampil utuh pada halaman undangan publik.
     */
    public function test_dashboard_menyimpan_instagram_dress_code_dan_turut_mengundang_dan_tampil_di_publik(): void
    {
        $client = Pengguna::factory()->create(['peran' => 'client']);
        $tema = Tema::create([
            'nama_tema' => 'Adat Jawa Keraton',
            'slug' => 'adat-jawa',
            'kategori' => 'adat',
            'tier' => 'premium',
            'lokasi_view' => 'tema.adat-jawa.index',
            'aktif' => true,
        ]);

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $tema->id,
            'slug' => 'akmal-aisyah-keraton',
            'nama_panggilan_pria' => 'Akmal',
            'nama_lengkap_pria' => 'Akmal Wirawan',
            'nama_panggilan_wanita' => 'Aisyah',
            'nama_lengkap_wanita' => 'Aisyah Paramita',
            'pengaturan' => Undangan::pengaturanBawaan(),
            'status_publikasi' => true,
            'berlaku_sampai' => now()->addMonths(3),
        ]);

        AcaraUndangan::create([
            'undangan_id' => $undangan->id,
            'nama_acara' => 'Akad Nikah',
            'tanggal_acara' => now()->addDays(20)->toDateString(),
            'waktu_mulai' => '08:00:00',
            'waktu_selesai' => '10:00:00',
            'zona_waktu' => 'WIB',
            'nama_tempat' => 'Pendopo Keraton',
            'alamat_lengkap' => 'Yogyakarta',
        ]);

        // Simpan Instagram di tab mempelai (menguji sanitasi @ dan URL)
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'mempelai',
                'nama_panggilan_pria' => 'Akmal',
                'nama_lengkap_pria' => 'Akmal Wirawan',
                'nama_panggilan_wanita' => 'Aisyah',
                'nama_lengkap_wanita' => 'Aisyah Paramita',
                'instagram_pria' => 'https://instagram.com/akmal_keraton/?hl=id',
                'instagram_wanita' => '@aisyah.jawa',
            ])
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertSessionHasNoErrors();

        // Simpan Dress Code & Turut Mengundang di tab cerita_streaming
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'cerita_streaming',
                'dress_code_disertakan' => '1',
                'dress_code_catatan' => 'Busana batik sogan dan kebaya krem.',
                'dress_code_warna' => ['#472a1c', '#d7bb83', '#fffaf5'],
                'turut_mengundang_wanita' => "Keluarga Besar Bpk. Suryono\nKeluarga Ndalem Timur",
                'turut_mengundang_pria' => "Keluarga Besar Bpk. Darmawan\nTrah Mataram",
            ])
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertSessionHasNoErrors();

        $undangan->refresh();
        $this->assertSame('akmal_keraton', $undangan->instagramPria());
        $this->assertSame('aisyah.jawa', $undangan->instagramWanita());
        $this->assertSame('Busana batik sogan dan kebaya krem.', $undangan->dressCodeCatatan());
        $this->assertSame(['#472A1C', '#D7BB83', '#FFFAF5'], $undangan->dressCodeWarna());
        $this->assertSame(['Keluarga Besar Bpk. Suryono', 'Keluarga Ndalem Timur'], $undangan->turutMengundangWanita());
        $this->assertSame(['Keluarga Besar Bpk. Darmawan', 'Trah Mataram'], $undangan->turutMengundangPria());

        // Verifikasi tampil di halaman undangan publik
        $this->get('/akmal-aisyah-keraton?to=Tamu+VIP')
            ->assertOk()
            ->assertSee('https://instagram.com/akmal_keraton', false)
            ->assertSee('https://instagram.com/aisyah.jawa', false)
            ->assertSee('Busana batik sogan dan kebaya krem.')
            ->assertSee('#472A1C', false)
            ->assertSee('#D7BB83', false)
            ->assertSee('Keluarga Ndalem Timur')
            ->assertSee('Trah Mataram');
    }

    /**
     * Memastikan user dapat mengustomisasi seluruh foto tema (sampul, pembuka, penutup,
     * latar tema, dan foto per-bab cerita cinta) + hashtag dari dashboard, tampil pada
     * undangan publik, disembunyikan saat Mode Tanpa Foto, serta bisa dihapus bersih.
     */
    public function test_dashboard_kustomisasi_foto_lengkap_dan_foto_bab_cerita_serta_aman_mode_tanpa_foto(): void
    {
        Storage::fake('public');

        $client = Pengguna::factory()->create(['peran' => 'client']);
        $temaJawa = Tema::create([
            'nama_tema' => 'Adat Jawa Keraton',
            'slug' => 'adat-jawa',
            'kategori' => 'adat',
            'tier' => 'premium',
            'lokasi_view' => 'tema.adat-jawa.index',
            'aktif' => true,
        ]);

        $temaSunda = Tema::create([
            'nama_tema' => 'Sunda Siger Heritage',
            'slug' => 'sunda-heritage',
            'kategori' => 'adat',
            'tier' => 'premium',
            'lokasi_view' => 'tema.sunda-heritage.index',
            'aktif' => true,
        ]);

        $undangan = Undangan::create([
            'pengguna_id' => $client->id,
            'tema_id' => $temaJawa->id,
            'slug' => 'kustom-foto-lengkap',
            'nama_panggilan_pria' => 'Dimas',
            'nama_lengkap_pria' => 'Dimas Prasetya',
            'nama_panggilan_wanita' => 'Laras',
            'nama_lengkap_wanita' => 'Larasati Ningrum',
            'pengaturan' => Undangan::pengaturanBawaan(),
            'status_publikasi' => true,
            'berlaku_sampai' => now()->addMonths(3),
        ]);

        AcaraUndangan::create([
            'undangan_id' => $undangan->id,
            'nama_acara' => 'Akad Nikah',
            'tanggal_acara' => now()->addDays(15)->toDateString(),
            'waktu_mulai' => '09:00:00',
            'waktu_selesai' => '11:00:00',
            'zona_waktu' => 'WIB',
            'nama_tempat' => 'Pendopo Agung',
            'alamat_lengkap' => 'Surakarta',
        ]);

        // 1. Upload foto sampul, pembuka, penutup, latar tema + hashtag dari tab Mempelai
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'mempelai',
                'nama_panggilan_pria' => 'Dimas',
                'nama_lengkap_pria' => 'Dimas Prasetya',
                'nama_panggilan_wanita' => 'Laras',
                'nama_lengkap_wanita' => 'Larasati Ningrum',
                'hashtag' => 'DimasLarasSelamanya',
                'foto_sampul' => UploadedFile::fake()->image('sampul.jpg', 900, 1200),
                'foto_pembuka' => UploadedFile::fake()->image('pembuka.jpg', 900, 1200),
                'foto_penutup' => UploadedFile::fake()->image('penutup.jpg', 900, 1200),
                'foto_latar_tema' => UploadedFile::fake()->image('latar.jpg', 1000, 1400),
            ])
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertSessionHasNoErrors();

        // 2. Upload foto per-bab pada tab Cerita Cinta
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'cerita_streaming',
                'cerita_cinta' => [
                    [
                        'judul' => 'Awal Jumpa',
                        'tanggal' => '2022',
                        'cerita' => 'Bertemu pertama kali di kota pelajar.',
                        'foto_file' => UploadedFile::fake()->image('bab-1.jpg', 800, 600),
                    ],
                ],
            ])
            ->assertRedirect("/dashboard/undangan/{$undangan->id}/kelola")
            ->assertSessionHasNoErrors();

        $undangan->refresh();

        $pathSampul = $undangan->pengaturan['foto_sampul'] ?? null;
        $pathPembuka = $undangan->pengaturan['foto_pembuka'] ?? null;
        $pathPenutup = $undangan->pengaturan['foto_penutup'] ?? null;
        $pathLatar = $undangan->pengaturan['foto_latar_tema'] ?? null;
        $pathBab = $undangan->pengaturan['cerita_cinta'][0]['foto'] ?? null;

        $this->assertNotEmpty($pathSampul);
        $this->assertNotEmpty($pathPembuka);
        $this->assertNotEmpty($pathPenutup);
        $this->assertNotEmpty($pathLatar);
        $this->assertNotEmpty($pathBab);
        $this->assertSame('#DimasLarasSelamanya', $undangan->hashtagPasangan());

        Storage::disk('public')->assertExists($pathSampul);
        Storage::disk('public')->assertExists($pathPembuka);
        Storage::disk('public')->assertExists($pathPenutup);
        Storage::disk('public')->assertExists($pathLatar);
        Storage::disk('public')->assertExists($pathBab);

        // 3. Verifikasi seluruh foto custom & hashtag muncul di tema flagship Adat Jawa
        $this->get('/kustom-foto-lengkap')
            ->assertOk()
            ->assertSee($pathSampul, false)
            ->assertSee($pathPembuka, false)
            ->assertSee($pathPenutup, false)
            ->assertSee($pathLatar, false)
            ->assertSee($pathBab, false)
            ->assertSee('#DimasLarasSelamanya', false);

        // 4. Verifikasi juga tampil pada tema lain (Sunda Heritage)
        $undangan->update(['tema_id' => $temaSunda->id]);
        $this->get('/kustom-foto-lengkap')
            ->assertOk()
            ->assertSee($pathSampul, false)
            ->assertSee($pathPembuka, false)
            ->assertSee($pathPenutup, false)
            ->assertSee($pathLatar, false)
            ->assertSee($pathBab, false)
            ->assertSee('#DimasLarasSelamanya', false);

        // 5. Mode Tanpa Foto aktif -> seluruh foto kustom disembunyikan dengan aman
        $pengaturanTf = $undangan->pengaturan;
        $pengaturanTf['tanpa_foto'] = true;
        $undangan->update(['tema_id' => $temaJawa->id, 'pengaturan' => $pengaturanTf]);

        $this->get('/kustom-foto-lengkap')
            ->assertOk()
            ->assertDontSee($pathSampul, false)
            ->assertDontSee($pathPembuka, false)
            ->assertDontSee($pathPenutup, false)
            ->assertDontSee($pathLatar, false)
            ->assertDontSee($pathBab, false);

        // 6. Hapus foto pembuka, penutup, latar tema, dan foto bab cerita dari dashboard
        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'mempelai',
                'nama_panggilan_pria' => 'Dimas',
                'nama_lengkap_pria' => 'Dimas Prasetya',
                'nama_panggilan_wanita' => 'Laras',
                'nama_lengkap_wanita' => 'Larasati Ningrum',
                'hapus_foto_pembuka' => '1',
                'hapus_foto_penutup' => '1',
                'hapus_foto_latar_tema' => '1',
            ])
            ->assertSessionHasNoErrors();

        $this->actingAs($client)
            ->put("/dashboard/undangan/{$undangan->id}", [
                'bagian' => 'cerita_streaming',
                'cerita_cinta' => [
                    [
                        'judul' => 'Awal Jumpa',
                        'tanggal' => '2022',
                        'cerita' => 'Bertemu pertama kali di kota pelajar.',
                        'foto' => $pathBab,
                        'hapus_foto' => '1',
                    ],
                ],
            ])
            ->assertSessionHasNoErrors();

        $undangan->refresh();
        $this->assertNull($undangan->pengaturan['foto_pembuka'] ?? null);
        $this->assertNull($undangan->pengaturan['foto_penutup'] ?? null);
        $this->assertNull($undangan->pengaturan['foto_latar_tema'] ?? null);
        $this->assertNull($undangan->pengaturan['cerita_cinta'][0]['foto'] ?? null);

        Storage::disk('public')->assertMissing($pathPembuka);
        Storage::disk('public')->assertMissing($pathPenutup);
        Storage::disk('public')->assertMissing($pathLatar);
        Storage::disk('public')->assertMissing($pathBab);
    }

    /**
     * Memastikan seluruh 9 tema sudah memiliki arsitektur mandiri (tidak lagi berbagi kerangka tunggal)
     * serta aset WebP berlapis khusus Gelombang 2 tersedia dan dirender pada halaman demonya.
     */
    public function test_seluruh_9_tema_mandiri_dan_aset_diorama_gelombang_2_valid(): void
    {
        $asetGelombang2 = [
            'sunda-heritage' => [
                'aset-tema/sunda-heritage/gapura-priangan.webp',
            ],
            'islamic-heavenly' => [
                'aset-tema/islamic-heavenly/gerbang-mihrab.webp',
                'aset-tema/islamic-heavenly/lentera-fanous.webp',
            ],
            'luxury-noir' => [
                'aset-tema/luxury-noir/bingkai-artdeco.webp',
            ],
            'velvet-garden' => [
                'aset-tema/velvet-garden/lengkungan-konservatori.webp',
            ],
        ];

        $semuaSlug = [
            'adat-jawa',
            'sunda-heritage',
            'islamic-heavenly',
            'luxury-noir',
            'velvet-garden',
            'royal-ivory',
            'editorial-monokrom',
            'islami-syari',
            'rustic-floral',
        ];

        foreach ($semuaSlug as $slug) {
            $kontenIndex = file_get_contents(resource_path("views/tema/{$slug}/index.blade.php"));
            $this->assertNotFalse($kontenIndex);
            $this->assertStringNotContainsString(
                'komponen-undangan.kerangka-tema',
                $kontenIndex,
                "Tema {$slug} seharusnya sudah mandiri dan tidak memakai kerangka-tema tunggal."
            );
        }

        foreach ($asetGelombang2 as $slug => $daftarJalur) {
            Tema::firstOrCreate(
                ['slug' => $slug],
                [
                    'nama_tema' => ucwords(str_replace('-', ' ', $slug)),
                    'kategori' => 'elegan',
                    'tier' => $slug === 'sunda-heritage' ? 'premium' : 'eksklusif',
                    'lokasi_view' => "tema.{$slug}.index",
                    'aktif' => true,
                ]
            );

            $respon = $this->get("/demo/{$slug}?kanvas=1")->assertOk();

            foreach ($daftarJalur as $jalur) {
                $penuh = public_path($jalur);
                $this->assertFileExists($penuh);
                $this->assertGreaterThan(20000, filesize($penuh));
                $respon->assertSee($jalur, false);
            }
        }
    }

    /**
     * Memastikan tema Islami Syar'i merender video motion hero Alhambra, overlay Mihrab sinkron,
     * seksi konten lengkap (slideshow, amplop buka-tutup, doa pengantin), aman pada Mode Tanpa Foto,
     * serta menampilkan poster hero-poster.webp pada katalog beranda.
     */
    public function test_islami_syari_merender_video_hero_poster_dan_seksi_lengkap(): void
    {
        $this->assertFileExists(public_path('aset-tema/islami-syari/islami-syari-motion-hero.mp4'));
        $this->assertFileExists(public_path('aset-tema/islami-syari/hero-poster.webp'));

        Tema::create([
            'nama_tema' => 'Islami Syari Emerald',
            'slug' => 'islami-syari',
            'kategori' => 'islami',
            'tier' => 'basic',
            'harga' => 59000,
            'lokasi_view' => 'tema.islami-syari.index',
            'aktif' => true,
        ]);

        $this->get('/demo/islami-syari?kanvas=1')
            ->assertOk()
            ->assertSee('aset-tema/islami-syari/islami-syari-motion-hero.mp4', false)
            ->assertSee('data-start-at="0.15"', false)
            ->assertSee('data-playback-rate="1.2"', false)
            ->assertSee('data-reveal-at="20.2"', false)
            ->assertSee('data-settled-at="22.8"', false)
            ->assertSee('putarUlangVideoHero()', false)
            ->assertSee('data-slideshow-syari', false)
            ->assertSee('Buka Amplop Digital', false)
            ->assertSee('data-section-doa-pengantin="mihrab"', false)
            ->assertSee('Doa Untuk Pengantin', false)
            ->assertSee('RSVP &amp; Wishes', false)
            ->assertSee('data-galeri-kolase-syari', false)
            ->assertSee('aspect-[16/10]', false)
            ->assertSee('Jazakumullahu Khairan', false);

        $this->get('/demo/islami-syari?kanvas=1&tf=1')
            ->assertOk()
            ->assertSee('aset-tema/islami-syari/islami-syari-motion-hero.mp4', false)
            ->assertSee('aset-tema/islami-syari/latar-utama.webp', false)
            ->assertDontSee('sampul-islami.webp', false)
            ->assertDontSee('data-slideshow-syari', false);

        $this->get('/')
            ->assertOk()
            ->assertSee('aset-tema/islami-syari/hero-poster.webp', false);
    }

    /**
     * Memastikan tema Islamic Heavenly merender video motion hero Celestial Night,
     * overlay bingkai safir sinkron, seksi konten lengkap (slideshow, amplop buka-tutup,
     * doa pengantin, galeri kolase bervariasi rasio), aman Mode Tanpa Foto, serta poster katalog.
     */
    public function test_islamic_heavenly_merender_video_hero_poster_dan_seksi_lengkap(): void
    {
        $this->assertFileExists(public_path('aset-tema/islamic-heavenly/islamic-heavenly-motion-hero.mp4'));
        $this->assertFileExists(public_path('aset-tema/islamic-heavenly/hero-poster.webp'));

        Tema::create([
            'nama_tema' => 'Islamic Heavenly Motion',
            'slug' => 'islamic-heavenly',
            'kategori' => 'islami',
            'tier' => 'eksklusif',
            'harga' => 119000,
            'lokasi_view' => 'tema.islamic-heavenly.index',
            'aktif' => true,
        ]);

        $responHeavenly = $this->get('/demo/islamic-heavenly?kanvas=1')
            ->assertOk()
            ->assertSee('intro-seragam-panggung', false)
            ->assertSee('data-intro-keluar="fade-halus"', false)
            ->assertSee('aset-tema/islamic-heavenly/islamic-heavenly-motion-hero.mp4', false)
            ->assertSee('data-start-at="0"', false)
            ->assertSee('data-playback-rate="1.05"', false)
            ->assertSee('data-reveal-at="16.8"', false)
            ->assertSee('data-settled-at="19.8"', false)
            ->assertSee('putarUlangVideoHero()', false)
            ->assertSee('data-slideshow-heavenly', false)
            ->assertSee('Buka Amplop Digital', false)
            ->assertSee('data-section-doa-pengantin="celestial"', false)
            ->assertSee('Doa Untuk Pengantin', false)
            ->assertSee('RSVP &amp; Wishes', false)
            ->assertSee('data-galeri-kolase-heavenly', false)
            ->assertSee('aspect-[16/10]', false)
            ->assertSee('Jazakumullahu Khairan', false);

        // Pastikan urutan seksi selaras Islami Syar'i: Mempelai -> Slideshow -> Save The Date -> Jadwal
        $htmlHeavenly = $responHeavenly->getContent();
        $posMempelai = strpos($htmlHeavenly, 'data-layout-mempelai="celestial"');
        $posSlideshow = strpos($htmlHeavenly, 'data-slideshow-heavenly');
        $posCountdown = strpos($htmlHeavenly, 'data-layout-countdown="celestial"');
        $posAcara = strpos($htmlHeavenly, 'data-layout-acara="celestial"');
        $this->assertNotFalse($posMempelai);
        $this->assertNotFalse($posSlideshow);
        $this->assertNotFalse($posCountdown);
        $this->assertNotFalse($posAcara);
        $this->assertLessThan($posSlideshow, $posMempelai);
        $this->assertLessThan($posCountdown, $posSlideshow);
        $this->assertLessThan($posAcara, $posCountdown);

        $this->get('/demo/islamic-heavenly?kanvas=1&tf=1')
            ->assertOk()
            ->assertSee('aset-tema/islamic-heavenly/islamic-heavenly-motion-hero.mp4', false)
            ->assertSee('aset-tema/islamic-heavenly/latar-utama.webp', false)
            ->assertDontSee('sampul-islamic-heavenly.webp', false)
            ->assertDontSee('data-slideshow-heavenly', false);

        $this->get('/')
            ->assertOk()
            ->assertSee('aset-tema/islamic-heavenly/hero-poster.webp', false);
    }
}
