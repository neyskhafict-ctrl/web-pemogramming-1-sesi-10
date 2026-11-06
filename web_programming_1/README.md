# Web Programming 1 — Modul 10: Multimedia CRUD

Project ini merupakan pengembangan dari project Web Programming 1 yang sudah ada.
Fitur CRUD Mahasiswa lama tetap dipertahankan dan ditambahkan fitur CRUD Media.

## Fitur
- READ data mahasiswa beserta foto, audio, dan PDF.
- CREATE data dengan foto wajib, audio dan PDF opsional.
- Preview foto/audio dan informasi dokumen sebelum form dikirim.
- Validasi sisi browser (JavaScript) dan sisi server (PHP `finfo`).
- UPDATE dengan mempertahankan media lama jika tidak ada file baru.
- Menghapus file lama saat media diganti.
- DELETE data dan file fisik terkait.
- Search/filter tabel menggunakan JavaScript DOM.

## Kebutuhan
- XAMPP (Apache dan MySQL aktif).
- PHP dengan ekstensi `fileinfo` dan MySQLi.
- Database bernama `web_programming_1`.

## Instalasi
1. Ekstrak folder `web_programming_1` ke `C:/xampp/htdocs/`.
2. Jalankan Apache dan MySQL dari XAMPP.
3. Pastikan database `web_programming_1` dan tabel `mahasiswa` sudah tersedia.
4. Backup database.
5. Buka phpMyAdmin, pilih database `web_programming_1`, lalu jalankan isi `database/migration_modul_10.sql` satu kali.
6. Pastikan kolom `mahasiswa.foto`, `mahasiswa.audio`, dan `mahasiswa.dokumen` bertipe `VARCHAR(255)` dan boleh `NULL`.
7. Pastikan konfigurasi `config/koneksi.php` sesuai dengan akun MySQL lokal.
8. Buka `http://localhost/web_programming_1/` dan login.
9. Dari Dashboard pilih menu **CRUD Media**.

## Aturan file sesuai Modul 10
- Foto: JPG/JPEG, PNG, WEBP; wajib saat CREATE.
- Audio: MP3/WAV; opsional.
- Dokumen: PDF; opsional.
- Batas ukuran setiap file: 2 MB.
- File fisik disimpan di `uploads/images`, `uploads/audio`, dan `uploads/documents`.
- Database hanya menyimpan nama file, bukan isi file.

## Pengujian
1. CREATE hanya dengan foto.
2. CREATE dengan foto, audio, dan PDF.
3. Coba tipe file yang salah dan file di atas 2 MB.
4. UPDATE teks tanpa mengganti file.
5. UPDATE dengan mengganti salah satu media.
6. DELETE lalu pastikan record dan file terkait terhapus.
7. Pastikan CRUD Mahasiswa lama tetap dapat digunakan.

## Catatan akun
Gunakan akun yang memang sudah tersedia di database project. File `buat_admin.php` lama memiliki nama kolom yang perlu dicocokkan dengan struktur tabel `users` sebelum digunakan.
