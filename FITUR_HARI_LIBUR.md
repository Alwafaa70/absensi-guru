# 🏖️ Fitur Hari Libur - Dokumentasi Lengkap

## ✨ Fitur Baru yang Ditambahkan

### 1. **Auto-Delete Hari Libur yang Sudah Lewat** ⏰
Sistem akan otomatis menghapus hari libur yang sudah lewat setiap tengah malam untuk mengurangi beban database.

### 2. **Tampilan Hari Libur di Riwayat Absensi Guru** 👨‍🏫
Guru dapat melihat hari libur di riwayat absensi mereka dengan tampilan khusus.

### 3. **Tampilan Hari Libur di Kelola Absensi Admin** 👨‍💼
Admin dapat melihat hari libur di kelola absensi (read-only, tidak bisa diedit).

---

## 🔄 Auto-Delete Hari Libur

### Command Manual:
```bash
# Dengan konfirmasi
php artisan holidays:cleanup

# Tanpa konfirmasi (auto yes)
php artisan holidays:cleanup --force
```

### Jadwal Otomatis:
Command ini akan berjalan **otomatis setiap hari jam 00:01** (tengah malam) melalui Laravel Scheduler.

### Cara Kerja:
1. Sistem mencari hari libur dengan tanggal < hari ini
2. Menampilkan daftar hari libur yang akan dihapus
3. Meminta konfirmasi (kecuali menggunakan `--force`)
4. Menghapus hari libur yang sudah lewat
5. Menampilkan jumlah hari libur yang dihapus

### Contoh Output:
```
Ditemukan 3 hari libur yang sudah lewat:

  - 01 Januari 2026 (Tahun Baru)
  - 15 Januari 2026 (Libur Nasional)
  - 04 Februari 2026 (Liburan)

Apakah Anda yakin ingin menghapus hari libur yang sudah lewat? (yes/no) [yes]:
> yes

✓ Berhasil menghapus 3 hari libur yang sudah lewat.
✓ Sistem menjadi lebih ringan!
```

---

## 📅 Tampilan Hari Libur di Riwayat Absensi Guru

### Fitur:
- **Badge "Libur"** di kolom tanggal
- **Background kuning muda** untuk baris hari libur
- **Status khusus** "🏖️ Hari Libur"
- **Keterangan libur** ditampilkan di kolom keterangan
- **Jam masuk/pulang** diganti dengan teks "Libur"
- **Kolom telat** tidak ditampilkan (-)

### Tampilan:
```
┌─────────────────┬────────┬───────────┬────────────┬──────────────┬───────┬──────────────────┐
│ Tanggal         │ Hari   │ Jam Masuk │ Jam Pulang │ Status       │ Telat │ Keterangan       │
├─────────────────┼────────┼───────────┼────────────┼──────────────┼───────┼──────────────────┤
│ 05 Feb 2026     │ Rabu   │ 07:15     │ 16:05      │ ✅ Hadir     │ -     │ -                │
│ 04 Feb 2026 🏖️  │ Selasa │ Libur     │ Libur      │ 🏖️ Hari Libur│ -     │ Liburan          │
│ 03 Feb 2026     │ Senin  │ 07:25     │ 16:00      │ ✅ Hadir     │ -     │ -                │
└─────────────────┴────────┴───────────┴────────────┴──────────────┴───────┴──────────────────┘
```

---

## 👨‍💼 Tampilan Hari Libur di Kelola Absensi Admin

### Fitur:
- **Badge "Libur"** di kolom tanggal
- **Background kuning muda** untuk baris hari libur
- **Status khusus** "🏖️ Hari Libur" dengan deskripsi libur
- **Jam masuk/pulang** diganti dengan teks "Libur"
- **Kolom aksi** menampilkan "Tidak dapat diedit" (read-only)
- **Tidak ada tombol Edit/Detail** untuk hari libur

