<?php

namespace Database\Seeders;

use App\Models\Campaign;
use App\Models\CampaignNeed;
use App\Models\Donation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DataBencanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Donation::truncate();
        \App\Models\CampaignNeed::truncate();
        \App\Models\Campaign::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            $campaigns = [
            [
                'slug' => 'donasi-darurat-banjir-bandang-demak',
                'title' => 'Donasi Darurat Banjir Bandang Demak',
                'location' => 'Demak, Jawa Tengah',
                'category' => 'banjir',
                'image' => 'storage/assets/bencana/demak_flood.png',
                'status' => 'Darurat',                
                'collected_raw' => 98500000,
                'target_raw' => 150000000,
                'days_left' => 12,
                'date_published' => '2026-06-18',
                'latitude'  => -6.8942,  
                'longitude' => 110.6386,
                'description_short' => 'Banjir bandang setinggi 1.5 meter merendam pemukiman warga akibat tanggul sungai yang jebol. Ratusan jiwa membutuhkan makanan cepat saji, pakaian bersih, dan obat-obatan.',
                'description_long' => 'Banjir bandang dahsyat yang melanda Kabupaten Demak disebabkan oleh tingginya curah hujan selama tiga hari berturut-turut yang mengakibatkan jebolnya tanggul Sungai Wulan di beberapa titik kritis. Lebih dari 1.200 kepala keluarga terdampak secara langsung, dengan ketinggian air di wilayah pemukiman mencapai 1 hingga 1.5 meter. Warga yang mengungsi tersebar di posko-posko darurat, balai desa, dan tempat ibadah dengan keterbatasan fasilitas sanitasi dan pasokan logistik harian. Tim penyelamat gabungan masih bersiaga melakukan evakuasi lansia dan balita. Bantuan dana Anda akan langsung kami belanjakan menjadi paket makanan instan hangat, perlengkapan higienis wanita/bayi, selimut tebal, serta obat-obatan penanganan penyakit air.',
                'victims' => 1200,
                'needs' => [
                    ['icon' => 'fa-solid fa-utensils', 'name' => 'Makanan Cepat Saji', 'qty' => '1.500 Porsi/hari'],
                    ['icon' => 'fa-solid fa-kit-medical', 'name' => 'Obat & Masker', 'qty' => '500 Paket'],
                    ['icon' => 'fa-solid fa-baby', 'name' => 'Susu & Popok Bayi', 'qty' => '300 Dus'],
                    ['icon' => 'fa-solid fa-shirt', 'name' => 'Pakaian Layak Pakai', 'qty' => '1.000 Set']
                ],
                'donors' => [
                    ['name' => 'Hamba Allah', 'amount' => 150000, 'created_at' => '2026-06-20 15:00:00', 'message' => 'Semoga lekas surut banjirnya dan warga diberikan ketabahan.'],
                    ['name' => 'Ahmad Faisal', 'amount' => 1000000, 'created_at' => '2026-06-20 12:00:00', 'message' => 'Semoga sedikit bantuan ini bisa meringankan beban saudara kita di Demak.'],
                    ['name' => 'Budi Santoso', 'amount' => 500000, 'created_at' => '2026-06-19 17:00:00', 'message' => 'Titip doa keselamatan untuk para relawan kemanusiaan di lapangan.'],
                    ['name' => 'Nadia Putri', 'amount' => 250000, 'created_at' => '2026-06-18 10:00:00', 'message' => 'Mari saling bantu bahu-membahu. Indonesia Kuat!']
                ]
            ],
            [
                'slug' => 'peduli-korban-gempa-bumi-mamuju',
                'title' => 'Peduli Korban Gempa Bumi Mamuju',
                'location' => 'Mamuju, Sulawesi Barat',
                'category' => 'gempa',
                'image' => 'storage/assets/bencana/mamuju_earthquake.png',
                'status' => 'Darurat',
                'collected_raw' => 175000000,
                'target_raw' => 250000000,
                'days_left' => 8,
                'date_published' => '2026-06-17',
                'latitude'  => -2.6727,
                'longitude' => 118.8880,
                'description_short' => 'Gempa berkekuatan M 6.2 mengakibatkan kerusakan parah infrastruktur dan puluhan rumah warga roboh. Kebutuhan mendesak meliputi tenda darurat, selimut, susu bayi, dan popok.',
                'description_long' => 'Mamuju diguncang gempa tektonik berkekuatan Magnitudo 6.2 pada kedalaman dangkal, mengakibatkan kerusakan parah pada puluhan gedung perkantoran, fasilitas umum, dan ratusan rumah penduduk setempat. Korban luka-luka akibat tertimpa reruntuhan bangunan telah dievakuasi ke RS Lapangan. Saat ini, ribuan warga memilih tinggal di tenda-tenda darurat yang dibangun secara swadaya di area terbuka karena trauma akan adanya gempa susulan. Kebutuhan yang paling mendesak di lapangan saat ini adalah tenda peleton/keluarga tahan hujan, kasur lipat, selimut hangat, penerangan bertenaga surya, makanan bayi, serta tangki air bersih mobile.',
                'victims' => 3500,
                'needs' => [
                    ['icon' => 'fa-solid fa-tent', 'name' => 'Tenda Darurat', 'qty' => '150 Unit'],
                    ['icon' => 'fa-solid fa-mattress-pillow', 'name' => 'Selimut & Matras', 'qty' => '800 Pcs'],
                    ['icon' => 'fa-solid fa-droplet', 'name' => 'Pasokan Air Bersih', 'qty' => '10 Tangki/hari'],
                    ['icon' => 'fa-solid fa-hands-holding-child', 'name' => 'Kid Wear & Milk', 'qty' => '250 Paket']
                ],
                'donors' => [
                    ['name' => 'Siti Aminah', 'amount' => 300000, 'created_at' => '2026-06-20 16:00:00', 'message' => 'Semoga keadaan di Mamuju segera membaik dan kondusif.'],
                    ['name' => 'Hendro Wijaya', 'amount' => 2500000, 'created_at' => '2026-06-20 13:00:00', 'message' => 'Bantuan untuk saudara kita yang tertimpa musibah gempa.'],
                    ['name' => 'Hamba Allah', 'amount' => 50000, 'created_at' => '2026-06-20 09:00:00', 'message' => 'Lekas sembuh Mamuju.'],
                    ['name' => 'Dewi Safitri', 'amount' => 500000, 'created_at' => '2026-06-19 10:00:00', 'message' => 'Terima kasih SIGANA yang memudahkan proses penyaluran donasi transparan.']
                ]
            ],
            [
                'slug' => 'bantuan-logistik-erupsi-gunung-semeru',
                'title' => 'Bantuan Logistik Erupsi Gunung Semeru',
                'location' => 'Lumajang, Jawa Timur',
                'category' => 'erupsi',
                'image' => 'storage/assets/bencana/semeru_eruption.png',
                'status' => 'Waspada',
                'collected_raw' => 45000000,
                'target_raw' => 100000000,
                'days_left' => 15,
                'date_published' => '2026-06-19',
                'latitude'  => -8.1080,
                'longitude' => 112.9220,
                'description_short' => 'Guguran awan panas Gunung Semeru memaksa ribuan warga mengungsi ke tempat aman. Dibutuhkan masker medis, pelindung mata, bahan makanan pokok, dan obat ISPA.',
                'description_long' => 'Aktivitas vulkanik Gunung Semeru kembali meningkat dengan meluncurkan Awan Panas Guguran (APG) sejauh puluhan kilometer ke arah tenggara. Sejumlah desa di Kecamatan Pronojiwo dan Candipuro tertutup abu vulkanik tebal yang membatasi jarak pandang dan berisiko memicu gangguan pernapasan akut (ISPA). Pemerintah daerah setempat telah menginstruksikan pengosongan wilayah rawan dalam radius bahaya. Donasi yang terkumpul akan dialokasikan untuk mendistribusikan masker respirator berkualitas, kacamata pelindung debu, tabung oksigen portabel untuk puskesmas rujukan, serta bahan makanan pokok (sembako) untuk menopang kebutuhan keluarga di posko pengungsian.',
                'victims' => 3500,
                'needs' => [
                    ['icon' => 'fa-solid fa-mask', 'name' => 'Masker N95 / Kacamata', 'qty' => '3.000 Pcs'],
                    ['icon' => 'fa-solid fa-box-open', 'name' => 'Paket Sembako', 'qty' => '600 Paket'],
                    ['icon' => 'fa-solid fa-wind', 'name' => 'Tabung Oksigen', 'qty' => '50 Unit'],
                    ['icon' => 'fa-solid fa-user-doctor', 'name' => 'Pemeriksaan Kesehatan', 'qty' => '10 Posko']
                ],
                'donors' => [
                    ['name' => 'Rian Ardianto', 'amount' => 200000, 'created_at' => '2026-06-20 16:30:00', 'message' => 'Semoga debu vulkanik segera reda dan tidak ada korban jiwa.'],
                    ['name' => 'Lembaga Amal Kita', 'amount' => 5000000, 'created_at' => '2026-06-20 14:00:00', 'message' => 'Penyaluran dana amanah kantor untuk bencana erupsi Semeru.'],
                    ['name' => 'Hamba Allah', 'amount' => 100000, 'created_at' => '2026-06-20 11:00:00', 'message' => 'Doa kami menyertai warga Lumajang.']
                ]
            ],
            [
                'slug' => 'penanganan-darurat-tanah-longsor-bogor',
                'title' => 'Penanganan Darurat Tanah Longsor Bogor',
                'location' => 'Bogor, Jawa Barat',
                'category' => 'lainnya',
                'image' => 'storage/assets/bencana/mamuju_earthquake.png',
                'status' => 'Darurat',
                'collected_raw' => 32000000,
                'target_raw' => 80000000,
                'days_left' => 18,
                'date_published' => '2026-06-15',
                'latitude'  => -6.5971,
                'longitude' => 106.8060,
                'description_short' => 'Curah hujan tinggi menyebabkan tebing longsor yang menimbun 5 rumah warga di lereng bukit. Tim penyelamat membutuhkan logistik medis, peralatan kebersihan, serta bahan pangan darurat.',
                'description_long' => 'Bencana tanah longsor melanda kawasan pemukiman padat di lereng perbukitan Bogor Selatan akibat dipicu hujan lebat dengan durasi lama. Longsoran tanah tebal menimbun setidaknya 5 rumah warga dan merusak akses jalan desa. Tim tanggap darurat bersama anjing pelacak masih bekerja menyisir sisa reruntuhan. Puluhan keluarga diungsikan ke aula kecamatan setempat demi menghindari ancaman longsor susulan mengingat cuaca ekstrem yang masih berlangsung. Dana bantuan donatur akan disalurkan dalam bentuk paket perlengkapan sanitasi dan kebersihan, kasur darurat, obat-obatan luka luar/infeksi, serta bahan makanan pokok instan.',
                'victims' => 3500,
                'needs' => [
                    ['icon' => 'fa-solid fa-broom', 'name' => 'Peralatan Kebersihan', 'qty' => '100 Set'],
                    ['icon' => 'fa-solid fa-mattress-pillow', 'name' => 'Kasur Lipat & Selimut', 'qty' => '200 Unit'],
                    ['icon' => 'fa-solid fa-box-tissue', 'name' => 'Hygiene Kit', 'qty' => '300 Paket'],
                    ['icon' => 'fa-solid fa-wheat-awn', 'name' => 'Bahan Pangan Pokok', 'qty' => '400 Box']
                ],
                'donors' => [
                    ['name' => 'Hamba Allah', 'amount' => 50000, 'created_at' => '2026-06-20 05:00:00', 'message' => 'Lekas pulih Bogor.'],
                    ['name' => 'Yusuf Mansur', 'amount' => 1500000, 'created_at' => '2026-06-19 17:00:00', 'message' => 'Semoga korban segera ditemukan dengan selamat. Amin.']
                ]
            ],
            [
                'slug' => 'bantuan-krisis-air-bersih-gunungkidul',
                'title' => 'Bantuan Krisis Air Bersih Gunungkidul',
                'location' => 'Gunungkidul, D.I. Yogyakarta',
                'category' => 'lainnya',
                'image' => 'storage/assets/bencana/demak_flood.png',
                'status' => 'Waspada',
                'collected_raw' => 18500000,
                'target_raw' => 50000000,
                'days_left' => 25,
                'date_published' => '2026-06-16',
                'latitude'  => -7.9897,
                'longitude' => 110.5978,
                'description_short' => 'Kekeringan panjang menyebabkan sumur warga mengering total di beberapa kecamatan. Bantuan difokuskan untuk droping tangki air bersih dan pembangunan bak penampungan air desa.',
                'description_long' => 'Fenomena El Nino memicu musim kemarau ekstrem yang berkepanjangan di kawasan karst Kabupaten Gunungkidul. Akibatnya, sumber mata air alami dan sumur-sumur galian warga mengering total sejak dua bulan terakhir. Ribuan warga terpaksa membeli air tangki komersial dengan harga tinggi atau menempuh jarak berkilo-kilometer melintasi perbukitan batu kapur hanya untuk mendapatkan beberapa liter air bersih. Kampanye ini digalang untuk melakukan aksi droping truk tangki air bersih gratis ke desa-desa terparah serta mendanai instalasi bak penampungan air (toren) komunal di titik-titik pemukiman strategis warga.',
                'victims' => 3500,
                'needs' => [
                    ['icon' => 'fa-solid fa-truck-droplet', 'name' => 'Truk Tangki Air Bersih', 'qty' => '100 Tangki'],
                    ['icon' => 'fa-solid fa-fill-drip', 'name' => 'Bak Penampung Air / Toren', 'qty' => '15 Unit'],
                    ['icon' => 'fa-solid fa-bucket', 'name' => 'Jeriken Plastik', 'qty' => '400 Pcs']
                ],
                'donors' => [
                    ['name' => 'Dwi Prasetyo', 'amount' => 250000, 'created_at' => '2026-06-20 14:00:00', 'message' => 'Semoga air bersih segera tersalurkan merata ke warga.'],
                    ['name' => 'Hamba Allah', 'amount' => 500000, 'created_at' => '2026-06-19 17:00:00', 'message' => 'Sedekah air bersih mendatangkan berkah. Semangat!']
                ]
            ],
            [
                'slug' => 'dukungan-medis-balita-gizi-buruk-ntt',
                'title' => 'Dukungan Medis Balita Gizi Buruk NTT',
                'location' => 'Kupang, NTT',
                'category' => 'lainnya',
                'image' => 'storage/assets/bencana/semeru_eruption.png',
                'status' => 'Aktif',
                'collected_raw' => 55000000,
                'target_raw' => 60000000,
                'days_left' => 5,
                'date_published' => '2026-06-20',
                'latitude'  => -10.1772,
                'longitude' => 123.6070,
                'description_short' => 'Membantu pengadaan paket makanan tambahan bergizi dan perawatan intensif bagi puluhan balita terdampak stunting dan gizi buruk di pelosok Kupang Timur.',
                'description_long' => 'Krisis pangan kronis akibat kegagalan panen musiman memicu tingginya angka kasus balita stunting dan gizi buruk (malnutrisi) di beberapa desa terpencil Kupang Timur, Nusa Tenggara Timur. Banyak balita memiliki berat badan jauh di bawah kurva normal dan rentan terserang infeksi penyakit sekunder karena imunitas tubuh yang sangat lemah. Bekerja sama dengan puskesmas lokal dan kader posyandu, donasi Anda akan langsung digunakan untuk membeli suplemen nutrisi khusus (F-75/F-100), susu formula medis, vitamin pertumbuhan, serta membiayai paket makanan tambahan (PMT) bergizi tinggi selama masa rehabilitasi medis 3 bulan ke depan.',
                'victims' => 3500,
                'needs' => [
                    ['icon' => 'fa-solid fa-prescription-bottle-medical', 'name' => 'Suplemen & Vitamin Medis', 'qty' => '300 Box'],
                    ['icon' => 'fa-solid fa-cookie-bite', 'name' => 'Biskuit PMT Khusus Balita', 'qty' => '500 Paket'],
                    ['icon' => 'fa-solid fa-cow', 'name' => 'Susu Formula Khusus', 'qty' => '200 Kaleng'],
                    ['icon' => 'fa-solid fa-hospital-user', 'name' => 'Rehabilitasi Medis Rawat Jalan', 'qty' => '50 Anak']
                ],
                'donors' => [
                    ['name' => 'Bunda Peduli', 'amount' => 1000000, 'created_at' => '2026-06-20 17:00:00', 'message' => 'Lekas sehat anak-anak masa depan Indonesia.'],
                    ['name' => 'Hamba Allah', 'amount' => 500000, 'created_at' => '2026-06-20 15:00:00', 'message' => 'Semoga target segera tercapai agar penanganan gizi anak-anak berjalan lancar.'],
                    ['name' => 'Rina Hermawan', 'amount' => 150000, 'created_at' => '2026-06-20 12:00:00', 'message' => 'Bantuan kecil untuk senyum anak-anak Kupang.']
                ]
            ]
        ];

        foreach ($campaigns as $data) {
            $campaign = Campaign::create([
                'slug' => $data['slug'],
                'title' => $data['title'],
                'location' => $data['location'],
                'category' => $data['category'],
                'image' => $data['image'],
                'status' => $data['status'],
                'collected_raw' => $data['collected_raw'],
                'target_raw' => $data['target_raw'],
                'days_left' => $data['days_left'],
                'date_published' => Carbon::parse($data['date_published']),
                'description_short' => $data['description_short'],
                'description_long' => $data['description_long'],
                'victims' => $data['victims'],
                'latitude' => $data['latitude'] ?? null, 
                'longitude' => $data['longitude'] ?? null,
            ]);

            foreach ($data['needs'] as $need) {
                CampaignNeed::create([
                    'campaign_id' => $campaign->id,
                    'name' => $need['name'],
                    'qty' => $need['qty'],
                ]);
            }

            foreach ($data['donors'] as $donor) {
                Donation::create([
                    'campaign_id' => $campaign->id,
                    'name' => $donor['name'],
                    'amount' => $donor['amount'],
                    'message' => $donor['message'],
                    'created_at' => Carbon::parse($donor['created_at']),
                    'updated_at' => Carbon::parse($donor['created_at']),
                ]);
            }
        }
    }
}
