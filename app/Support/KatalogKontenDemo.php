<?php

namespace App\Support;

use App\Models\Tema;

class KatalogKontenDemo
{
    /**
     * Katalog konten demo unik untuk setiap tema agar isi demo berbeda sesuai karakter dan budaya tema.
     *
     * @return array<string, mixed>
     */
    public static function untukTema(Tema $tema): array
    {
        $semua = self::semuaData();

        return $semua[$tema->slug] ?? $semua['rustic-floral'];
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private static function semuaData(): array
    {
        return [
            'rustic-floral' => [
                'pria' => [
                    'panggilan' => 'Dimas',
                    'lengkap' => 'Dimas Pratama Putra, S.Kom.',
                    'ayah' => 'Bpk. Hendra Wijaya',
                    'ibu' => 'Ibu Ratna Sari',
                ],
                'wanita' => [
                    'panggilan' => 'Rani',
                    'lengkap' => 'Rani Kusuma Wardhani, S.E.',
                    'ayah' => 'Bpk. Bambang Sutrisno',
                    'ibu' => 'Ibu Sri Wahyuni',
                ],
                'foto_sampul' => 'aset-demo/sampul-rustic.webp',
                'musik_latar' => 'musik/romantis-akustik.mp3',
                'hari_lagi' => 21,
                'kutipan_ayat' => 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan hidup dari jenismu sendiri, supaya kamu merasa tenteram di sampingnya. (QS. Ar-Rum: 21)',
                'cerita_cinta' => [
                    [
                        'judul' => 'Pertemuan Pertama',
                        'tanggal' => 'Oktober 2023',
                        'cerita' => 'Dipertemukan di sebuah kafe taman rindang kawasan Kemang saat diskusi proyek kreatif, lalu tumbuh menjadi sahabat berbagi cerita.',
                    ],
                    [
                        'judul' => 'Momen Lamaran',
                        'tanggal' => 'Januari 2026',
                        'cerita' => 'Di bawah cahaya senja yang hangat, kedua keluarga besar duduk bersama mengikat niat suci menuju pelaminan.',
                    ],
                    [
                        'judul' => 'Menuju Hari Bahagia',
                        'tanggal' => '2026',
                        'cerita' => 'Dengan doa dan restu orang tua serta sahabat, kami siap melangkah membangun rumah tangga penuh cinta.',
                    ],
                ],
                'live_streaming' => [
                    'aktif' => true,
                    'platform' => 'YouTube Live',
                    'link' => 'https://youtube.com',
                ],
                'alamat_kado_fisik' => 'Jl. Kemang Raya No. 45, Jakarta Selatan 12730',
                'acara' => [
                    [
                        'nama_acara' => 'Akad Nikah',
                        'waktu_mulai' => '08:00:00',
                        'waktu_selesai' => '10:00:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Pendopo Plataran Dharmawangsa',
                        'alamat_lengkap' => 'Jl. Dharmawangsa Raya No. 6, Kebayoran Baru, Jakarta Selatan',
                        'link_maps' => 'https://maps.google.com/?q=Plataran+Dharmawangsa+Jakarta',
                    ],
                    [
                        'nama_acara' => 'Resepsi Taman',
                        'waktu_mulai' => '11:00:00',
                        'waktu_selesai' => '14:30:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Garden Pavilion Dharmawangsa',
                        'alamat_lengkap' => 'Jl. Dharmawangsa Raya No. 6, Kebayoran Baru, Jakarta Selatan',
                        'link_maps' => 'https://maps.google.com/?q=Plataran+Dharmawangsa+Jakarta',
                    ],
                ],
                'galeri' => [
                    ['lokasi_foto' => 'aset-demo/galeri-1.webp', 'keterangan' => 'Senja Hangat di Pesisir Pertunangan'],
                    ['lokasi_foto' => 'aset-demo/galeri-2.webp', 'keterangan' => 'Simbol Cincin & Janji Suci'],
                    ['lokasi_foto' => 'aset-demo/galeri-3.webp', 'keterangan' => 'Lorong Floral Menuju Pelaminan'],
                ],
                'amplop' => [
                    ['nama_bank' => 'BCA', 'nomor_rekening' => '1234567890', 'atas_nama' => 'Dimas Pratama Putra'],
                    ['nama_bank' => 'Mandiri', 'nomor_rekening' => '9876543210123', 'atas_nama' => 'Rani Kusuma Wardhani'],
                ],
                'ucapan' => [
                    ['nama_tamu' => 'Bagas Prakoso', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 2, 'ucapan_doa' => 'Selamat menempuh hidup baru Dimas & Rani! Semoga menjadi keluarga sakinah, mawaddah, warahmah.'],
                    ['nama_tamu' => 'Nadia Larasati', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 1, 'ucapan_doa' => 'Bahagia selalu untuk Dimas & Rani. Tidak sabar menghadiri resepsi tamannya!'],
                ],
            ],

            'adat-jawa' => [
                'pria' => [
                    'panggilan' => 'Akmal',
                    'lengkap' => 'R.M. Akmal Wirawan Hadiningrat, S.T.',
                    'ayah' => 'K.R.T. Darmawan Hadiningrat',
                    'ibu' => 'R.Ay. Sekar Tanjung',
                ],
                'wanita' => [
                    'panggilan' => 'Aisyah',
                    'lengkap' => 'R.Aj. Aisyah Paramita Kusumo, S.Psi.',
                    'ayah' => 'Bpk. H. Suryono Kusumo',
                    'ibu' => 'Ibu Hj. Endang Larasati',
                ],
                'foto_sampul' => 'aset-demo/sampul-jawa.webp',
                'musik_latar' => 'musik/gamelan-lembut.mp3',
                'hari_lagi' => 35,
                'kutipan_ayat' => 'Mugi Gusti Kang Murbeng Dumadi tansah paring berkah katresnan, guyub rukun, saha katentreman tumrap kulawarga ingkang badhe kabangun. (Pitutur Luhur Jawi & QS. Ar-Rum: 21)',
                'cerita_cinta' => [
                    [
                        'judul' => 'Kawiwitan ing Yogyakarta',
                        'tanggal' => 'Agustus 2022',
                        'cerita' => 'Kisah kami bersemi saat pameran pusaka & arsitektur keraton di Ndalem Pujokusuman, Yogyakarta.',
                    ],
                    [
                        'judul' => 'Paningsetan & Lamaran',
                        'tanggal' => 'Desember 2025',
                        'cerita' => 'Keluarga besar berhimpun dalam prosesi srah-srahan dan paningset penuh khidmat di Pendopo Agung.',
                    ],
                    [
                        'judul' => 'Pinanganten Agung',
                        'tanggal' => '2026',
                        'cerita' => 'Menyatukan dua trah dalam upacara panggih adat Mataram dengan iringan gending karawitan.',
                    ],
                ],
                'live_streaming' => [
                    'aktif' => true,
                    'platform' => 'YouTube Live Keraton Channel',
                    'link' => 'https://youtube.com',
                ],
                'alamat_kado_fisik' => 'Ndalem Kusuman No. 18, Kraton, Kota Yogyakarta 55132',
                'acara' => [
                    [
                        'nama_acara' => 'Ijab Qabul & Upacara Panggih',
                        'waktu_mulai' => '07:30:00',
                        'waktu_selesai' => '10:00:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Pendopo Agung Royal Ambarrukmo',
                        'alamat_lengkap' => 'Jl. Laksda Adisucipto No. 81, Sleman, DI Yogyakarta',
                        'link_maps' => 'https://maps.google.com/?q=Pendopo+Agung+Royal+Ambarrukmo+Yogyakarta',
                    ],
                    [
                        'nama_acara' => 'Pahargyan Agung (Resepsi)',
                        'waktu_mulai' => '11:30:00',
                        'waktu_selesai' => '15:00:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Bale Agung Kedaton Ballroom',
                        'alamat_lengkap' => 'Jl. Laksda Adisucipto No. 81, Sleman, DI Yogyakarta',
                        'link_maps' => 'https://maps.google.com/?q=Royal+Ambarrukmo+Yogyakarta',
                    ],
                ],
                'galeri' => [
                    ['lokasi_foto' => 'aset-demo/sampul-jawa.webp', 'keterangan' => 'Busana Beludru Hitam Adat Jawa di Gebyok Ukir'],
                    ['lokasi_foto' => 'aset-demo/galeri-cincin-mawar.webp', 'keterangan' => 'Kalpika & Kembang Setaman Peningset'],
                    ['lokasi_foto' => 'aset-demo/galeri-lampu-senja.webp', 'keterangan' => 'Sorot Lentera Malam Midodareni'],
                ],
                'amplop' => [
                    ['nama_bank' => 'BSI', 'nomor_rekening' => '7182930456', 'atas_nama' => 'Akmal Wirawan Hadiningrat'],
                    ['nama_bank' => 'BCA', 'nomor_rekening' => '8820192837', 'atas_nama' => 'Aisyah Paramita Kusumo'],
                ],
                'ucapan' => [
                    ['nama_tamu' => 'R.M. Yudhistira & Keluarga', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 2, 'ucapan_doa' => 'Sugeng manggih kabagyan kangge Mas Akmal lan Mbak Aisyah. Mugi dados brayat sakinah mawaddah warahmah.'],
                    ['nama_tamu' => 'Sekararum Puspita', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 1, 'ucapan_doa' => 'Ndherek bingah! Saking tebih tansah ndedonga mugi acara panggih lan pahargyan lumampah lancar.'],
                ],
            ],

            'sunda-heritage' => [
                'pria' => [
                    'panggilan' => 'Bagja',
                    'lengkap' => 'Raden Bagja Natawijaya, M.B.A.',
                    'ayah' => 'Bpk. H. Dadan Natawijaya',
                    'ibu' => 'Ibu Hj. Euis Kartika',
                ],
                'wanita' => [
                    'panggilan' => 'Nenden',
                    'lengkap' => 'Nenden Ratna Dewi, S.Ars.',
                    'ayah' => 'Bpk. Usep Suryadi',
                    'ibu' => 'Ibu Tati Rohayati',
                ],
                'foto_sampul' => 'aset-demo/sampul-sunda.webp',
                'musik_latar' => 'musik/gamelan-lembut.mp3',
                'hari_lagi' => 28,
                'kutipan_ayat' => 'Silih asah, silih asih, silih asuh. Mugia rumah tangga salawasna dipaparin kabagjaan, kasalametan, tur barokah ti Gusti Nu Maha Suci.',
                'cerita_cinta' => [
                    [
                        'judul' => 'Tepang di Kota Kembang',
                        'tanggal' => 'Mei 2023',
                        'cerita' => 'Bermula dari kolaborasi pelestarian bangunan cagar budaya di Jalan Braga, Bandung.',
                    ],
                    [
                        'judul' => 'Neundeun Omong & Seserahan',
                        'tanggal' => 'Februari 2026',
                        'cerita' => 'Tali asih keluarga terjalin hangat dalam tradisi neundeun omong dan ngeuyeuk seureuh.',
                    ],
                    [
                        'judul' => 'Sawer Panganten',
                        'tanggal' => '2026',
                        'cerita' => 'Melangkah menuju pelaminan berbusana siger Sunda dengan iringan kacapi suling nan syahdu.',
                    ],
                ],
                'live_streaming' => [
                    'aktif' => true,
                    'platform' => 'Instagram Live & YouTube',
                    'link' => 'https://youtube.com',
                ],
                'alamat_kado_fisik' => 'Jl. Ir. H. Djuanda (Dago) No. 112, Kota Bandung 40132',
                'acara' => [
                    [
                        'nama_acara' => 'Akad Nikah & Sungkeman',
                        'waktu_mulai' => '08:00:00',
                        'waktu_selesai' => '10:30:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Gedung Pendopo Kota Bandung',
                        'alamat_lengkap' => 'Jl. Dalem Kaum No. 56, Regol, Kota Bandung, Jawa Barat',
                        'link_maps' => 'https://maps.google.com/?q=Pendopo+Kota+Bandung',
                    ],
                    [
                        'nama_acara' => 'Resepsi & Sawer Panganten',
                        'waktu_mulai' => '11:30:00',
                        'waktu_selesai' => '15:00:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Bumi Samami Heritage Garden',
                        'alamat_lengkap' => 'Jl. Siliwangi No. 12, Coblong, Kota Bandung, Jawa Barat',
                        'link_maps' => 'https://maps.google.com/?q=Coblong+Bandung',
                    ],
                ],
                'galeri' => [
                    ['lokasi_foto' => 'aset-demo/sampul-sunda.webp', 'keterangan' => 'Siger Sunda & Kebaya Gading di Senja Priangan'],
                    ['lokasi_foto' => 'aset-demo/galeri-nikah-pelaminan.webp', 'keterangan' => 'Nuansa Pelaminan Putih & Rangkaian Mawar'],
                    ['lokasi_foto' => 'aset-demo/galeri-cincin-mawar.webp', 'keterangan' => 'Tanda Kasih & Kalpika Emas'],
                ],
                'amplop' => [
                    ['nama_bank' => 'BNI', 'nomor_rekening' => '0987654321', 'atas_nama' => 'Bagja Natawijaya'],
                    ['nama_bank' => 'Bank BJB', 'nomor_rekening' => '001122334455', 'atas_nama' => 'Nenden Ratna Dewi'],
                ],
                'ucapan' => [
                    ['nama_tamu' => 'Kang Gilang & Teh Risa', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 2, 'ucapan_doa' => 'Wilujeng ngawangun rumah tangga enggal Bagja & Nenden! Mugia langgeng salamina.'],
                    ['nama_tamu' => 'Raka Maulana', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 1, 'ucapan_doa' => 'Sampurasun! InsyaAllah hadir ti Jakarta ngiring bingah acara sawer panganten.'],
                ],
            ],

            'editorial-monokrom' => [
                'pria' => [
                    'panggilan' => 'Arsen',
                    'lengkap' => 'Arsenio Mahesa Tanoto, S.Sn.',
                    'ayah' => 'Bpk. Gunawan Tanoto',
                    'ibu' => 'Ibu Claire Wijaya',
                ],
                'wanita' => [
                    'panggilan' => 'Kaira',
                    'lengkap' => 'Kaira Nadhira Halim, M.Arch.',
                    'ayah' => 'Bpk. Erwin Halim',
                    'ibu' => 'Ibu Maya Puspita',
                ],
                'foto_sampul' => 'aset-demo/sampul-editorial.webp',
                'musik_latar' => 'musik/romantis-akustik.mp3',
                'hari_lagi' => 42,
                'kutipan_ayat' => 'Two quiet souls, one shared architecture — building a lifetime of calm mornings, honest conversations, and timeless grace.',
                'cerita_cinta' => [
                    [
                        'judul' => 'First Gallery Vernissage',
                        'tanggal' => 'November 2022',
                        'cerita' => 'Dipertemukan di ruang pamer fotografi monokrom di Jakarta Selatan, terpikat pada komposisi yang sama.',
                    ],
                    [
                        'judul' => 'Studio Proposal',
                        'tanggal' => 'Januari 2026',
                        'cerita' => 'Dalam hening cahaya pagi studio pribadi, sebuah janji sederhana diucapkan tanpa gegap gempita.',
                    ],
                    [
                        'judul' => 'The Editorial Vows',
                        'tanggal' => '2026',
                        'cerita' => 'Merayakan cinta dalam garis minimalis hitam-putih yang abadi melampaui pergantian musim.',
                    ],
                ],
                'live_streaming' => [
                    'aktif' => true,
                    'platform' => 'Vimeo Private Stream',
                    'link' => 'https://youtube.com',
                ],
                'alamat_kado_fisik' => 'The Residences Senopati Tower B Unit 14A, Jakarta Selatan 12190',
                'acara' => [
                    [
                        'nama_acara' => 'Intimate Vows',
                        'waktu_mulai' => '15:30:00',
                        'waktu_selesai' => '17:00:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Gallery Atrium Senopati',
                        'alamat_lengkap' => 'Jl. Senopati No. 78, Kebayoran Baru, Jakarta Selatan',
                        'link_maps' => 'https://maps.google.com/?q=Senopati+Jakarta+Selatan',
                    ],
                    [
                        'nama_acara' => 'Minimalist Cocktail Dinner',
                        'waktu_mulai' => '18:30:00',
                        'waktu_selesai' => '21:30:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Atelier Monokrom Glass Hall',
                        'alamat_lengkap' => 'Jl. Tulodong Atas No. 19, SCBD, Jakarta Selatan',
                        'link_maps' => 'https://maps.google.com/?q=SCBD+Jakarta+Selatan',
                    ],
                ],
                'galeri' => [
                    ['lokasi_foto' => 'aset-demo/sampul-editorial.webp', 'keterangan' => 'Portrait Study di Jendela Batu Klasik'],
                    ['lokasi_foto' => 'aset-demo/galeri-editorial-1.webp', 'keterangan' => 'Silent Poise Before Walking the Aisle'],
                    ['lokasi_foto' => 'aset-demo/galeri-editorial-2.webp', 'keterangan' => 'Monochrome Promise on Our Hands'],
                ],
                'amplop' => [
                    ['nama_bank' => 'BCA Prioritas', 'nomor_rekening' => '5270192837', 'atas_nama' => 'Arsenio Mahesa Tanoto'],
                    ['nama_bank' => 'Permata', 'nomor_rekening' => '4120987654', 'atas_nama' => 'Kaira Nadhira Halim'],
                ],
                'ucapan' => [
                    ['nama_tamu' => 'Julian Prasetya', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 1, 'ucapan_doa' => 'Classy as always, Arsen & Kaira! Wishing you a lifetime of serenity and creative harmony.'],
                    ['nama_tamu' => 'Bianca Aurellia', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 2, 'ucapan_doa' => 'Congratulations on your timeless union. See you in black-tie attire at Senopati!'],
                ],
            ],

            'luxury-noir' => [
                'pria' => [
                    'panggilan' => 'Alvaro',
                    'lengkap' => 'Alvaro Dirgantara, M.Sc.',
                    'ayah' => 'Bpk. Handoko Dirgantara',
                    'ibu' => 'Ibu Helena Kusuma',
                ],
                'wanita' => [
                    'panggilan' => 'Clarissa',
                    'lengkap' => 'Clarissa Aurelia Hartono, B.Bus.',
                    'ayah' => 'Bpk. Ferdinand Hartono',
                    'ibu' => 'Ibu Priscilla Tan',
                ],
                'foto_sampul' => 'aset-demo/sampul-luxury.webp',
                'musik_latar' => 'musik/romantis-akustik.mp3',
                'hari_lagi' => 49,
                'kutipan_ayat' => 'And suddenly all the golden lights fell quiet — choosing you tonight, tomorrow, and for every midnight waltz ahead.',
                'cerita_cinta' => [
                    [
                        'judul' => 'An Evening at the Gala',
                        'tanggal' => 'Desember 2022',
                        'cerita' => 'Saling bertukar sapa di bawah kilau lampu kristal acara amal tahunan di Jakarta Pusat.',
                    ],
                    [
                        'judul' => 'Lake Como Engagement',
                        'tanggal' => 'September 2025',
                        'cerita' => 'Diiringi denting orkestra kecil tepi danau senja, cincin berlian melingkar di jari manis.',
                    ],
                    [
                        'judul' => 'Midnight Grand Banquet',
                        'tanggal' => '2026',
                        'cerita' => 'Mengundang sahabat dan kerabat terkasih merayakan malam istimewa dalam balutan black-tie.',
                    ],
                ],
                'live_streaming' => [
                    'aktif' => true,
                    'platform' => 'YouTube 4K Private Cast',
                    'link' => 'https://youtube.com',
                ],
                'alamat_kado_fisik' => 'Pacific Place Residence Penthouse 28B, SCBD Jakarta 12190',
                'acara' => [
                    [
                        'nama_acara' => 'Holy Matrimony',
                        'waktu_mulai' => '15:00:00',
                        'waktu_selesai' => '16:30:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'The St. Regis Astor Chapel',
                        'alamat_lengkap' => 'Jl. H. R. Rasuna Said Kav. B-4, Setiabudi, Jakarta Selatan',
                        'link_maps' => 'https://maps.google.com/?q=The+St+Regis+Jakarta',
                    ],
                    [
                        'nama_acara' => 'Black-Tie Gala Dinner',
                        'waktu_mulai' => '18:30:00',
                        'waktu_selesai' => '22:00:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Astor Grand Ballroom St. Regis',
                        'alamat_lengkap' => 'Jl. H. R. Rasuna Said Kav. B-4, Setiabudi, Jakarta Selatan',
                        'link_maps' => 'https://maps.google.com/?q=The+St+Regis+Jakarta',
                    ],
                ],
                'galeri' => [
                    ['lokasi_foto' => 'aset-demo/sampul-luxury.webp', 'keterangan' => 'First Dance Under Ballroom Chandeliers'],
                    ['lokasi_foto' => 'aset-demo/galeri-buket-malam.webp', 'keterangan' => 'Mawar Champagne & Detail Renda Malam'],
                    ['lokasi_foto' => 'aset-demo/galeri-lampu-senja.webp', 'keterangan' => 'Golden Bokeh Soiree'],
                ],
                'amplop' => [
                    ['nama_bank' => 'BCA Solitaire', 'nomor_rekening' => '7750019283', 'atas_nama' => 'Alvaro Dirgantara'],
                    ['nama_bank' => 'CIMB Niaga Preferred', 'nomor_rekening' => '800123456700', 'atas_nama' => 'Clarissa Aurelia'],
                ],
                'ucapan' => [
                    ['nama_tamu' => 'Kevin & Michelle Tjandra', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 2, 'ucapan_doa' => 'To Alvaro & Clarissa, may your marriage shimmer forever with grace and boundless joy!'],
                    ['nama_tamu' => 'dr. Stephanie Wijaya', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 1, 'ucapan_doa' => 'So honored to witness this black-tie celebration. Wishing you eternal happiness!'],
                ],
            ],

            'royal-ivory' => [
                'pria' => [
                    'panggilan' => 'Raka',
                    'lengkap' => 'Raka Bramantyo Pranoto, S.H., LL.M.',
                    'ayah' => 'Bpk. Drs. Wahyu Bramantyo',
                    'ibu' => 'Ibu Dra. Widya Prameswari',
                ],
                'wanita' => [
                    'panggilan' => 'Kirana',
                    'lengkap' => 'drg. Kirana Maharani Putri',
                    'ayah' => 'Bpk. Ir. Hendro Sudibyo',
                    'ibu' => 'Ibu Ratna Dewi Pertiwi',
                ],
                'foto_sampul' => 'aset-demo/sampul-royal.webp',
                'musik_latar' => 'musik/romantis-akustik.mp3',
                'hari_lagi' => 33,
                'kutipan_ayat' => 'Dengan memohon rahmat dan rida Tuhan Yang Maha Esa, kami melangkah memasuki babak kehidupan baru dengan penuh cinta, hormat, dan rasa syukur.',
                'cerita_cinta' => [
                    [
                        'judul' => 'Kampus Menteng',
                        'tanggal' => 'Mei 2021',
                        'cerita' => 'Saling mengenal sejak kepanitiaan bakti sosial alumni hingga berbagi impian di ruang baca klasik.',
                    ],
                    [
                        'judul' => 'Pertunangan Keluarga',
                        'tanggal' => 'November 2025',
                        'cerita' => 'Di ruang tengah bernuansa gading yang hangat, kedua orang tua merestui langkah menuju altar.',
                    ],
                    [
                        'judul' => 'Royal Ivory Reception',
                        'tanggal' => '2026',
                        'cerita' => 'Menyambut tamu kehormatan dalam perjamuan agung bergaya klasik abadi.',
                    ],
                ],
                'live_streaming' => [
                    'aktif' => true,
                    'platform' => 'YouTube Live Heritage',
                    'link' => 'https://youtube.com',
                ],
                'alamat_kado_fisik' => 'Jl. Teuku Umar No. 31, Menteng, Jakarta Pusat 10350',
                'acara' => [
                    [
                        'nama_acara' => 'Akad & Ikrar Suci',
                        'waktu_mulai' => '09:00:00',
                        'waktu_selesai' => '10:30:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Masjid Cut Meutia & Pavilion',
                        'alamat_lengkap' => 'Jl. Taman Cut Meutia No. 1, Menteng, Jakarta Pusat',
                        'link_maps' => 'https://maps.google.com/?q=Masjid+Cut+Meutia+Menteng+Jakarta',
                    ],
                    [
                        'nama_acara' => 'Royal Ivory Banquet',
                        'waktu_mulai' => '12:00:00',
                        'waktu_selesai' => '15:30:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Bali Room Hotel Indonesia Kempinski',
                        'alamat_lengkap' => 'Jl. M.H. Thamrin No. 1, Menteng, Jakarta Pusat',
                        'link_maps' => 'https://maps.google.com/?q=Hotel+Indonesia+Kempinski+Jakarta',
                    ],
                ],
                'galeri' => [
                    ['lokasi_foto' => 'aset-demo/sampul-royal.webp', 'keterangan' => 'Pelukan Hangat Pra-Resepsi'],
                    ['lokasi_foto' => 'aset-demo/galeri-arsitektur.webp', 'keterangan' => 'Potret Klasik Pilar Kayu Warisan'],
                    ['lokasi_foto' => 'aset-demo/galeri-2.webp', 'keterangan' => 'Janji Cincin Emas Abadi'],
                ],
                'amplop' => [
                    ['nama_bank' => 'Mandiri Prioritas', 'nomor_rekening' => '1220099887766', 'atas_nama' => 'Raka Bramantyo Pranoto'],
                    ['nama_bank' => 'BCA', 'nomor_rekening' => '3350918273', 'atas_nama' => 'Kirana Maharani Putri'],
                ],
                'ucapan' => [
                    ['nama_tamu' => 'Prof. Haryanto & Ibu', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 2, 'ucapan_doa' => 'Selamat menempuh bahtera rumah tangga untuk Raka & Kirana. Semoga selalu diberkahi harmoni.'],
                    ['nama_tamu' => 'Dinda & Fariz', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 2, 'ucapan_doa' => 'Pasangan serasi idaman! Kami siap hadir merayakan di Kempinski.'],
                ],
            ],

            'velvet-garden' => [
                'pria' => [
                    'panggilan' => 'Narendra',
                    'lengkap' => 'Narendra Senoaji, M.T.',
                    'ayah' => 'Bpk. Prasetyo Senoaji',
                    'ibu' => 'Ibu Indriani Putri',
                ],
                'wanita' => [
                    'panggilan' => 'Seruni',
                    'lengkap' => 'Seruni Ayuningtyas, S.Ds.',
                    'ayah' => 'Bpk. Agus Purnomo',
                    'ibu' => 'Ibu Lilis Sulistiani',
                ],
                'foto_sampul' => 'aset-demo/sampul-garden.webp',
                'musik_latar' => 'musik/romantis-akustik.mp3',
                'hari_lagi' => 19,
                'kutipan_ayat' => 'Seperti lentera senja di bawah kanopi zamrud dan mekarnya wisteria, cinta kami bertumbuh lembut di setiap musim kehidupan.',
                'cerita_cinta' => [
                    [
                        'judul' => 'Konservatori Kebun Raya',
                        'tanggal' => 'April 2023',
                        'cerita' => 'Saling bertukar sketsa botani anggrek di rumah kaca tua yang dipenuhi embun pagi.',
                    ],
                    [
                        'judul' => 'Janji di Bawah Pergola',
                        'tanggal' => 'Januari 2026',
                        'cerita' => 'Cahaya kunang-kunang dan lentera taman menjadi saksi ikatan pertunangan hangat kami.',
                    ],
                    [
                        'judul' => 'Twilight Garden Wedding',
                        'tanggal' => '2026',
                        'cerita' => 'Berjanji setia di taman kaca berbalut nuansa beludru zamrud dan mawar dusty rose.',
                    ],
                ],
                'live_streaming' => [
                    'aktif' => true,
                    'platform' => 'YouTube Live Sanctuary',
                    'link' => 'https://youtube.com',
                ],
                'alamat_kado_fisik' => 'Jl. Pajajaran Indah V No. 9, Baranangsiang, Kota Bogor 16143',
                'acara' => [
                    [
                        'nama_acara' => 'Garden Akad',
                        'waktu_mulai' => '15:30:00',
                        'waktu_selesai' => '17:00:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Orchid Glasshouse Taman Anggrek',
                        'alamat_lengkap' => 'Jl. Ir. H. Juanda No. 13, Kebun Raya Bogor, Jawa Barat',
                        'link_maps' => 'https://maps.google.com/?q=Kebun+Raya+Bogor',
                    ],
                    [
                        'nama_acara' => 'Twilight Conservatory Dinner',
                        'waktu_mulai' => '18:30:00',
                        'waktu_selesai' => '21:30:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Plataran Puncak Glass Pavilion',
                        'alamat_lengkap' => 'Jl. Raya Puncak KM 84, Cisarua, Kabupaten Bogor',
                        'link_maps' => 'https://maps.google.com/?q=Plataran+Puncak+Bogor',
                    ],
                ],
                'galeri' => [
                    ['lokasi_foto' => 'aset-demo/sampul-garden.webp', 'keterangan' => 'Pesona Senja di Rumah Kaca Anggrek'],
                    ['lokasi_foto' => 'aset-demo/galeri-rumput-renda.webp', 'keterangan' => 'Jejak Langkah di Hamparan Rumput'],
                    ['lokasi_foto' => 'aset-demo/galeri-3.webp', 'keterangan' => 'Pelaminan Outdoor Bermandikan Bunga'],
                ],
                'amplop' => [
                    ['nama_bank' => 'BRI', 'nomor_rekening' => '012301009988501', 'atas_nama' => 'Narendra Senoaji'],
                    ['nama_bank' => 'SeaBank', 'nomor_rekening' => '901234567890', 'atas_nama' => 'Seruni Ayuningtyas'],
                ],
                'ucapan' => [
                    ['nama_tamu' => 'Tania & Rino', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 2, 'ucapan_doa' => 'Magis sekali konsep garden malamnya! Selamat ya Narendra & Seruni, langgeng terus!'],
                    ['nama_tamu' => 'Gita Savitri', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 1, 'ucapan_doa' => 'Semoga kebahagiaan kalian selalu mekar indah seperti rumah kaca Bogor.'],
                ],
            ],

            'islami-syari' => [
                'pria' => [
                    'panggilan' => 'Zayd',
                    'lengkap' => 'Ust. Muhammad Zayd Al-Faruq, Lc., M.A.',
                    'ayah' => 'Bpk. KH. Ahmad Syauqi',
                    'ibu' => 'Ibu Umi Salamah',
                ],
                'wanita' => [
                    'panggilan' => 'Fatimah',
                    'lengkap' => 'Fatimah Az-Zahra, S.Kep., Ners',
                    'ayah' => 'Bpk. H. Abdul Malik',
                    'ibu' => 'Ibu Hj. Khadijah',
                ],
                'foto_sampul' => 'aset-demo/sampul-islami.webp',
                'musik_latar' => 'musik/instrumen-islami.mp3',
                'hari_lagi' => 24,
                'kutipan_ayat' => 'Baarakallahu laka wa baaraka ‘alaika wa jama’a bainakuma fii khair. Semoga Allah menghimpun kalian berdua dalam kebaikan, keberkahan, dan ketaatan hingga surga-Nya. (HR. Abu Dawud)',
                'cerita_cinta' => [
                    [
                        'judul' => 'Ta’aruf atas Saran Guru',
                        'tanggal' => 'Rajab 1447 H',
                        'cerita' => 'Berawal dari proses ta’aruf syar’i yang dijembatani murobbi serta kedua keluarga dengan bertukar biodata.',
                    ],
                    [
                        'judul' => 'Nadhor & Khitbah',
                        'tanggal' => 'Sya’ban 1447 H',
                        'cerita' => 'Melalui shalat istikharah dan pertemuan keluarga yang penuh adab, niat ibadah pernikahan pun dimantapkan.',
                    ],
                    [
                        'judul' => 'Menuju Mitsaqan Ghalizha',
                        'tanggal' => '2026',
                        'cerita' => 'Memohon doa restu kaum muslimin untuk menyempurnakan separuh agama dalam ikatan halal.',
                    ],
                ],
                'live_streaming' => [
                    'aktif' => true,
                    'platform' => 'YouTube Live Kajian & Akad',
                    'link' => 'https://youtube.com',
                ],
                'alamat_kado_fisik' => 'Komplek Pesantren Darussalam Blok C-7, Depok 16415',
                'acara' => [
                    [
                        'nama_acara' => 'Akad Nikah Syar’i',
                        'waktu_mulai' => '08:00:00',
                        'waktu_selesai' => '09:30:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Masjid Istiqlal — Ruang Utama',
                        'alamat_lengkap' => 'Jl. Taman Wijaya Kusuma, Pasar Baru, Sawah Besar, Jakarta Pusat',
                        'link_maps' => 'https://maps.google.com/?q=Masjid+Istiqlal+Jakarta',
                    ],
                    [
                        'nama_acara' => 'Walimatul Ursy (Terpisah Hijab)',
                        'waktu_mulai' => '10:30:00',
                        'waktu_selesai' => '13:30:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Aula Al-Madinah Menteng',
                        'alamat_lengkap' => 'Jl. Menteng Raya No. 62, Jakarta Pusat (Area Ikhwan & Akhwat Terpisah)',
                        'link_maps' => 'https://maps.google.com/?q=Menteng+Raya+Jakarta+Pusat',
                    ],
                ],
                'galeri' => [
                    ['lokasi_foto' => 'aset-demo/sampul-islami.webp', 'keterangan' => 'Usai Ijab Qabul dengan Busana Putih Suci'],
                    ['lokasi_foto' => 'aset-demo/galeri-nikah-pelaminan.webp', 'keterangan' => 'Dekorasi Pelaminan Syar’i Nuansa Putih Zamrud'],
                    ['lokasi_foto' => 'aset-demo/galeri-2.webp', 'keterangan' => 'Mahar Cincin Emas Penuh Keberkahan'],
                ],
                'amplop' => [
                    ['nama_bank' => 'Bank Syariah Indonesia (BSI)', 'nomor_rekening' => '7001928374', 'atas_nama' => 'Muhammad Zayd Al-Faruq'],
                    ['nama_bank' => 'Bank Muamalat', 'nomor_rekening' => '3010099881', 'atas_nama' => 'Fatimah Az-Zahra'],
                ],
                'ucapan' => [
                    ['nama_tamu' => 'Ust. Abdullah & Keluarga', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 2, 'ucapan_doa' => 'Barakallahu lakuma wa baraka alaikuma. Semoga menjadi keluarga Qurani yang penuh berkah, Zayd & Fatimah.'],
                    ['nama_tamu' => 'Ukhti Salma', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 1, 'ucapan_doa' => 'MasyaAllah tabarakallah! Selamat ya Fatimah sayang, semoga sakinah mawaddah warahmah hingga Jannah.'],
                ],
            ],

            'islamic-heavenly' => [
                'pria' => [
                    'panggilan' => 'Farhan',
                    'lengkap' => 'dr. Farhan Hakim Hidayat',
                    'ayah' => 'Bpk. H. Taufiq Hidayat',
                    'ibu' => 'Ibu Hj. Aminah Mansyur',
                ],
                'wanita' => [
                    'panggilan' => 'Hana',
                    'lengkap' => 'Hana Humaira Ridwan, S.Pd.',
                    'ayah' => 'Bpk. H. Ridwan Kamiluddin',
                    'ibu' => 'Ibu Hj. Nurhayati',
                ],
                'foto_sampul' => 'aset-demo/sampul-islamic-heavenly.webp',
                'musik_latar' => 'musik/instrumen-islami.mp3',
                'hari_lagi' => 45,
                'kutipan_ayat' => 'Dan segala sesuatu Kami ciptakan berpasang-pasangan supaya kamu mengingat akan kebesaran Allah. (QS. Adz-Dzariyat: 49)',
                'cerita_cinta' => [
                    [
                        'judul' => 'Misi Kemanusiaan',
                        'tanggal' => 'Ramadan 2024',
                        'cerita' => 'Dipertemukan saat kegiatan sosial pengobatan dan pendidikan anak yatim di Jakarta Pusat.',
                    ],
                    [
                        'judul' => 'Khitbah di Bawah Cahaya Senja',
                        'tanggal' => 'Desember 2025',
                        'cerita' => 'Bersama kedua orang tua berikrar menjaga kehormatan cinta hingga tiba waktu halal.',
                    ],
                    [
                        'judul' => 'Sakinah Malam Berkah',
                        'tanggal' => '2026',
                        'cerita' => 'Melangkah di bawah naungan doa dan keberkahan langit menuju rumah tangga idaman.',
                    ],
                ],
                'live_streaming' => [
                    'aktif' => true,
                    'platform' => 'YouTube Live Heavenly Cast',
                    'link' => 'https://youtube.com',
                ],
                'alamat_kado_fisik' => 'Jl. Bangka IX No. 24, Mampang Prapatan, Jakarta Selatan 12720',
                'acara' => [
                    [
                        'nama_acara' => 'Ijab Qabul',
                        'waktu_mulai' => '15:30:00',
                        'waktu_selesai' => '17:00:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Masjid Agung Sunda Kelapa',
                        'alamat_lengkap' => 'Jl. Taman Sunda Kelapa No. 16, Menteng, Jakarta Pusat',
                        'link_maps' => 'https://maps.google.com/?q=Masjid+Agung+Sunda+Kelapa+Jakarta',
                    ],
                    [
                        'nama_acara' => 'Walimatul Ursy & Ramah Tamah',
                        'waktu_mulai' => '18:30:00',
                        'waktu_selesai' => '21:00:00',
                        'zona_waktu' => 'WIB',
                        'nama_tempat' => 'Smaragda Courtyard Kemang',
                        'alamat_lengkap' => 'Jl. Kemang Timur No. 55, Jakarta Selatan',
                        'link_maps' => 'https://maps.google.com/?q=Kemang+Timur+Jakarta+Selatan',
                    ],
                ],
                'galeri' => [
                    ['lokasi_foto' => 'aset-demo/sampul-islamic-heavenly.webp', 'keterangan' => 'Senyum Syahdu Pengantin Muslimah di Ruang Cahaya'],
                    ['lokasi_foto' => 'aset-demo/galeri-lampu-senja.webp', 'keterangan' => 'Kilau Lentera Bintang Malam Walimah'],
                    ['lokasi_foto' => 'aset-demo/galeri-nikah-pelaminan.webp', 'keterangan' => 'Singgasana Putih Penuh Doa Restu'],
                ],
                'amplop' => [
                    ['nama_bank' => 'BSI', 'nomor_rekening' => '7112233445', 'atas_nama' => 'Farhan Hakim Hidayat'],
                    ['nama_bank' => 'Mandiri', 'nomor_rekening' => '1240055667788', 'atas_nama' => 'Hana Humaira Ridwan'],
                ],
                'ucapan' => [
                    ['nama_tamu' => 'dr. Iqbal Maulana', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 2, 'ucapan_doa' => 'Barakallah dr. Farhan & Hana! Semoga Allah limpahkan ketenangan dan rezeki berkah bagi kalian.'],
                    ['nama_tamu' => 'Aisyah Rahma', 'status_kehadiran' => 'hadir', 'jumlah_tamu' => 1, 'ucapan_doa' => 'Terharu banget lihat perjalanan kalian. Selamat menempuh ibadah terpanjang seumur hidup!'],
                ],
            ],
        ];
    }
}