### Tampilan:
```
┌──────────────┬─────────────────┬───────────┬────────────┬──────────────────┬───────┬──────────────────┐
│ Nama Guru    │ Tanggal & Hari  │ Jam Masuk │ Jam Pulang │ Status           │ Telat │ Aksi             │
├──────────────┼─────────────────┼───────────┼────────────┼──────────────────┼───────┼──────────────────┤
│ Rapir Joy    │ 05/02/2026      │ 07:15     │ 16:05      │ ✅ Hadir         │ -     │ Detail | Edit    │
│              │ Rabu            │           │            │                  │       │                  │
├──────────────┼─────────────────┼───────────┼────────────┼──────────────────┼───────┼──────────────────┤
│ Rapir Joy    │ 04/02/2026 🏖️   │ Libur     │ Libur      │ 🏖️ Hari Libur    │ -     │ Tidak dapat      │
│              │ Selasa          │           │            │ Liburan          │       │ diedit           │
└──────────────┴─────────────────┴───────────┴────────────┴──────────────────┴───────┴──────────────────┘
```

---

## 🎨 Styling & Visual

### Warna yang Digunakan:
- **Background baris**: `bg-yellow-50/30` atau `bg-yellow-50/40` (kuning muda transparan)
- **Badge libur**: `bg-yellow-100 text-yellow-800` (kuning)
- **Teks "Libur"**: `text-yellow-600 font-semibold`
- **Icon**: 🏖️ (emoji pantai/liburan)

### Efek Hover:
- Baris hari libur tetap memiliki efek hover seperti baris normal
- Background berubah sedikit lebih gelap saat di-hover

---

## 📊 Integrasi dengan Fitur Lain

### Auto-Bolos:
- Hari libur **TIDAK** akan di-mark sebagai bolos
- Command `absensi:auto-bolos` sudah mengecek hari libur
- Jika hari ini adalah hari libur, auto-bolos tidak akan berjalan

### Statistik:
- Hari libur **TIDAK** mempengaruhi statistik
- Statistik hanya menghitung: hadir, izin, sakit, bolos
- Hari libur tidak masuk dalam perhitungan persentase kehadiran

### Filter:
- Hari libur **TIDAK** bisa difilter berdasarkan status
- Hari libur akan muncul di semua view tanpa filter status
- Filter tanggal tetap berfungsi untuk hari libur

---

## 🔧 Technical Details

### File yang Dimodifikasi:

#### 1. **Command**
- `app/Console/Commands/CleanupOldHolidays.php` (NEW)

#### 2. **Scheduler**
- `app/Console/Kernel.php` (UPDATED)

#### 3. **Controllers**
- `app/Http/Controllers/AbsensiController.php` (UPDATED - method `riwayat`)
- `app/Http/Controllers/AbsensiAdminController.php` (UPDATED - method `index`)

#### 4. **Views**
- `resources/views/guru/absensi/riwayat.blade.php` (UPDATED)
- `resources/views/admin/absensi/index.blade.php` (UPDATED)

### Database:
- **Tidak ada perubahan struktur database**
- Menggunakan tabel `holidays` yang sudah ada
- Data hari libur diambil dengan: `Holiday::pluck('description', 'date')->toArray()`

---

## 📝 Cara Penggunaan

### Untuk Admin:

#### 1. Menambah Hari Libur:
1. Login sebagai admin
2. Buka menu **Kelola Hari Libur**
3. Klik **Tambah Hari Libur**
4. Isi tanggal dan deskripsi
5. Klik **Simpan**

#### 2. Melihat Hari Libur di Kelola Absensi:
1. Login sebagai admin
2. Buka menu **Kelola Absensi**
3. Hari libur akan ditampilkan dengan badge 🏖️ Libur
4. Baris hari libur memiliki background kuning muda
5. Kolom aksi menampilkan "Tidak dapat diedit"

#### 3. Menghapus Hari Libur yang Sudah Lewat:
**Otomatis**: Sistem akan menghapus setiap tengah malam (00:01)

