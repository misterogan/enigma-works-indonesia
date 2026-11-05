# Kalender blog Enigma Health (November 2026 – Januari 2027)

Satu artikel per minggu, terbit setiap Kamis. Tanggal di front matter artikel menentukan kapan artikel tampil: artikel bertanggal di masa depan tersimpan di database tetapi baru tayang pada tanggalnya.

Kategori mengikuti `Post::CATEGORIES`: `simrs`, `bpjs`, `satusehat`, `infrastruktur`.

| # | Terbit | Judul | Kata kunci utama | Kategori | Ringkasan | Tautan ke layanan | Status |
|---|---|---|---|---|---|---|---|
| 1 | 5 Nov 2026 | Migrasi Data SIMRS: Langkah Aman Pindah ke Sistem Baru | migrasi data SIMRS | simrs | Cara memetakan, membersihkan, menguji, dan memindahkan data SIMRS lama tanpa menghentikan pelayanan. | /layanan/simrs | Ditulis (`migrasi-data-simrs-lama-ke-sistem-baru.md`) |
| 2 | 12 Nov 2026 | RME Klinik: Cara Memulai dan Terhubung ke SATUSEHAT | RME klinik | satusehat | Kewajiban RME, fitur yang perlu ada, dan langkah praktis klinik sampai data terkirim ke SATUSEHAT. | /layanan/integrasi-satusehat | Ditulis (`rekam-medis-elektronik-klinik-satusehat.md`) |
| 3 | 19 Nov 2026 | Spesifikasi Server SIMRS: Cara Menghitung Kebutuhan dari Jumlah Pengguna | server rumah sakit | infrastruktur | Cara memperkirakan kapasitas server dan penyimpanan SIMRS berdasarkan jumlah pengguna, unit, dan pertumbuhan data. | /layanan/hardware-jaringan | Rencana |
| 4 | 26 Nov 2026 | Antrean Online Mobile JKN: Persiapan Rumah Sakit dan Kendala yang Sering Muncul | antrean online BPJS | bpjs | Apa yang perlu disiapkan di SIMRS agar antrean Mobile JKN berjalan, beserta kendala jadwal dan kuota yang umum. | /layanan/bridging-bpjs | Rencana |
| 5 | 3 Des 2026 | Berapa Lama Implementasi SIMRS? Tahapan dari Survei sampai Go-Live | implementasi SIMRS | simrs | Faktor yang menentukan durasi implementasi SIMRS dan gambaran tahapan dari survei sampai pendampingan. | /layanan/simrs | Rencana |
| 6 | 10 Des 2026 | Data Master SATUSEHAT: Kenapa Lokasi, Tenaga Kesehatan, dan Kode Diagnosis Menentukan | data master SATUSEHAT | satusehat | Penyebab paling umum gagal kirim ke SATUSEHAT dan cara merapikan data master sebelum integrasi. | /layanan/integrasi-satusehat | Rencana |
| 7 | 17 Des 2026 | Jaringan Rumah Sakit: Desain LAN dan Wi-Fi agar SIMRS Tidak Lambat | jaringan rumah sakit | infrastruktur | Prinsip desain jaringan antargedung dan antarlantai, pemisahan jaringan, dan tanda jaringan yang perlu dibenahi. | /layanan/hardware-jaringan | Rencana |
| 8 | 24 Des 2026 | Klaim BPJS Tertunda: Penyebab dari Sisi Data dan Cara Mencegahnya lewat SIMRS | klaim BPJS rumah sakit | bpjs | Kesalahan data pelayanan yang sering membuat berkas klaim dikembalikan, dan cara SIMRS membantu mencegahnya. | /layanan/bridging-bpjs | Rencana |
| 9 | 31 Des 2026 | Dashboard Rumah Sakit: Indikator yang Perlu Dipantau Direksi Setiap Hari | dashboard rumah sakit | simrs | Indikator kunjungan, hunian, pendapatan, dan klaim yang layak tampil di dashboard manajemen. | /layanan/aplikasi-rumah-sakit | Rencana |
| 10 | 7 Jan 2027 | Ransomware di Rumah Sakit: Langkah Pencegahan dan Rencana Pemulihan | keamanan data rumah sakit | infrastruktur | Langkah praktis mencegah ransomware dan menyusun rencana pemulihan agar pelayanan cepat kembali normal. | /layanan/keamanan-data | Rencana |
| 11 | 14 Jan 2027 | Kontrak Maintenance SIMRS: Apa Saja yang Perlu Ada di Dalam SLA | SLA maintenance SIMRS | simrs | Isi kontrak maintenance yang melindungi rumah sakit: cakupan, waktu respons, prioritas, dan laporan. | /layanan/maintenance-sla | Rencana |
| 12 | 21 Jan 2027 | HR dan Payroll Rumah Sakit: Mengelola Jadwal Shift dan Penggajian dengan Mekari | HR payroll rumah sakit | simrs | Tantangan jadwal shift dan penggajian di rumah sakit, dan bagaimana Mekari membantu merapikannya. | /layanan/solusi-mekari | Rencana |

## Aturan penulisan

- 800–1.200 kata, minimal 3 subjudul `##`, satu kata kunci utama di judul dan paragraf pembuka.
- Tautan internal ke layanan terkait dan ke halaman kontak di penutup.
- Fakta regulasi hanya yang sudah pasti. Bila ragu, tulis lebih umum atau beri catatan `[CEK REGULASI]`.
- Jangan menyebut nama mitra teknologi, angka karangan, atau nama klien tanpa izin.
- Simpan sebagai `database/seeders/content/{slug}.md`, lalu jalankan `php artisan db:seed --class=RebrandSeeder` (artikel yang sudah ada tidak akan diubah).
