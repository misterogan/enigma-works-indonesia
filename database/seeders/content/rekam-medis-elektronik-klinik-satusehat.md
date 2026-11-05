---
title: RME Klinik: Cara Memulai dan Terhubung ke SATUSEHAT
description: Panduan RME klinik: kewajiban rekam medis elektronik, fitur yang perlu ada, persiapan data, langkah terhubung ke SATUSEHAT, dan kesalahan yang sering terjadi.
date: 2026-11-12
category: satusehat
author: Tim Enigma Works Indonesia
---

Banyak klinik pratama dan klinik utama masih mencatat pemeriksaan pasien di kartu kertas atau di aplikasi sederhana yang tidak terhubung ke mana pun. Sejak terbitnya Peraturan Menteri Kesehatan Nomor 24 Tahun 2022 tentang Rekam Medis, kondisi itu tidak lagi cukup. Setiap fasilitas pelayanan kesehatan, termasuk klinik, wajib menyelenggarakan rekam medis elektronik (RME) dan terhubung dengan SATUSEHAT, platform data kesehatan milik Kementerian Kesehatan.

Bagi klinik dengan tim kecil, kewajiban ini sering terasa berat. Kabar baiknya, memulai RME klinik tidak harus rumit. Artikel ini membahas apa yang perlu disiapkan, fitur yang sebaiknya ada, dan langkah praktis sampai data klinik terkirim ke SATUSEHAT.

## Apa yang diwajibkan

Secara garis besar, Permenkes 24/2022 mengatur bahwa rekam medis diselenggarakan secara elektronik, dijaga kerahasiaannya, dan datanya dapat dipertukarkan melalui platform yang ditetapkan Kementerian Kesehatan, yaitu SATUSEHAT. Batas waktu transisi dan ketentuan teknis turunannya beberapa kali diperjelas melalui surat edaran dan petunjuk teknis. [CEK REGULASI: batas waktu dan sanksi terbaru yang berlaku untuk klinik.]

Selain itu, data kesehatan termasuk data pribadi yang bersifat spesifik menurut Undang-Undang Nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi. Artinya, klinik juga bertanggung jawab menjaga siapa saja yang boleh membuka data pasien dan bagaimana data itu disimpan.

Dua hal ini menjadi dasar dalam memilih sistem: RME yang dipakai harus mampu mengirim data ke SATUSEHAT, dan harus punya pengaturan akses yang jelas.

## Fitur RME klinik yang sebaiknya ada

Klinik tidak membutuhkan semua modul yang dipakai rumah sakit besar. Namun, beberapa fitur sebaiknya sudah tersedia sejak awal:

- **Pendaftaran dan antrean.** Identitas pasien dicatat sekali, termasuk NIK, lalu dipakai di semua kunjungan berikutnya.
- **Pemeriksaan dokter.** Anamnesis, pemeriksaan fisik, diagnosis dengan kode ICD-10, dan tindakan tercatat dalam satu layar yang cepat diisi.
- **Resep elektronik dan farmasi.** Resep dari dokter langsung masuk ke bagian obat, lengkap dengan stoknya.
- **Kasir.** Tagihan terbentuk dari layanan dan obat yang diberikan, tanpa menghitung ulang.
- **Riwayat pasien.** Dokter bisa melihat kunjungan sebelumnya sebelum memeriksa pasien.
- **Pengiriman ke SATUSEHAT.** Data kunjungan dan diagnosis terkirim, dan klinik bisa melihat bila ada data yang gagal terkirim.
- **Hak akses per peran.** Petugas pendaftaran, dokter, perawat, dan kasir hanya melihat data yang memang dibutuhkan.

Bila klinik melayani pasien JKN sebagai fasilitas kesehatan tingkat pertama, perlu juga dipastikan bagaimana sistem RME bekerja berdampingan dengan aplikasi yang disediakan BPJS Kesehatan untuk FKTP. [CEK REGULASI: ketentuan integrasi FKTP dengan BPJS Kesehatan yang berlaku.]

## Persiapan sebelum terhubung ke SATUSEHAT

