# 🔐 Hak Akses Admin vs Guru - Sistem Absensi

## 📋 Ringkasan

Sistem absensi memiliki **dua level akses** dengan hak yang berbeda:

| Fitur | GURU | ADMIN |
|-------|------|-------|
| Absen Datang/Pulang | ✅ (dengan batasan waktu) | ❌ (tidak perlu) |
| Mengajukan Izin/Sakit | ✅ (sampai jam 16:00) | ❌ (tidak perlu) |
| Melihat Riwayat Sendiri | ✅ | ✅ |
| **Mengubah Status Absensi** | ❌ **TIDAK BISA** | ✅ **BISA SEMUA** |
| Approve/Reject Pengajuan | ❌ | ✅ |
| Melihat Semua Data | ❌ | ✅ |

---

## 🎯 Konsep "Mutlak" yang Benar

### **Untuk GURU:**

Status absensi menjadi **"mutlak"** setelah jam **16:00**, artinya:

❌ **TIDAK BISA:**
- Mengajukan izin/sakit baru
- Mengubah status yang sudah ada
- Menghapus record absensi

✅ **BISA:**
- Melihat riwayat absensi (read-only)
- Melihat status bolos yang sudah ditetapkan

**Contoh Skenario Guru:**
```
07:31 → Guru otomatis ditandai BOLOS (tidak absen datang)
12:00 → Guru coba ajukan izin → ✅ BISA (masih sebelum jam 16:00)
16:01 → Guru coba ajukan izin → ❌ DITOLAK (sudah lewat jam 16:00)
      → Pesan: "Batas waktu pengajuan izin/sakit sudah lewat (16:00)"
```

---

### **Untuk ADMIN:**

Status absensi **TIDAK PERNAH MUTLAK**, artinya:

✅ **SELALU BISA:**
- Mengubah status apapun kapan saja
- Mengubah bolos → hadir/izin/sakit/dll
- Mengubah hadir → bolos
- Mengedit jam datang/pulang
- Menambah/mengurangi menit telat
- Mengubah keterangan

⏰ **TIDAK ADA BATASAN WAKTU** untuk admin!

**Contoh Skenario Admin:**
```
Jam 07:31 → Guru ditandai BOLOS otomatis
Jam 17:00 → Admin buka "Kelola Absensi"
          → Admin bisa ubah BOLOS → IZIN ✅
          → Admin bisa ubah BOLOS → HADIR ✅
          → Admin bisa ubah BOLOS → SAKIT ✅
          → Admin bisa ubah ke status apapun! ✅
```

---

## 🛠️ Fitur Kelola Absensi Admin

### **1. Halaman List Absensi**
**URL:** `/admin/absensi`

**Fitur:**
- ✅ Filter berdasarkan tanggal
- ✅ Filter berdasarkan nama guru
- ✅ Filter berdasarkan status (termasuk 'bolos')
- ✅ Sorting (terbaru/terlama)
- ✅ Approve/Reject pengajuan izin/sakit
- ✅ Edit data absensi

**Status yang Tersedia di Filter:**
- ✅ Hadir
- ⏰ Telat
- 📝 Izin
- 🏥 Sakit
- ❌ Bolos (Auto)
- ⛔ Tidak Hadir

---

### **2. Halaman Edit Absensi**
**URL:** `/admin/absensi/{id}/edit`

**Field yang Bisa Diubah:**
1. **Status Kehadiran** (dropdown):
   - ✅ Hadir
   - ⏰ Telat
   - 📝 Izin
   - 🏥 Sakit
   - ❌ Bolos (Auto)
   - ⛔ Tidak Hadir

2. **Jam Masuk** (time picker)
3. **Jam Pulang** (time picker)
4. **Menit Telat** (number input)
5. **Keterangan/Catatan** (textarea)

**Validasi:**
- ✅ Semua field opsional (bisa dikosongkan)
- ✅ Tidak ada batasan waktu
- ✅ Admin punya kontrol penuh

**Catatan di Form:**
> "Admin dapat mengubah status apapun, termasuk status bolos otomatis."

---

## 🔄 Alur Kerja Admin

### **Skenario 1: Guru Bolos, Admin Ubah Jadi Izin**

