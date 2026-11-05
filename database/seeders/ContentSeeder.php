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
use Illuminate\Support\Str;

/**
 * Isi awal website. Aman dijalankan ulang: data yang sudah ada
 * (berdasarkan key/slug) tidak akan ditimpa.
 *
 * Data konten disediakan lewat method statis agar bisa dipakai ulang oleh RebrandSeeder.
 */
class ContentSeeder extends Seeder
{
    public function run(): void
    {
        foreach (static::settingDefaults() as $key => $value) {
            Setting::firstOrCreate(['key' => $key], ['value' => $value]);
        }

        foreach (static::serviceItems() as $i => $item) {
            Service::firstOrCreate(['slug' => $item['slug']], $item + ['sort' => $i + 1, 'is_active' => true]);
        }

        $sort = 1;
        foreach (static::cityItems() as $item) {
            City::firstOrCreate(['slug' => $item['slug']], $item + ['sort' => $sort++]);
        }
        foreach (static::otherCities() as $name) {
            City::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'has_page' => false, 'sort' => $sort++]);
        }

        $case = static::caseStudyItem();
        CaseStudy::firstOrCreate(['slug' => $case['slug']], $case);

        foreach (static::portfolioItems() as $i => $item) {
            PortfolioItem::firstOrCreate(['name' => $item['name']], $item + ['sort' => $i + 1]);
        }

        foreach (static::faqItems() as $i => [$question, $answer]) {
            Faq::firstOrCreate(['question' => $question], ['answer' => $answer, 'sort' => $i + 1, 'is_active' => true]);
        }

        static::seedPosts();
    }

    /**
     * Nilai default semua pengaturan dari config/admin.php.
     *
     * @return array<string, string>
     */
    public static function settingDefaults(): array
    {
        $defaults = [];
        foreach (config('admin.settings') as $group) {
            foreach ($group['fields'] as $field) {
                $defaults[$field['name']] = $field['default'] ?? '';
            }
        }

        return $defaults;
    }

    /**
     * Artikel dari database/seeders/content/*.md. Artikel yang sudah ada tidak diubah.
     *
     * @return int Jumlah artikel baru
     */
    public static function seedPosts(): int
    {
        $created = 0;

        foreach (static::postFiles() as $slug => $attributes) {
            $post = Post::firstOrCreate(['slug' => $slug], $attributes + [
                'author' => 'Tim Enigma Works Indonesia',
                'is_published' => true,
            ]);
            $created += $post->wasRecentlyCreated ? 1 : 0;
        }

        return $created;
    }

    /**
     * Isi artikel dari file Markdown, dikunci dengan slug (nama file).
     *
     * @return array<string, array{title: string, description: ?string, category: string, body: string, published_at: Carbon}>
     */
    public static function postFiles(): array
    {
        $posts = [];

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

            $posts[$file->getFilenameWithoutExtension()] = [
                'title' => $meta['title'] ?? 'Tanpa judul',
                'description' => $meta['description'] ?? null,
                'category' => $meta['category'] ?? 'simrs',
                'body' => $body,
                'published_at' => Carbon::parse($meta['date'] ?? now()),
            ];
        }

        return $posts;
    }

    /** @return list<array<string, mixed>> */
    public static function serviceItems(): array
    {
        return [
            [
                'slug' => 'simrs', 'group' => 'software', 'layer' => 'SIMRS', 'icon' => 'pulse', 'badge' => 'Produk utama',
                'name' => 'SIMRS Enigma Health',
                'short' => 'Satu SIMRS untuk pendaftaran, rekam medis elektronik, penunjang, farmasi, kasir, hingga klaim BPJS. Tersedia juga versi ringkas untuk klinik dan apotek.',
                'tags' => ['Pendaftaran', 'Rawat jalan', 'Rawat inap', 'IGD', 'Rekam medis elektronik', 'Penunjang', 'Farmasi', 'Kasir', 'Klaim', 'Dashboard manajemen'],
                'seo_title' => 'SIMRS Enigma Health: Aplikasi SIMRS dan RME Rumah Sakit',
                'seo_description' => 'SIMRS Enigma Health untuk rumah sakit dan klinik: rekam medis elektronik, farmasi, kasir, klaim BPJS, dan SATUSEHAT dalam satu sistem. Konsultasi gratis.',
                'h1' => 'SIMRS Enigma Health untuk rumah sakit dan klinik',
                'intro' => 'Enigma Health adalah SIMRS yang menyatukan seluruh alur pelayanan rumah sakit, dari pasien mendaftar sampai berkas klaim siap dikirim. Data pasien cukup dicatat sekali di pendaftaran, lalu dipakai bersama oleh poliklinik, rawat inap, IGD, laboratorium, radiologi, farmasi, kasir, dan bagian klaim. Enigma Health disediakan oleh PT Enigma Works Indonesia dan diimplementasikan langsung oleh tim kami, termasuk bridging BPJS Kesehatan dan integrasi SATUSEHAT.',
                'points' => [
                    ['Pendaftaran dan antrean', 'Pendaftaran pasien umum, asuransi, dan JKN dalam satu layar. SEP diterbitkan langsung dari SIMRS, dan antrean poliklinik tersambung ke Mobile JKN.'],
                    ['Rawat jalan, rawat inap, dan IGD', 'Asesmen, CPPT, order penunjang, resep, dan tindakan dicatat di unit masing-masing. Pindah ruang, pulang, dan rujukan tercatat rapi dalam riwayat pasien.'],
                    ['Rekam medis elektronik (RME)', 'Satu riwayat pasien yang lengkap dan mudah dicari dokter maupun perawat. Data kunjungan dikirim ke SATUSEHAT sesuai ketentuan Kementerian Kesehatan.'],
                    ['Penunjang, farmasi, dan logistik', 'Order laboratorium dan radiologi masuk tanpa kertas, hasil kembali ke RME. Resep elektronik terhubung dengan stok obat dan bahan medis habis pakai.'],
                    ['Kasir, klaim, dan dashboard manajemen', 'Tagihan terbentuk otomatis dari layanan yang diberikan. Direksi melihat kunjungan, pendapatan, dan status klaim dari dashboard tanpa menunggu laporan manual.'],
                    ['Untuk siapa', 'Rumah sakit umum dan khusus, klinik pratama dan utama, serta apotek. Modul dan alur kerja diatur sesuai skala dan kebutuhan setiap fasilitas.'],
                    ['Cara implementasi', 'Survei alur kerja, konfigurasi modul, migrasi data, pelatihan per unit, go-live bertahap, lalu pendampingan dan pemeliharaan dengan SLA yang disepakati.'],
                ],
                'faqs' => [
                    ['Apakah data dari SIMRS lama bisa dipindahkan ke Enigma Health?', 'Bisa. Kami memetakan data master dan data pasien dari sistem lama, menguji hasil migrasi bersama tim rumah sakit, lalu memindahkannya sebelum go-live agar riwayat pasien tetap tersedia.'],
                    ['Berapa lama implementasi SIMRS Enigma Health?', 'Tergantung jumlah unit, kondisi data lama, dan kesiapan perangkat. Setelah survei, kami menyusun jadwal tertulis per tahap sehingga rumah sakit tahu kapan setiap unit mulai memakai sistem.'],
                    ['Apakah Enigma Health sudah terhubung ke BPJS Kesehatan dan SATUSEHAT?', 'Ya. Bridging BPJS Kesehatan dan integrasi SATUSEHAT menjadi bagian dari implementasi, termasuk pendampingan uji coba sampai berjalan di lingkungan produksi.'],
                    ['Bagaimana dengan klinik dan apotek?', 'Tersedia versi Enigma Health yang lebih ringkas untuk klinik dan apotek, tetap dengan rekam medis elektronik dan pengiriman data ke SATUSEHAT.'],
                    ['Siapa yang menangani kendala setelah go-live?', 'Tim Enigma Works Indonesia. Helpdesk, pemantauan, dan pembaruan sistem diatur dalam kontrak pemeliharaan dengan waktu respons yang jelas.'],
                ],
            ],
            [
                'slug' => 'bridging-bpjs', 'group' => 'software', 'layer' => 'Integrasi', 'icon' => 'pulse',
                'name' => 'Bridging BPJS Kesehatan',
                'short' => 'Penerbitan SEP, antrean online, dan data klaim pasien JKN langsung dari SIMRS, tanpa mengetik ulang di aplikasi BPJS.',
                'tags' => ['V-Claim', 'SEP', 'Antrean online', 'Mobile JKN'],
                'seo_title' => 'Bridging BPJS Kesehatan: SEP, V-Claim, dan Antrean Online',
                'seo_description' => 'Bridging BPJS Kesehatan untuk rumah sakit dan klinik: SEP dari SIMRS, V-Claim, dan antrean online Mobile JKN. Melayani Medan dan Sumatera Utara.',
                'h1' => 'Bridging BPJS Kesehatan untuk rumah sakit',
                'intro' => 'Tanpa bridging, petugas pendaftaran mengetik data pasien JKN dua kali: di aplikasi BPJS dan di SIMRS. Antrean memanjang, risiko salah input meningkat, dan berkas klaim sering tidak lengkap. Kami menghubungkan SIMRS dengan layanan BPJS Kesehatan sehingga data cukup dicatat sekali. Bridging sudah menjadi bagian dari setiap implementasi Enigma Health, dan juga bisa dikerjakan untuk SIMRS lain selama sistemnya dapat dikembangkan.',
                'points' => [
                    ['SEP langsung dari SIMRS', 'Petugas memeriksa kepesertaan, rujukan, dan menerbitkan SEP tanpa berpindah aplikasi. Nomor SEP tersimpan otomatis di data kunjungan pasien.'],
                    ['Antrean online Mobile JKN', 'Jadwal dokter dan kuota poliklinik tersambung, sehingga pasien JKN dapat mengambil antrean dari Mobile JKN dan statusnya diperbarui dari SIMRS.'],
                    ['Data klaim lebih rapi', 'Diagnosis, tindakan, dan dokumen pendukung tersusun dari data pelayanan di SIMRS, sehingga petugas klaim tidak lagi mengumpulkan berkas secara manual.'],
                    ['Pemetaan data master', 'Kode poliklinik, dokter, dan ruang perawatan di SIMRS dipetakan ke referensi BPJS. Langkah ini mencegah sebagian besar kegagalan saat bridging berjalan.'],
                    ['Uji coba dan pemantauan', 'Alur diuji bersama petugas sebelum go-live, lalu koneksi dipantau agar gangguan cepat terdeteksi dan ditangani.'],
                    ['Tanpa harus mengganti SIMRS', 'Bila rumah sakit belum siap berganti sistem, bridging dapat dikerjakan pada SIMRS yang sudah berjalan selama sistem itu bisa dikembangkan. Bila sudah saatnya berganti, bridging langsung tersedia di Enigma Health.'],
                ],
                'faqs' => [
                    ['Berapa lama proses bridging BPJS Kesehatan?', 'Tergantung kondisi SIMRS dan kelengkapan kredensial dari BPJS Kesehatan. Kami memberikan estimasi waktu tertulis setelah survei awal.'],
                    ['Apakah SIMRS lama kami bisa di-bridging?', 'Bisa, selama SIMRS tersebut dapat dikembangkan atau menyediakan akses integrasi. Kami menilainya saat survei sebelum memberikan penawaran.'],
                    ['Apa yang perlu disiapkan rumah sakit?', 'Umumnya kredensial dari BPJS Kesehatan, akses ke server SIMRS, data master poliklinik dan dokter yang rapi, serta petugas yang dapat menguji alur pendaftaran hingga klaim.'],
                    ['Bagaimana jika layanan BPJS sedang gangguan?', 'Pelayanan tetap berjalan. Kami menyiapkan prosedur cadangan bersama rumah sakit, lalu data yang tertunda dikirim ulang setelah layanan kembali normal.'],
                    ['Apakah petugas perlu pelatihan ulang?', 'Ya, tetapi singkat. Kami melatih petugas pendaftaran, poliklinik, dan klaim sesuai alur baru, termasuk kasus khusus seperti rujukan balik, pasien kontrol, dan perubahan kelas rawat.'],
                    ['Bagaimana memantau bridging setelah berjalan?', 'Kami memantau koneksi dan respons layanan BPJS Kesehatan. Bila ada kegagalan berulang, misalnya karena perubahan referensi dari BPJS, pemetaan disesuaikan dan rumah sakit diberi tahu.'],
                ],
            ],
            [
                'slug' => 'integrasi-satusehat', 'group' => 'software', 'layer' => 'Integrasi', 'icon' => 'plus',
                'name' => 'Integrasi SATUSEHAT',
                'short' => 'Data rekam medis elektronik terkirim ke SATUSEHAT Kementerian Kesehatan, untuk rumah sakit maupun klinik.',
                'tags' => ['Rekam medis elektronik', 'Kemenkes', 'RME klinik', 'Rumah sakit dan klinik'],
                'seo_title' => 'Integrasi SATUSEHAT dan Rekam Medis Elektronik Klinik & RS',
                'seo_description' => 'Integrasi SATUSEHAT untuk rumah sakit dan klinik: kredensial, pemetaan data RME, uji sandbox, sampai pengiriman rutin. Dampingan tim di Medan dan Sumut.',
                'h1' => 'Integrasi SATUSEHAT untuk rumah sakit dan klinik',
                'intro' => 'Fasilitas pelayanan kesehatan wajib menyelenggarakan rekam medis elektronik dan terhubung ke SATUSEHAT, platform milik Kementerian Kesehatan. Bagi banyak rumah sakit dan klinik, tantangannya bukan di kemauan, tetapi di data: lokasi, tenaga kesehatan, dan kode diagnosis yang belum rapi. Kami membantu dari pendaftaran kredensial, pemetaan data dari SIMRS, uji kirim di sandbox, hingga pemantauan pengiriman rutin.',
                'points' => [
                    ['Persiapan kredensial', 'Pendampingan pendaftaran organisasi dan pengaturan akses ke lingkungan uji dan produksi SATUSEHAT.'],
                    ['Data master yang rapi', 'Lokasi, unit layanan, dan tenaga kesehatan disesuaikan dengan data di SATUSEHAT, karena kesalahan di sini menjadi penyebab gagal kirim yang paling umum.'],
                    ['Pemetaan data RME', 'Kunjungan, diagnosis, tindakan, pemeriksaan, dan obat dari SIMRS dipetakan ke format dan kode yang diminta SATUSEHAT.'],
                    ['Uji kirim dan pemantauan', 'Data diuji di sandbox sebelum dikirim rutin. Setelah berjalan, kegagalan kirim dipantau dan ditangani agar data tidak tertinggal.'],
                    ['RME klinik', 'Untuk klinik dan apotek, tersedia Enigma Health versi ringkas yang sudah membawa rekam medis elektronik dan pengiriman ke SATUSEHAT.'],
                    ['Untuk rumah sakit yang sudah punya SIMRS', 'Bila SIMRS yang berjalan belum mendukung SATUSEHAT, kami menilai apakah integrasi bisa ditambahkan ke sistem itu, atau lebih efisien beralih ke Enigma Health yang sudah membawa integrasinya.'],
                    ['Pendampingan petugas', 'Petugas pendaftaran dan dokter dilatih mengisi data yang dibutuhkan SATUSEHAT, seperti NIK pasien dan kode diagnosis, sehingga data sudah lengkap sejak dicatat.'],
                ],
                'faqs' => [
                    ['Apakah klinik juga bisa terintegrasi ke SATUSEHAT?', 'Bisa. Kami membantu klinik mengirim data rekam medis elektronik ke SATUSEHAT, mulai dari pendaftaran kredensial sampai pengujian pengiriman data.'],
                    ['Bagaimana jika pengiriman data gagal?', 'Kami membaca pesan kesalahan dari SATUSEHAT, memperbaiki pemetaan atau data master, lalu mengirim ulang data yang gagal.'],
                    ['Apakah SIMRS selain Enigma Health bisa diintegrasikan?', 'Bisa, selama SIMRS tersebut dapat dikembangkan atau menyediakan akses ke datanya. Kelayakannya kami nilai saat survei.'],
                    ['Data apa saja yang dikirim ke SATUSEHAT?', 'Cakupan data mengikuti ketentuan dan tahapan dari Kementerian Kesehatan. Umumnya dimulai dari data kunjungan dan diagnosis, lalu bertambah sesuai kesiapan fasilitas.'],
                    ['Berapa lama sampai data terkirim ke lingkungan produksi?', 'Tergantung kesiapan kredensial dan kerapian data master. Kami memberikan estimasi tertulis setelah memeriksa data lokasi, tenaga kesehatan, dan contoh data kunjungan dari SIMRS.'],
                    ['Siapa yang memantau setelah integrasi berjalan?', 'Tim kami, sebagai bagian dari kontrak maintenance. Data yang gagal terkirim dilaporkan, diperbaiki, lalu dikirim ulang agar tidak menumpuk.'],
                ],
            ],
            [
                'slug' => 'aplikasi-rumah-sakit', 'group' => 'software', 'layer' => 'Aplikasi', 'icon' => 'monitor',
                'name' => 'Aplikasi rumah sakit custom',
                'short' => 'Dashboard rumah sakit, pendaftaran online, dan pelaporan yang dibuat sesuai alur kerja, terhubung ke Enigma Health.',
                'tags' => ['Dashboard rumah sakit', 'Pendaftaran online', 'Pelaporan', 'Integrasi antarsistem'],
                'seo_title' => 'Aplikasi Rumah Sakit Custom: Dashboard & Pendaftaran Online',
                'seo_description' => 'Pembuatan aplikasi rumah sakit custom yang terhubung ke SIMRS: dashboard manajemen, pendaftaran online, pelaporan internal, dan integrasi antarsistem.',
                'h1' => 'Aplikasi rumah sakit custom sesuai alur kerja Anda',
                'intro' => 'Setiap rumah sakit punya kebutuhan yang tidak selalu tersedia di SIMRS standar: laporan khusus untuk direksi, pendaftaran online dengan tampilan sendiri, atau penghubung ke sistem lain yang sudah dipakai. Kami membangun aplikasi tambahan yang mengambil data dari Enigma Health, sehingga data tetap berasal dari satu sumber dan petugas tidak mencatat ulang.',
                'points' => [
                    ['Dashboard rumah sakit', 'Kunjungan, pendapatan, tingkat hunian, dan status klaim dalam satu tampilan yang mudah dibaca direksi, diperbarui dari data SIMRS.'],
                    ['Pendaftaran online', 'Aplikasi web atau mobile untuk pendaftaran, jadwal dokter, dan informasi layanan, dengan identitas visual rumah sakit sendiri.'],
                    ['Pelaporan internal', 'Laporan unit yang selama ini disusun manual di spreadsheet dibuat otomatis dan bisa diunduh kapan saja.'],
                    ['Integrasi antarsistem', 'Menghubungkan SIMRS dengan aplikasi laboratorium, radiologi, HR, atau akuntansi yang sudah berjalan di rumah sakit.'],
                    ['Kepemilikan kebutuhan yang jelas', 'Kebutuhan ditulis dan disetujui sebelum pengembangan, lalu setiap tahap diuji bersama pengguna di unit terkait.'],
                    ['Standar keamanan yang sama', 'Aplikasi custom memakai pengaturan hak akses dan pencatatan aktivitas yang sama dengan SIMRS, sehingga data pasien tetap terlindungi.'],
                    ['Dokumentasi dan serah terima', 'Setiap aplikasi diserahkan beserta panduan pengguna dan dokumentasi teknis, agar tim IT rumah sakit memahami cara kerjanya.'],
                ],
                'faqs' => [
                    ['Apakah aplikasi bisa terhubung dengan SIMRS yang sudah ada?', 'Bisa, selama SIMRS menyediakan akses integrasi. Untuk Enigma Health, integrasi sudah kami siapkan sejak awal.'],
                    ['Berapa lama membuat aplikasi custom?', 'Tergantung cakupannya. Kami memecah pekerjaan menjadi tahap kecil sehingga bagian yang paling dibutuhkan bisa dipakai lebih dulu.'],
                    ['Apakah rumah sakit bisa meminta perubahan setelah aplikasi jadi?', 'Bisa. Perubahan kecil ditangani dalam kontrak pemeliharaan, sedangkan pengembangan baru dibahas sebagai tahap terpisah.'],
                    ['Di mana aplikasi dijalankan?', 'Di server rumah sakit atau di cloud, sesuai kebijakan rumah sakit tentang penyimpanan data pasien.'],
                    ['Contoh aplikasi apa saja yang bisa dibuat?', 'Misalnya dashboard direksi, pendaftaran online dengan tampilan rumah sakit, laporan indikator mutu, jadwal jaga, atau penghubung data ke sistem laboratorium dan akuntansi. Kebutuhan dibahas dulu sebelum diputuskan dibuat.'],
                    ['Bagaimana biaya pembuatan aplikasi dihitung?', 'Berdasarkan cakupan fitur yang disepakati tertulis. Kami menyarankan memulai dari kebutuhan paling penting, lalu menambah fitur di tahap berikutnya setelah aplikasi dipakai.'],
                    ['Apakah data tetap menjadi milik rumah sakit?', 'Ya, data selalu milik rumah sakit. Ketentuan hak atas aplikasi dan kode program diatur dalam perjanjian kerja sebelum pengembangan dimulai.'],
                ],
            ],
            [
                'slug' => 'hardware-jaringan', 'group' => 'infra', 'layer' => 'Infrastruktur', 'icon' => 'server',
                'name' => 'Hardware dan jaringan',
                'short' => 'Server rumah sakit, komputer, printer, LAN, dan Wi-Fi yang dihitung dari kebutuhan SIMRS, diadakan melalui principal resmi.',
                'tags' => ['Server rumah sakit', 'Jaringan', 'Pengadaan komputer', 'Wi-Fi'],
                'seo_title' => 'Jaringan Rumah Sakit dan Server SIMRS lewat Principal Resmi',
                'seo_description' => 'Jaringan rumah sakit, server SIMRS, dan pengadaan komputer RS melalui principal resmi. Dihitung dari kebutuhan pengguna dan unit. Konsultasi gratis.',
                'h1' => 'Jaringan rumah sakit, server, dan perangkat untuk SIMRS',
                'intro' => 'SIMRS hanya secepat perangkat dan jaringan yang menjalankannya. Pendaftaran yang lambat sering bukan karena aplikasinya, tetapi karena server yang kekurangan kapasitas atau jaringan antarlantai yang tidak stabil. Kami menghitung kebutuhan perangkat dari jumlah unit dan pengguna Enigma Health, lalu menyediakan dan memasangnya melalui principal resmi, sehingga garansi dan suku cadang terjamin.',
                'points' => [
                    ['Server rumah sakit', 'Spesifikasi server dan penyimpanan disesuaikan dengan beban SIMRS, jumlah pengguna, dan rencana pertumbuhan data beberapa tahun ke depan.'],
                    ['Pengadaan komputer dan perangkat unit', 'Komputer, printer label, printer gelang pasien, pemindai, dan perangkat pendukung lain untuk setiap unit pelayanan.'],
                    ['Jaringan LAN dan Wi-Fi', 'Desain dan instalasi jaringan antargedung dan antarlantai, dengan pemisahan jaringan pelayanan, administrasi, dan tamu.'],
                    ['Garansi resmi', 'Perangkat diadakan melalui principal dan distributor resmi, sehingga garansi dan dukungan purna jual jelas.'],
                    ['Dokumentasi', 'Denah jaringan dan daftar perangkat diserahkan ke tim IT rumah sakit agar pemeliharaan lebih mudah.'],
                    ['Survei lokasi', 'Sebelum memberi penawaran, kami memeriksa ruang server, jalur kabel, titik jaringan, dan perangkat yang sudah ada, sehingga kebutuhan dihitung dari kondisi nyata.'],
                    ['Listrik dan cadangan daya', 'UPS untuk server dan perangkat jaringan utama, agar SIMRS tetap berjalan saat listrik padam sesaat dan data tidak rusak.'],
                ],
                'faqs' => [
                    ['Apakah perangkat yang sudah ada masih bisa dipakai?', 'Bisa. Kami memeriksa perangkat lama terlebih dahulu dan hanya menyarankan penggantian yang benar-benar diperlukan.'],
                    ['Lebih baik server di rumah sakit atau di cloud?', 'Keduanya bisa. Pilihannya bergantung pada kualitas internet, kebijakan penyimpanan data, dan anggaran. Kami menjelaskan kelebihan dan risikonya sebelum rumah sakit memutuskan.'],
                    ['Apakah pemasangan jaringan mengganggu pelayanan?', 'Pekerjaan dijadwalkan bertahap per area dan di luar jam sibuk, sehingga pelayanan tetap berjalan.'],
                    ['Berapa spesifikasi server yang dibutuhkan untuk SIMRS?', 'Tergantung jumlah pengguna bersamaan, unit yang memakai sistem, dan volume data. Kami menghitungnya setelah survei dan menyisakan ruang untuk pertumbuhan beberapa tahun ke depan.'],
                    ['Apakah rumah sakit bisa membeli perangkat sendiri?', 'Bisa. Kami memberikan spesifikasi minimum yang dibutuhkan, lalu membantu memeriksa perangkat yang dibeli rumah sakit sebelum dipasang.'],
                    ['Apakah jaringan rumah sakit perlu dipisah?', 'Sebaiknya ya. Jaringan pelayanan, administrasi, dan tamu dipisahkan agar lalu lintas internet pengunjung tidak mengganggu SIMRS, dan perangkat yang terhubung ke jaringan pelayanan tetap aman.'],
                    ['Bagaimana dengan garansi dan perbaikan?', 'Perangkat yang diadakan melalui kami memakai garansi resmi dari principal. Penanganan kerusakan dibantu tim kami sesuai kontrak maintenance.'],
                ],
            ],
            [
                'slug' => 'keamanan-data', 'group' => 'infra', 'layer' => 'Keamanan', 'icon' => 'shield',
                'name' => 'Keamanan data dan backup',
                'short' => 'Backup SIMRS terjadwal, antivirus terpusat, dan pengaturan hak akses untuk melindungi data pasien.',
                'tags' => ['Backup SIMRS', 'Antivirus', 'Hak akses', 'Uji pemulihan'],
                'seo_title' => 'Keamanan Data Rumah Sakit: Backup SIMRS dan Antivirus',
                'seo_description' => 'Keamanan data rumah sakit: backup SIMRS terjadwal, antivirus terpusat, pengaturan hak akses, dan uji pemulihan berkala untuk melindungi data pasien.',
                'h1' => 'Keamanan data rumah sakit dan backup SIMRS',
                'intro' => 'Data pasien termasuk data pribadi yang sensitif. Serangan ransomware, kerusakan server, atau kesalahan pengguna dapat menghentikan pelayanan dalam hitungan menit. Kami memasang perlindungan berlapis di sekitar Enigma Health dan server rumah sakit, lalu memastikan data selalu dapat dipulihkan ketika terjadi masalah.',
                'points' => [
                    ['Backup SIMRS terjadwal', 'Backup otomatis database SIMRS dengan salinan di lokasi terpisah, mengikuti prinsip 3-2-1.'],
                    ['Antivirus rumah sakit', 'Antivirus untuk seluruh komputer dan server, dipantau dari satu konsol sehingga perangkat yang bermasalah cepat terlihat.'],
                    ['Pengaturan hak akses', 'Hak akses pengguna diatur sesuai peran, sehingga data pasien hanya dibuka oleh pihak yang berwenang dan aktivitasnya tercatat.'],
                    ['Uji pemulihan berkala', 'Backup diuji dengan pemulihan nyata secara berkala, karena backup yang belum pernah dipulihkan belum tentu bisa dipakai.'],
                    ['Prosedur saat insiden', 'Langkah yang dilakukan staf ketika sistem terganggu disusun dan dilatihkan, sehingga pelayanan tetap berjalan.'],
                    ['Pembaruan sistem', 'Sistem operasi dan aplikasi di server dan komputer diperbarui secara terjadwal untuk menutup celah keamanan yang sudah diketahui.'],
                    ['Pelatihan kesadaran keamanan', 'Staf dilatih mengenali tautan dan lampiran mencurigakan, karena banyak serangan masuk lewat email atau pesan yang tampak biasa.'],
                ],
                'faqs' => [
                    ['Seberapa sering backup SIMRS sebaiknya dilakukan?', 'Backup harian adalah batas minimum untuk database SIMRS. Jadwal tepatnya disesuaikan dengan volume transaksi rumah sakit.'],
                    ['Apakah backup di cloud aman?', 'Aman bila data dienkripsi dan aksesnya dibatasi. Salinan di cloud juga melindungi rumah sakit dari kerusakan fisik di lokasi.'],
                    ['Apa yang harus dilakukan bila terkena ransomware?', 'Putuskan perangkat yang terdampak dari jaringan, hubungi tim IT, dan jangan membayar tebusan. Pemulihan dilakukan dari backup yang bersih.'],
                    ['Apa itu aturan backup 3-2-1?', 'Simpan minimal tiga salinan data, di dua jenis media penyimpanan, dengan satu salinan di lokasi terpisah. Penjelasan lengkapnya ada di artikel blog kami tentang backup SIMRS.'],
                    ['Apakah keamanan data berkaitan dengan pelindungan data pribadi?', 'Ya. Data kesehatan termasuk data pribadi yang bersifat spesifik menurut Undang-Undang Pelindungan Data Pribadi, sehingga rumah sakit perlu mengatur akses, penyimpanan, dan penanganan insiden dengan serius.'],
                    ['Berapa lama data bisa dipulihkan bila server rusak?', 'Tergantung jenis backup dan ukuran data. Target waktu pemulihan disepakati di awal, lalu dibuktikan lewat uji pemulihan berkala.'],
                    ['Apakah antivirus gratis sudah cukup?', 'Untuk rumah sakit, sebaiknya tidak. Antivirus terpusat memungkinkan tim IT melihat kondisi semua perangkat dari satu konsol dan bertindak cepat bila ada ancaman.'],
                ],
            ],
            [
                'slug' => 'maintenance-sla', 'group' => 'infra', 'layer' => 'Pendampingan', 'icon' => 'clock',
                'name' => 'Maintenance dan SLA',
                'short' => 'Helpdesk SIMRS, pemantauan sistem, pembaruan rutin, dan kunjungan ke lokasi dengan waktu respons yang disepakati.',
                'tags' => ['Helpdesk SIMRS', 'SLA', 'Pemantauan', 'Kunjungan lokasi'],
                'seo_title' => 'Maintenance IT Rumah Sakit dengan SLA dan Helpdesk SIMRS',
                'seo_description' => 'Maintenance IT rumah sakit dengan SLA tertulis: helpdesk SIMRS, pemantauan BPJS dan SATUSEHAT, pembaruan rutin, dan kunjungan ke lokasi di Sumatera Utara.',
                'h1' => 'Maintenance IT rumah sakit dengan SLA yang jelas',
                'intro' => 'Rumah sakit beroperasi 24 jam, sehingga gangguan sistem harus segera ditangani. Setelah Enigma Health berjalan, pekerjaan belum selesai: pengguna baru perlu dilatih, aturan BPJS dan SATUSEHAT berubah, dan perangkat perlu diperiksa. Dengan kontrak maintenance, rumah sakit tahu siapa yang dihubungi, berapa lama waktu responsnya, dan apa saja yang dikerjakan setiap bulan.',
                'points' => [
                    ['Helpdesk SIMRS', 'Saluran bantuan melalui WhatsApp, telepon, dan tiket untuk staf rumah sakit, dengan pencatatan setiap laporan sampai selesai.'],
                    ['Waktu respons dalam SLA', 'Tingkat prioritas dan waktu respons ditulis dalam kontrak, sehingga kendala yang menghentikan pelayanan ditangani lebih dulu.'],
                    ['Pemantauan sistem', 'Server, backup, serta koneksi BPJS Kesehatan dan SATUSEHAT dipantau agar gangguan terdeteksi sebelum dilaporkan pengguna.'],
                    ['Pembaruan rutin', 'Pembaruan aplikasi dan penyesuaian aturan dijadwalkan di luar jam sibuk agar tidak mengganggu pelayanan.'],
                    ['Laporan dan kunjungan berkala', 'Laporan bulanan berisi kendala dan tindak lanjutnya, ditambah kunjungan ke lokasi sesuai kontrak.'],
                    ['Pelatihan pengguna baru', 'Staf baru dan pengguna yang pindah unit dilatih agar tetap memakai SIMRS dengan benar, tanpa menunggu pelatihan besar berikutnya.'],
                    ['Penyesuaian aturan BPJS dan SATUSEHAT', 'Bila ada perubahan ketentuan atau referensi dari BPJS Kesehatan maupun SATUSEHAT, penyesuaian di sistem dikerjakan dalam kontrak.'],
                    ['Pemeriksaan backup', 'Status backup diperiksa rutin dan uji pemulihan dijadwalkan, sehingga rumah sakit yakin data bisa dipulihkan bila diperlukan.'],
                ],
                'faqs' => [
                    ['Apa saja yang tercakup dalam kontrak maintenance?', 'Pemantauan sistem, perbaikan, pembaruan, helpdesk, dan waktu respons yang disepakati dalam SLA. Rinciannya disesuaikan dengan kebutuhan rumah sakit.'],
                    ['Apakah helpdesk tersedia di luar jam kerja?', 'Cakupan jam layanan diatur dalam SLA. Untuk gangguan yang menghentikan pelayanan, jalur darurat disepakati sejak awal.'],
                    ['Apakah maintenance bisa untuk sistem yang bukan dari kami?', 'Bisa, setelah kami memeriksa kondisi sistem dan dokumentasinya. Hasil pemeriksaan menentukan cakupan yang bisa kami tanggung.'],
                    ['Bagaimana cara melaporkan kendala?', 'Melalui WhatsApp, telepon, atau tiket. Setiap laporan diberi nomor dan prioritas, lalu rumah sakit bisa memantau statusnya sampai selesai.'],
                    ['Bagaimana prioritas kendala ditentukan?', 'Kendala yang menghentikan pelayanan, misalnya pendaftaran tidak bisa diakses, menjadi prioritas tertinggi. Kendala yang mengganggu sebagian fungsi atau berupa pertanyaan ditangani sesuai urutan dalam SLA.'],
                    ['Apakah ada laporan rutin untuk direksi?', 'Ada. Laporan bulanan berisi jumlah laporan, waktu penyelesaian, kendala berulang, dan rekomendasi perbaikan, sehingga direksi bisa menilai kinerja sistem dan layanan kami.'],
                    ['Berapa lama masa kontrak maintenance?', 'Masa kontrak disepakati bersama dan dapat diperpanjang. Cakupan dan biayanya ditinjau di akhir periode sesuai kebutuhan rumah sakit.'],
                ],
            ],
            [
                'slug' => 'solusi-mekari', 'group' => 'business', 'layer' => 'Bisnis', 'icon' => 'building', 'badge' => 'Partner resmi',
                'name' => 'Solusi Mekari',
                'short' => 'HR dan payroll rumah sakit, akuntansi, serta komunikasi pasien bersama partner resmi Mekari.',
                'tags' => ['HR dan payroll', 'Akuntansi', 'Komunikasi pasien', 'Partner Mekari'],
                'seo_title' => 'Mekari untuk Rumah Sakit: HR, Payroll, dan Akuntansi RS',
                'seo_description' => 'Mekari untuk rumah sakit bersama partner resmi Mekari: HR dan payroll rumah sakit, jadwal shift, akuntansi, dan komunikasi pasien. Konsultasi gratis.',
                'h1' => 'Mekari untuk rumah sakit: HR, payroll, dan keuangan',
                'intro' => 'Pelayanan pasien ditangani Enigma Health, tetapi administrasi di belakangnya juga perlu rapi: jadwal shift ratusan karyawan, penggajian dengan banyak komponen tunjangan, dan laporan keuangan. Sebagai partner resmi Mekari, kami membantu rumah sakit memilih produk Mekari yang tepat, menerapkannya, dan menghubungkannya dengan operasional rumah sakit.',
                'points' => [
                    ['HR dan payroll rumah sakit', 'Absensi, cuti, jadwal shift, lembur, dan penggajian karyawan dalam satu sistem, dengan komponen tunjangan yang khas rumah sakit.'],
                    ['Akuntansi', 'Pencatatan keuangan dan laporan yang lebih cepat disusun, dengan data pendapatan yang dapat dihubungkan dari SIMRS.'],
                    ['Komunikasi pasien', 'Pengelolaan pesan dan layanan pelanggan dari berbagai kanal, sehingga pertanyaan pasien tidak tercecer.'],
                    ['Pendampingan implementasi', 'Pengaturan awal, migrasi data karyawan dan akun, serta pelatihan pengguna di bagian SDM dan keuangan.'],
                    ['Terhubung dengan Enigma Health', 'Data pendapatan dan transaksi dari SIMRS dapat dihubungkan ke akuntansi, sehingga pencatatan keuangan tidak diketik ulang.'],
                    ['Laporan untuk manajemen', 'Biaya tenaga kerja dan laporan keuangan tersedia lebih cepat, sehingga direksi bisa membandingkannya dengan pendapatan pelayanan.'],
                ],
                'faqs' => [
                    ['Apakah Mekari bisa digunakan bersama SIMRS?', 'Bisa. Mekari menangani administrasi bisnis, sedangkan Enigma Health menangani pelayanan. Keduanya dapat dihubungkan sesuai kebutuhan.'],
                    ['Produk Mekari apa yang cocok untuk rumah sakit?', 'Tergantung kebutuhan. Umumnya dimulai dari HR dan payroll, lalu akuntansi. Kami membantu memilih setelah memahami proses di rumah sakit.'],
                    ['Apakah Enigma Works Indonesia partner resmi Mekari?', 'Ya. Kami adalah partner resmi Mekari, sehingga implementasi dan pendampingan dilakukan sesuai standar Mekari.'],
                    ['Apakah data karyawan lama bisa dipindahkan?', 'Bisa. Data karyawan, komponen gaji, dan saldo cuti dipindahkan dan diperiksa bersama tim SDM sebelum sistem dipakai.'],
                    ['Apakah sistem bisa menangani jadwal shift yang rumit?', 'Rumah sakit punya pola shift pagi, siang, dan malam dengan banyak pengecualian. Pengaturan jadwal dan aturan lembur dibahas bersama bagian SDM saat implementasi agar sesuai kebijakan rumah sakit.'],
                    ['Bagaimana proses pemilihan paket Mekari?', 'Kami membantu memilih paket yang sesuai dengan jumlah karyawan dan produk yang dibutuhkan, lalu mengurus prosesnya bersama Mekari.'],
                    ['Apakah ada pelatihan untuk bagian SDM dan keuangan?', 'Ada. Pelatihan diberikan per peran, misalnya admin SDM, penyetuju cuti, dan staf keuangan, disertai pendampingan pada periode penggajian pertama.'],
                    ['Apakah karyawan bisa melihat slip gaji dan mengajukan cuti sendiri?', 'Bisa. Karyawan dapat mengakses slip gaji, pengajuan cuti, dan jadwal kerja mereka sendiri, sehingga beban bagian SDM berkurang.'],
                ],
            ],
        ];
    }

    /** @return list<array<string, mixed>> */
    public static function cityItems(): array
    {
        return [
            [
                'slug' => 'medan', 'name' => 'Medan', 'has_page' => true, 'is_main' => true,
                'seo_title' => 'SIMRS Medan: Enigma Health untuk Rumah Sakit dan Klinik',
                'seo_description' => 'SIMRS Medan untuk rumah sakit dan klinik: Enigma Health dengan bridging BPJS Medan, integrasi SATUSEHAT, dan tim yang datang langsung. Konsultasi gratis.',
                'h1' => 'SIMRS Medan untuk rumah sakit dan klinik',
                'intro' => 'Medan adalah pusat rujukan kesehatan di Sumatera Utara. Rumah sakit swasta, rumah sakit pemerintah, dan klinik di kota ini melayani pasien dari Medan sendiri sekaligus rujukan dari kabupaten di sekitarnya. Volume pasien JKN yang tinggi membuat SIMRS yang stabil dan bridging BPJS yang lancar menjadi kebutuhan sehari-hari, bukan pelengkap.',
                'body' => "Persaingan layanan kesehatan di Medan cukup ketat. Pasien membandingkan lama antrean, kemudahan mendaftar lewat Mobile JKN, dan kecepatan pelayanan di kasir. Banyak rumah sakit masih memakai beberapa aplikasi terpisah untuk pendaftaran, farmasi, dan keuangan, sehingga data pasien dicatat berulang kali dan laporan untuk direksi baru tersedia di akhir bulan. Enigma Health menyatukan alur itu dalam satu SIMRS, dari pendaftaran sampai berkas klaim.\n\nUntuk rumah sakit di Medan, kami biasanya mulai dari survei langsung ke setiap unit: pendaftaran, poliklinik, IGD, rawat inap, penunjang, farmasi, kasir, dan bagian klaim. Hasilnya adalah rancangan tertulis yang memuat modul yang dipakai, data yang dipindahkan dari sistem lama, kebutuhan perangkat dan jaringan, serta jadwal go-live per unit. Bridging BPJS Kesehatan dan integrasi SATUSEHAT dikerjakan dalam proyek yang sama, sehingga rumah sakit tidak perlu mengurus vendor terpisah.\n\nBanyak rumah sakit di Medan sudah memakai SIMRS sejak bertahun-tahun lalu. Bagi mereka, pertanyaannya adalah apakah sistem lama masih bisa dikembangkan atau sudah saatnya diganti. Kami membantu menilainya secara terbuka. Bila SIMRS lama masih layak, bridging BPJS dan integrasi SATUSEHAT bisa dikerjakan pada sistem itu. Bila tidak, data pasien, tarif, dan obat dipindahkan ke Enigma Health dengan uji coba bersama setiap unit sebelum go-live.\n\nKlinik pratama dan klinik utama di Medan juga menghadapi kewajiban rekam medis elektronik dan pengiriman data ke SATUSEHAT. Untuk mereka, tersedia Enigma Health versi ringkas yang lebih cepat diterapkan, tetapi tetap membawa RME, antrean, dan farmasi.\n\nTim kami hadir di lokasi untuk instalasi, pelatihan per unit, dan pendampingan pada minggu-minggu awal setelah go-live. Setelah sistem stabil, dukungan harian dilakukan dari jarak jauh melalui helpdesk, dengan kunjungan berkala sesuai kontrak maintenance.\n\nBagi direksi, manfaat yang paling cepat terasa biasanya ada di laporan. Kunjungan per poliklinik, pendapatan per penjamin, dan status klaim BPJS dapat dilihat dari dashboard setiap hari, tanpa menunggu rekap manual dari setiap unit. Data itu membantu manajemen mengambil keputusan lebih cepat, misalnya menambah jadwal dokter di poliklinik yang antreannya selalu penuh, atau menelusuri penyebab klaim yang dikembalikan.",
                'nearby' => ['deli-serdang', 'binjai'],
            ],
            [
                'slug' => 'deli-serdang', 'name' => 'Deli Serdang', 'has_page' => true,
                'seo_title' => 'SIMRS Deli Serdang: Sistem untuk Rumah Sakit dan Klinik Baru',
                'seo_description' => 'SIMRS Deli Serdang untuk rumah sakit dan klinik di Lubuk Pakam dan sekitarnya: Enigma Health, jaringan, bridging BPJS, dan SATUSEHAT sejak hari pertama.',
                'h1' => 'SIMRS Deli Serdang untuk rumah sakit dan klinik',
                'intro' => 'Deli Serdang mengelilingi Kota Medan dan terus berkembang, dari Lubuk Pakam sebagai ibu kota kabupaten hingga kawasan di sekitar Bandara Kualanamu. Pertumbuhan permukiman ini diikuti oleh rumah sakit dan klinik baru yang perlu siap melayani pasien JKN sejak hari pertama beroperasi.',
                'body' => "Fasilitas kesehatan yang baru dibangun punya keuntungan: sistemnya bisa dirancang dengan benar sejak awal, tanpa beban data lama. Kami dapat menyiapkan semuanya dalam satu proyek, mulai dari jaringan dan perangkat di setiap ruangan, server, SIMRS Enigma Health, sampai bridging BPJS Kesehatan dan integrasi SATUSEHAT. Rumah sakit cukup berurusan dengan satu tim, dan semua komponen diuji bersama sebelum pasien pertama datang.\n\nUrutan pekerjaannya kami sesuaikan dengan jadwal pembangunan dan perizinan. Jaringan dipasang ketika ruangan siap, perangkat diadakan melalui principal resmi, lalu SIMRS dikonfigurasi dengan data master poliklinik, dokter, tarif, dan obat. Pelatihan staf dilakukan sebelum operasional dimulai, sehingga petugas sudah terbiasa saat pelayanan berjalan.\n\nAda beberapa hal yang sering terlambat disiapkan oleh rumah sakit baru: kredensial bridging BPJS Kesehatan, pendaftaran ke SATUSEHAT, serta data master tarif dan obat. Kami menyusun daftar periksa bersama manajemen sejak masa pembangunan, sehingga semuanya siap ketika izin operasional terbit dan kerja sama dengan BPJS Kesehatan dimulai.\n\nRumah sakit yang tumbuh bertahap, misalnya membuka rawat jalan lebih dulu lalu rawat inap, dapat mengaktifkan modul sesuai kesiapan unit. Data pasien tetap menyatu sejak kunjungan pertama, sehingga riwayatnya tersedia ketika unit baru mulai melayani.\n\nUntuk rumah sakit dan klinik di Deli Serdang yang sudah lama beroperasi, kami memulai dengan audit sistem yang ada: aplikasi yang dipakai, kondisi data, perangkat, dan jaringan. Dari situ kami menyarankan mana yang perlu diganti dan mana yang masih layak dipertahankan, agar biaya perubahan tetap masuk akal. Tim kami datang ke lokasi untuk survei, instalasi, dan kunjungan berkala, sementara dukungan harian dilakukan dari jarak jauh.\n\nRumah sakit di Lubuk Pakam dan sekitarnya juga menerima rujukan dari puskesmas di kecamatan yang tersebar luas. Dengan bridging BPJS Kesehatan, data rujukan dibaca langsung saat pendaftaran, dan antrean online Mobile JKN membantu pasien dari kecamatan yang jauh mengatur waktu kedatangan. Dua hal ini mengurangi penumpukan di loket pada pagi hari, sehingga petugas punya waktu lebih untuk memastikan data pasien tercatat lengkap dan benar sejak awal kunjungan.",
                'nearby' => ['medan', 'binjai'],
            ],
            [
                'slug' => 'binjai', 'name' => 'Binjai', 'has_page' => true,
                'seo_title' => 'SIMRS Binjai dan Langkat: Bridging BPJS untuk Pasien JKN',
                'seo_description' => 'SIMRS Binjai untuk rumah sakit dan klinik di Binjai dan Langkat: Enigma Health dengan bridging BPJS, antrean Mobile JKN, dan maintenance IT terjadwal.',
                'h1' => 'SIMRS Binjai untuk rumah sakit dan klinik di Binjai dan Langkat',
                'intro' => 'Binjai berbatasan langsung dengan Medan dan menjadi pintu masuk ke Kabupaten Langkat. Rumah sakit dan klinik di wilayah ini melayani banyak pasien JKN, termasuk pasien dari kecamatan di Langkat yang menempuh perjalanan cukup jauh. Bagi mereka, antrean panjang di loket pendaftaran berarti waktu yang terbuang.',
                'body' => "Masalah yang paling sering kami temui di rumah sakit dengan porsi pasien JKN besar adalah pendaftaran yang lambat. Petugas memeriksa kepesertaan di satu aplikasi, menerbitkan SEP di aplikasi lain, lalu mengetik ulang data di SIMRS. Dengan Enigma Health dan bridging BPJS Kesehatan, seluruh langkah itu dilakukan dari satu layar, dan nomor SEP tersimpan langsung di data kunjungan.\n\nPasien rujukan dari puskesmas dan klinik di Langkat juga lebih mudah dilayani ketika data rujukan dibaca langsung dari layanan BPJS saat pendaftaran. Petugas tidak perlu mengetik ulang nomor rujukan, sehingga kesalahan yang membuat SEP gagal terbit dapat dikurangi. Bagi pasien, artinya waktu tunggu di loket lebih singkat dan kepastian layanan lebih jelas.\n\nAntrean online melalui Mobile JKN membantu pasien dari Langkat mengatur waktu kedatangan. Jadwal dokter dan kuota poliklinik di SIMRS tersambung, sehingga pasien tidak perlu datang subuh hanya untuk mengambil nomor antrean. Bagi rumah sakit, kedatangan pasien menjadi lebih merata sepanjang hari.\n\nKami juga memperhatikan jam sibuk. Di banyak rumah sakit, beban pendaftaran menumpuk di pagi hari. Uji beban dilakukan sebelum go-live agar server dan jaringan mampu melayani semua loket dan poliklinik pada saat bersamaan. Setelah sistem berjalan, berkas klaim pun lebih rapi karena diagnosis, tindakan, dan dokumen pendukung tersusun dari data pelayanan.\n\nKlinik dan apotek di Binjai dapat memakai Enigma Health versi ringkas dengan rekam medis elektronik dan pengiriman data ke SATUSEHAT, tanpa harus menerapkan seluruh modul rumah sakit. Untuk menjaga sistem tetap berjalan, kontrak maintenance mencakup pemantauan koneksi BPJS dan SATUSEHAT, helpdesk untuk staf, serta kunjungan berkala ke lokasi.\n\nBagi manajemen rumah sakit di Binjai, dashboard Enigma Health membantu memantau jumlah kunjungan pasien JKN dan non-JKN, pendapatan per penjamin, serta berkas klaim yang belum lengkap. Laporan yang sebelumnya disusun manual setiap akhir bulan kini dapat dilihat kapan saja. Masalah klaim dapat ditangani sebelum menumpuk, arus kas rumah sakit lebih terjaga, dan direksi dapat membandingkan kinerja setiap poliklinik dari minggu ke minggu.",
                'nearby' => ['medan', 'deli-serdang'],
            ],
            [
                'slug' => 'pematangsiantar', 'name' => 'Pematangsiantar', 'has_page' => true,
                'seo_title' => 'SIMRS Pematangsiantar: Dukungan Jarak Jauh untuk Simalungun',
                'seo_description' => 'SIMRS Pematangsiantar untuk rumah sakit dan klinik di Simalungun: Enigma Health, bridging BPJS, SATUSEHAT, pemantauan jarak jauh, dan kunjungan berkala.',
                'h1' => 'SIMRS Pematangsiantar untuk rumah sakit di Pematangsiantar dan Simalungun',
                'intro' => 'Pematangsiantar adalah salah satu kota utama di jalur tengah Sumatera Utara dan menjadi rujukan bagi wilayah Simalungun. Karena letaknya cukup jauh dari Medan, rumah sakit di sini membutuhkan SIMRS yang stabil dan dukungan jarak jauh yang andal, bukan sistem yang selalu menunggu teknisi datang.',
                'body' => "Kami merancang implementasi di Pematangsiantar dengan prinsip sebisa mungkin mandiri di lokasi. Server dan jaringan disiapkan dengan cadangan yang memadai, backup berjalan otomatis, dan staf IT rumah sakit dilatih untuk menangani kendala ringan sendiri. Tim kami tetap hadir di lokasi untuk survei, instalasi Enigma Health, pelatihan per unit, dan pendampingan pada masa go-live.\n\nKoneksi internet mendapat perhatian khusus, karena bridging BPJS Kesehatan dan pengiriman data ke SATUSEHAT membutuhkan akses yang stabil. Kami menyarankan jalur cadangan dari penyedia yang berbeda, sehingga pendaftaran pasien JKN tidak terhenti ketika satu jalur bermasalah.\n\nSetelah sistem berjalan, pemantauan dilakukan dari jarak jauh. Server, backup, serta koneksi ke BPJS Kesehatan dan SATUSEHAT dipantau, sehingga gangguan sering kali sudah terdeteksi sebelum petugas melapor. Sebagian besar kendala aplikasi diselesaikan melalui helpdesk dan akses jarak jauh yang aman, dengan prosedur yang disepakati bersama rumah sakit.\n\nUntuk masalah perangkat atau jaringan yang perlu ditangani langsung, kunjungan ke lokasi dijadwalkan sesuai SLA. Sebelum proyek dimulai, kami menyepakati penanggung jawab di lokasi, jalur komunikasi, dan jadwal kunjungan berkala. Kunjungan itu dipakai untuk memeriksa perangkat, menguji pemulihan backup, dan melatih pengguna baru.\n\nRumah sakit dan klinik di Simalungun dan sekitarnya dapat memakai pola yang sama. Klinik dapat memulai dengan Enigma Health versi ringkas yang membawa rekam medis elektronik dan pengiriman data ke SATUSEHAT. Bila layanan bertambah, klinik dapat beralih ke modul yang lebih lengkap tanpa mengulang pencatatan data pasien dari awal.\n\nStaf IT rumah sakit menjadi mitra utama kami di lokasi. Mereka mendapat pelatihan khusus tentang cara memeriksa status server, memulai ulang layanan yang berhenti, dan membaca laporan backup. Dengan bekal itu, banyak kendala kecil selesai dalam hitungan menit tanpa menunggu tim kami terhubung.\n\nBackup database Enigma Health disimpan di lebih dari satu tempat, termasuk salinan di luar gedung rumah sakit. Bila terjadi kerusakan perangkat atau bencana di lokasi, data pasien tetap dapat dipulihkan dan pelayanan bisa kembali berjalan secepat mungkin.",
                'nearby' => ['medan', 'deli-serdang'],
            ],
        ];
    }

    /** @return list<string> */
    public static function otherCities(): array
    {
        return ['Langkat', 'Serdang Bedagai', 'Tebing Tinggi', 'Simalungun', 'Karo', 'Asahan', 'Labuhanbatu', 'Padangsidimpuan', 'Sibolga'];
    }

    /** @return array<string, mixed> */
    public static function caseStudyItem(): array
    {
        return [
            'slug' => 'rsu-serenapita',
            'client' => 'RSU Serenapita',
            'title' => 'RSU Serenapita: implementasi SIMRS Enigma Health dengan BPJS dan SATUSEHAT',
            'seo_title' => 'Studi Kasus Implementasi SIMRS dan BPJS di RSU Serenapita',
            'seo_description' => 'Studi kasus implementasi SIMRS Enigma Health di RSU Serenapita: bridging BPJS Kesehatan dan integrasi SATUSEHAT sudah aktif. Pelajari prosesnya di sini.',
            'summary' => 'RSU Serenapita membutuhkan SIMRS yang terhubung ke BPJS Kesehatan dan SATUSEHAT tanpa menghentikan pelayanan pasien. Tim Enigma Works Indonesia mengimplementasikan Enigma Health, mengaktifkan bridging BPJS dan integrasi SATUSEHAT, serta menyiapkan aplikasi pendukung sesuai kebutuhan unit. Implementasi masih berjalan.',
            'checks' => ['Bridging BPJS Kesehatan aktif untuk pasien JKN', 'Data kunjungan terkirim ke SATUSEHAT', 'Implementasi Enigma Health berjalan bertahap per unit'],
            'facts' => [['Klien', 'Rumah Sakit Umum Serenapita'], ['Produk', 'SIMRS Enigma Health'], ['Lingkup', 'Implementasi SIMRS, bridging BPJS, integrasi SATUSEHAT, aplikasi pendukung'], ['Status', 'Implementasi berjalan; bridging BPJS dan SATUSEHAT aktif'], ['Lokasi', '[ISI KOTA]']],
            'sections' => [
                ['Tantangan', '[ISI TANTANGAN: kondisi sebelum proyek, sistem lama yang dipakai, kendala pelayanan, dan kebutuhan regulasi.]'],
                ['Solusi', 'Implementasi SIMRS Enigma Health di unit pelayanan, bridging dengan BPJS Kesehatan, integrasi ke SATUSEHAT, serta aplikasi pendukung yang dibuat sesuai kebutuhan rumah sakit.'],
                ['Proses', '[ISI PROSES: tahapan survei, persiapan data, pelatihan, go-live per unit, dan pendampingan.]'],
                ['Hasil', 'Bridging BPJS Kesehatan dan pengiriman data ke SATUSEHAT sudah aktif. [ISI HASIL TERUKUR: misalnya waktu pendaftaran pasien JKN atau kelengkapan berkas klaim, setelah datanya tersedia.]'],
            ],
            'service_slugs' => ['simrs', 'bridging-bpjs', 'integrasi-satusehat', 'aplikasi-rumah-sakit'],
            'quote' => 'Tim Enigma Works Indonesia mendampingi kami dari persiapan hingga sistem terhubung ke BPJS dan SATUSEHAT. Setiap kendala di lapangan ditangani dengan cepat, sehingga pelayanan pasien tetap berjalan selama masa transisi.',
            'quote_by' => '[ISI NAMA]',
            'quote_role' => '[ISI JABATAN], RSU Serenapita',
            'quote_approved' => false,
            'sort' => 1,
            'is_active' => true,
        ];
    }

    /** @return list<array<string, mixed>> */
    public static function portfolioItems(): array
    {
        return [
            ['name' => 'RSU Serenapita', 'label' => 'Proyek Enigma Works Indonesia', 'is_own' => true, 'is_active' => true, 'text' => 'Implementasi SIMRS Enigma Health dengan bridging BPJS Kesehatan, integrasi SATUSEHAT, dan aplikasi pendukung.', 'link' => '/studi-kasus/rsu-serenapita'],
            ['name' => '[ISI PROYEK BERIKUTNYA]', 'label' => 'Proyek Enigma Works Indonesia', 'is_own' => true, 'is_active' => false, 'text' => '[ISI RINGKASAN PROYEK]', 'link' => null],
        ];
    }

    /** @return list<array{0: string, 1: string}> */
    public static function faqItems(): array
    {
        return [
            ['Apakah data dari SIMRS lama bisa dipindahkan?', 'Bisa. Kami memetakan data master dan data pasien dari sistem lama, menguji hasil migrasi bersama tim rumah sakit, lalu memindahkannya sebelum go-live. Riwayat pasien tetap tersedia di Enigma Health.'],
            ['Berapa lama implementasi SIMRS sampai go-live?', 'Tergantung jumlah unit, kondisi data lama, serta kesiapan perangkat dan jaringan. Setelah survei, kami menyusun jadwal tertulis per tahap, dan go-live dapat dilakukan bertahap per unit agar pelayanan tidak terganggu.'],
            ['Apakah Enigma Health sudah siap untuk BPJS Kesehatan dan SATUSEHAT?', 'Ya. Bridging BPJS Kesehatan (SEP, V-Claim, antrean online) dan integrasi SATUSEHAT menjadi bagian dari implementasi, dan sudah aktif di proyek yang sedang berjalan.'],
            ['Bagaimana keamanan data pasien dijaga?', 'Hak akses diatur per peran, aktivitas pengguna tercatat, dan database dibackup terjadwal dengan salinan di lokasi terpisah. Kami juga membantu menguji pemulihan backup secara berkala.'],
            ['Siapa yang membantu setelah go-live?', 'Tim Enigma Works Indonesia. Helpdesk, pemantauan sistem, pembaruan, dan kunjungan ke lokasi diatur dalam kontrak maintenance dengan waktu respons yang disepakati dalam SLA.'],
            ['Apakah tersedia versi untuk klinik?', 'Tersedia. Klinik pratama, klinik utama, dan apotek dapat memakai Enigma Health versi ringkas yang tetap membawa rekam medis elektronik dan pengiriman data ke SATUSEHAT.'],
        ];
    }

    /**
     * FAQ beranda versi sebelumnya; dinonaktifkan oleh RebrandSeeder bila tidak dipakai lagi.
     *
     * @return list<string>
     */
    public static function retiredFaqs(): array
    {
        return [
            'Apakah Enigma Works Indonesia melayani rumah sakit di Medan?',
            'Apakah SIMRS bisa disesuaikan dengan kebutuhan rumah sakit?',
            'Berapa lama proses bridging BPJS Kesehatan?',
            'Apakah klinik juga bisa terintegrasi ke SATUSEHAT?',
            'Apakah tersedia kontrak maintenance?',
        ];
    }
}
