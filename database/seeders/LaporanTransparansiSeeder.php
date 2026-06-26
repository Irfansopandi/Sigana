<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\TransparencyReport;
use App\Models\ReportAllocation;
use App\Models\ReportTimeline;
use App\Models\ReportEvidence;
use App\Models\ReportDoc;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LaporanTransparansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\ReportDoc::truncate();
        \App\Models\ReportEvidence::truncate();
        \App\Models\ReportTimeline::truncate();
        \App\Models\ReportAllocation::truncate();
        \App\Models\TransparencyReport::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $reports = [
            'donasi-darurat-banjir-bandang-demak' => [
                'status' => 'Dalam Penyaluran',
                'status_class' => 'transparency-badge-penyaluran',
                'status_icon' => 'fa-solid fa-truck',
                'used' => 75000000,
                'date' => '2026-06-18',
                'description' => 'Penyaluran logistik bencana banjir bandang Demak difokuskan pada pemenuhan kebutuhan dasar pengungsi, termasuk bahan pangan mentah untuk dapur umum, obat-obatan pasca-banjir, pakaian bersih, dan selimut hangat untuk mengantisipasi hawa dingin posko darurat.',
                'beneficiaries' => 850,
                'allocations' => [
                    ['kategori' => 'Dapur Umum & Pangan Darurat', 'nominal' => 35000000, 'progress' => '46%', 'icon' => 'fa-solid fa-utensils', 'desc' => 'Pembelian beras, mie, telur, bumbu dapur, gas LPG, and air mineral galon untuk kebutuhan makan 3x sehari.'],
                    ['kategori' => 'Obat & Layanan Medis', 'nominal' => 15000000, 'progress' => '20%', 'icon' => 'fa-solid fa-prescription-bottle-medical', 'desc' => 'Pengadaan masker medis, salep gatal, perban, minyak kayu putih, obat penurun demam, and suplemen daya tahan tubuh.'],
                    ['kategori' => 'Selimut, Kasur Lipat & Pakaian', 'nominal' => 20000000, 'progress' => '27%', 'icon' => 'fa-solid fa-shirt', 'desc' => 'Pengadaan 500 selimut polar hangat, 200 unit kasur busa lipat darurat, and paket pakaian dalam baru.'],
                    ['kategori' => 'Distribusi & Logistik Lapangan', 'nominal' => 5000000, 'progress' => '7%', 'icon' => 'fa-solid fa-truck-ramp-box', 'desc' => 'Biaya bahan bakar armada truk pengangkut bantuan, sewa pick-up lokal untuk daerah pelosok, and makan relawan.']
                ],
                'timeline' => [
                    ['tanggal' => '2026-06-18', 'judul' => 'Pendirian Dapur Umum Tahap II', 'deskripsi' => 'Pengiriman beras sebanyak 2 ton dan ribuan paket mie instan serta telur ke posko pengungsian utama Kecamatan Karanganyar, Demak.', 'icon' => 'fa-solid fa-utensils'],
                    ['tanggal' => '2026-06-15', 'judul' => 'Pembagian 500 Selimut Polar', 'deskripsi' => 'Relawan membagikan selimut polar hangat dan pakaian layak pakai kepada pengungsi lansia dan anak-anak di malam hari.', 'icon' => 'fa-solid fa-bed'],
                    ['tanggal' => '2026-06-12', 'judul' => 'Pemeriksaan Kesehatan Massal', 'deskripsi' => 'Pemeriksaan medis gratis bersama dokter relawan untuk menangani wabah kutu air dan demam pasca genangan banjir surut.', 'icon' => 'fa-solid fa-heart-pulse']
                ],
                'evidence' => [
                    ['url' => 'storage/assets/ilustasi/demak_flood.png', 'desc' => 'Relawan SIGANA membagikan bahan logistik pangan di posko utama.'],
                    ['url' => 'storage/assets/ilustasi/hero_illustration.png', 'desc' => 'Kondisi dapur umum darurat yang melayani ratusan pengungsi setiap hari.'],
                    ['url' => 'storage/assets/ilustasi/mamuju_earthquake.png', 'desc' => 'Truk logistik SIGANA saat tiba di lokasi penyaluran bencana Demak.']
                ],
                'docs' => [
                    ['id' => 'OUT-DMK-001', 'nama' => 'Kuitansi Belanja Beras & Sembako', 'nominal' => 35000000, 'file' => 'Kwitansi_Sembako_Demak.pdf'],
                    ['id' => 'OUT-DMK-002', 'nama' => 'Faktur Apotek Pembelian Obat Medis', 'nominal' => 15000000, 'file' => 'Faktur_Obat_Sehat.pdf'],
                    ['id' => 'OUT-DMK-003', 'nama' => 'Nota Pembelian Selimut & Sandang', 'nominal' => 20000000, 'file' => 'Nota_Sandang_Demak.pdf']
                ]
            ],
            'peduli-korban-gempa-bumi-mamuju' => [
                'status' => 'Hampir Selesai',
                'status_class' => 'transparency-badge-selesai',
                'status_icon' => 'fa-solid fa-circle-check',
                'used' => 160000000,
                'date' => '2026-06-17',
                'description' => 'Dana bantuan gempa Mamuju dialokasikan untuk membiayai sewa alat berat demi membuka jalur isolasi desa, pengadaan ratusan terpal tenda keluarga mandiri, kebutuhan nutrisi khusus balita, serta penyediaan fasilitas MCK portable darurat.',
                'beneficiaries' => 3200,
                'allocations' => [
                    ['kategori' => 'Alat Berat & Evakuasi Runtuhan', 'nominal' => 50000000, 'progress' => '31%', 'icon' => 'fa-solid fa-helmet-safety', 'desc' => 'Sewa ekskavator untuk evakuasi puing-puing jalan penghubung desa terisolir.'],
                    ['kategori' => 'Terpal & Tenda Pengungsian', 'nominal' => 60000000, 'progress' => '38%', 'icon' => 'fa-solid fa-tents', 'desc' => 'Pengadaan 100 unit tenda keluarga mandiri ukuran 4x4 meter berbahan terpal tebal.'],
                    ['kategori' => 'Susu & MPASI Balita', 'nominal' => 30000000, 'progress' => '19%', 'icon' => 'fa-solid fa-baby', 'desc' => 'Pengadaan susu formula, bubur instan bayi, biskuit balita, dan popok sekali pakai.'],
                    ['kategori' => 'MCK Portable Darurat', 'nominal' => 20000000, 'progress' => '12%', 'icon' => 'fa-solid fa-restroom', 'desc' => 'Pembangunan 5 unit toilet portable darurat beserta sistem tangki air bersih.']
                ],
                'timeline' => [
                    ['tanggal' => '2026-06-17', 'judul' => 'Sewa Ekskavator Pembuka Akses', 'deskripsi' => 'Penyaluran dana untuk menyewa alat berat guna menyingkirkan material longsor akibat gempa yang mengisolasi pemukiman.', 'icon' => 'fa-solid fa-truck'],
                    ['tanggal' => '2026-06-15', 'judul' => 'Pembangunan MCK Portable', 'deskripsi' => 'Penyediaan toilet darurat lengkap dengan tandon air bersih di area lapangan pengungsian pusat Kabupaten Mamuju.', 'icon' => 'fa-solid fa-bath'],
                    ['tanggal' => '2026-06-10', 'judul' => 'Distribusi 100 Unit Tenda Terpal', 'deskripsi' => 'Pembagian terpal pelindung dan rangka tenda instan agar warga tidak tidur di ruang terbuka tanpa pelindung.', 'icon' => 'fa-solid fa-campground']
                ],
                'evidence' => [
                    ['url' => 'storage/assets/ilustasi/mamuju_earthquake.png', 'desc' => 'MCK portable darurat yang telah berhasil dibangun untuk warga.'],
                    ['url' => 'storage/assets/ilustasi/hero_illustration.png', 'desc' => 'Alat berat ekskavator bekerja menyingkirkan material runtuhan.'],
                    ['url' => 'storage/assets/ilustasi/demak_flood.png', 'desc' => 'Distribusi bantuan susu formula dan popok bayi di tenda pengungsian.']
                ],
                'docs' => [
                    ['id' => 'OUT-MMJ-001', 'nama' => 'Faktur Sewa Alat Berat Kontraktor', 'nominal' => 50000000, 'file' => 'Kapasitas_Sewa_AlatBerat.pdf'],
                    ['id' => 'OUT-MMJ-002', 'nama' => 'Nota Pembelian Tenda Terpal Sulawesi', 'nominal' => 60000000, 'file' => 'Nota_Tenda_Mamuju.pdf'],
                    ['id' => 'OUT-MMJ-003', 'nama' => 'Faktur Belanja Susu & Gizi Balita', 'nominal' => 30000000, 'file' => 'Faktur_Susu_Mamuju.pdf'],
                    ['id' => 'OUT-MMJ-004', 'nama' => 'Kuitansi Vendor Toilet MCK Portable', 'nominal' => 20000000, 'file' => 'Kwitansi_MCK_Portable.pdf']
                ]
            ],
            'bantuan-logistik-erupsi-gunung-semeru' => [
                'status' => 'Dalam Penyaluran',
                'status_class' => 'transparency-badge-penyaluran',
                'status_icon' => 'fa-solid fa-truck',
                'used' => 38000000,
                'date' => '2026-06-16',
                'description' => 'Dana bantuan Semeru disalurkan dalam bentuk pengadaan masker medis khusus abu vulkanik, kacamata google, bahan pangan mentah bagi posko pengungsian di Lumajang, serta obat-obatan inhaler pernapasan.',
                'beneficiaries' => 6500,
                'allocations' => [
                    ['kategori' => 'Masker & Kacamata Proteksi', 'nominal' => 15000000, 'progress' => '39%', 'icon' => 'fa-solid fa-head-side-mask', 'desc' => 'Pengadaan 10.000 masker KN95 pelindung abu vulkanik dan kacamata proteksi relawan.'],
                    ['kategori' => 'Dapur Umum Lumajang', 'nominal' => 15000000, 'progress' => '39%', 'icon' => 'fa-solid fa-bowl-food', 'desc' => 'Bahan pokok dapur umum mandiri bagi pengungsi di daerah Lumajang.'],
                    ['kategori' => 'Obat ISPA & Inhaler Pernapasan', 'nominal' => 8000000, 'progress' => '22%', 'icon' => 'fa-solid fa-briefcase-medical', 'desc' => 'Obat penurun sesak napas, inhaler, suplemen paru-paru, dan obat mata merah.']
                ],
                'timeline' => [
                    ['tanggal' => '2026-06-16', 'judul' => 'Pembagian Masker KN95 Massal', 'deskripsi' => 'Membagikan 10.000 masker KN95 and kacamata pelindung debu vulkanik ke desa-desa terdampak hujan abu tebal di Lumajang.', 'icon' => 'fa-solid fa-head-side-mask'],
                    ['tanggal' => '2026-06-14', 'judul' => 'Pengisian Stok Sembako Dapur Umum', 'deskripsi' => 'Mengisi ulang bahan dapur berupa telur, beras, mie instan, sayur-mayur segar, dan gas LPG untuk dapur umum lapangan.', 'icon' => 'fa-solid fa-utensils']
                ],
                'evidence' => [
                    ['url' => 'storage/assets/ilustasi/semeru_eruption.png', 'desc' => 'Relawan mendistribusikan masker medis KN95 ke warga.'],
                    ['url' => 'storage/assets/ilustasi/hero_illustration.png', 'desc' => 'Relawan SIGANA menyiapkan paket makanan di Dapur Umum Lumajang.']
                ],
                'docs' => [
                    ['id' => 'OUT-SMR-001', 'nama' => 'Nota Pembelian Masker KN95 & Goggles', 'nominal' => 15000000, 'file' => 'Nota_Masker_Semeru.pdf'],
                    ['id' => 'OUT-SMR-002', 'nama' => 'Kuitansi Belanja Sembako Dapur Umum', 'nominal' => 15000000, 'file' => 'Kwitansi_Sembako_Semeru.pdf'],
                    ['id' => 'OUT-SMR-003', 'nama' => 'Faktur Obat-obatan Paru & ISPA', 'nominal' => 8000000, 'file' => 'Faktur_Obat_ISPA.pdf']
                ]
            ],
            'penanganan-darurat-tanah-longsor-bogor' => [
                'status' => 'Aktif',
                'status_class' => 'transparency-badge-aktif',
                'status_icon' => 'fa-solid fa-circle-dot',
                'used' => 25000000,
                'date' => '2026-06-12',
                'description' => 'Dana penanganan longsor Bogor dialokasikan untuk pembersihan lumpur pemukiman, paket pembersih lumpur (cangkul, sekop, booting), serta kebutuhan pangan posko pengungsi.',
                'beneficiaries' => 300,
                'allocations' => [
                    ['kategori' => 'Alat Kerja Pembersih Lumpur', 'nominal' => 10000000, 'progress' => '40%', 'icon' => 'fa-solid fa-toolbox', 'desc' => 'Pembelian sekop, cangkul, kereta dorong, sepatu boot karet relawan, dan pacul.'],
                    ['kategori' => 'Logistik Dapur Umum Darurat', 'nominal' => 15000000, 'progress' => '60%', 'icon' => 'fa-solid fa-utensils', 'desc' => 'Belanja bahan pangan mentah, bumbu, gas LPG, dan air mineral galon.']
                ],
                'timeline' => [
                    ['tanggal' => '2026-06-12', 'judul' => 'Pembersihan Material Lumpur', 'deskripsi' => 'Relawan SIGANA bersama warga bergotong royong membersihkan sisa lumpur longsoran tebing menggunakan alat-alat kerja baru.', 'icon' => 'fa-solid fa-person-digging'],
                    ['tanggal' => '2026-06-10', 'judul' => 'Pengadaan Alat Kebersihan Posko', 'deskripsi' => 'Membeli perlengkapan kebersihan cangkul, sekop, booting, dan pacul untuk diserahkan ke posko koordinasi lapangan.', 'icon' => 'fa-solid fa-toolbox']
                ],
                'evidence' => [
                    ['url' => 'storage/assets/ilustasi/mamuju_earthquake.png', 'desc' => 'Warga dan relawan bergotong royong menggunakan cangkul dan sekop.'],
                    ['url' => 'storage/assets/ilustasi/hero_illustration.png', 'desc' => 'Dapur umum darurat menyajikan makanan untuk korban longsor Bogor.']
                ],
                'docs' => [
                    ['id' => 'OUT-BGR-001', 'nama' => 'Nota Pembelian Alat Kerja Sekop & Boot', 'nominal' => 10000000, 'file' => 'Nota_Alat_Longsor.pdf'],
                    ['id' => 'OUT-BGR-002', 'nama' => 'Kuitansi Bahan Pangan Dapur Umum', 'nominal' => 15000000, 'file' => 'Kwitansi_BahanPangan_Bogor.pdf']
                ]
            ],
            'bantuan-krisis-air-bersih-gunungkidul' => [
                'status' => 'Hampir Selesai',
                'status_class' => 'transparency-badge-selesai',
                'status_icon' => 'fa-solid fa-circle-check',
                'used' => 15000000,
                'date' => '2026-06-14',
                'description' => 'Dana bantuan krisis air bersih dialokasikan penuh untuk menyewa armada mobil tangki air bersih guna didistribusikan ke wilayah pelosok kering Gunungkidul, serta pengadaan wadah penampungan air (jeriken plastik) untuk warga.',
                'beneficiaries' => 2400,
                'allocations' => [
                    ['kategori' => 'Droping Tangki Air Bersih', 'nominal' => 10000000, 'progress' => '67%', 'icon' => 'fa-solid fa-truck', 'desc' => 'Pembayaran 50 armada mobil tangki air kapasitas 5.000 liter.'],
                    ['kategori' => 'Jeriken & Ember Plastik', 'nominal' => 5000000, 'progress' => '33%', 'icon' => 'fa-solid fa-bucket', 'desc' => 'Pembelian 400 pcs jeriken plastik kapasitas 20 liter untuk menampung air di rumah.']
                ],
                'timeline' => [
                    ['tanggal' => '2026-06-14', 'judul' => 'Droping Air Bersih Gelombang II', 'deskripsi' => 'Pengiriman 25 tangki air bersih kapasitas 5.000 liter secara serentak ke 4 desa paling kritis kekeringan di Gunungkidul.', 'icon' => 'fa-solid fa-truck'],
                    ['tanggal' => '2026-06-10', 'judul' => 'Distribusi 400 Jeriken Plastik', 'deskripsi' => 'Membagikan jeriken wadah tampung air agar warga mudah mengangkut air bersih dari tandon umum desa.', 'icon' => 'fa-solid fa-bucket']
                ],
                'evidence' => [
                    ['url' => 'storage/assets/ilustasi/demak_flood.png', 'desc' => 'Truk tangki air menyuplai bak penampungan air warga.'],
                    ['url' => 'storage/assets/ilustasi/semeru_eruption.png', 'desc' => 'Warga mengantre tertib membawa jeriken plastik untuk diisi air bersih.']
                ],
                'docs' => [
                    ['id' => 'OUT-GK-001', 'nama' => 'Surat Jalan & Invoice 50 Tangki Air', 'nominal' => 10000000, 'file' => 'Invoice_Tangki_Air_GK.pdf'],
                    ['id' => 'OUT-GK-002', 'nama' => 'Nota Pembelian 400 Pcs Jeriken Plastik', 'nominal' => 5000000, 'file' => 'Nota_Jeriken_GK.pdf']
                ]
            ],
            'dukungan-medis-balita-gizi-buruk-ntt' => [
                'status' => 'Aktif',
                'status_class' => 'transparency-badge-aktif',
                'status_icon' => 'fa-solid fa-circle-dot',
                'used' => 40000000,
                'date' => '2026-06-10',
                'description' => 'Dana donasi dialokasikan untuk pemenuhan gizi balita malnutrisi, obat-obatan suplemen medis posyandu, dan makanan tambahan bergizi (PMT) biskuit khusus pertumbuhan balita stunting.',
                'beneficiaries' => 100,
                'allocations' => [
                    ['kategori' => 'Suplemen & Vitamin Pertumbuhan', 'nominal' => 15000000, 'progress' => '37.5%', 'icon' => 'fa-solid fa-prescription-bottle-medical', 'desc' => 'Pembelian multivitamin khusus, susu formula F-75/F-100, dan suplemen besi untuk balita anemia.'],
                    ['kategori' => 'Biskuit PMT Khusus Balita', 'nominal' => 15000000, 'progress' => '37.5%', 'icon' => 'fa-solid fa-cookie-bite', 'desc' => 'Pengadaan biskuit tinggi kalori pendukung tumbuh kembang balita stunting.'],
                    ['kategori' => 'Susu Formula Formula Medis', 'nominal' => 10000000, 'progress' => '25%', 'icon' => 'fa-solid fa-jar-wheat', 'desc' => 'Susu kaleng khusus malnutrisi terverifikasi rekomendasi posyandu desa.']
                ],
                'timeline' => [
                    ['tanggal' => '2026-06-10', 'judul' => 'Penyaluran Suplemen Posyandu', 'deskripsi' => 'Menyerahkan paket multivitamin dan susu F-75 ke Posyandu Desa Kupang Timur untuk penanganan balita kurang gizi.', 'icon' => 'fa-solid fa-prescription-bottle-medical'],
                    ['tanggal' => '2026-06-07', 'judul' => 'Distribusi Biskuit PMT Bergizi', 'deskripsi' => 'Membagikan ratusan karton biskuit tinggi kalori PMT khusus balita yang dikawal oleh bidan desa Kupang Timur.', 'icon' => 'fa-solid fa-cookie-bite']
                ],
                'evidence' => [
                    ['url' => 'storage/assets/ilustasi/semeru_eruption.png', 'desc' => 'Bidan desa menyerahkan susu and biskuit PMT ke ibu balita.'],
                    ['url' => 'storage/assets/ilustasi/hero_illustration.png', 'desc' => 'Kader posyandu mengukur berat badan balita saat rehabilitasi medis gizi.']
                ],
                'docs' => [
                    ['id' => 'OUT-NTT-001', 'nama' => 'Invoice Susu F-75 & Suplemen Medis', 'nominal' => 15000000, 'file' => 'Invoice_Suplemen_NTT.pdf'],
                    ['id' => 'OUT-NTT-002', 'nama' => 'Nota Pembelian Biskuit PMT Pertumbuhan', 'nominal' => 15000000, 'file' => 'Nota_Biskuit_PMT.pdf'],
                    ['id' => 'OUT-NTT-003', 'nama' => 'Nota Belanja Susu Formula Gizi Balita', 'nominal' => 10000000, 'file' => 'Nota_Susu_Gizi_NTT.pdf']
                ]
            ]
        ];

        foreach ($reports as $slug => $data) {
            $campaign = Campaign::where('slug', $slug)->first();
            if ($campaign) {
                $report = TransparencyReport::create([
                    'campaign_id' => $campaign->id,
                    'status' => $data['status'],
                    'status_class' => $data['status_class'],
                    'status_icon' => $data['status_icon'],
                    'used' => $data['used'],
                    'date' => Carbon::parse($data['date']),
                    'description' => $data['description'],
                    'beneficiaries' => $data['beneficiaries'],
                ]);

                foreach ($data['allocations'] as $alloc) {
                    ReportAllocation::create([
                        'report_id' => $report->id,
                        'kategori' => $alloc['kategori'],
                        'nominal' => $alloc['nominal'],
                        'progress' => $alloc['progress'],
                        'icon' => $alloc['icon'],
                        'desc' => $alloc['desc'],
                    ]);
                }

                foreach ($data['timeline'] as $time) {
                    ReportTimeline::create([
                        'report_id' => $report->id,
                        'tanggal' => Carbon::parse($time['tanggal']),
                        'judul' => $time['judul'],
                        'deskripsi' => $time['deskripsi'],
                        'icon' => $time['icon'],
                    ]);
                }

                foreach ($data['evidence'] as $ev) {
                    ReportEvidence::create([
                        'report_id' => $report->id,
                        'url' => $ev['url'],
                        'desc' => $ev['desc'],
                    ]);
                }

                foreach ($data['docs'] as $doc) {
                    ReportDoc::create([
                        'report_id' => $report->id,
                        'doc_id' => $doc['id'],
                        'nama' => $doc['nama'],
                        'nominal' => $doc['nominal'],
                        'file' => $doc['file'],
                    ]);
                }
            }
        }
    }
}
