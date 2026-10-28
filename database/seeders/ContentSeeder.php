<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use App\Models\City;
use App\Models\Faq;
use App\Models\PortfolioItem;
use App\Models\Post;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

/**
 * Isi awal website. Aman dijalankan ulang: data yang sudah ada
 * (berdasarkan key/slug) tidak akan ditimpa.
 */
class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->settings();
        $this->services();
        $this->cities();
        $this->caseStudies();
        $this->portfolio();
        $this->faqs();
        $this->posts();
    }

    protected function settings(): void
    {
        foreach (config('admin.settings') as $group) {
            foreach ($group['fields'] as $field) {
                Setting::firstOrCreate(['key' => $field['name']], ['value' => $field['default'] ?? '']);
            }
        }
    }

    protected function services(): void
    {
        $items = [
            [
                'slug' => 'simrs', 'group' => 'software', 'layer' => 'Pelayanan', 'icon' => 'pulse', 'badge' => 'Layanan utama',
                'name' => 'Implementasi SIMRS',
                'short' => 'Instalasi, migrasi data, penyesuaian modul, dan pelatihan staf hingga SIMRS benar-benar digunakan di setiap unit. Tersedia juga versi ringkas untuk klinik dan apotek.',
                'tags' => ['Pendaftaran', 'Rawat jalan', 'Rawat inap', 'IGD', 'Rekam medis elektronik', 'Farmasi', 'Laboratorium', 'Radiologi', 'Kasir', 'Dashboard'],
                'seo_title' => 'Implementasi SIMRS Rumah Sakit di Medan & Sumatera Utara',
                'seo_description' => 'Implementasi SIMRS untuk rumah sakit dan klinik: migrasi data, penyesuaian modul, bridging BPJS, integrasi SATUSEHAT, pelatihan, dan pendampingan.',
                'h1' => 'Implementasi SIMRS untuk rumah sakit dan klinik',
                'intro' => 'SIMRS yang baik menyatukan pendaftaran, rekam medis elektronik, penunjang, farmasi, keuangan, hingga klaim BPJS dalam satu alur kerja. Kami mendampingi rumah sakit sejak survei awal sampai sistem digunakan sehari-hari di setiap unit.',
                'points' => [
                    ['Satu data untuk semua unit', 'Data pasien cukup dicatat sekali di pendaftaran, lalu digunakan bersama oleh poliklinik, penunjang, farmasi, kasir, dan bagian klaim.'],
                    ['Rekam medis elektronik lengkap', 'Asesmen, CPPT, resep, tindakan, dan hasil penunjang tersimpan dalam satu riwayat pasien.'],
                    ['Terhubung ke layanan nasional', 'Bridging BPJS Kesehatan dan pengiriman data ke SATUSEHAT sudah menjadi bagian dari implementasi.'],
                    ['Disesuaikan dengan rumah sakit Anda', 'Modul, alur kerja, dan laporan diatur sesuai kebutuhan, bukan sebaliknya.'],
                ],
                'faqs' => [
                    ['Apakah data dari SIMRS lama bisa dipindahkan?', 'Bisa. Kami memetakan data master dan data pasien dari sistem lama, lalu memindahkannya setelah diuji bersama tim rumah sakit.'],
                    ['Apakah SIMRS bisa disesuaikan dengan kebutuhan rumah sakit?', 'Bisa. Modul, alur kerja, dan laporan disesuaikan dengan kebutuhan rumah sakit, lalu kami dampingi sampai staf terbiasa menggunakannya.'],
                    ['Bagaimana dengan klinik?', 'Untuk klinik dan apotek tersedia versi yang lebih ringkas, tetap terhubung ke SATUSEHAT.'],
                ],
            ],
            [
                'slug' => 'bridging-bpjs', 'group' => 'software', 'layer' => 'Integrasi', 'icon' => 'pulse',
                'name' => 'Bridging BPJS Kesehatan',
                'short' => 'Penerbitan SEP, klaim, dan antrean pasien JKN langsung dari SIMRS, tanpa input ulang.',
                'tags' => ['V-Claim', 'Antrean online', 'SEP'],
                'seo_title' => 'Bridging BPJS Kesehatan untuk Rumah Sakit di Medan',
                'seo_description' => 'Bridging BPJS Kesehatan untuk rumah sakit dan klinik di Medan: V-Claim, SEP, antrean online, dan dukungan klaim. Konsultasi gratis.',
                'h1' => 'Bridging BPJS Kesehatan untuk rumah sakit',
                'intro' => 'Tanpa bridging, petugas harus mengetik ulang data pasien JKN di aplikasi BPJS dan di SIMRS. Antrean menjadi lebih panjang dan risiko salah input meningkat. Kami menghubungkan SIMRS Anda dengan layanan BPJS Kesehatan sehingga data cukup dicatat sekali.',
                'points' => [
                    ['Penerbitan SEP dari SIMRS', 'Petugas pendaftaran menerbitkan SEP langsung dari SIMRS tanpa berpindah aplikasi.'],
                    ['Antrean online', 'Jadwal dan antrean poliklinik tersambung, sehingga pasien JKN dapat mendaftar melalui Mobile JKN.'],
                    ['Klaim lebih rapi', 'Data pelayanan dan dokumen pendukung tersusun dari SIMRS, sehingga berkas klaim lebih lengkap.'],
                    ['Pendampingan uji coba', 'Kami mendampingi pengujian sampai bridging berjalan di lingkungan produksi.'],
                ],
                'faqs' => [
                    ['Berapa lama proses bridging BPJS Kesehatan?', 'Tergantung kondisi SIMRS dan kelengkapan kredensial dari BPJS. Kami memberikan estimasi waktu yang jelas setelah survei awal.'],
                    ['Apakah SIMRS lama kami bisa di-bridging?', 'Bisa, selama SIMRS tersebut dapat dikembangkan atau menyediakan akses integrasi. Kami menilainya saat survei.'],
                    ['Apa yang perlu disiapkan rumah sakit?', 'Umumnya kredensial dari BPJS Kesehatan, akses ke server SIMRS, dan petugas yang dapat menguji alur pendaftaran hingga klaim.'],
                ],
            ],
            [
                'slug' => 'integrasi-satusehat', 'group' => 'software', 'layer' => 'Integrasi', 'icon' => 'plus',
                'name' => 'Integrasi SATUSEHAT',
                'short' => 'Data rekam medis elektronik terkirim ke SATUSEHAT Kemenkes, untuk rumah sakit maupun klinik.',
                'tags' => ['Rekam medis elektronik', 'Kemenkes', 'Rumah sakit dan klinik'],
                'seo_title' => 'Integrasi SATUSEHAT Rumah Sakit & Klinik di Medan',
                'seo_description' => 'Integrasi SATUSEHAT Kemenkes dan rekam medis elektronik untuk rumah sakit dan klinik di Medan dan Sumatera Utara.',
                'h1' => 'Integrasi SATUSEHAT untuk rumah sakit dan klinik',
                'intro' => 'Fasilitas pelayanan kesehatan wajib menyelenggarakan rekam medis elektronik dan terhubung ke SATUSEHAT milik Kementerian Kesehatan. Kami membantu menyiapkan kredensial, memetakan data dari SIMRS, dan memastikan data kunjungan terkirim dengan benar.',
                'points' => [
                    ['Persiapan kredensial', 'Pendampingan pendaftaran organisasi dan pengaturan akses ke lingkungan uji dan produksi SATUSEHAT.'],
                    ['Pemetaan data', 'Data kunjungan, diagnosis, tindakan, dan pemeriksaan dari SIMRS dipetakan ke format yang diminta SATUSEHAT.'],
                    ['Uji kirim dan pemantauan', 'Data diuji di sandbox sebelum dikirim rutin, lalu dipantau agar kegagalan kirim cepat ditangani.'],
                    ['Untuk rumah sakit dan klinik', 'Integrasi dapat dilakukan untuk rumah sakit maupun klinik dan apotek.'],
                ],
                'faqs' => [
                    ['Apakah klinik juga bisa terintegrasi ke SATUSEHAT?', 'Bisa. Kami membantu rumah sakit dan klinik mengirim data rekam medis elektronik ke SATUSEHAT, mulai dari pendaftaran kredensial sampai pengujian pengiriman data.'],
                    ['Bagaimana jika pengiriman data gagal?', 'Kami memeriksa pesan kesalahan dari SATUSEHAT, memperbaiki pemetaan atau data master, lalu mengirim ulang data yang gagal.'],
                ],
            ],
            [
                'slug' => 'aplikasi-rumah-sakit', 'group' => 'software', 'layer' => 'Aplikasi', 'icon' => 'monitor',
                'name' => 'Aplikasi pendukung',
                'short' => 'Dashboard manajemen, pendaftaran online, dan pelaporan yang dibuat sesuai kebutuhan rumah sakit.',
                'tags' => ['Web', 'Mobile', 'Dashboard'],
                'seo_title' => 'Pembuatan Aplikasi Rumah Sakit Sesuai Kebutuhan',
                'seo_description' => 'Pengembangan aplikasi rumah sakit sesuai kebutuhan: dashboard manajemen, pendaftaran online, pelaporan, dan integrasi dengan SIMRS.',
                'h1' => 'Aplikasi pendukung yang dibuat sesuai alur kerja Anda',
                'intro' => 'Setiap rumah sakit memiliki kebutuhan yang tidak selalu tersedia di SIMRS standar. Kami membangun aplikasi tambahan yang terhubung ke SIMRS, sehingga data tetap berasal dari satu sumber dan petugas tidak perlu mencatat ulang.',
                'points' => [
                    ['Dashboard manajemen', 'Ringkasan kunjungan, pendapatan, dan indikator mutu yang mudah dibaca direksi.'],
                    ['Pendaftaran dan informasi pasien', 'Aplikasi web atau mobile untuk pendaftaran, jadwal dokter, dan informasi layanan.'],
                    ['Pelaporan internal', 'Laporan unit yang selama ini disusun manual dapat dibuat otomatis.'],
                    ['Integrasi antarsistem', 'Menghubungkan SIMRS dengan sistem lain seperti laboratorium, radiologi, HR, atau akuntansi.'],
                ],
                'faqs' => [
                    ['Apakah aplikasi bisa terhubung dengan SIMRS yang sudah ada?', 'Bisa, selama SIMRS menyediakan akses integrasi. Kami memeriksanya saat survei.'],
                ],
            ],
            [
                'slug' => 'hardware-jaringan', 'group' => 'infra', 'layer' => 'Infrastruktur', 'icon' => 'server',
                'name' => 'Hardware dan jaringan',
                'short' => 'Server, komputer, printer, LAN, dan Wi-Fi rumah sakit melalui principal resmi.',
                'tags' => ['Server', 'Jaringan', 'Perangkat'],
                'seo_title' => 'Pengadaan Hardware & Jaringan Rumah Sakit di Medan',
                'seo_description' => 'Pengadaan dan instalasi server, komputer, printer, jaringan LAN, dan Wi-Fi untuk rumah sakit dan klinik di Medan dan Sumatera Utara.',
                'h1' => 'Hardware dan jaringan rumah sakit',
                'intro' => 'SIMRS hanya secepat perangkat dan jaringan yang menjalankannya. Kami menghitung kebutuhan perangkat berdasarkan jumlah unit dan pengguna, lalu menyediakan dan memasangnya melalui principal resmi.',
                'points' => [
                    ['Server dan penyimpanan', 'Spesifikasi server disesuaikan dengan beban SIMRS dan rencana pertumbuhan data.'],
                    ['Perangkat unit', 'Komputer, printer label, printer gelang pasien, dan perangkat pendukung pelayanan.'],
                    ['Jaringan', 'Instalasi LAN dan Wi-Fi yang stabil antargedung dan antarlantai.'],
                    ['Garansi resmi', 'Perangkat diadakan melalui principal dan distributor resmi.'],
                ],
                'faqs' => [
                    ['Apakah perangkat yang sudah ada masih bisa dipakai?', 'Bisa. Kami memeriksa perangkat lama terlebih dahulu dan hanya menyarankan penggantian yang benar-benar diperlukan.'],
                ],
            ],
            [
                'slug' => 'keamanan-data', 'group' => 'infra', 'layer' => 'Keamanan', 'icon' => 'shield',
                'name' => 'Keamanan data dan backup',
                'short' => 'Antivirus, backup terjadwal, dan pengaturan akses untuk melindungi data pasien.',
                'tags' => ['Antivirus', 'Backup', 'Hak akses'],
                'seo_title' => 'Keamanan Data, Antivirus & Backup SIMRS Rumah Sakit',
                'seo_description' => 'Pemasangan antivirus, backup data, dan pengamanan sistem untuk melindungi data pasien rumah sakit dan klinik.',
                'h1' => 'Keamanan data dan backup untuk rumah sakit',
                'intro' => 'Data pasien termasuk data sensitif. Serangan ransomware atau kerusakan server dapat menghentikan pelayanan. Kami memasang perlindungan berlapis dan memastikan data selalu dapat dipulihkan.',
                'points' => [
                    ['Antivirus terpusat', 'Antivirus untuk seluruh komputer dan server, dipantau dari satu konsol.'],
                    ['Backup terjadwal', 'Backup otomatis database SIMRS dengan salinan di lokasi terpisah.'],
                    ['Pengaturan akses', 'Hak akses pengguna diatur sesuai peran, sehingga data hanya dibuka oleh pihak yang berwenang.'],
                    ['Uji pemulihan', 'Backup diuji secara berkala untuk memastikan data benar-benar dapat dipulihkan.'],
                ],
                'faqs' => [
                    ['Seberapa sering backup sebaiknya dilakukan?', 'Untuk database SIMRS, backup harian adalah batas minimum. Jadwal tepatnya disesuaikan dengan volume transaksi rumah sakit.'],
                ],
            ],
            [
                'slug' => 'maintenance-sla', 'group' => 'infra', 'layer' => 'Pendampingan', 'icon' => 'clock',
                'name' => 'Maintenance dan SLA',
                'short' => 'Helpdesk, pemantauan sistem, pembaruan rutin, dan kunjungan ke lokasi dengan waktu respons yang jelas.',
                'tags' => ['Helpdesk', 'Monitoring', 'Kunjungan lokasi'],
                'seo_title' => 'Maintenance IT Rumah Sakit dengan Kontrak SLA',
                'seo_description' => 'Kontrak maintenance IT rumah sakit dengan SLA yang jelas: helpdesk, pemantauan, pembaruan, dan kunjungan ke lokasi di Medan dan Sumatera Utara.',
                'h1' => 'Maintenance IT rumah sakit dengan SLA yang jelas',
                'intro' => 'Rumah sakit beroperasi 24 jam, sehingga gangguan sistem harus segera ditangani. Dengan kontrak maintenance, Anda tahu siapa yang dihubungi, berapa lama waktu responsnya, dan apa saja yang dikerjakan setiap bulan.',
                'points' => [
                    ['Helpdesk', 'Saluran bantuan melalui WhatsApp, telepon, dan tiket untuk staf rumah sakit.'],
                    ['Pemantauan', 'Pemantauan server, backup, serta integrasi BPJS dan SATUSEHAT.'],
                    ['Pembaruan rutin', 'Pembaruan dan perbaikan dijadwalkan agar tidak mengganggu pelayanan.'],
                    ['Kunjungan berkala', 'Kunjungan ke lokasi sesuai kontrak untuk memeriksa perangkat dan jaringan.'],
                ],
                'faqs' => [
                    ['Apakah tersedia kontrak maintenance?', 'Tersedia. Kontrak mencakup pemantauan sistem, perbaikan, pembaruan, dan waktu respons yang disepakati dalam SLA.'],
                ],
            ],
            [
                'slug' => 'solusi-mekari', 'group' => 'business', 'layer' => 'Bisnis', 'icon' => 'building', 'badge' => 'Partner resmi',
                'name' => 'Solusi Mekari',
                'short' => 'HR dan payroll, akuntansi, serta komunikasi pasien yang terhubung dengan operasional rumah sakit.',
                'tags' => ['HR dan payroll', 'Akuntansi', 'Komunikasi pelanggan'],
                'seo_title' => 'Partner Resmi Mekari untuk Rumah Sakit & Klinik',
                'seo_description' => 'Implementasi Mekari untuk HR, payroll, akuntansi, dan komunikasi pasien di rumah sakit dan klinik. Partner resmi Mekari.',
                'h1' => 'Solusi Mekari untuk administrasi rumah sakit',
                'intro' => 'Administrasi SDM, penggajian, dan keuangan rumah sakit masih sering dikerjakan secara manual. Sebagai partner resmi Mekari, kami membantu memilih, menerapkan, dan menghubungkan produk Mekari dengan operasional rumah sakit.',
                'points' => [
                    ['HR dan payroll', 'Absensi, cuti, jadwal shift, dan penggajian karyawan dalam satu sistem.'],
                    ['Akuntansi', 'Pencatatan keuangan dan laporan yang lebih cepat disusun.'],
                    ['Komunikasi pasien', 'Pengelolaan pesan dan layanan pelanggan dari berbagai kanal.'],
                    ['Pendampingan implementasi', 'Pengaturan awal, migrasi data, dan pelatihan pengguna.'],
                ],
                'faqs' => [
                    ['Apakah Mekari bisa digunakan bersama SIMRS?', 'Bisa. Mekari menangani administrasi bisnis, sedangkan SIMRS menangani pelayanan. Keduanya dapat dihubungkan sesuai kebutuhan.'],
                ],
            ],
        ];

        foreach ($items as $i => $item) {
            Service::firstOrCreate(['slug' => $item['slug']], $item + ['sort' => $i + 1, 'is_active' => true]);
        }
    }

    protected function cities(): void
    {
        $items = [
            [
                'slug' => 'medan', 'name' => 'Medan', 'has_page' => true, 'is_main' => true,
                'seo_title' => 'SIMRS & Solusi IT Rumah Sakit di Medan',
                'seo_description' => 'Implementasi SIMRS, bridging BPJS, integrasi SATUSEHAT, hardware, jaringan, dan maintenance untuk rumah sakit dan klinik di Medan.',
                'h1' => 'SIMRS dan solusi IT untuk rumah sakit di Medan',
                'intro' => 'Medan adalah pusat rujukan kesehatan di Sumatera Utara, dengan banyak rumah sakit swasta, rumah sakit pemerintah, dan klinik. Kebutuhannya serupa: SIMRS yang stabil, terhubung ke BPJS dan SATUSEHAT, serta tim yang sigap ketika ada kendala.',
                'body' => "Kami mendampingi rumah sakit di Medan mulai dari survei, implementasi SIMRS, bridging BPJS, dan integrasi SATUSEHAT, hingga kontrak pemeliharaan. Tim datang langsung untuk survei, instalasi, dan pelatihan, lalu dukungan harian dilakukan dari jarak jauh dengan kunjungan berkala.\n\nUntuk klinik pratama dan klinik utama di Medan, tersedia versi SIMRS yang lebih ringkas namun tetap terhubung ke SATUSEHAT.",
                'nearby' => ['deli-serdang', 'binjai'],
            ],
            [
                'slug' => 'deli-serdang', 'name' => 'Deli Serdang', 'has_page' => true,
                'seo_title' => 'SIMRS & Solusi IT Rumah Sakit di Deli Serdang',
                'seo_description' => 'Implementasi SIMRS, bridging BPJS, dan integrasi SATUSEHAT untuk rumah sakit dan klinik di Deli Serdang, Lubuk Pakam, dan sekitarnya.',
                'h1' => 'Solusi IT untuk rumah sakit di Deli Serdang',
                'intro' => 'Deli Serdang mengelilingi Kota Medan dan terus berkembang, dari Lubuk Pakam hingga kawasan sekitar Bandara Kualanamu. Banyak rumah sakit dan klinik baru di wilayah ini membutuhkan sistem yang siap sejak hari pertama beroperasi.',
                'body' => "Untuk fasilitas kesehatan yang baru dibangun, kami dapat menyiapkan semuanya sekaligus: jaringan, perangkat, SIMRS, serta bridging BPJS dan SATUSEHAT, sehingga rumah sakit siap melayani pasien JKN sejak awal.\n\nUntuk rumah sakit yang sudah beroperasi, kami memulai dengan audit sistem yang ada sebelum menyarankan perubahan.",
                'nearby' => ['medan', 'binjai'],
            ],
            [
                'slug' => 'binjai', 'name' => 'Binjai', 'has_page' => true,
                'seo_title' => 'SIMRS & Solusi IT Rumah Sakit di Binjai dan Langkat',
                'seo_description' => 'SIMRS, bridging BPJS, integrasi SATUSEHAT, dan maintenance IT untuk rumah sakit dan klinik di Binjai dan Langkat.',
                'h1' => 'Solusi IT untuk rumah sakit di Binjai dan Langkat',
                'intro' => 'Binjai berbatasan langsung dengan Medan dan menjadi pintu masuk ke Kabupaten Langkat. Rumah sakit dan klinik di wilayah ini melayani banyak pasien JKN, sehingga bridging BPJS yang lancar sangat menentukan kecepatan pelayanan.',
                'body' => 'Kami membantu rumah sakit dan klinik di Binjai dan Langkat menata SIMRS, menghubungkannya ke BPJS dan SATUSEHAT, serta menyediakan dukungan rutin agar setiap gangguan cepat ditangani.',
                'nearby' => ['medan', 'deli-serdang'],
            ],
            [
                'slug' => 'pematangsiantar', 'name' => 'Pematangsiantar', 'has_page' => true,
                'seo_title' => 'SIMRS & Solusi IT Rumah Sakit di Pematangsiantar',
                'seo_description' => 'Implementasi SIMRS, bridging BPJS, integrasi SATUSEHAT, dan maintenance IT untuk rumah sakit dan klinik di Pematangsiantar dan Simalungun.',
                'h1' => 'Solusi IT untuk rumah sakit di Pematangsiantar dan Simalungun',
                'intro' => 'Pematangsiantar merupakan salah satu kota utama di jalur tengah Sumatera Utara dan menjadi rujukan bagi wilayah Simalungun. Karena jaraknya dari Medan, dukungan jarak jauh yang andal menjadi sangat penting.',
                'body' => 'Kami merancang sistem dengan pemantauan jarak jauh dan prosedur penanganan yang jelas, sehingga sebagian besar kendala dapat diselesaikan tanpa menunggu teknisi tiba. Kunjungan ke lokasi tetap dijadwalkan untuk implementasi, pelatihan, dan pemeriksaan berkala.',
                'nearby' => ['medan', 'deli-serdang'],
            ],
        ];
        $others = ['Langkat', 'Serdang Bedagai', 'Tebing Tinggi', 'Simalungun', 'Karo', 'Asahan', 'Labuhanbatu', 'Padangsidimpuan', 'Sibolga'];

        $sort = 1;
        foreach ($items as $item) {
            City::firstOrCreate(['slug' => $item['slug']], $item + ['sort' => $sort++]);
        }
        foreach ($others as $name) {
            City::firstOrCreate(['slug' => \Illuminate\Support\Str::slug($name)], ['name' => $name, 'has_page' => false, 'sort' => $sort++]);
        }
    }

    protected function caseStudies(): void
    {
        CaseStudy::firstOrCreate(['slug' => 'rsu-serenapita'], [
            'client' => 'RSU Serenapita',
            'title' => 'RSU Serenapita: SIMRS terhubung ke BPJS dan SATUSEHAT',
            'seo_title' => 'Studi Kasus RSU Serenapita: SIMRS, BPJS & SATUSEHAT',
            'seo_description' => 'Bagaimana Enigma Works Indonesia mendampingi RSU Serenapita menerapkan SIMRS dengan bridging BPJS Kesehatan dan integrasi SATUSEHAT.',
            'summary' => 'RSU Serenapita membutuhkan SIMRS yang terhubung ke BPJS Kesehatan dan SATUSEHAT tanpa menghentikan pelayanan pasien. Kami mendampingi implementasi, menyiapkan bridging, dan membangun aplikasi pendukung sesuai kebutuhan setiap unit.',
            'checks' => ['Bridging BPJS aktif untuk pasien JKN', 'Data kunjungan terkirim ke SATUSEHAT', 'Aplikasi pendukung dibuat sesuai kebutuhan unit'],
            'facts' => [['Klien', 'Rumah Sakit Umum Serenapita'], ['Lingkup', 'Implementasi SIMRS, bridging BPJS, integrasi SATUSEHAT, aplikasi pendukung'], ['Status', 'Bridging BPJS dan SATUSEHAT aktif'], ['Lokasi', '[Isi kota]']],
            'sections' => [
                ['Tantangan', '[Ceritakan kondisi sebelum proyek: sistem lama, kendala pelayanan, dan kebutuhan regulasi.]'],
                ['Solusi', 'Implementasi SIMRS di unit pelayanan, bridging dengan BPJS Kesehatan, integrasi ke SATUSEHAT, serta aplikasi pendukung yang dibuat khusus sesuai kebutuhan rumah sakit.'],
                ['Proses', '[Ceritakan tahapan: survei, persiapan data, pelatihan, go-live, dan pendampingan.]'],
                ['Hasil', '[Tuliskan hasil yang dapat diukur, misalnya waktu pendaftaran pasien JKN atau kelengkapan berkas klaim.]'],
            ],
            'service_slugs' => ['simrs', 'bridging-bpjs', 'integrasi-satusehat', 'aplikasi-rumah-sakit'],
            'quote' => 'Tim Enigma Works Indonesia mendampingi kami dari persiapan hingga sistem terhubung ke BPJS dan SATUSEHAT. Setiap kendala di lapangan ditangani dengan cepat, sehingga pelayanan pasien tetap berjalan selama masa transisi.',
            'quote_by' => '[Nama]',
            'quote_role' => '[Jabatan], RSU Serenapita',
            'quote_approved' => false,
            'sort' => 1,
            'is_active' => true,
        ]);
    }

    protected function portfolio(): void
    {
        $items = [
            ['name' => 'RSU Serenapita', 'label' => 'Proyek Enigma Works Indonesia', 'is_own' => true, 'text' => 'Implementasi SIMRS dengan bridging BPJS, integrasi SATUSEHAT, dan aplikasi pendukung.', 'link' => '/studi-kasus/rsu-serenapita'],
            ['name' => 'RS Prima Pekanbaru', 'label' => 'Pengguna DHealth, Pekanbaru', 'text' => 'Pelayanan terintegrasi dengan BPJS Kesehatan dan SATUSEHAT, sehingga alur layanan pasien lebih ringkas.'],
            ['name' => 'RSUD Labuang Baji', 'label' => 'Pengguna DHealth, Makassar', 'text' => 'Menjalankan rekam medis elektronik dengan DHealth sejak go-live pada 2023.'],
            ['name' => 'Mayapada Hospital', 'label' => 'Pengguna DHealth, beberapa kota', 'text' => 'Digunakan di jaringan Mayapada Bandung, Kuningan, Surabaya, dan Bogor.'],
            ['name' => 'RSUD Sinjai', 'label' => 'Pengguna DHealth, Sulawesi Selatan', 'text' => 'Rumah sakit umum daerah pengguna SIMRS DHealth.'],
        ];
        foreach ($items as $i => $item) {
            PortfolioItem::firstOrCreate(['name' => $item['name']], $item + ['sort' => $i + 1, 'is_active' => true]);
        }
    }

    protected function faqs(): void
    {
        $items = [
            ['Apakah Enigma Works Indonesia melayani rumah sakit di Medan?', 'Ya. Tim kami datang ke lokasi untuk survei, instalasi, dan pelatihan, lalu memberikan dukungan harian dari jarak jauh untuk rumah sakit dan klinik di Medan dan seluruh Sumatera Utara.'],
            ['Apakah SIMRS bisa disesuaikan dengan kebutuhan rumah sakit?', 'Bisa. Modul, alur kerja, dan laporan disesuaikan dengan kebutuhan rumah sakit, lalu kami dampingi mulai dari migrasi data, bridging BPJS, dan integrasi SATUSEHAT, hingga pelatihan dan dukungan setelah go-live.'],
            ['Berapa lama proses bridging BPJS Kesehatan?', 'Tergantung kondisi SIMRS dan kelengkapan kredensial dari BPJS. Kami memberikan estimasi waktu yang jelas setelah survei awal.'],
            ['Apakah klinik juga bisa terintegrasi ke SATUSEHAT?', 'Bisa. Kami membantu rumah sakit dan klinik mengirim data rekam medis elektronik ke SATUSEHAT, mulai dari pendaftaran kredensial sampai pengujian pengiriman data.'],
            ['Apakah tersedia kontrak maintenance?', 'Tersedia. Kontrak mencakup pemantauan sistem, perbaikan, pembaruan, dan waktu respons yang disepakati dalam SLA.'],
        ];
        foreach ($items as $i => [$q, $a]) {
            Faq::firstOrCreate(['question' => $q], ['answer' => $a, 'sort' => $i + 1, 'is_active' => true]);
        }
    }

    protected function posts(): void
    {
        foreach (File::files(database_path('seeders/content')) as $file) {
            if ($file->getExtension() !== 'md') {
                continue;
            }
            $raw = File::get($file->getPathname());
            $meta = [];
            $body = $raw;
            if (preg_match('/^---\R(.*?)\R---\R(.*)$/s', $raw, $m)) {
                foreach (preg_split('/\R/', $m[1]) as $line) {
                    if (str_contains($line, ':')) {
                        [$key, $value] = array_map('trim', explode(':', $line, 2));
                        $meta[$key] = $value;
                    }
                }
                $body = trim($m[2]);
            }

            Post::firstOrCreate(['slug' => $file->getFilenameWithoutExtension()], [
                'title' => $meta['title'] ?? 'Tanpa judul',
                'description' => $meta['description'] ?? null,
                'category' => $meta['category'] ?? 'simrs',
                'author' => 'Tim Enigma Works Indonesia',
                'body' => $body,
                'is_published' => true,
                'published_at' => Carbon::parse($meta['date'] ?? now()),
            ]);
        }
    }
}
