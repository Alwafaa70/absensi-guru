# 🚀 QUICK START - Auto Bolos

## ⚡ Solusi Cepat untuk Hari Ini

Jika ada guru yang belum ditandai bolos hari ini, jalankan command ini **SEKARANG**:

```bash
php artisan absensi:auto-bolos datang --force
```

Ini akan langsung menandai semua guru yang belum absen sebagai **bolos**.

---

## 🔧 Setup Otomatis (Sekali Setup, Jalan Selamanya)

### Windows - Menggunakan Task Scheduler (RECOMMENDED)

1. **Buka PowerShell sebagai Administrator**
   - Klik kanan pada PowerShell
   - Pilih "Run as Administrator"

2. **Jalankan script setup**
   ```powershell
   cd C:\Users\ridan\absensi-guru
   .\setup-auto-bolos.ps1
   ```

3. **Selesai!** Auto bolos akan jalan otomatis setiap hari:
   - Jam 07:31 → Tandai guru yang tidak absen datang
   - Jam 16:01 → Tandai guru yang tidak absen pulang

---

## 📋 Cara Manual (Jika Tidak Mau Setup Otomatis)

Jalankan command ini setiap hari:

### Setelah Jam 07:30
```bash
php artisan absensi:auto-bolos datang
```

### Setelah Jam 16:00
```bash
php artisan absensi:auto-bolos pulang
```

---

## 🧪 Testing

Untuk test kapan saja (tidak perlu tunggu jam tertentu):

```bash
php artisan absensi:auto-bolos datang --force
php artisan absensi:auto-bolos pulang --force
```

---

## ❓ FAQ

### Q: Kenapa auto bolos tidak jalan otomatis?
**A:** Karena Laravel Scheduler memerlukan setup Task Scheduler di Windows. Gunakan script `setup-auto-bolos.ps1` untuk setup otomatis.

### Q: Apakah harus jalankan manual setiap hari?
**A:** Tidak, jika sudah setup Task Scheduler menggunakan `setup-auto-bolos.ps1`, auto bolos akan jalan otomatis.

### Q: Bagaimana cara cek apakah auto bolos sudah jalan?
**A:** Buka menu **Kelola Absensi** di admin, lihat apakah guru yang tidak absen sudah ditandai bolos.

### Q: Apakah guru bisa mengajukan izin setelah ditandai bolos?
**A:** Ya! Guru bisa mengajukan izin/sakit sampai jam 16:00. Jika admin approve, status akan berubah dari bolos menjadi izin/sakit.

---

## 📖 Dokumentasi Lengkap

Lihat file `CARA_JALANKAN_AUTO_BOLOS.md` untuk dokumentasi lengkap.

---

## ✅ Checklist Setup

- [ ] Jalankan `setup-auto-bolos.ps1` sebagai Administrator
- [ ] Verifikasi task muncul di Task Scheduler
- [ ] Test dengan `Start-ScheduledTask -TaskName "Laravel Auto Bolos Datang"`
- [ ] Cek database apakah ada record bolos baru
- [ ] Selesai! Auto bolos akan jalan otomatis setiap hari
