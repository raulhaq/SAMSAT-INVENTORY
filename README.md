# Sistem Inventaris Barang 

Project ini Sistem Informasi Inventaris Barang yang dikembangkan untuk membantu UPTD-PPA Wilayah I Banda Aceh dalam mencatat, memantau, dan mengelola data inventaris secara digital. Proyek ini dibangun menggunakan PHP dan MySQL, serta diimplementasikan secara lokal melalui XAMPP.

## Cara Menjalankan
1. Clone repo ini ke `htdocs/`
2. Import file `database.sql` ke phpMyAdmin
3. Jalankan `localhost/nama_project/` di browser

👤 Menambahkan User Baru melalui phpMyAdmin
Jika Anda belum memiliki halaman registrasi atau ingin menambahkan user secara manual, berikut langkah-langkahnya:

1. Buka phpMyAdmin
Akses melalui http://localhost/phpmyadmin

2. Pilih Database
Klik pada database tempat Anda menyimpan tabel user. Misalnya: inventaris_db.

3. Pilih Tabel Login
Klik pada tabel bernama login.

4. Tambahkan User Baru
Klik tab Insert.

Isi kolom-kolom sebagai berikut:

id : Kosongkan atau isi dengan NULL jika auto increment.

email : Masukkan email user baru (contoh: admin@example.com)

password : Masukkan password user baru (contoh: 123456)

⚠️ Catatan: Saat ini, password disimpan tanpa enkripsi. Untuk alasan keamanan, sebaiknya gunakan hashing (contoh: password_hash()).

5. Klik Go
Klik tombol Go di bagian bawah untuk menyimpan data.


## Dibuat oleh
M. Raul Al Haq &
Raudhatul Mahfuzha
- 2025 - 
