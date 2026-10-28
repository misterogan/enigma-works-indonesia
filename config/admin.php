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

use App\Models\Post;
use App\Models\Service;

return [

    'settings' => [

        'perusahaan' => [
            'label' => 'Perusahaan',
            'fields' => [
                ['name' => 'company_name', 'label' => 'Nama perusahaan', 'type' => 'text', 'default' => 'Enigma Works Indonesia'],
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
                ['name' => 'partner_line', 'label' => 'Teks kemitraan di footer', 'type' => 'text', 'default' => 'Partner DHealth dan partner resmi Mekari'],
            ],
        ],

        'seo' => [
            'label' => 'SEO beranda',
            'fields' => [
                ['name' => 'seo_title', 'label' => 'Judul di Google (title tag)', 'type' => 'text', 'help' => 'Ideal 50–60 karakter.', 'default' => 'SIMRS & Solusi IT Rumah Sakit di Medan | Enigma Works Indonesia'],
                ['name' => 'seo_description', 'label' => 'Deskripsi di Google', 'type' => 'textarea', 'help' => 'Ideal 140–160 karakter.', 'default' => 'SIMRS, bridging BPJS Kesehatan, integrasi SATUSEHAT, dan infrastruktur IT untuk rumah sakit dan klinik di Medan dan Sumatera Utara. Konsultasi gratis.'],
                ['name' => 'title_suffix', 'label' => 'Akhiran judul halaman lain', 'type' => 'text', 'default' => ' | Enigma Works Indonesia'],
            ],
        ],

        'banner' => [
            'label' => 'Banner utama',
            'fields' => [
                ['name' => 'announce_text', 'label' => 'Teks bar pengumuman (kosongkan untuk menyembunyikan)', 'type' => 'text', 'default' => 'Kini melayani integrasi SATUSEHAT untuk klinik dan apotek.'],
                ['name' => 'announce_link', 'label' => 'Link bar pengumuman', 'type' => 'text', 'default' => '/layanan/integrasi-satusehat'],
                ['name' => 'hero_title', 'label' => 'Judul banner (H1)', 'type' => 'text', 'help' => 'Beri *bintang* pada kata yang ingin bergradasi.', 'default' => 'Solusi SIMRS dan IT Rumah Sakit yang *Terintegrasi*'],
                ['name' => 'hero_subtitle', 'label' => 'Deskripsi banner', 'type' => 'textarea', 'default' => 'Kami membantu rumah sakit dan klinik menerapkan SIMRS yang terhubung ke BPJS Kesehatan dan SATUSEHAT, didukung infrastruktur IT yang andal. Melayani Medan, Sumatera Utara, dan seluruh Indonesia.'],
                ['name' => 'hero_badges', 'label' => 'Lencana (satu per baris, baris pertama huruf kapital)', 'type' => 'textarea', 'default' => "SIMRS terintegrasi\nBPJS & SATUSEHAT\nPartner resmi Mekari"],
                ['name' => 'hero_cta_primary', 'label' => 'Tombol utama', 'type' => 'text', 'default' => 'Konsultasi gratis'],
                ['name' => 'hero_cta_secondary', 'label' => 'Tombol kedua', 'type' => 'text', 'default' => 'Lihat layanan'],
                ['name' => 'logos_label', 'label' => 'Judul strip di bawah banner', 'type' => 'text', 'default' => 'Dipercaya dan terhubung dengan'],
                ['name' => 'logos_items', 'label' => 'Isi strip (satu per baris)', 'type' => 'textarea', 'default' => "RSU Serenapita\nBPJS Kesehatan\nSATUSEHAT Kemenkes\nMobile JKN\nMekari"],
                ['name' => 'ribbon_items', 'label' => 'Pita teks besar (satu per baris)', 'type' => 'textarea', 'default' => "Pendaftaran lebih cepat\nKlaim lebih rapi\nRekam medis lengkap\nPelayanan tanpa jeda"],
            ],
        ],

        'beranda' => [
            'label' => 'Bagian beranda',
            'fields' => [
                ['name' => 'hub_pill', 'label' => 'Hub: label kecil', 'type' => 'text', 'default' => 'Satu pusat data'],
                ['name' => 'hub_title', 'label' => 'Hub: judul', 'type' => 'text', 'default' => 'Satu SIMRS, *semua unit terhubung*'],
                ['name' => 'hub_text', 'label' => 'Hub: deskripsi', 'type' => 'textarea', 'default' => 'Data pasien cukup dicatat sekali, lalu dipakai bersama oleh pendaftaran, poliklinik, penunjang, farmasi, dan kasir, hingga klaim BPJS dan pelaporan ke SATUSEHAT.'],
                ['name' => 'services_title', 'label' => 'Layanan: judul', 'type' => 'text', 'default' => 'Solusi IT lengkap untuk *rumah sakit dan klinik*'],
                ['name' => 'services_text', 'label' => 'Layanan: deskripsi', 'type' => 'textarea', 'default' => 'Dari perangkat lunak, integrasi, hingga perangkat keras dan pemeliharaan, semuanya ditangani satu tim yang memahami alur kerja rumah sakit.'],
                ['name' => 'proof_title', 'label' => 'Bukti: judul', 'type' => 'text', 'default' => 'Sudah berjalan di *rumah sakit*'],
                ['name' => 'proof_text', 'label' => 'Bukti: deskripsi', 'type' => 'textarea', 'default' => 'Kami menerapkan platform SIMRS yang telah digunakan banyak rumah sakit di Indonesia, lalu memastikan setiap integrasinya berjalan di rumah sakit Anda.'],
                ['name' => 'stats', 'label' => 'Angka (format: Angka | Keterangan)', 'type' => 'textarea', 'default' => "15+ | rumah sakit aktif menggunakan platform DHealth\n10+ | tahun pengalaman DHealth di teknologi kesehatan\n2.000+ | pasien dilayani setiap hari melalui platform DHealth\nISO | 9001 dan 27001 milik DHealth, terdaftar PSE Komdigi"],
                ['name' => 'stats_note', 'label' => 'Catatan di bawah angka', 'type' => 'text', 'default' => 'Angka dan sertifikasi platform DHealth, mitra teknologi kami.'],
                ['name' => 'portfolio_title', 'label' => 'Portofolio: judul', 'type' => 'text', 'default' => 'Platform yang sudah teruji'],
                ['name' => 'portfolio_text', 'label' => 'Portofolio: deskripsi', 'type' => 'textarea', 'default' => 'SIMRS yang kami terapkan dikembangkan bersama mitra teknologi kami, DHealth. Berikut proyek kami dan rumah sakit lain yang menggunakan platform tersebut.'],
                ['name' => 'portfolio_more', 'label' => 'Portofolio: catatan tambahan', 'type' => 'text', 'default' => 'Pengguna DHealth lainnya: RSU Adhyaksa, RS Kramat 128, dan RS Kebonjati.'],
                ['name' => 'process_title', 'label' => 'Proses: judul', 'type' => 'text', 'default' => 'Proses kerja yang *jelas*'],
                ['name' => 'process_text', 'label' => 'Proses: deskripsi', 'type' => 'textarea', 'default' => 'Setiap tahap disepakati sejak awal, sehingga rumah sakit tahu apa yang dikerjakan, kapan, dan oleh siapa.'],
                ['name' => 'process_steps', 'label' => 'Tahapan (format: Judul | Penjelasan)', 'type' => 'textarea', 'default' => "Survei | Kami mempelajari alur pelayanan, sistem yang berjalan, dan perangkat yang tersedia.\nRancangan | Solusi, jadwal, dan biaya disusun tertulis sebelum pekerjaan dimulai.\nImplementasi | Instalasi, migrasi data, bridging BPJS, dan integrasi SATUSEHAT.\nPelatihan | Staf setiap unit didampingi sampai mahir menggunakan sistem.\nPendampingan | Dukungan dan pemeliharaan rutin sesuai kesepakatan layanan."],
                ['name' => 'area_title', 'label' => 'Area: judul', 'type' => 'text', 'default' => 'Melayani Medan dan seluruh Sumatera Utara'],
                ['name' => 'area_text', 'label' => 'Area: deskripsi', 'type' => 'textarea', 'default' => 'Tim kami datang langsung untuk survei, instalasi, dan pelatihan. Setelah sistem berjalan, dukungan harian dilakukan dari jarak jauh, disertai kunjungan berkala sesuai kontrak.'],
                ['name' => 'blog_title', 'label' => 'Blog: judul', 'type' => 'text', 'default' => 'Wawasan seputar *SIMRS*'],
                ['name' => 'blog_text', 'label' => 'Blog: deskripsi', 'type' => 'textarea', 'default' => 'Panduan praktis tentang SIMRS, BPJS, dan SATUSEHAT dari pengalaman kami di lapangan.'],
                ['name' => 'faq_title', 'label' => 'FAQ: judul', 'type' => 'text', 'default' => 'Pertanyaan yang sering diajukan'],
                ['name' => 'faq_text', 'label' => 'FAQ: deskripsi', 'type' => 'textarea', 'default' => 'Belum menemukan jawabannya? Hubungi kami melalui WhatsApp.'],
                ['name' => 'final_small', 'label' => 'Ajakan penutup: label kecil', 'type' => 'text', 'default' => 'Konsultasi awal gratis'],
                ['name' => 'final_title', 'label' => 'Ajakan penutup: judul', 'type' => 'text', 'default' => 'Siap membenahi sistem rumah sakit Anda?'],
                ['name' => 'final_text', 'label' => 'Ajakan penutup: deskripsi', 'type' => 'textarea', 'default' => 'Ceritakan kebutuhan Anda. Tim kami akan membantu memetakan solusi yang paling sesuai, tanpa biaya.'],
                ['name' => 'contact_title', 'label' => 'Kontak: judul', 'type' => 'text', 'default' => 'Ceritakan kebutuhan rumah sakit Anda'],
                ['name' => 'contact_text', 'label' => 'Kontak: deskripsi', 'type' => 'textarea', 'default' => 'Kami membalas di hari kerja yang sama.'],
            ],
        ],

        'tentang' => [
            'label' => 'Tentang kami',
            'fields' => [
                ['name' => 'about_intro', 'label' => 'Pembuka', 'type' => 'textarea', 'default' => 'Enigma Works Indonesia adalah integrator IT untuk rumah sakit dan klinik. Kami membantu fasilitas kesehatan menerapkan sistem yang terhubung, stabil, dan benar-benar digunakan oleh staf di setiap unit.'],
                ['name' => 'about_body', 'label' => 'Isi (Markdown)', 'type' => 'markdown', 'default' => "## Siapa kami\n\nKami berfokus pada perangkat lunak dan integrasi: implementasi SIMRS, bridging BPJS Kesehatan, integrasi SATUSEHAT, serta aplikasi pendukung yang disesuaikan dengan kebutuhan rumah sakit.\n\nUntuk perangkat keras, jaringan, dan keamanan data, kami bekerja sama dengan principal resmi, sehingga rumah sakit cukup berurusan dengan satu mitra.\n\n## Kemitraan\n\n- **DHealth**, mitra teknologi untuk platform SIMRS yang kami terapkan.\n- **Mekari**, partner resmi untuk solusi HR, payroll, akuntansi, dan komunikasi pelanggan.\n\n## Cara kami bekerja\n\nSetiap proyek dimulai dari survei dan rancangan tertulis. Kami mendampingi rumah sakit sampai sistem berjalan dan staf terbiasa menggunakannya, lalu melanjutkan dengan dukungan dan pemeliharaan rutin."],
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
            'model' => App\Models\City::class,
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
            'model' => App\Models\CaseStudy::class,
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
            'model' => App\Models\PortfolioItem::class,
            'title' => 'name',
            'columns' => ['name' => 'Nama', 'label' => 'Label', 'sort' => 'Urutan', 'is_active' => 'Aktif'],
            'fields' => [
                ['name' => 'name', 'label' => 'Nama rumah sakit', 'type' => 'text', 'rules' => 'required|max:150'],
                ['name' => 'label', 'label' => 'Label', 'type' => 'text', 'help' => 'Contoh: Proyek Enigma Works Indonesia, atau Pengguna DHealth, Pekanbaru'],
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
            'model' => App\Models\Faq::class,
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
