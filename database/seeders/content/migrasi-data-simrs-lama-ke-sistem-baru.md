---
title: Migrasi Data SIMRS: Langkah Aman Pindah ke Sistem Baru
description: Panduan migrasi data SIMRS: data yang dipindahkan, cara membersihkan data master, uji coba, dan strategi go-live agar pelayanan rumah sakit tetap berjalan.
date: 2026-11-05
category: simrs
author: Tim Enigma Works Indonesia
---

Keputusan mengganti SIMRS biasanya datang setelah rumah sakit lama bertahan dengan sistem yang tidak lagi memadai: modul tidak lengkap, belum terhubung ke BPJS Kesehatan atau SATUSEHAT, atau vendor lama sulit dihubungi. Begitu keputusan diambil, pertanyaan berikutnya hampir selalu sama: bagaimana dengan data yang sudah ada?

Data pasien, riwayat kunjungan, tarif, dan stok obat adalah aset rumah sakit. Migrasi yang terburu-buru bisa membuat nomor rekam medis ganda, riwayat pasien hilang, atau tagihan salah hitung pada hari pertama sistem baru dipakai. Artikel ini merangkum langkah migrasi data SIMRS yang kami pakai di lapangan, agar perpindahan berjalan aman dan pelayanan tidak terhenti.

## Kenali dulu data yang akan dipindahkan

Langkah pertama bukan memindahkan data, tetapi memetakan apa saja yang ada di sistem lama. Secara umum, data SIMRS terbagi menjadi tiga kelompok.

**Data master** adalah data acuan yang dipakai sehari-hari: daftar dokter, poliklinik, ruang dan kelas perawatan, tarif tindakan, daftar obat dan bahan medis habis pakai, penjamin, serta pengguna sistem. Data ini wajib dipindahkan dan wajib rapi, karena seluruh transaksi baru bergantung padanya.

**Data pasien** mencakup identitas pasien dan nomor rekam medis. Ini data yang paling sensitif dan paling sering bermasalah, misalnya satu pasien tercatat dua kali dengan ejaan nama berbeda.

**Data transaksi** adalah riwayat kunjungan, diagnosis, tindakan, resep, hasil penunjang, dan tagihan. Tidak semua rumah sakit perlu memindahkan seluruh riwayat transaksi ke sistem baru. Kadang cukup memindahkan riwayat beberapa tahun terakhir, sementara data yang lebih lama tetap bisa dibuka dari arsip sistem lama dalam mode baca saja.

Keputusan tentang seberapa jauh riwayat dipindahkan sebaiknya diambil bersama unit rekam medis, karena berkaitan dengan kewajiban penyimpanan rekam medis. [CEK REGULASI: ketentuan masa simpan rekam medis elektronik yang berlaku.]

## Bersihkan data sebelum dipindahkan

Memindahkan data kotor ke sistem baru hanya memindahkan masalah. Karena itu, sebelum migrasi kami menjalankan pemeriksaan sederhana bersama tim rumah sakit:

- **Pasien ganda.** Cari pasien dengan nama, tanggal lahir, dan alamat yang mirip. Penggabungan dilakukan oleh petugas rekam medis, bukan otomatis oleh sistem, karena keputusan ini berdampak pada riwayat klinis.
- **NIK dan nomor kartu JKN.** Data identitas yang kosong atau tidak valid akan menyulitkan bridging BPJS Kesehatan dan pengiriman data ke SATUSEHAT di kemudian hari.
- **Tarif dan obat yang sudah tidak dipakai.** Nonaktifkan atau buang item lama agar daftar di sistem baru lebih ringkas dan petugas tidak salah pilih.
- **Kode diagnosis dan tindakan.** Pastikan kode yang dipakai mengikuti standar, karena kode ini dipakai untuk klaim dan pelaporan.

Pembersihan data biasanya memakan waktu lebih lama dari perkiraan. Itu wajar. Waktu yang dihabiskan di tahap ini jauh lebih murah dibandingkan memperbaiki kesalahan setelah sistem baru berjalan.

## Pemetaan dan uji coba migrasi

Setelah data bersih, kolom-kolom di sistem lama dipetakan ke struktur di sistem baru. Misalnya, kode poliklinik lama dipadankan dengan kode poliklinik baru, dan status pembayaran lama diterjemahkan ke status yang dikenal SIMRS baru.

