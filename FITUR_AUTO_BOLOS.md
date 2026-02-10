# Fitur Auto-Bolos Absensi Guru

## 📋 Deskripsi Fitur

Sistem ini secara otomatis menandai guru sebagai **BOLOS** jika:
1. **Tidak absen datang** sampai jam **07:30**
2. **Tidak absen pulang** sampai jam **16:00** (padahal sudah absen datang)

## ⏰ Aturan Waktu

| Jenis Absen | Waktu Mulai | Batas Waktu | Auto-Bolos Jam |
|-------------|-------------|-------------|----------------|
| Absen Datang | 05:30 | 07:30 | 07:31 |
| Absen Pulang | 12:00 | 16:00 | 16:01 |

## 🔄 Alur Kerja

### Skenario 1: Tidak Absen Datang
```
07:00 - Guru belum absen datang
07:30 - Batas waktu terlewat
07:31 - Sistem otomatis membuat record dengan status "bolos"
```

### Skenario 2: Tidak Absen Pulang
```
07:00 - Guru absen datang (status: hadir)
16:00 - Batas waktu absen pulang terlewat
16:01 - Sistem otomatis mengubah status menjadi "bolos"
```

### Skenario 3: Mengajukan Izin/Sakit Setelah Bolos
```
07:31 - Guru otomatis ditandai bolos (tidak absen datang)
12:00 - Guru mengajukan izin/sakit
      - Record bolos diupdate menjadi pengajuan izin/sakit
      - Status: pending (menunggu approval admin)
      - Jika disetujui: status berubah dari bolos → izin/sakit
      - Jika ditolak: status kembali ke tidak_hadir
```

### Skenario 4: Pengajuan Setelah Jam 16:00
```
16:01 - Status bolos sudah MUTLAK/FINAL
      - Tidak bisa mengajukan izin/sakit lagi
      - Pesan error: "Batas waktu pengajuan izin/sakit sudah lewat (16:00)"
```

## 🚫 Pengecualian

Sistem **TIDAK** akan menandai bolos jika:
- ✅ Hari **Sabtu** atau **Minggu**
- ✅ Hari **Libur Nasional** (sesuai data di tabel `holidays`)

## 🤖 Cara Kerja Otomatis

### 1. Task Scheduler (Cron Job)

Sistem menggunakan Laravel Task Scheduler yang berjalan otomatis:

```php
// app/Console/Kernel.php

// Auto-bolos jika tidak absen datang
$schedule->command('absensi:auto-bolos datang')
    ->dailyAt('07:31')
    ->timezone('Asia/Jakarta');

// Auto-bolos jika tidak absen pulang
$schedule->command('absensi:auto-bolos pulang')
    ->dailyAt('16:01')
    ->timezone('Asia/Jakarta');
```

### 2. Menjalankan Scheduler

**Di Production (Server):**
Tambahkan cron job di server:
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

**Di Development (Testing Manual):**
```bash
# Test auto-bolos datang
php artisan absensi:auto-bolos datang

# Test auto-bolos pulang
php artisan absensi:auto-bolos pulang

# Atau jalankan scheduler secara manual
php artisan schedule:work
```

## 💾 Status Absensi

| Status | Deskripsi |
|--------|-----------|
| `hadir` | Guru hadir tepat waktu |
| `telat` | Guru hadir tapi telat |
| `izin` | Guru mengajukan izin (perlu approval) |
| `sakit` | Guru mengajukan sakit (perlu approval) |
| `bolos` | **[NEW]** Guru tidak absen sama sekali |
| `tidak_hadir` | Status umum untuk tidak hadir |

## 📊 Tampilan di Sistem

### 1. Riwayat Absensi Guru
- Status "bolos" akan muncul dengan badge merah
- Keterangan otomatis: "Otomatis ditandai bolos karena tidak absen datang sampai jam 07:30"

### 2. Kelola Absensi Admin
- Admin dapat melihat semua guru yang bolos
- Admin dapat mengubah status bolos menjadi status lain jika ada kesalahan
- Admin dapat approve/reject pengajuan izin/sakit yang mengubah status bolos

### 3. Dashboard
- Statistik bolos akan muncul di dashboard admin
- Guru dapat melihat status bolos di dashboard mereka

## 🔧 File yang Diubah/Ditambahkan

1. **app/Console/Commands/AutoMarkBolos.php** (NEW)
   - Command untuk auto-mark bolos

2. **app/Console/Kernel.php** (UPDATED)
   - Scheduler untuk menjalankan command otomatis

3. **app/Http/Controllers/AbsensiController.php** (UPDATED)
   - Logika pengajuan izin/sakit bisa update record bolos

4. **app/Http/Controllers/AbsensiAdminController.php** (UPDATED)
   - Validation menerima status 'bolos'

5. **database/migrations/2026_02_04_060720_add_bolos_status_to_absensis_table.php** (NEW)
   - Migration dokumentasi untuk status bolos

## 🧪 Testing

### Test Manual Command:
```bash
# Test auto-bolos datang (akan mark semua guru yang belum absen hari ini)
php artisan absensi:auto-bolos datang

# Test auto-bolos pulang (akan mark guru yang sudah absen datang tapi belum pulang)
php artisan absensi:auto-bolos pulang
```

### Test Skenario Lengkap:
1. Pastikan ada guru yang belum absen hari ini
2. Jalankan command `php artisan absensi:auto-bolos datang`
3. Cek database atau halaman admin, guru tersebut harus berstatus "bolos"
4. Guru coba mengajukan izin/sakit
5. Admin approve pengajuan
6. Status harus berubah dari "bolos" menjadi "izin/sakit"

## ⚠️ Catatan Penting

1. **Timezone**: Pastikan timezone server sudah di-set ke `Asia/Jakarta`
2. **Cron Job**: Di production, pastikan cron job sudah berjalan dengan benar
3. **Testing Mode**: Jika `config('app.testing_absensi')` = true, validasi waktu akan di-skip
4. **Hari Libur**: Pastikan data hari libur selalu update di tabel `holidays`

## 📝 Log & Monitoring

Command akan menampilkan output:
```
✓ Muhammad Alvafaz K. S.T ditandai bolos (tidak absen datang)
✓ Rapir Joy S.Pd ditandai bolos (tidak absen datang)
Total 2 guru ditandai bolos karena tidak absen datang.
```

Anda bisa redirect output ke log file:
```bash
php artisan absensi:auto-bolos datang >> storage/logs/auto-bolos.log 2>&1
```

## 🎯 Kesimpulan

Fitur ini memastikan bahwa:
- ✅ Guru yang tidak absen akan otomatis tercatat sebagai bolos
- ✅ Data absensi selalu akurat dan real-time
- ✅ Admin tidak perlu manual input data bolos
- ✅ Guru masih punya kesempatan mengajukan izin/sakit sampai jam 16:00
- ✅ Sistem fair dan transparan untuk semua pihak
