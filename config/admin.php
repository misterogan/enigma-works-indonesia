<?php

/*
|--------------------------------------------------------------------------
| Konfigurasi backoffice
|--------------------------------------------------------------------------
| 'settings'  : teks dan data umum website, dikelompokkan per tab.
|               Nilai 'default' dipakai saat pertama kali seeding.
| 'resources' : data yang bisa ditambah/diubah/dihapus (layanan, kota, dll).
|
| Jenis field:
|   text, textarea, markdown, number, boolean, select, image, datetime,
|   lines  (satu item per baris, disimpan sebagai array)
|   pairs  (satu item per baris dengan format "Judul | Teks")
|   tags   (dipisah koma)
|
| Tanda *bintang* di judul akan ditampilkan dengan warna gradasi.
*/

use App\Models\CaseStudy;
use App\Models\City;
use App\Models\Faq;
use App\Models\PortfolioItem;
use App\Models\Post;
use App\Models\Service;

return [

    'settings' => [

        'perusahaan' => [
            'label' => 'Perusahaan',
            'fields' => [
                ['name' => 'company_name', 'label' => 'Nama perusahaan', 'type' => 'text', 'default' => 'Enigma Works Indonesia'],
                ['name' => 'product_name', 'label' => 'Nama produk (merek utama di header dan judul tab)', 'type' => 'text', 'default' => 'Enigma Health'],
                ['name' => 'legal_name', 'label' => 'Nama badan hukum', 'type' => 'text', 'default' => 'PT Enigma Works Indonesia'],
                ['name' => 'phone', 'label' => 'Telepon (tampilan)', 'type' => 'text', 'default' => '0838-7464-3903'],
                ['name' => 'phone_e164', 'label' => 'Telepon (format internasional)', 'type' => 'text', 'default' => '+6283874643903', 'help' => 'Contoh: +6283874643903'],
                ['name' => 'whatsapp', 'label' => 'Nomor WhatsApp', 'type' => 'text', 'default' => '6283874643903', 'help' => 'Tanpa tanda +, diawali 62'],
                ['name' => 'email', 'label' => 'Email', 'type' => 'text', 'default' => 'info@enigmaworks.co.id'],
                ['name' => 'street', 'label' => 'Alamat', 'type' => 'text', 'default' => 'Perumahan Golden Estesia, Jl. Serua Raya No. 56'],
                ['name' => 'city', 'label' => 'Kota', 'type' => 'text', 'default' => 'Depok'],
                ['name' => 'region', 'label' => 'Provinsi', 'type' => 'text', 'default' => 'Jawa Barat'],
                ['name' => 'linkedin', 'label' => 'URL LinkedIn', 'type' => 'text', 'default' => ''],
                ['name' => 'instagram', 'label' => 'URL Instagram', 'type' => 'text', 'default' => ''],
                ['name' => 'youtube', 'label' => 'URL YouTube', 'type' => 'text', 'default' => ''],
                ['name' => 'logo', 'label' => 'Logo (opsional)', 'type' => 'image', 'default' => '', 'help' => 'Disarankan PNG atau SVG dengan latar transparan.'],
                ['name' => 'logo_height', 'label' => 'Tinggi logo di header (piksel)', 'type' => 'number', 'default' => '52', 'help' => 'Disarankan 44–64. Di HP otomatis diperkecil.'],
                ['name' => 'show_company_name', 'label' => 'Tampilkan nama perusahaan di samping logo', 'type' => 'boolean', 'default' => '1', 'help' => 'Matikan bila logo sudah memuat tulisan nama perusahaan.'],
                ['name' => 'og_image', 'label' => 'Gambar saat link dibagikan (1200×630)', 'type' => 'image', 'default' => ''],
                ['name' => 'partner_line', 'label' => 'Teks kemitraan di footer', 'type' => 'text', 'default' => 'Partner resmi Mekari'],
            ],
        ],

        'seo' => [
            'label' => 'SEO beranda',
            'fields' => [
                ['name' => 'seo_title', 'label' => 'Judul di Google (title tag)', 'type' => 'text', 'help' => 'Ideal 50–60 karakter.', 'default' => 'SIMRS Enigma Health untuk Rumah Sakit di Medan & Sumut'],
                ['name' => 'seo_description', 'label' => 'Deskripsi di Google', 'type' => 'textarea', 'help' => 'Ideal 140–160 karakter.', 'default' => 'SIMRS Enigma Health untuk rumah sakit dan klinik: RME, bridging BPJS Kesehatan, dan integrasi SATUSEHAT. Melayani Medan dan Sumatera Utara. Konsultasi gratis.'],
                ['name' => 'title_suffix', 'label' => 'Akhiran judul halaman lain', 'type' => 'text', 'default' => ' | Enigma Health'],
            ],
        ],

        'banner' => [
            'label' => 'Banner utama',
            'fields' => [
                ['name' => 'announce_text', 'label' => 'Teks bar pengumuman (kosongkan untuk menyembunyikan)', 'type' => 'text', 'default' => 'Kini melayani integrasi SATUSEHAT untuk klinik dan apotek.'],
                ['name' => 'announce_link', 'label' => 'Link bar pengumuman', 'type' => 'text', 'default' => '/layanan/integrasi-satusehat'],
                ['name' => 'hero_title', 'label' => 'Judul banner (H1)', 'type' => 'text', 'help' => 'Beri *bintang* pada kata yang ingin bergradasi.', 'default' => 'SIMRS *Enigma Health* untuk rumah sakit yang terintegrasi'],
                ['name' => 'hero_subtitle', 'label' => 'Deskripsi banner', 'type' => 'textarea', 'default' => 'Enigma Health menyatukan pendaftaran, rekam medis elektronik, penunjang, farmasi, kasir, dan klaim dalam satu SIMRS yang terhubung ke BPJS Kesehatan dan SATUSEHAT. Diimplementasikan oleh tim Enigma Works Indonesia untuk rumah sakit dan klinik di Medan, Sumatera Utara, dan seluruh Indonesia.'],
                ['name' => 'hero_badges', 'label' => 'Lencana (satu per baris, baris pertama huruf kapital)', 'type' => 'textarea', 'default' => "SIMRS Enigma Health\nBridging BPJS & SATUSEHAT\nPartner resmi Mekari"],
                ['name' => 'hero_cta_primary', 'label' => 'Tombol utama', 'type' => 'text', 'default' => 'Konsultasi gratis'],
                ['name' => 'hero_cta_secondary', 'label' => 'Tombol kedua', 'type' => 'text', 'default' => 'Lihat layanan'],
                ['name' => 'logos_label', 'label' => 'Judul strip di bawah banner', 'type' => 'text', 'default' => 'Proyek dan integrasi yang berjalan'],
                ['name' => 'logos_items', 'label' => 'Isi strip (satu per baris)', 'type' => 'textarea', 'default' => "RSU Serenapita\nBPJS Kesehatan\nSATUSEHAT Kemenkes\nMobile JKN\nMekari"],
                ['name' => 'ribbon_items', 'label' => 'Pita teks besar (satu per baris)', 'type' => 'textarea', 'default' => "Data pasien dicatat sekali\nSEP terbit dari SIMRS\nRME terkirim ke SATUSEHAT\nKlaim lebih rapi"],
            ],
        ],

        'beranda' => [
            'label' => 'Bagian beranda',
            'fields' => [
                ['name' => 'hub_pill', 'label' => 'Hub: label kecil', 'type' => 'text', 'default' => 'Arsitektur integrasi'],
                ['name' => 'hub_title', 'label' => 'Hub: judul', 'type' => 'text', 'default' => 'Satu SIMRS, *semua unit saling terhubung*'],
                ['name' => 'hub_text', 'label' => 'Hub: deskripsi', 'type' => 'textarea', 'default' => 'Enigma Health menjadi pusat data pasien. Aplikasi penunjang yang sudah berjalan tetap bisa dipakai, lalu dihubungkan ke BPJS Kesehatan, SATUSEHAT, dan Mekari melalui lapisan integrasi yang kami rawat.'],
                ['name' => 'standards_label', 'label' => 'Standar: judul kecil', 'type' => 'text', 'default' => 'Standar yang kami tangani'],
                ['name' => 'standards_items', 'label' => 'Standar dan protokol (satu per baris, kosongkan untuk menyembunyikan)', 'type' => 'textarea', 'default' => "HL7 v2\nFHIR R4\nDICOM\nREST API\nICD-10 & ICD-9-CM\nLOINC\nSNOMED CT\nKFA"],
                ['name' => 'services_title', 'label' => 'Layanan: judul', 'type' => 'text', 'default' => 'Dari SIMRS sampai infrastruktur, *satu tim*'],
                ['name' => 'services_text', 'label' => 'Layanan: deskripsi', 'type' => 'textarea', 'default' => 'Enigma Health sebagai inti, ditambah integrasi, perangkat, keamanan data, dan pemeliharaan. Semuanya ditangani satu tim yang memahami alur kerja rumah sakit.'],
                ['name' => 'proof_title', 'label' => 'Bukti: judul', 'type' => 'text', 'default' => 'Sudah berjalan di *rumah sakit*'],
                ['name' => 'proof_text', 'label' => 'Bukti: deskripsi', 'type' => 'textarea', 'default' => 'Di RSU Serenapita, Enigma Health diimplementasikan bersama bridging BPJS Kesehatan dan integrasi SATUSEHAT yang sudah aktif. Ini yang bisa kami tunjukkan saat ini.'],
                ['name' => 'stats', 'label' => 'Angka (format: Angka | Keterangan)', 'type' => 'textarea', 'default' => "BPJS | Bridging aktif di proyek berjalan\nSATUSEHAT | Pengiriman data rekam medis berjalan\nLokal | Tim datang langsung ke Medan dan Sumatera Utara\nMekari | Partner resmi untuk HR dan keuangan"],
                ['name' => 'stats_note', 'label' => 'Catatan di bawah angka', 'type' => 'text', 'default' => 'Status per proyek yang sedang berjalan. Angka capaian akan ditampilkan setelah terukur.'],
                ['name' => 'portfolio_title', 'label' => 'Portofolio: judul', 'type' => 'text', 'default' => 'Proyek yang sedang *berjalan*'],
                ['name' => 'portfolio_text', 'label' => 'Portofolio: deskripsi', 'type' => 'textarea', 'default' => 'Setiap proyek kami tangani langsung, dari survei sampai pendampingan setelah go-live.'],
                ['name' => 'portfolio_more', 'label' => 'Portofolio: catatan tambahan', 'type' => 'text', 'default' => ''],
                ['name' => 'process_title', 'label' => 'Proses: judul', 'type' => 'text', 'default' => 'Proses kerja yang *jelas*'],
                ['name' => 'process_text', 'label' => 'Proses: deskripsi', 'type' => 'textarea', 'default' => 'Setiap tahap disepakati sejak awal, sehingga rumah sakit tahu apa yang dikerjakan, kapan, dan oleh siapa.'],
                ['name' => 'process_steps', 'label' => 'Tahapan (format: Judul | Penjelasan)', 'type' => 'textarea', 'default' => "Survei | Kami mempelajari alur pelayanan, sistem yang berjalan, dan perangkat yang tersedia.\nRancangan | Modul, jadwal, dan biaya disusun tertulis sebelum pekerjaan dimulai.\nImplementasi | Instalasi Enigma Health, migrasi data, bridging BPJS, dan integrasi SATUSEHAT.\nPelatihan | Staf setiap unit didampingi sampai terbiasa menggunakan sistem.\nPendampingan | Helpdesk dan pemeliharaan rutin sesuai SLA yang disepakati."],
                ['name' => 'area_title', 'label' => 'Area: judul', 'type' => 'text', 'default' => 'SIMRS untuk rumah sakit di Medan dan Sumatera Utara'],
                ['name' => 'area_text', 'label' => 'Area: deskripsi', 'type' => 'textarea', 'default' => 'Tim kami datang langsung untuk survei, instalasi, dan pelatihan. Setelah sistem berjalan, dukungan harian dilakukan dari jarak jauh dengan kunjungan berkala. Mulai dari Sumatera Utara, terbuka untuk seluruh Indonesia.'],
                ['name' => 'blog_title', 'label' => 'Blog: judul', 'type' => 'text', 'default' => 'Wawasan seputar *SIMRS*'],
                ['name' => 'blog_text', 'label' => 'Blog: deskripsi', 'type' => 'textarea', 'default' => 'Panduan praktis seputar SIMRS, bridging BPJS Kesehatan, dan SATUSEHAT, ditulis dari pengalaman implementasi di lapangan.'],
                ['name' => 'faq_title', 'label' => 'FAQ: judul', 'type' => 'text', 'default' => 'Pertanyaan yang sering diajukan'],
                ['name' => 'faq_text', 'label' => 'FAQ: deskripsi', 'type' => 'textarea', 'default' => 'Pertanyaan yang paling sering kami terima dari direktur dan kepala IT rumah sakit. Belum menemukan jawabannya? Hubungi kami melalui WhatsApp.'],
                ['name' => 'final_small', 'label' => 'Ajakan penutup: label kecil', 'type' => 'text', 'default' => 'Konsultasi awal gratis'],
                ['name' => 'final_title', 'label' => 'Ajakan penutup: judul', 'type' => 'text', 'default' => 'Siap menerapkan SIMRS yang terhubung?'],
                ['name' => 'final_text', 'label' => 'Ajakan penutup: deskripsi', 'type' => 'textarea', 'default' => 'Ceritakan kondisi rumah sakit Anda. Kami petakan kebutuhan, tunjukkan cara kerja Enigma Health, dan susun langkah implementasinya, tanpa biaya.'],
                ['name' => 'contact_title', 'label' => 'Kontak: judul', 'type' => 'text', 'default' => 'Ceritakan kebutuhan rumah sakit Anda'],
                ['name' => 'contact_text', 'label' => 'Kontak: deskripsi', 'type' => 'textarea', 'default' => 'Kami membalas di hari kerja yang sama.'],
            ],
        ],

        'tentang' => [
            'label' => 'Tentang kami',
            'fields' => [
                ['name' => 'about_intro', 'label' => 'Pembuka', 'type' => 'textarea', 'default' => 'PT Enigma Works Indonesia adalah penyedia Enigma Health, SIMRS untuk rumah sakit dan klinik, sekaligus integrator IT rumah sakit. Kami mengimplementasikan Enigma Health, menghubungkannya ke BPJS Kesehatan dan SATUSEHAT, lalu mendampingi rumah sakit sampai sistem benar-benar dipakai di setiap unit.'],
                ['name' => 'about_body', 'label' => 'Isi (Markdown)', 'type' => 'markdown', 'default' => "## Siapa kami\n\nPT Enigma Works Indonesia berkedudukan di Depok, Jawa Barat, dan saat ini berfokus melayani rumah sakit dan klinik di Medan dan Sumatera Utara, lalu seluruh Indonesia.\n\nEnigma Health disediakan oleh PT Enigma Works Indonesia dan diimplementasikan langsung oleh tim kami. Fokus kami adalah membuat SIMRS benar-benar dipakai: data pasien cukup dicatat sekali, terhubung ke BPJS Kesehatan dan SATUSEHAT, dan didukung perangkat serta jaringan yang andal.\n\n## Cerita kami\n\n[ISI CERITA PENDIRI]\n\n## Apa yang kami kerjakan\n\n- **SIMRS Enigma Health** untuk rumah sakit, ditambah versi ringkas untuk klinik dan apotek.\n- **Integrasi**: bridging BPJS Kesehatan, integrasi SATUSEHAT, dan aplikasi pendukung yang terhubung ke SIMRS.\n- **Infrastruktur**: hardware, jaringan, keamanan data, dan backup melalui principal resmi.\n- **Pendampingan**: pelatihan, helpdesk, dan maintenance dengan SLA yang jelas.\n\n## Kemitraan\n\n- **Mekari**: kami adalah partner resmi Mekari untuk HR, payroll, akuntansi, dan komunikasi pelanggan.\n- **Principal perangkat**: hardware dan jaringan diadakan melalui principal dan distributor resmi, sehingga garansi terjamin.\n\n## Cara kami bekerja\n\nSetiap proyek dimulai dari survei dan rancangan tertulis. Kami mendampingi rumah sakit sampai sistem berjalan dan staf terbiasa menggunakannya, lalu melanjutkan dengan dukungan dan pemeliharaan rutin."],
            ],
        ],
    ],

    'resources' => [

        'services' => [
            'label' => 'Layanan',
            'singular' => 'layanan',
            'model' => Service::class,
            'title' => 'name',
            'columns' => ['name' => 'Nama', 'group' => 'Kelompok', 'sort' => 'Urutan', 'is_active' => 'Aktif'],
            'fields' => [
                ['name' => 'name', 'label' => 'Nama layanan', 'type' => 'text', 'rules' => 'required|max:150'],
                ['name' => 'slug', 'label' => 'Slug URL', 'type' => 'text', 'rules' => 'required|alpha_dash|max:100', 'help' => 'Alamat halaman: /layanan/slug'],
                ['name' => 'group', 'label' => 'Kelompok', 'type' => 'select', 'options' => Service::GROUPS],
                ['name' => 'layer', 'label' => 'Label kecil di kartu', 'type' => 'text', 'help' => 'Contoh: Integrasi, Infrastruktur'],
                ['name' => 'icon', 'label' => 'Ikon', 'type' => 'select', 'options' => Service::ICONS],
                ['name' => 'badge', 'label' => 'Lencana (opsional)', 'type' => 'text', 'help' => 'Contoh: Layanan utama'],
                ['name' => 'short', 'label' => 'Ringkasan di kartu', 'type' => 'textarea', 'rules' => 'required'],
                ['name' => 'tags', 'label' => 'Tag / modul', 'type' => 'tags', 'help' => 'Pisahkan dengan koma'],
                ['name' => 'h1', 'label' => 'Judul halaman (H1)', 'type' => 'text'],
                ['name' => 'intro', 'label' => 'Paragraf pembuka halaman', 'type' => 'textarea'],
                ['name' => 'points', 'label' => 'Yang kami kerjakan (Judul | Penjelasan)', 'type' => 'pairs'],
                ['name' => 'faqs', 'label' => 'FAQ layanan (Pertanyaan | Jawaban)', 'type' => 'pairs'],
                ['name' => 'seo_title', 'label' => 'Judul di Google', 'type' => 'text'],
                ['name' => 'seo_description', 'label' => 'Deskripsi di Google', 'type' => 'textarea'],
                ['name' => 'sort', 'label' => 'Urutan', 'type' => 'number'],
                ['name' => 'is_active', 'label' => 'Tampilkan di website', 'type' => 'boolean'],
            ],
        ],

        'cities' => [
            'label' => 'Kota / area',
            'singular' => 'kota',
            'model' => City::class,
            'title' => 'name',
            'columns' => ['name' => 'Nama', 'has_page' => 'Punya halaman', 'sort' => 'Urutan'],
            'fields' => [
                ['name' => 'name', 'label' => 'Nama kota / kabupaten', 'type' => 'text', 'rules' => 'required|max:100'],
                ['name' => 'slug', 'label' => 'Slug URL', 'type' => 'text', 'rules' => 'required|alpha_dash|max:100', 'help' => 'Alamat halaman: /it-rumah-sakit/slug'],
                ['name' => 'has_page', 'label' => 'Buat halaman sendiri', 'type' => 'boolean', 'help' => 'Aktifkan hanya bila isinya benar-benar berbeda dari kota lain.'],
                ['name' => 'is_main', 'label' => 'Tandai sebagai kota utama', 'type' => 'boolean'],
                ['name' => 'h1', 'label' => 'Judul halaman (H1)', 'type' => 'text'],
                ['name' => 'intro', 'label' => 'Paragraf pembuka', 'type' => 'textarea'],
                ['name' => 'body', 'label' => 'Isi halaman', 'type' => 'textarea', 'help' => 'Pisahkan paragraf dengan baris kosong.'],
                ['name' => 'nearby', 'label' => 'Slug kota terdekat', 'type' => 'tags', 'help' => 'Contoh: medan, binjai'],
                ['name' => 'seo_title', 'label' => 'Judul di Google', 'type' => 'text'],
                ['name' => 'seo_description', 'label' => 'Deskripsi di Google', 'type' => 'textarea'],
                ['name' => 'sort', 'label' => 'Urutan', 'type' => 'number'],
            ],
        ],

        'case-studies' => [
            'label' => 'Studi kasus',
            'singular' => 'studi kasus',
            'model' => CaseStudy::class,
            'title' => 'client',
            'columns' => ['client' => 'Klien', 'quote_approved' => 'Testimoni disetujui', 'is_active' => 'Aktif'],
            'fields' => [
                ['name' => 'client', 'label' => 'Nama klien', 'type' => 'text', 'rules' => 'required|max:150'],
                ['name' => 'slug', 'label' => 'Slug URL', 'type' => 'text', 'rules' => 'required|alpha_dash|max:100'],
                ['name' => 'title', 'label' => 'Judul', 'type' => 'text', 'rules' => 'required'],
                ['name' => 'summary', 'label' => 'Ringkasan', 'type' => 'textarea'],
                ['name' => 'checks', 'label' => 'Poin hasil (satu per baris)', 'type' => 'lines'],
                ['name' => 'facts', 'label' => 'Fakta proyek (Label | Isi)', 'type' => 'pairs'],
                ['name' => 'sections', 'label' => 'Cerita lengkap (Subjudul | Isi)', 'type' => 'pairs'],
                ['name' => 'service_slugs', 'label' => 'Slug layanan terkait', 'type' => 'tags'],
                ['name' => 'quote', 'label' => 'Kutipan testimoni', 'type' => 'textarea'],
                ['name' => 'quote_by', 'label' => 'Nama pemberi testimoni', 'type' => 'text'],
                ['name' => 'quote_role', 'label' => 'Jabatan pemberi testimoni', 'type' => 'text'],
                ['name' => 'quote_approved', 'label' => 'Testimoni sudah disetujui rumah sakit', 'type' => 'boolean', 'help' => 'Bila belum dicentang, testimoni tidak tampil di website live.'],
                ['name' => 'image', 'label' => 'Foto', 'type' => 'image'],
                ['name' => 'seo_title', 'label' => 'Judul di Google', 'type' => 'text'],
                ['name' => 'seo_description', 'label' => 'Deskripsi di Google', 'type' => 'textarea'],
                ['name' => 'sort', 'label' => 'Urutan', 'type' => 'number'],
                ['name' => 'is_active', 'label' => 'Tampilkan di website', 'type' => 'boolean'],
            ],
        ],

        'portfolio' => [
            'label' => 'Portofolio',
            'singular' => 'portofolio',
            'model' => PortfolioItem::class,
            'title' => 'name',
            'columns' => ['name' => 'Nama', 'label' => 'Label', 'sort' => 'Urutan', 'is_active' => 'Aktif'],
            'fields' => [
                ['name' => 'name', 'label' => 'Nama rumah sakit', 'type' => 'text', 'rules' => 'required|max:150'],
                ['name' => 'label', 'label' => 'Label', 'type' => 'text', 'help' => 'Contoh: Proyek Enigma Works Indonesia'],
                ['name' => 'is_own', 'label' => 'Proyek sendiri', 'type' => 'boolean'],
                ['name' => 'text', 'label' => 'Keterangan', 'type' => 'textarea'],
                ['name' => 'image', 'label' => 'Foto', 'type' => 'image'],
                ['name' => 'link', 'label' => 'Link (opsional)', 'type' => 'text', 'help' => 'Contoh: /studi-kasus/rsu-serenapita'],
                ['name' => 'sort', 'label' => 'Urutan', 'type' => 'number'],
                ['name' => 'is_active', 'label' => 'Tampilkan di website', 'type' => 'boolean'],
            ],
        ],

        'faqs' => [
            'label' => 'FAQ beranda',
            'singular' => 'FAQ',
            'model' => Faq::class,
            'title' => 'question',
            'columns' => ['question' => 'Pertanyaan', 'sort' => 'Urutan', 'is_active' => 'Aktif'],
            'fields' => [
                ['name' => 'question', 'label' => 'Pertanyaan', 'type' => 'text', 'rules' => 'required|max:255'],
                ['name' => 'answer', 'label' => 'Jawaban', 'type' => 'textarea', 'rules' => 'required'],
                ['name' => 'sort', 'label' => 'Urutan', 'type' => 'number'],
                ['name' => 'is_active', 'label' => 'Tampilkan di website', 'type' => 'boolean'],
            ],
        ],

        'posts' => [
            'label' => 'Artikel blog',
            'singular' => 'artikel',
            'model' => Post::class,
            'title' => 'title',
            'order' => ['published_at', 'desc'],
            'columns' => ['title' => 'Judul', 'category' => 'Kategori', 'published_at' => 'Terbit', 'is_published' => 'Tayang'],
            'fields' => [
                ['name' => 'title', 'label' => 'Judul', 'type' => 'text', 'rules' => 'required|max:200', 'help' => 'Sebaiknya memuat kata kunci utama.'],
                ['name' => 'slug', 'label' => 'Slug URL', 'type' => 'text', 'rules' => 'required|alpha_dash|max:150', 'help' => 'Alamat artikel: /blog/slug'],
                ['name' => 'description', 'label' => 'Deskripsi di Google', 'type' => 'textarea', 'help' => 'Ideal 140–160 karakter.'],
                ['name' => 'category', 'label' => 'Kategori', 'type' => 'select', 'options' => Post::CATEGORIES],
                ['name' => 'cover', 'label' => 'Gambar sampul', 'type' => 'image'],
                ['name' => 'author', 'label' => 'Penulis', 'type' => 'text'],
                ['name' => 'body', 'label' => 'Isi artikel (Markdown)', 'type' => 'markdown', 'help' => 'Gunakan ## untuk subjudul, - untuk daftar, **teks** untuk tebal, [teks](/link) untuk tautan.'],
                ['name' => 'published_at', 'label' => 'Tanggal terbit', 'type' => 'datetime'],
                ['name' => 'is_published', 'label' => 'Tayangkan', 'type' => 'boolean'],
            ],
        ],
    ],
];
