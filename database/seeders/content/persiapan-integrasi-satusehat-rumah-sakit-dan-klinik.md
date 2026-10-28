---
title: Persiapan Integrasi SATUSEHAT untuk Rumah Sakit dan Klinik
description: Langkah menyiapkan integrasi SATUSEHAT Kemenkes: pendaftaran, data master lokasi dan tenaga kesehatan, uji di sandbox, sampai penyebab gagal kirim data yang paling umum.
date: 2026-10-20
category: satusehat
author: Tim Enigma Works
---

Sejak Peraturan Menteri Kesehatan Nomor 24 Tahun 2022 tentang Rekam Medis, fasilitas pelayanan kesehatan wajib menyelenggarakan rekam medis elektronik dan terhubung dengan platform SATUSEHAT milik Kementerian Kesehatan. Bagi banyak rumah sakit dan klinik, pertanyaannya bukan lagi perlu atau tidak, tetapi bagaimana memulainya dengan benar.

## Gambaran singkat SATUSEHAT

SATUSEHAT adalah platform pertukaran data kesehatan nasional. Data dari SIMRS atau aplikasi klinik dikirim dalam format standar internasional bernama HL7 FHIR. Setiap data kunjungan pasien dipecah menjadi beberapa jenis data, misalnya kunjungan (Encounter), diagnosis (Condition), hasil pemeriksaan (Observation), dan tindakan (Procedure).

Artinya, SIMRS Anda harus bisa menerjemahkan data internalnya ke format tersebut. Inilah inti pekerjaan integrasi.

## Langkah 1: Pendaftaran dan kredensial

Fasilitas kesehatan mendaftar di portal SATUSEHAT untuk mendapatkan identitas organisasi dan kredensial akses. Akses biasanya dibuka bertahap: lingkungan uji (sandbox) lebih dulu, lalu produksi.

Simpan kredensial dengan aman dan catat siapa penanggung jawabnya di rumah sakit.

## Langkah 2: Siapkan data master

Sebelum data kunjungan bisa dikirim, beberapa data dasar harus terdaftar lebih dulu:

- **Lokasi**, yaitu poliklinik, ruang rawat, IGD, dan unit lain yang didaftarkan sebagai lokasi organisasi Anda.
- **Tenaga kesehatan**, yang dicocokkan berdasarkan NIK agar mendapat nomor identitas di SATUSEHAT.
- **Pasien**, yang juga dicocokkan melalui NIK saat pertama kali dikirim.

Banyak kegagalan kirim data berawal dari data master yang belum lengkap, jadi jangan lewati langkah ini.

## Langkah 3: Pemetaan terminologi

SATUSEHAT memakai kode standar. Diagnosis menggunakan ICD-10, sedangkan obat dan alat kesehatan menggunakan Kamus Farmasi dan Alat Kesehatan (KFA). SIMRS perlu menyimpan kode-kode ini, bukan hanya nama bebas yang diketik petugas.

Untuk farmasi, pemetaan obat ke KFA sering memakan waktu paling lama, karena daftar obat rumah sakit bisa mencapai ribuan item.

## Langkah 4: Uji di sandbox

Kirim data contoh di lingkungan sandbox dan periksa setiap respons. Uji berbagai skenario: rawat jalan, IGD, rawat inap, pasien tanpa NIK, dan pasien bayi baru lahir. Setelah semua skenario lolos, barulah beralih ke produksi.

## Penyebab gagal kirim yang paling umum

**NIK pasien tidak ditemukan.** Biasanya karena salah ketik di pendaftaran. Validasi NIK sejak pasien mendaftar akan sangat membantu.

**Tenaga kesehatan belum terdaftar.** Dokter baru sering lupa didaftarkan di data master.

**Lokasi belum dibuat.** Poliklinik atau ruangan baru di SIMRS belum didaftarkan ke SATUSEHAT.

**Kode tidak valid.** Diagnosis tanpa kode ICD-10 atau obat tanpa kode KFA.

## Pemantauan setelah berjalan

Integrasi SATUSEHAT bukan pekerjaan sekali selesai. Siapkan pemantauan harian untuk data yang gagal terkirim, lalu kirim ulang setelah penyebabnya diperbaiki. Dengan begitu, data rumah sakit Anda di SATUSEHAT tetap lengkap.

Butuh pendampingan? Pelajari [layanan integrasi SATUSEHAT](/layanan/integrasi-satusehat) kami untuk rumah sakit dan klinik di Medan dan Sumatera Utara.