**Manual**:
```bash
php artisan holidays:cleanup
```

### Untuk Guru:

#### Melihat Hari Libur di Riwayat Absensi:
1. Login sebagai guru
2. Buka menu **Riwayat Absensi**
3. Hari libur akan ditampilkan dengan badge 🏖️ Libur
4. Status menampilkan "🏖️ Hari Libur"
5. Keterangan menampilkan deskripsi libur (misal: "Tahun Baru", "Libur Nasional")

---

## ⚙️ Konfigurasi Scheduler

Pastikan Laravel Scheduler sudah berjalan. Lihat file `AUTO_BOLOS_SETUP.md` untuk cara setup.

### Jadwal yang Berjalan:
```php
// 1️⃣ Auto-bolos datang (07:31)
$schedule->command('absensi:auto-bolos datang')
    ->dailyAt('07:31')
    ->timezone('Asia/Jakarta');

// 2️⃣ Auto-bolos pulang (16:01)
$schedule->command('absensi:auto-bolos pulang')
    ->dailyAt('16:01')
    ->timezone('Asia/Jakarta');

// 3️⃣ Auto-cleanup hari libur (00:01)
$schedule->command('holidays:cleanup --force')
    ->dailyAt('00:01')
    ->timezone('Asia/Jakarta');
```

---

## 🧪 Testing

### Test Auto-Delete:
```bash
# Lihat hari libur yang akan dihapus
php artisan holidays:cleanup

# Hapus tanpa konfirmasi
php artisan holidays:cleanup --force
```

### Test Tampilan:
1. Tambahkan hari libur untuk hari ini
2. Buat absensi untuk guru di hari yang sama
3. Buka riwayat absensi guru → Hari libur harus muncul dengan badge
4. Buka kelola absensi admin → Hari libur harus muncul dengan "Tidak dapat diedit"

---

## 🎯 Keuntungan Fitur Ini

### 1. **Performa Database** 📈
- Database lebih ringan karena hari libur lama otomatis terhapus
- Query lebih cepat karena data lebih sedikit

### 2. **User Experience** 😊
- Guru tahu kapan hari libur dari riwayat absensi
- Admin tidak perlu manual hapus hari libur lama
- Tidak ada kebingungan tentang hari libur

### 3. **Data Integrity** ✅
- Hari libur tidak bisa diedit oleh admin
- Tidak ada status absensi untuk hari libur
- Tidak mempengaruhi statistik kehadiran

### 4. **Maintenance** 🔧
- Otomatis, tidak perlu intervensi manual
- Cleanup berjalan setiap tengah malam
- Admin tidak perlu repot

---

## 📞 Troubleshooting

### Hari libur tidak muncul di riwayat?
1. Pastikan hari libur sudah ditambahkan di menu **Kelola Hari Libur**
2. Pastikan tanggal hari libur sesuai dengan tanggal absensi
3. Clear cache: `php artisan cache:clear`

### Auto-cleanup tidak berjalan?
1. Pastikan Laravel Scheduler sudah aktif (lihat `AUTO_BOLOS_SETUP.md`)
2. Cek Task Scheduler Windows: cari task "Laravel Scheduler - Absensi Guru"
3. Test manual: `php artisan holidays:cleanup --force`

### Hari libur masih bisa diedit?
- Ini tidak mungkin karena tombol Edit tidak ditampilkan untuk hari libur
- Jika ada masalah, clear cache dan reload halaman

---

## ✅ Checklist Implementasi

- [x] Command `holidays:cleanup` dibuat
- [x] Scheduler dikonfigurasi untuk cleanup otomatis
- [x] Controller riwayat guru diupdate
- [x] Controller kelola absensi admin diupdate
- [x] View riwayat guru diupdate
- [x] View kelola absensi admin diupdate
- [x] Testing manual berhasil
- [x] Dokumentasi lengkap dibuat

---

**Fitur ini sudah siap digunakan!** 🎉
