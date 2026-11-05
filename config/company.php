<?php

/*
|--------------------------------------------------------------------------
| Company profile PT Enigma Works Indonesia (enigmaworks.web.id)
|--------------------------------------------------------------------------
| Satu halaman yang hanya tampil di domain company profile. Seluruh teks ada
| di sini agar mudah diubah tanpa menyentuh view.
|
| Nilai yang masih berisi "[ISI ...]" tidak ditampilkan di website sampai
| diganti dengan data asli. Kontak (telepon, WhatsApp, email, alamat) diambil
| dari Pengaturan → Perusahaan di backoffice; nilai di 'contact' hanya cadangan.
*/

return [

    'domain' => env('COMPANY_DOMAIN', 'enigmaworks.web.id'),
    'main_url' => rtrim(env('MAIN_URL', 'https://enigmaworks.online'), '/'),

    'name' => 'Enigma Works Indonesia',
    'legal_name' => 'PT Enigma Works Indonesia',
    'nib' => '[ISI NIB]',

    'seo' => [
        'title' => 'Enigma Works Indonesia | Perusahaan Teknologi & Integrasi Sistem',
        'description' => 'PT Enigma Works Indonesia: pengembangan perangkat lunak, integrasi sistem, dan infrastruktur IT, dengan spesialisasi solusi teknologi untuk sektor kesehatan.',
    ],

    'contact' => [
        'phone' => '0838-7464-3903',
        'phone_e164' => '+6283874643903',
        'whatsapp' => '6283874643903',
        'email' => 'info@enigmaworks.co.id',
        'street' => 'Perumahan Golden Estesia, Jl. Serua Raya No. 56',
        'city' => 'Depok',
        'region' => 'Jawa Barat',
        'hours' => '[ISI JAM KERJA]',
    ],

    'nav' => [
        'tentang' => 'Tentang',
        'layanan' => 'Layanan',
        'produk' => 'Produk',
        'cara-kerja' => 'Cara Kerja',
        'kontak' => 'Kontak',
    ],

    'hero' => [
        'eyebrow' => 'Perusahaan teknologi · Integrasi sistem',
        'title' => 'Membangun dan menghubungkan sistem yang *menggerakkan bisnis Anda*',
        'subtitle' => 'PT Enigma Works Indonesia adalah perusahaan teknologi yang berfokus pada pengembangan perangkat lunak, integrasi sistem, dan infrastruktur IT, dengan spesialisasi di sektor kesehatan.',
        'cta_primary' => 'Lihat layanan',
        'cta_secondary' => 'Konsultasi',
        'highlights' => ['Perangkat lunak', 'Integrasi sistem', 'Infrastruktur IT', 'Teknologi kesehatan'],
    ],

    'about' => [
        'label' => 'Tentang kami',
        'title' => 'Teknologi yang dipakai, bukan sekadar terpasang',
        'paragraphs' => [
            'Kami membangun perangkat lunak, menghubungkan sistem yang sudah ada, dan menyiapkan infrastruktur yang menjalankannya. Fokus kami adalah hasil yang benar-benar dipakai oleh pengguna sehari-hari.',
            'Sektor kesehatan menjadi spesialisasi kami. Di rumah sakit dan klinik, sistem harus berjalan tanpa jeda dan terhubung dengan layanan nasional. Pengalaman itu kami bawa ke setiap proyek, termasuk di luar sektor kesehatan.',
            'Setiap pekerjaan dimulai dari memahami proses bisnis klien. Rancangan, jadwal, dan biaya disepakati tertulis sebelum pekerjaan dimulai.',
        ],
        'founder_story' => '[ISI CERITA PENDIRI]',
        'team_photo' => '[ISI FOTO TIM]',
        'vision' => 'Menjadi mitra teknologi yang dipercaya untuk membangun sistem yang terhubung, andal, dan mudah digunakan, dimulai dari sektor kesehatan di Indonesia.',
        'mission' => [
            'Membangun perangkat lunak yang sesuai dengan proses kerja nyata klien.',
            'Menghubungkan aplikasi dan data agar informasi cukup dicatat sekali.',
            'Menyediakan infrastruktur yang stabil dan aman untuk menjalankan sistem.',
            'Mendampingi klien setelah implementasi dengan dukungan yang jelas.',
        ],
    ],

    'services' => [
        'label' => 'Layanan',
        'title' => 'Kapabilitas kami',
        'text' => 'Dari perangkat lunak sampai infrastruktur, ditangani satu tim yang memahami bisnis Anda.',
        'items' => [
            ['icon' => 'code', 'title' => 'Pengembangan perangkat lunak', 'text' => 'Aplikasi web dan mobile yang dibangun sesuai kebutuhan dan proses bisnis Anda.'],
            ['icon' => 'link', 'title' => 'Integrasi sistem', 'text' => 'Menghubungkan aplikasi, API, dan data antarsistem agar informasi mengalir tanpa input ulang.'],
            ['icon' => 'health', 'title' => 'Solusi IT kesehatan', 'text' => 'SIMRS, bridging BPJS Kesehatan, integrasi SATUSEHAT, dan pertukaran data HL7/FHIR.'],
            ['icon' => 'server', 'title' => 'Infrastruktur & jaringan', 'text' => 'Server, perangkat, serta LAN dan Wi-Fi yang diadakan melalui principal resmi.'],
            ['icon' => 'shield', 'title' => 'Keamanan data & backup', 'text' => 'Pengaturan hak akses, antivirus terpusat, backup terjadwal, dan uji pemulihan berkala.'],
            ['icon' => 'support', 'title' => 'Managed service & maintenance', 'text' => 'Helpdesk, pemantauan, dan pemeliharaan rutin dengan waktu respons yang disepakati dalam SLA.'],
        ],
    ],

    'products' => [
        'label' => 'Produk & kemitraan',
        'title' => 'Produk dan mitra kami',
        'main' => [
            'badge' => 'Produk',
            'name' => 'Enigma Health',
            'tagline' => 'SIMRS terintegrasi untuk rumah sakit dan klinik',
            'text' => 'Pendaftaran, rekam medis elektronik, penunjang, farmasi, kasir, hingga klaim dalam satu sistem yang terhubung ke BPJS Kesehatan dan SATUSEHAT. Disediakan dan diimplementasikan oleh PT Enigma Works Indonesia.',
            'points' => ['Rekam medis elektronik', 'Bridging BPJS Kesehatan', 'Integrasi SATUSEHAT', 'Versi ringkas untuk klinik'],
            'cta' => 'Kunjungi Enigma Health',
        ],
        'partner' => [
            'badge' => 'Partner resmi',
            'name' => 'Mekari',
            'tagline' => 'Solusi HR, payroll, dan akuntansi',
            'text' => 'Sebagai partner resmi Mekari, kami membantu memilih, menerapkan, dan menghubungkan solusi Mekari dengan operasional perusahaan Anda.',
        ],
    ],

    'projects' => [
        'label' => 'Proyek',
        'title' => 'Proyek yang sedang berjalan',
        'items' => [
            [
                'name' => 'RSU Serenapita',
                'tag' => 'Kesehatan',
                'text' => 'Implementasi SIMRS dengan bridging BPJS Kesehatan dan integrasi SATUSEHAT yang sudah aktif.',
                'link' => '/studi-kasus/rsu-serenapita',
            ],
            [
                'name' => '[ISI PROYEK BERIKUTNYA]',
                'tag' => '[ISI BIDANG]',
                'text' => '[ISI RINGKASAN PROYEK]',
                'link' => null,
            ],
        ],
    ],

    'process' => [
        'label' => 'Cara kerja',
        'title' => 'Lima langkah yang jelas',
        'steps' => [
            ['Konsultasi & survei', 'Kami mempelajari proses bisnis, sistem yang berjalan, dan kebutuhan Anda.'],
            ['Rancangan solusi', 'Solusi, jadwal, dan biaya disusun tertulis dan disepakati bersama.'],
            ['Pengembangan / implementasi', 'Sistem dibangun atau dipasang bertahap, dengan uji coba di setiap tahap.'],
            ['Pelatihan & serah terima', 'Pengguna dilatih sampai terbiasa, lalu sistem dan dokumentasinya diserahkan.'],
            ['Dukungan berkelanjutan', 'Helpdesk dan pemeliharaan rutin sesuai kesepakatan layanan.'],
        ],
    ],

    'why' => [
        'label' => 'Mengapa kami',
        'title' => 'Satu mitra, tanggung jawab yang jelas',
        'items' => [
            ['Memahami proses bisnis', 'Kami mulai dari cara kerja Anda, bukan dari fitur aplikasi.'],
            ['Dari software sampai infrastruktur', 'Satu mitra untuk aplikasi, integrasi, perangkat, dan jaringan.'],
            ['Dukungan langsung ke lokasi', 'Tim hadir untuk survei, implementasi, dan pelatihan di tempat klien.'],
            ['Transparan', 'Rancangan dan biaya disampaikan tertulis sebelum pekerjaan dimulai.'],
        ],
    ],

    'contact_section' => [
        'label' => 'Kontak',
        'title' => 'Ceritakan kebutuhan Anda',
        'text' => 'Konsultasi awal tanpa biaya. Isi formulir dan pesan akan terbuka di WhatsApp, siap dikirim.',
        'needs' => ['Pengembangan perangkat lunak', 'Integrasi sistem', 'Solusi IT kesehatan / Enigma Health', 'Infrastruktur & jaringan', 'Keamanan data & backup', 'Managed service & maintenance', 'Mekari', 'Lainnya'],
    ],
];
