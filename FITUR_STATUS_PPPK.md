# Fitur Status Kepegawaian PPPK

## 📋 Deskripsi
Sistem absensi guru sekarang mendukung **3 jenis status kepegawaian**:
1. **PNS** (Pegawai Negeri Sipil) - menggunakan NIP
2. **PPPK** (Pegawai Pemerintah dengan Perjanjian Kerja) - menggunakan NIP
3. **Honor** (Guru Honor) - menggunakan NUPTK

## ✨ Fitur Utama

### 1. Status PPPK Menggunakan NIP
- PPPK dan PNS sama-sama menggunakan **NIP** (Nomor Induk Pegawai)
- Honor tetap menggunakan **NUPTK** (Nomor Unik Pendidik dan Tenaga Kependidikan)
- Perbedaan hanya pada jenis kepegawaian, bukan pada nomor identitas

### 2. Badge Visual yang Berbeda
- **PNS**: Badge biru (bg-blue-100 text-blue-800)
- **PPPK**: Badge ungu/purple (bg-purple-100 text-purple-800)
- **Honor**: Badge hijau (bg-green-100 text-green-800)

### 3. Form Dinamis
Saat memilih status kepegawaian di form tambah/edit guru:
- Pilih **PNS** → Label berubah menjadi "NIP" dengan placeholder "Nomor Induk Pegawai"
- Pilih **PPPK** → Label berubah menjadi "NIP" dengan placeholder "Nomor Induk Pegawai"
- Pilih **Honor** → Label berubah menjadi "NUPTK" dengan placeholder "Nomor Unik Pendidik dan Tenaga Kependidikan"

## 📂 File yang Diubah

### 1. Migration
**File**: `database/migrations/2026_02_10_083911_add_pppk_to_status_kepegawaian.php`
- Mengubah enum `status_kepegawaian` dari `['pns', 'honor']` menjadi `['pns', 'pppk', 'honor']`

### 2. Controller
**File**: `app/Http/Controllers/GuruController.php`
- Update validasi di method `store()` dan `update()`:
  ```php
  'status_kepegawaian' => 'required|in:pns,pppk,honor',
  ```

### 3. Views

#### a. Form Tambah Guru
**File**: `resources/views/admin/guru/create.blade.php`
- Menambahkan opsi PPPK di dropdown
- Update JavaScript `updateNipLabel()` untuk menangani PPPK

#### b. Form Edit Guru
**File**: `resources/views/admin/guru/edit.blade.php`
- Menambahkan opsi PPPK di dropdown
- Update logika Blade untuk menampilkan label NIP/NUPTK yang benar
- Update JavaScript `updateNipLabel()` untuk menangani PPPK

#### c. Daftar Guru
**File**: `resources/views/admin/guru/index.blade.php`
- Menambahkan badge PPPK dengan warna purple
- Update label NIP/NUPTK menggunakan `in_array()`

#### d. Dashboard
**File**: `resources/views/dashboard.blade.php`
- Menambahkan badge PPPK dengan warna purple
- Update logika NIP/NUPTK untuk menangani PPPK

## 🎨 Tampilan Visual

### Badge Status Kepegawaian
```
┌─────────────────────────────────────┐
│ 👤 PNS    (Biru)                    │
│ 👥 PPPK   (Ungu/Purple)             │
│ 👤 Honor  (Hijau)                   │
└─────────────────────────────────────┘
```

### Form Input
```
Status Kepegawaian: [Dropdown]
├─ Guru Honor
├─ Guru PNS
└─ Guru PPPK

Jika PNS atau PPPK dipilih:
  Label: NIP (Wajib)
  Placeholder: Nomor Induk Pegawai
  Hint: NIP untuk guru PNS / NIP untuk guru PPPK

Jika Honor dipilih:
  Label: NUPTK (Wajib)
  Placeholder: Nomor Unik Pendidik dan Tenaga Kependidikan
  Hint: NUPTK untuk guru honor
```

## 🔧 Cara Menggunakan

### Menambah Guru PPPK Baru
1. Login sebagai admin
2. Buka menu **Kelola Guru**
3. Klik tombol **Tambah Guru**
4. Pilih **Status Kepegawaian**: Guru PPPK
5. Isi **NIP** (bukan NUPTK)
6. Lengkapi data lainnya
7. Klik **Simpan Data**

### Mengubah Guru Menjadi PPPK
1. Login sebagai admin
2. Buka menu **Kelola Guru**
3. Klik tombol **Edit** pada guru yang ingin diubah
4. Ubah **Status Kepegawaian** menjadi **Guru PPPK**
5. Pastikan **NIP** sudah terisi dengan benar
6. Klik **Simpan Perubahan**

## 📊 Database Schema

### Tabel: `users`
```sql
status_kepegawaian ENUM('pns', 'pppk', 'honor') DEFAULT 'honor'
```

## ⚠️ Catatan Penting

1. **NIP vs NUPTK**:
   - PNS dan PPPK menggunakan NIP
   - Honor menggunakan NUPTK
   - Keduanya disimpan di kolom `nip` yang sama di database

2. **Validasi**:
   - Status kepegawaian wajib dipilih
   - NIP/NUPTK wajib diisi
   - NIP/NUPTK harus unik (tidak boleh duplikat)

3. **Backward Compatibility**:
   - Data guru yang sudah ada tetap aman
   - Hanya menambahkan opsi baru, tidak mengubah data lama

## 🚀 Testing

### Test Case 1: Tambah Guru PPPK
1. Buka form tambah guru
2. Pilih status PPPK
3. Verifikasi label berubah menjadi "NIP"
4. Isi NIP dan data lainnya
5. Submit form
6. Verifikasi badge PPPK berwarna purple muncul di daftar guru

### Test Case 2: Edit Guru ke PPPK
1. Buka form edit guru yang sudah ada
2. Ubah status menjadi PPPK
3. Verifikasi label berubah menjadi "NIP"
4. Update dan simpan
5. Verifikasi badge berubah menjadi purple

### Test Case 3: Dashboard Guru PPPK
1. Login sebagai guru dengan status PPPK
2. Buka dashboard
3. Verifikasi badge "Guru PPPK" berwarna purple muncul
4. Verifikasi label menampilkan "NIP"

## 📝 Changelog

### Version 1.1.0 - 2026-02-10
- ✅ Menambahkan status kepegawaian PPPK
- ✅ PPPK menggunakan NIP seperti PNS
- ✅ Badge PPPK dengan warna purple
- ✅ Form dinamis untuk NIP/NUPTK
- ✅ Update semua view terkait
- ✅ Migration database berhasil

## 🔗 Related Files
- Migration: `2026_02_10_083911_add_pppk_to_status_kepegawaian.php`
- Controller: `GuruController.php`
- Views: `create.blade.php`, `edit.blade.php`, `index.blade.php`, `dashboard.blade.php`
- Documentation: `FITUR_STATUS_PPPK.md`
