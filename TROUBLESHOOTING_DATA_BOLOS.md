# 🔧 Troubleshooting: Data Bolos Tidak Muncul di Riwayat Absensi

## ✅ Status Verifikasi

**Data bolos untuk tanggal 9 Februari 2026 SUDAH ADA di database!**

Semua 7 guru sudah ditandai bolos dengan detail:
- **Status**: `bolos`
- **Jam Datang**: `-` (kosong)
- **Jam Pulang**: `-` (kosong)
- **Keterangan**: "Otomatis ditandai bolos karena tidak absen datang sampai jam 07:30"

---

## 🚨 Masalah Umum & Solusi

### 1. **Login sebagai Admin (bukan Guru)**

**Masalah**: Halaman `/guru/absensi/riwayat` hanya menampilkan data untuk user yang sedang login. Jika Anda login sebagai admin, data guru tidak akan muncul.

**Solusi**: 
1. Logout dari akun admin
2. Login sebagai salah satu guru:
   - Email: `rapirjinx@gmail.com` (Rapir Joy S.Pd)
   - Email: `m.alwafa.k@gmail.com` (Muhammad Alvafaz K. S.T)
   - Email: `kotarosan101@gmail.com` (Gilang Wardi S.T)
   - Email: `refi@gmail.com` (Refi Aura S.T)
   - Email: `cr7@gmail.com` (Cristiano Ronaldo S.Pd.)
   - Email: `arnold@gmail.com` (Intan Einstein S.Pd)
   - Email: `dimas@gmail.com` (Dimas Anggara S.Pd)
3. Buka halaman: `http://127.0.0.1:8000/guru/absensi/riwayat`

---

### 2. **Cache Browser**

**Masalah**: Browser menyimpan data lama sehingga perubahan tidak terlihat.

**Solusi**:
- **Hard Refresh**: Tekan `Ctrl + Shift + R` (Windows) atau `Cmd + Shift + R` (Mac)
- **Incognito Mode**: Buka halaman dalam mode incognito/private browsing
- **Clear Browser Cache**: 
  - Chrome: Settings → Privacy and security → Clear browsing data
  - Firefox: Settings → Privacy & Security → Clear Data

---

### 3. **Cache Laravel**

**Masalah**: Laravel menyimpan cache yang sudah usang.

**Solusi**: Jalankan command berikut (sudah dijalankan):
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

### 4. **Pagination**

**Masalah**: Data ada di halaman berikutnya karena ada banyak record.

**Solusi**:
- Scroll ke bawah halaman
- Cek tombol pagination (1, 2, 3, Next, dll)
- Klik halaman berikutnya untuk melihat data lama

---

### 5. **Filter Tanggal/Status Aktif**

**Masalah**: Ada filter yang aktif sehingga data tidak muncul.

**Solusi**:
- Klik tombol **"Reset"** di bagian filter
- Atau hapus semua filter yang aktif
- Pastikan tidak ada filter tanggal atau status yang membatasi hasil

---

## 🧪 Cara Verifikasi Data Ada di Database

Jalankan script berikut untuk memastikan data ada:

```bash
php cek-absensi-tanggal.php
```

Output yang diharapkan:
```
========================================
Cek Data Absensi untuk 2026-02-09
========================================

Total Guru: 7

Guru: Rapir Joy S.Pd
  ✓ Ada record absensi
  - Status: bolos
  - Jam Datang: -
  - Jam Pulang: -
  - Keterangan: Otomatis ditandai bolos karena tidak absen datang sampai jam 07:30

... (dan seterusnya untuk 6 guru lainnya)
```

---

## 📋 Checklist Troubleshooting

Ikuti checklist ini secara berurutan:

- [ ] **1. Pastikan login sebagai GURU (bukan admin)**
  - Cek email yang digunakan untuk login
  - Pastikan role adalah "guru"
  
- [ ] **2. Clear cache Laravel**
  ```bash
  php artisan cache:clear
  php artisan config:clear
  php artisan view:clear
  ```

- [ ] **3. Hard refresh browser**
  - Tekan `Ctrl + Shift + R`
  
- [ ] **4. Cek filter**
  - Klik tombol "Reset" di halaman riwayat
  
- [ ] **5. Cek pagination**
  - Scroll ke bawah
  - Lihat apakah ada halaman berikutnya
  
- [ ] **6. Verifikasi data di database**
  ```bash
  php cek-absensi-tanggal.php
  ```

---

## 🎯 Tampilan yang Diharapkan

Setelah login sebagai guru dan membuka halaman riwayat, Anda seharusnya melihat:

```
┌─────────────────┬────────┬───────────┬────────────┬──────────────┬───────┬──────────────────────────────┐
│ Tanggal         │ Hari   │ Jam Masuk │ Jam Pulang │ Status       │ Telat │ Keterangan                   │
├─────────────────┼────────┼───────────┼────────────┼──────────────┼───────┼──────────────────────────────┤
│ 09 Februari 2026│ Senin  │ -         │ -          │ ❌ Bolos     │ -     │ Otomatis ditandai bolos      │
│                 │        │           │            │              │       │ karena tidak absen datang    │
│                 │        │           │            │              │       │ sampai jam 07:30             │
└─────────────────┴────────┴───────────┴────────────┴──────────────┴───────┴──────────────────────────────┘
```

**Ciri-ciri visual**:
- Badge **❌ Bolos** berwarna merah
- Jam Masuk dan Jam Pulang: **-** (kosong)
- Kolom Telat: **-** (kosong)
- Keterangan: "Otomatis ditandai bolos karena tidak absen datang sampai jam 07:30"

---

## 🔍 Debug Lebih Lanjut

Jika masih tidak muncul setelah semua langkah di atas, jalankan:

### 1. Cek User yang Sedang Login
```bash
php cek-users.php
```

### 2. Cek Data Absensi untuk Tanggal Tertentu
```bash
php cek-absensi-tanggal.php
```

### 3. Jalankan Auto-Bolos Manual
```bash
php manual-auto-bolos.php
```

---

## 📞 Bantuan Lebih Lanjut

Jika setelah mengikuti semua langkah di atas data masih tidak muncul:

1. **Screenshot halaman riwayat** dan kirimkan
2. **Cek console browser** (F12 → Console) untuk error JavaScript
3. **Cek log Laravel**: `storage/logs/laravel.log`
4. **Pastikan server Laravel berjalan**: `php artisan serve`

---

## ✅ Kesimpulan

**Data bolos untuk 9 Februari 2026 SUDAH ADA di database!**

Jika tidak muncul di halaman riwayat, kemungkinan besar:
1. Anda login sebagai admin (bukan guru)
2. Cache browser/Laravel masih menyimpan data lama
3. Ada filter yang aktif

**Solusi tercepat**: 
1. Login sebagai guru (misal: `rapirjinx@gmail.com`)
2. Clear cache: `php artisan cache:clear`
3. Hard refresh browser: `Ctrl + Shift + R`
4. Buka: `http://127.0.0.1:8000/guru/absensi/riwayat`

Data pasti akan muncul! 🎉
