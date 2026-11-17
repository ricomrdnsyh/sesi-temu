<?php

namespace Tests\Feature;

use App\Models\Tema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TemaMotion3DTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Memastikan seluruh 9 tema memiliki file ornamen WebP transparan valid dan merender elemen 3D Diorama.
     */
    public function test_semua_tema_merender_diorama_3d_dan_ornamen_valid(): void
    {
        $daftarTema = [
            [
                'slug' => 'adat-jawa',
                'nama' => 'Adat Jawa Keraton',
                'kategori' => 'adat',
                'ornamen' => 'aset-tema/adat-jawa/ornamen-gunungan.webp',
                'penandaGate' => 'belah-pintu-3d',
                'penandaGerak' => 'animasi-burung',
            ],
            [
                'slug' => 'sunda-heritage',
                'nama' => 'Sunda Siger Heritage',
                'kategori' => 'adat',
                'ornamen' => 'aset-tema/sunda-heritage/ornamen-siger.webp',
                'penandaGate' => 'belah-pintu-3d',
                'penandaGerak' => 'animasi-burung',
            ],
            [
                'slug' => 'islamic-heavenly',
                'nama' => 'Islamic Heavenly',
                'kategori' => 'islami',
                'ornamen' => 'aset-tema/islamic-heavenly/ornamen-sabit.webp',
                'penandaGate' => 'tirai-portal-3d',
                'penandaGerak' => 'animasi-bintang-jatuh',
            ],
            [
                'slug' => 'islami-syari',
                'nama' => 'Islami Syari Emerald',
                'kategori' => 'islami',
                'ornamen' => 'aset-tema/islami-syari/ornamen-arabesque.webp',
                'penandaGate' => 'lipat-katedral-3d',
                'penandaGerak' => 'animasi-sinar',
            ],
            [
                'slug' => 'luxury-noir',
                'nama' => 'Luxury Noir Gold',
                'kategori' => 'luxury',
                'ornamen' => 'aset-tema/luxury-noir/ornamen-emas.webp',
                'penandaGate' => 'tirai-portal-3d',
                'penandaGerak' => 'animasi-debu-emas',
            ],
            [
                'slug' => 'royal-ivory',
                'nama' => 'Royal Ivory Cathedral',
                'kategori' => 'luxury',
                'ornamen' => 'aset-tema/royal-ivory/ornamen-katedral.webp',
                'penandaGate' => 'lipat-katedral-3d',
                'penandaGerak' => 'animasi-sinar',
            ],
            [
                'slug' => 'velvet-garden',
                'nama' => 'Velvet Garden Motion',
                'kategori' => 'motion',
                'ornamen' => 'aset-tema/velvet-garden/ornamen-botani.webp',
                'penandaGate' => 'tirai-portal-3d',
                'penandaGerak' => 'animasi-kelopak-3d',
            ],
            [
                'slug' => 'rustic-floral',
                'nama' => 'Rustic Floral',
                'kategori' => 'modern',
                'ornamen' => 'aset-tema/rustic-floral/ornamen-sudut.webp',
                'penandaGate' => 'halaman-editorial-3d',
                'penandaGerak' => 'animasi-kelopak-3d',
            ],
            [
                'slug' => 'editorial-monokrom',
                'nama' => 'Editorial Monokrom',
                'kategori' => 'modern',
                'ornamen' => 'aset-tema/editorial-monokrom/ornamen-bingkai.webp',
                'penandaGate' => 'halaman-editorial-3d',
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
                'lokasi_view' => 'tema.'.$item['slug'].'.index',
                'aktif' => true,
            ]);

            $respon = $this->get('/demo/'.$item['slug']);
            $respon->assertOk()
                ->assertSee('panggung-3d', false)
                ->assertSee('kartu-3d', false)
                ->assertSee('animasi-ayun-3d', false)
                ->assertSee('data-panggung-3d', false)
                ->assertSee('Buka Undangan', false)
                ->assertSee('We Are Getting Married!', false)
                ->assertSee('Save The Date', false)
                ->assertSee($item['ornamen'], false)
                ->assertSee($item['penandaGerak'], false);

            if ($item['slug'] !== 'editorial-monokrom') {
                $respon->assertSee('rounded-t-[10.5rem]', false);
            }

            $konten = $respon->getContent();
            $this->assertStringNotContainsString('&amp;bull;', $konten);
            $this->assertStringNotContainsString('&amp;amp;', $konten);
            if (preg_match('/<div[^>]+lg:w-\[445px\][^>]*>/', $konten, $cocokKolom)) {
                $this->assertStringNotContainsString('panggung-3d', $cocokKolom[0]);
            }

            if (in_array($item['penandaGate'], ['belah-pintu-3d', 'tirai-portal-3d'], true)) {
                $this->assertStringContainsString('panel-gerbang-kiri', $konten);
                $this->assertStringContainsString('panel-gerbang-kanan', $konten);
                $this->assertStringContainsString('rotateY(-112deg)', $konten);
                $this->assertStringContainsString('w-[200%]', $konten);
            } elseif ($item['penandaGate'] === 'lipat-katedral-3d') {
                $this->assertStringContainsString('lipat-katedral-3d', $konten);
                $this->assertStringContainsString('rotateX(78deg)', $konten);
            } elseif ($item['penandaGate'] === 'halaman-editorial-3d') {
                $this->assertStringContainsString('halaman-editorial-3d', $konten);
                $this->assertStringContainsString('rotateY(-108deg)', $konten);
            }
        }
    }
}
