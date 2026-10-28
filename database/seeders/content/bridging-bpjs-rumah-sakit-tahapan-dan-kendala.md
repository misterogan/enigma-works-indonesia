---
title: Bridging BPJS Kesehatan untuk Rumah Sakit: Tahapan dan Kendala yang Sering Muncul
description: Panduan praktis bridging BPJS Kesehatan di rumah sakit, dari persiapan kredensial, pemetaan data master, uji coba, sampai kendala yang paling sering ditemui.
date: 2026-10-26
category: bpjs
author: Tim Enigma Works
---

Hampir setiap rumah sakit yang melayani pasien JKN pernah mengalami hal yang sama: petugas pendaftaran mengetik data pasien di SIMRS, lalu mengetik ulang di aplikasi BPJS. Antrean memanjang, dan risiko salah input membesar. Bridging menyelesaikan masalah ini dengan menghubungkan SIMRS langsung ke layanan BPJS Kesehatan.

Artikel ini merangkum tahapan bridging yang biasa kami jalankan di lapangan, beserta kendala yang paling sering muncul.

## Apa saja yang di-bridging

Bridging BPJS bukan satu fitur tunggal. Umumnya ada beberapa bagian yang dihubungkan:

- **V-Claim**, untuk cek kepesertaan, rujukan, dan penerbitan SEP langsung dari SIMRS.
- **Antrean online**, agar jadwal dokter dan antrean poliklinik rumah sakit tersambung dengan pendaftaran pasien dari aplikasi Mobile JKN.
- **Pendukung klaim**, supaya data pelayanan dari SIMRS bisa dipakai untuk menyusun berkas klaim tanpa input ulang.

Setiap rumah sakit tidak harus mengerjakan semuanya sekaligus. Biasanya V-Claim didahulukan karena paling terasa dampaknya di pendaftaran.

## Tahap 1: Persiapan kredensial

Bridging membutuhkan kredensial akses dari BPJS Kesehatan yang diajukan rumah sakit melalui kantor cabang. Pastikan penanggung jawab di rumah sakit jelas, karena kredensial ini bersifat rahasia dan sebaiknya disimpan oleh tim IT, bukan dibagikan lewat grup percakapan.

Biasanya akses diberikan untuk lingkungan pengujian lebih dulu, baru kemudian produksi setelah alur dinyatakan berjalan baik.

## Tahap 2: Pemetaan data master

Ini tahap yang paling sering diremehkan. Kode poliklinik, kode dokter, dan kode ruangan di SIMRS harus dicocokkan dengan kode yang dikenal BPJS. Jika pemetaannya salah, SEP bisa gagal terbit atau antrean muncul di poli yang keliru.

Kami menyarankan membuat satu tabel pemetaan yang disetujui bagian pendaftaran dan bagian casemix, lalu baru dimasukkan ke sistem.

## Tahap 3: Uji alur bersama petugas

Uji coba sebaiknya dilakukan oleh petugas yang benar-benar akan memakai sistem, bukan hanya tim IT. Skenario yang perlu diuji antara lain:

1. Pasien rujukan dari FKTP datang ke poliklinik.
2. Pasien kontrol ulang dengan surat kontrol.
3. Pasien IGD yang kemudian dirawat inap.
4. Pasien yang mendaftar lewat antrean online.

Setiap skenario dicatat hasilnya. Masalah yang ditemukan di tahap ini jauh lebih murah diperbaiki daripada setelah go-live.

## Tahap 4: Go-live dan pemantauan

Saat pertama dipakai di lingkungan produksi, siapkan pendampingan di meja pendaftaran pada jam sibuk. Pantau juga log komunikasi antara SIMRS dan BPJS selama beberapa minggu pertama, karena pola kegagalan biasanya baru terlihat setelah volume pasien sebenarnya masuk.

## Kendala yang paling sering muncul

**Kode dokter atau poli tidak cocok.** Gejalanya, SEP gagal terbit atau antrean tidak muncul. Solusinya kembali ke tabel pemetaan data master.

**Jadwal dokter tidak sinkron.** Untuk antrean online, jadwal praktik di SIMRS harus selalu diperbarui. Dokter yang cuti tetapi jadwalnya masih aktif akan membuat pasien datang sia-sia.

**Koneksi internet tidak stabil.** Bridging bergantung pada koneksi ke server BPJS. Jaringan cadangan di area pendaftaran sangat dianjurkan.

**Perubahan versi layanan.** BPJS sesekali memperbarui layanannya. SIMRS perlu dipelihara agar tetap mengikuti versi yang berlaku, dan di sinilah kontrak maintenance berperan.

## Kesimpulan

Bridging BPJS yang berhasil bukan hanya soal teknis. Kuncinya ada pada data master yang rapi, uji coba bersama petugas, dan pemantauan setelah go-live. Jika rumah sakit Anda di Medan atau Sumatera Utara sedang menyiapkan bridging, [konsultasikan dengan tim kami](/kontak) atau pelajari [layanan bridging BPJS](/layanan/bridging-bpjs) yang kami kerjakan.