Migrasi tidak langsung dilakukan ke sistem produksi. Kami menjalankan **migrasi uji** ke lingkungan percobaan terlebih dahulu, lalu meminta perwakilan setiap unit memeriksa hasilnya:

1. Petugas pendaftaran mencari beberapa pasien lama dan memastikan identitasnya benar.
2. Perawat dan dokter membuka riwayat kunjungan beberapa pasien dan mencocokkannya dengan sistem lama.
3. Farmasi memeriksa daftar obat dan saldo stok.
4. Kasir mencoba membuat tagihan dengan tarif yang sudah dipindahkan.

Setiap temuan dicatat, diperbaiki di skrip migrasi, lalu migrasi uji diulang. Biasanya diperlukan dua sampai tiga putaran sampai hasilnya dinyatakan layak oleh rumah sakit.

## Strategi go-live: kapan sistem lama dimatikan

Ada dua pendekatan yang umum dipakai.

**Go-live serentak.** Seluruh unit pindah ke sistem baru pada hari yang sama, biasanya di akhir pekan atau tanggal dengan kunjungan rendah. Data transaksi terakhir dari sistem lama dipindahkan pada malam sebelumnya. Pendekatan ini cepat, tetapi menuntut persiapan dan pelatihan yang matang.

**Go-live bertahap.** Unit dipindahkan satu per satu, misalnya dimulai dari rawat jalan, lalu farmasi, rawat inap, dan IGD. Risikonya lebih kecil, tetapi selama masa transisi perlu ada jembatan agar data dari unit yang sudah pindah tetap terbaca oleh unit yang belum pindah.

Apa pun pendekatannya, beberapa hal sebaiknya selalu ada:

- **Pembekuan data.** Tentukan waktu ketika sistem lama tidak lagi menerima transaksi baru, agar tidak ada data yang tertinggal.
- **Prosedur cadangan.** Siapkan formulir manual untuk berjaga-jaga bila terjadi kendala di jam pertama, beserta petugas yang bertanggung jawab memasukkannya kembali ke sistem.
- **Pendampingan di lokasi.** Tim implementasi hadir di setiap unit pada hari-hari awal untuk menjawab pertanyaan dan menangani kendala secara langsung.
- **Sistem lama tetap tersedia untuk dibaca.** Jangan langsung mematikan server lama. Biarkan tetap bisa dibuka dalam mode baca sampai rumah sakit yakin semua data sudah aman.

## Hal yang sering terlupa

Beberapa detail kecil sering baru disadari setelah go-live:

- **Nomor rekam medis.** Tentukan sejak awal apakah format nomor lama dipertahankan atau diganti. Mengganti format berarti kartu pasien dan label berkas juga perlu disesuaikan.
- **Saldo awal.** Stok obat, deposit pasien rawat inap, dan piutang penjamin perlu dihitung ulang pada saat pembekuan data.
- **Hak akses.** Akun pengguna di sistem baru sebaiknya dibuat ulang sesuai peran, bukan disalin mentah dari sistem lama.
- **Integrasi.** Kredensial bridging BPJS Kesehatan dan SATUSEHAT perlu dipindahkan dan diuji di sistem baru sebelum hari go-live, agar penerbitan SEP tidak terhambat.

## Penutup

Migrasi data SIMRS bukan sekadar pekerjaan teknis memindahkan tabel. Keberhasilannya ditentukan oleh data yang bersih, uji coba bersama pengguna, dan rencana go-live yang realistis. Dengan langkah-langkah di atas, rumah sakit bisa berpindah sistem tanpa menghentikan pelayanan pasien.

Migrasi data menjadi bagian dari setiap implementasi [SIMRS Enigma Health](/layanan/simrs), termasuk pengujian ulang [bridging BPJS Kesehatan](/layanan/bridging-bpjs) dan [integrasi SATUSEHAT](/layanan/integrasi-satusehat) di sistem baru. Jika rumah sakit Anda sedang mempertimbangkan pergantian SIMRS, [konsultasikan kondisi sistem lama Anda dengan tim kami](/kontak), tanpa biaya.
