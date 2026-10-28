# Website Enigma Works Indonesia (Laravel + Backoffice)

Website multi-halaman dengan desain baru dan **backoffice** untuk mengubah isi tanpa menyentuh kode.

## Isi paket

- **Website publik:** beranda, layanan, halaman kota, studi kasus, blog, tentang kami, kontak, sitemap.xml.
- **Backoffice (`/admin`):** login, ringkasan, kelola layanan, kota, studi kasus, portofolio, FAQ, artikel blog, serta pengaturan teks banner, judul bagian, data perusahaan, dan SEO.

## Cara memasang (Windows / CMD)

1. Buat proyek Laravel baru (Laravel 11 atau 12):
   ```
   composer create-project laravel/laravel enigma-works
   ```
2. Ekstrak paket ini, lalu salin isinya ke folder proyek (timpa file yang sama):
   ```
   xcopy /E /Y C:\lokasi\paket-ini\* C:\lokasi\enigma-works\
   ```
3. Atur file `.env`:
   ```
   APP_NAME="Enigma Works Indonesia"
   APP_URL=http://localhost:8000
   APP_LOCALE=id

   ADMIN_EMAIL=admin@enigmaworks.co.id
   ADMIN_PASSWORD=ganti-dengan-password-kuat
   ```
   Database bawaan Laravel adalah SQLite, sudah cukup untuk mulai. Untuk MySQL, isi `DB_CONNECTION=mysql` beserta `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
4. Buat tabel, isi konten awal, dan aktifkan folder gambar:
   ```
   php artisan migrate --seed
   php artisan storage:link
   ```
5. Jalankan website (tidak perlu npm; CSS dan JS ada di `public/css` dan `public/js`):
   ```
   php artisan serve
   ```
6. Buka website di **http://localhost:8000** dan backoffice di **http://localhost:8000/admin**, lalu masuk dengan email dan password dari `.env`.

## Menggunakan backoffice

| Menu | Untuk mengubah |
|---|---|
| Pengaturan → Banner utama | Judul banner, deskripsi, lencana, tombol, strip nama, pita teks |
| Pengaturan → Bagian beranda | Judul dan deskripsi setiap bagian, angka statistik, tahapan kerja |
| Pengaturan → Perusahaan | Nama, alamat, telepon, WhatsApp, email, logo, media sosial |
| Pengaturan → SEO beranda | Judul dan deskripsi di hasil Google |
| Pengaturan → Tentang kami | Isi halaman Tentang kami |
| Layanan | Kartu layanan dan halaman `/layanan/...` |
| Kota / area | Daftar area dan halaman `/it-rumah-sakit/...` |
| Studi kasus | Studi kasus dan testimoni |
| Portofolio | Kartu rumah sakit di bagian portofolio |
| FAQ beranda | Pertanyaan di beranda |
| Artikel blog | Menulis dan menerbitkan artikel |

**Format khusus di backoffice:**
- `*bintang*` pada judul membuat kata tersebut berwarna gradasi. Contoh: `Solusi SIMRS dan IT Rumah Sakit yang *Terintegrasi*`.
- Kolom "satu per baris": tulis satu item di setiap baris.
- Kolom berformat `Judul | Penjelasan`: pisahkan judul dan isinya dengan garis tegak `|`, satu item per baris.
- Isi artikel memakai Markdown: `## Subjudul`, `- daftar`, `**tebal**`, `[teks](/link)`.

**Testimoni:** testimoni studi kasus hanya tampil di website live setelah kolom **"Testimoni sudah disetujui rumah sakit"** dicentang. Di komputer lokal, testimoni draf tetap terlihat untuk pratinjau.

## Sebelum tayang

- [ ] Ganti password admin di `.env`, lalu jalankan `php artisan db:seed` untuk memperbaruinya.
- [ ] Ganti domain di `.env` (`APP_URL`) dan di `public/robots.txt`.
- [ ] Isi email asli, logo, dan gambar berbagi di Pengaturan → Perusahaan.
- [ ] Lengkapi studi kasus Serenapita (kota, tantangan, proses, hasil) dan minta persetujuan testimoni.
- [ ] Untuk server live: `APP_ENV=production`, `APP_DEBUG=false`, lalu `php artisan config:cache`, `route:cache`, `view:cache`.

## Setelah tayang

1. Daftarkan website di Google Search Console dan kirim `https://domainanda/sitemap.xml`.
2. Pasang Google Analytics 4 di `resources/views/layouts/app.blade.php`.
3. Terbitkan minimal satu artikel per minggu dari pengalaman nyata di lapangan.
4. Aktifkan halaman kota baru hanya bila isinya benar-benar berbeda dari kota lain.