```
1. Guru tidak absen sampai jam 07:30
2. Jam 07:31 → Sistem auto-mark BOLOS
3. Jam 08:00 → Admin buka "Kelola Absensi"
4. Admin lihat guru X status BOLOS
5. Admin klik "Edit"
6. Admin ubah status: BOLOS → IZIN
7. Admin isi keterangan: "Izin sakit, konfirmasi via WA"
8. Admin klik "Simpan Data"
9. ✅ Status berubah jadi IZIN
```

### **Skenario 2: Guru Mengajukan Izin Setelah Bolos**

```
1. Jam 07:31 → Guru ditandai BOLOS (tidak absen)
2. Jam 12:00 → Guru ajukan izin via sistem
3. Status berubah: BOLOS → IZIN (Pending)
4. Admin buka "Kelola Absensi"
5. Admin lihat status: "Menunggu Persetujuan (Izin)"
6. Admin klik tombol ✅ "Setujui"
7. ✅ Status jadi IZIN (approved)
```

**Atau jika ditolak:**
```
6. Admin klik tombol ❌ "Tolak"
7. ❌ Status jadi TIDAK HADIR
```

### **Skenario 3: Koreksi Data Salah**

```
1. Guru hadir tapi lupa absen pulang
2. Jam 16:01 → Sistem auto-mark BOLOS
3. Guru lapor ke admin: "Pak saya hadir kok, cuma lupa absen pulang"
4. Admin buka "Kelola Absensi"
5. Admin klik "Edit" pada data guru tersebut
6. Admin ubah:
   - Status: BOLOS → HADIR
   - Jam Masuk: 07:00:00
   - Jam Pulang: 15:30:00 (manual input)
   - Keterangan: "Lupa absen pulang, dikonfirmasi manual"
7. Admin klik "Simpan Data"
8. ✅ Data terkoreksi
```

---

## 🎨 Tampilan Status di Sistem

### **Badge Status:**

| Status | Badge | Warna |
|--------|-------|-------|
| Hadir | ✅ Hadir | Hijau |
| Telat | ⏰ Telat | Orange |
| Izin | 📝 Izin | Biru |
| Sakit | 🏥 Sakit | Ungu |
| Bolos (Auto) | ❌ Bolos (Auto) | Merah |
| Tidak Hadir | ⛔ Tidak Hadir | Abu-abu |
| Pending | ⏳ Menunggu Persetujuan | Kuning |

---

## ⚖️ Perbedaan Status "Bolos" vs "Tidak Hadir"

| Aspek | BOLOS | TIDAK HADIR |
|-------|-------|-------------|
| **Cara Dibuat** | Otomatis oleh sistem | Manual oleh admin |
| **Waktu** | Jam 07:31 atau 16:01 | Kapan saja |
| **Keterangan** | "Otomatis ditandai bolos..." | Custom oleh admin |
| **Bisa Diubah Guru?** | ❌ Tidak (setelah jam 16:00) | ❌ Tidak |
| **Bisa Diubah Admin?** | ✅ Ya, kapan saja | ✅ Ya, kapan saja |

**Rekomendasi Penggunaan:**
- **BOLOS**: Untuk yang benar-benar tidak hadir tanpa keterangan
- **TIDAK HADIR**: Untuk kasus khusus yang perlu dicatat manual oleh admin

---

## 🔒 Keamanan & Audit Trail

### **Log Perubahan:**
Setiap perubahan yang dilakukan admin akan tercatat di:
- `updated_at` timestamp di database
- Keterangan field (jika admin menambahkan catatan)

### **Best Practice:**
1. ✅ Selalu isi keterangan saat mengubah status
2. ✅ Dokumentasikan alasan perubahan
3. ✅ Konfirmasi dengan guru sebelum mengubah data
4. ✅ Backup database secara berkala

---

## 📝 Kesimpulan

### **Untuk Guru:**
- ❌ Status "mutlak" setelah jam 16:00
- ❌ Tidak bisa mengubah data sendiri
- ✅ Bisa mengajukan izin/sakit sampai jam 16:00

### **Untuk Admin:**
- ✅ **KONTROL PENUH** kapan saja
- ✅ Bisa mengubah **SEMUA STATUS**
- ✅ Bisa mengoreksi data yang salah
- ✅ **TIDAK ADA BATASAN WAKTU**

### **Prinsip Utama:**
> **"Admin adalah penguasa tertinggi sistem absensi. Guru hanya bisa mengajukan, admin yang memutuskan."**

---

**Terakhir diupdate:** 4 Februari 2026, 08:15 WIB
