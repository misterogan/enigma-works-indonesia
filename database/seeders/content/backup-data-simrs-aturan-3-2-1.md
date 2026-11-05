---
title: Backup Data SIMRS dengan Aturan 3-2-1 agar Pelayanan Tidak Terhenti
description: Cara sederhana melindungi database SIMRS dari kerusakan server dan ransomware dengan aturan backup 3-2-1, plus pentingnya uji pemulihan berkala.
date: 2026-10-05
category: infrastruktur
author: Tim Enigma Works
---

Ketika server SIMRS rusak atau terkena ransomware, pelayanan rumah sakit bisa terhenti. Satu-satunya penyelamat adalah backup yang benar-benar bisa dipulihkan. Cara paling sederhana untuk memulainya adalah aturan 3-2-1.

## Apa itu aturan 3-2-1

- **3 salinan data**: data utama di server, ditambah dua salinan backup.
- **2 jenis media berbeda**: misalnya disk di server backup dan media penyimpanan terpisah.
- **1 salinan di lokasi lain**: di luar gedung rumah sakit, misalnya penyimpanan cloud atau server di lokasi berbeda.

Tujuannya sederhana: satu kejadian, entah kebakaran, kerusakan perangkat, atau serangan, tidak boleh menghapus semua salinan sekaligus.

## Seberapa sering backup dilakukan

Untuk database SIMRS, backup harian adalah batas minimum. Rumah sakit dengan transaksi tinggi sebaiknya mempertimbangkan backup beberapa kali sehari atau replikasi database. Pertanyaan kuncinya: berapa jam data yang rela hilang jika server rusak sekarang?

## Lindungi backup dari ransomware

Ransomware modern sering mencari dan mengenkripsi file backup juga. Karena itu, minimal satu salinan sebaiknya tidak bisa diubah atau tidak terhubung terus-menerus ke jaringan rumah sakit.

## Yang paling sering terlupa: uji pemulihan

Backup yang tidak pernah diuji belum tentu bisa dipakai. Jadwalkan uji pemulihan secara berkala: pulihkan backup ke server uji, lalu pastikan SIMRS bisa berjalan dengan data tersebut. Catat berapa lama prosesnya, karena angka inilah yang menentukan berapa lama pelayanan bisa terganggu saat bencana.

## Langkah berikutnya

Periksa kondisi backup rumah sakit Anda hari ini: ada berapa salinan, di mana disimpan, dan kapan terakhir diuji. Jika belum yakin, tim kami bisa membantu lewat [layanan keamanan data dan antivirus](/layanan/keamanan-data) serta [kontrak maintenance](/layanan/maintenance-sla).