Sebagian besar kegagalan pengiriman data ke SATUSEHAT tidak disebabkan oleh aplikasinya, tetapi oleh data dasar yang belum siap. Karena itu, siapkan beberapa hal berikut sejak awal.

**Data organisasi dan kredensial.** Klinik perlu terdaftar dan memiliki akses ke lingkungan pengembangan (sandbox) dan produksi SATUSEHAT. Proses ini dilakukan melalui kanal resmi Kementerian Kesehatan, dan biasanya memerlukan penanggung jawab dari pihak klinik.

**Data lokasi.** Ruang pemeriksaan, ruang tindakan, dan unit lain didaftarkan sebagai lokasi, karena setiap kunjungan dikaitkan dengan lokasi tempat pelayanan diberikan.

**Data tenaga kesehatan.** Dokter dan tenaga kesehatan lain perlu dicocokkan dengan data mereka di SATUSEHAT. Nama atau NIK yang tidak sesuai akan membuat data kunjungan ditolak.

**NIK pasien.** Pengiriman data pasien membutuhkan identitas yang valid. Biasakan petugas pendaftaran mencatat NIK dengan benar sejak hari pertama.

**Kode diagnosis.** Diagnosis yang ditulis bebas tanpa kode akan menyulitkan pengiriman. Gunakan kode ICD-10 yang sudah tersedia di sistem.

## Langkah praktis memulai

Untuk klinik yang baru memulai RME, kami biasanya menyarankan urutan berikut:

1. **Pilih sistem yang sudah mendukung SATUSEHAT.** Mengembangkan integrasi sendiri membutuhkan waktu dan tenaga teknis yang jarang dimiliki klinik.
2. **Siapkan perangkat dan jaringan.** Komputer di meja pendaftaran, ruang dokter, farmasi, dan kasir, ditambah koneksi internet yang stabil.
3. **Masukkan data master.** Dokter, jadwal, tarif, obat, dan lokasi diisi dan diperiksa sebelum sistem dipakai.
4. **Latih petugas.** Pelatihan singkat per peran, disertai simulasi alur pasien dari pendaftaran sampai kasir.
5. **Uji kirim di sandbox.** Kirim beberapa data kunjungan percobaan ke lingkungan uji SATUSEHAT dan perbaiki bila ada penolakan.
6. **Mulai di produksi.** Setelah uji berhasil, aktifkan pengiriman di lingkungan produksi dan pantau hasilnya setiap hari pada minggu-minggu awal.

## Kesalahan yang sering terjadi

Dari pengalaman mendampingi fasilitas kesehatan, beberapa kesalahan berikut paling sering muncul:

- **Menganggap RME hanya urusan aplikasi.** Tanpa kebiasaan baru di meja pendaftaran dan ruang dokter, data tetap tidak lengkap.
- **Mencatat ulang di kertas.** Bila dokter tetap menulis di kartu kertas lalu petugas menyalinnya ke sistem, beban kerja justru bertambah.
- **Tidak memantau data yang gagal terkirim.** Data yang ditolak SATUSEHAT perlu diperbaiki dan dikirim ulang, bukan dibiarkan menumpuk.
- **Akun bersama.** Satu akun dipakai beramai-ramai membuat jejak akses tidak jelas, padahal data pasien termasuk data pribadi yang dilindungi.
- **Tidak ada backup.** RME yang tersimpan di satu komputer tanpa salinan cadangan berisiko hilang bila perangkat rusak.

## Penutup

Rekam medis elektronik untuk klinik tidak harus dimulai dengan sistem besar dan mahal. Yang penting adalah sistem yang mampu mengirim data ke SATUSEHAT, data dasar yang rapi, dan petugas yang terbiasa mencatat langsung di sistem.

Untuk klinik pratama, klinik utama, dan apotek, tersedia [Enigma Health versi ringkas](/layanan/simrs) yang sudah membawa rekam medis elektronik dan pengiriman data ke SATUSEHAT. Tim kami juga mendampingi proses [integrasi SATUSEHAT](/layanan/integrasi-satusehat), dari kredensial sampai pemantauan pengiriman. Bila klinik Anda berada di Medan atau Sumatera Utara, [hubungi kami untuk konsultasi gratis](/kontak).
