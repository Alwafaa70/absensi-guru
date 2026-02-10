# Perbaikan Status Absensi

## Ringkasan Perubahan

Telah dilakukan perbaikan pada sistem status absensi agar lebih konsisten dan sesuai dengan kebutuhan. Perubahan utama:

### 1. Status Absensi yang Valid
Sekarang hanya ada **4 status** yang valid:
- ✅ **Hadir** - Guru hadir dan absen masuk & pulang
- ❌ **Bolos** - Guru tidak hadir (sebelumnya: "tidak_hadir")
- 📝 **Izin** - Guru mengajukan izin
- 🏥 **Sakit** - Guru sakit

### 2. Status yang Dihapus
- ❌ **Telat** - Bukan lagi status, tapi hanya peringatan yang dicatat di kolom `menit_telat`
- ❌ **Tidak Hadir** - Diganti menjadi "Bolos"

### 3. Perubahan Detail

#### A. Controller (Backend)
1. **AbsensiController.php**
   - Filter riwayat: Menghapus logika `whereIn(['hadir', 'telat'])` 
   - Auto bolos: Mengubah status dari 'tidak_hadir' menjadi 'bolos'
   - Filter status sekarang langsung menggunakan `where('status', $request->status)`

2. **AbsensiAdminController.php**
   - Validasi status: Hanya menerima `hadir, izin, sakit, bolos`
   - Filter status: Menghapus logika untuk 'telat'
   - Reject pengajuan: Mengubah status menjadi 'bolos' (bukan 'tidak_hadir')

3. **StatistikController.php**
   - Perhitungan hadir: Berdasarkan `status = 'hadir'` (bukan lagi berdasarkan jam_datang & jam_pulang)
   - Perhitungan bolos: `Total hari kerja - (hadir + izin + sakit)`
   - Konsisten di method `index()` dan `calculateStatistik()`

#### B. View (Frontend)
1. **riwayat.blade.php** (Guru)
   - Filter status: Mengubah 'tidak_hadir' menjadi 'bolos'
   - Display status: Menghapus logik untuk status 'telat'
   - Telat ditampilkan sebagai peringatan di kolom terpisah

2. **admin/absensi/index.blade.php**
   - Filter dropdown: Menghapus option 'telat' dan 'tidak_hadir'
   - Display status: Hanya menampilkan 4 status valid
   - Telat ditampilkan sebagai info tambahan di kolom jam masuk

3. **admin/absensi/edit.blade.php**
   - Dropdown status: Hanya 4 option (hadir, izin, sakit, bolos)
   - Kolom `menit_telat` tetap ada untuk mencatat keterlambatan

#### C. Database Migration
File: `2026_02_05_073000_update_status_absensi_values.php`
- Mengupdate semua record 'tidak_hadir' → 'bolos'
- Mengupdate semua record 'telat' → 'hadir'

## Cara Menjalankan Perubahan

### 1. Pastikan Database Aktif
Jalankan MySQL/MariaDB server terlebih dahulu.

### 2. Jalankan Migration
```bash
php artisan migrate
```

Migration akan otomatis mengupdate data yang sudah ada:
- Status 'tidak_hadir' → 'bolos'
- Status 'telat' → 'hadir' (data telat tetap tersimpan di kolom `menit_telat`)

### 3. Verifikasi Perubahan
Cek di database:
```sql
SELECT DISTINCT status FROM absensis;
```
Hasilnya harus hanya: `hadir`, `bolos`, `izin`, `sakit`

## Penjelasan Logika Baru

### Telat Bukan Status
- **Sebelumnya**: Telat adalah status terpisah
- **Sekarang**: Telat adalah peringatan yang dicatat di kolom `menit_telat`
- **Contoh**: 
  - Guru datang jam 07:15 (telat 15 menit)
  - Status: `hadir`
  - Menit telat: `15`
  - Ditampilkan: "Hadir (Telat 15m)"

### Bolos vs Tidak Hadir
- **Sebelumnya**: Ada 2 istilah berbeda
- **Sekarang**: Hanya "Bolos" untuk semua kasus tidak hadir
- **Auto Mark**: 
  - Tidak absen datang sampai 07:30 → Bolos
  - Tidak absen pulang sampai 16:00 → Bolos

### Filter di Riwayat
- **Sebelumnya**: Filter "Hadir" menampilkan status 'hadir' DAN 'telat'
- **Sekarang**: Filter "Hadir" hanya menampilkan status 'hadir'
- **Bug Fixed**: Filter tidak lagi menampilkan data yang salah

### Statistik
- **Hadir**: Dihitung dari `status = 'hadir'`
- **Izin**: Dihitung dari `status = 'izin'`
- **Sakit**: Dihitung dari `status = 'sakit'`
- **Bolos**: `Total hari kerja - (Hadir + Izin + Sakit)`
- **Persentase Kehadiran**: `(Hadir + Izin + Sakit) / Total Hari Kerja × 100%`

## Testing

Setelah migration, test hal berikut:

1. ✅ Filter di halaman Riwayat Absensi (Guru)
2. ✅ Filter di halaman Kelola Absensi (Admin)
3. ✅ Edit status absensi (Admin)
4. ✅ Statistik kehadiran
5. ✅ Auto mark bolos (command)
6. ✅ Pengajuan izin/sakit

## Rollback (Jika Diperlukan)

Jika ingin kembali ke sistem lama:
```bash
php artisan migrate:rollback
```

**Catatan**: Rollback akan mengembalikan:
- 'bolos' → 'tidak_hadir'
- 'hadir' dengan menit_telat > 0 → 'telat'

## File yang Diubah

1. `app/Http/Controllers/AbsensiController.php`
2. `app/Http/Controllers/AbsensiAdminController.php`
3. `app/Http/Controllers/StatistikController.php`
4. `resources/views/guru/absensi/riwayat.blade.php`
5. `resources/views/admin/absensi/index.blade.php`
6. `resources/views/admin/absensi/edit.blade.php`
7. `database/migrations/2026_02_05_073000_update_status_absensi_values.php` (baru)

## Catatan Penting

- ⚠️ **Backup database** sebelum menjalankan migration
- ✅ Semua data telat tetap tersimpan di kolom `menit_telat`
- ✅ Command `AutoMarkBolos` sudah benar dan tidak perlu diubah
- ✅ Validasi di form sudah disesuaikan dengan 4 status baru
