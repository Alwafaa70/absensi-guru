# 📬 Fitur Informasi & Notifikasi - Dokumentasi Lengkap

## ✨ Ringkasan Fitur

Sistem notifikasi/informasi yang mirip dengan aplikasi sosial media (Facebook, Instagram) untuk komunikasi antara admin dan guru.

### **Untuk Guru:**
- Menu **"Informasi"** untuk melihat semua notifikasi
- Badge notifikasi belum dibaca di menu
- Notifikasi otomatis untuk berbagai event

### **Untuk Admin:**
- Menu **"Broadcast"** untuk kirim pesan ke semua guru
- Bisa mengetik pesan dan upload foto
- Riwayat broadcast yang pernah dikirim

---

## 🎯 Jenis Notifikasi Otomatis

### 1. **Pengajuan Izin/Sakit (Pending)**
**Kapan**: Saat guru mengajukan izin atau sakit

**Contoh Notifikasi:**
```
⏳ Pengajuan Izin
Pengajuan izin Anda sedang menunggu persetujuan admin. 
Keterangan: Sakit demam
```

### 2. **Persetujuan Izin/Sakit (Approved)**
**Kapan**: Saat admin menyetujui pengajuan izin/sakit

**Contoh Notifikasi:**
```
✅ Pengajuan Izin Disetujui
Pengajuan izin Anda untuk tanggal 10 Februari 2026 telah disetujui oleh admin.
```

### 3. **Penolakan Izin/Sakit (Rejected)**
**Kapan**: Saat admin menolak pengajuan izin/sakit

**Contoh Notifikasi:**
```
❌ Pengajuan Izin Ditolak
Pengajuan izin Anda untuk tanggal 10 Februari 2026 telah ditolak oleh admin. 
Status diubah menjadi bolos.
```

### 4. **Broadcast dari Admin**
**Kapan**: Saat admin mengirim pesan broadcast

**Contoh Notifikasi:**
```
📢 Informasi Penting - Rapat Guru
Besok Senin, 11 Februari 2026 akan ada rapat guru pukul 13:00 di ruang guru. 
Harap semua guru hadir tepat waktu.
[Foto lampiran jika ada]
```

---

## 📱 Tampilan Menu Informasi (Guru)

### Fitur:
- **Badge notifikasi** di menu (angka merah)
- **Notifikasi belum dibaca** ditandai dengan border biru dan badge "BARU"
- **Icon berbeda** untuk setiap jenis notifikasi
- **Timestamp** yang user-friendly (contoh: "2 jam yang lalu")
- **Tombol aksi**: Tandai Dibaca, Hapus
- **Pagination** untuk notifikasi banyak

### Tampilan:
```
┌─────────────────────────────────────────────────────────────┐
│ 📬 Informasi & Notifikasi                  [✓ Tandai Semua] │
├─────────────────────────────────────────────────────────────┤
│ 🔔 Anda memiliki 3 notifikasi belum dibaca                  │
├─────────────────────────────────────────────────────────────┤
│ ┌─────────────────────────────────────────────────────┐     │
│ │ ✅ Pengajuan Izin Disetujui              [BARU]     │     │
│ │ Pengajuan izin Anda untuk tanggal 10 Februari 2026  │     │
│ │ telah disetujui oleh admin.                         │     │
│ │ 🕐 10 Februari 2026, 08:30 • 2 jam yang lalu        │     │
│ │ [Tandai Dibaca] [Hapus]                             │     │
│ └─────────────────────────────────────────────────────┘     │
│                                                              │
│ ┌─────────────────────────────────────────────────────┐     │
│ │ 📢 Informasi Penting - Rapat Guru                   │     │
│ │ Besok Senin akan ada rapat guru pukul 13:00...      │     │
│ │ [Foto lampiran]                                      │     │
│ │ 🕐 9 Februari 2026, 15:00 • Kemarin                 │     │
│ │ [Hapus]                                              │     │
│ └─────────────────────────────────────────────────────┘     │
└─────────────────────────────────────────────────────────────┘
```

---

## 📢 Tampilan Broadcast (Admin)

### Form Kirim Broadcast:
```
┌─────────────────────────────────────────────────────────────┐
│ 📢 Kirim Informasi ke Semua Guru      [Riwayat Broadcast]  │
├─────────────────────────────────────────────────────────────┤
│ Judul Informasi *                                           │
│ [Contoh: Informasi Penting - Rapat Guru              ]     │
│                                                              │
│ Pesan *                                                      │
│ ┌───────────────────────────────────────────────────┐       │
│ │ Tulis pesan informasi yang ingin disampaikan...   │       │
│ │                                                    │       │
│ │                                                    │       │
│ └───────────────────────────────────────────────────┘       │
│ 💡 Tip: Tulis pesan dengan jelas dan lengkap                │
│                                                              │
│ Lampiran Foto (Opsional)                                    │
│ ┌───────────────────────────────────────────────────┐       │
│ │         📷                                         │       │
│ │    [Upload foto] atau drag and drop               │       │
│ │    PNG, JPG, GIF hingga 2MB                        │       │
│ └───────────────────────────────────────────────────┘       │
│                                                              │
│ ⚠️ Perhatian: Pesan ini akan dikirim ke SEMUA GURU          │
│                                                              │
│ [← Kembali]                      [📢 Kirim ke Semua Guru]   │
└─────────────────────────────────────────────────────────────┘
```

### Riwayat Broadcast:
```
┌─────────────────────────────────────────────────────────────┐
│ 📋 Riwayat Broadcast                  [➕ Kirim Broadcast]  │
├─────────────────────────────────────────────────────────────┤
│ ┌─────────────────────────────────────────────────────┐     │
│ │ 📢 Informasi Penting - Rapat Guru                   │     │
│ │ Besok Senin, 11 Februari 2026 akan ada rapat guru   │     │
│ │ pukul 13:00 di ruang guru. Harap semua guru hadir.  │     │
│ │ [Foto lampiran]                                      │     │
│ │ 🕐 10 Februari 2026, 15:00 • 2 jam yang lalu        │     │
│ └─────────────────────────────────────────────────────┘     │
└─────────────────────────────────────────────────────────────┘
```

---

## 🔧 Technical Details

### Database Structure

**Table: `notifications`**
```sql
- id (bigint, primary key)
- user_id (bigint, foreign key to users)
- type (string) - Jenis notifikasi
- broadcast_id (string, nullable, indexed) - ID unik untuk mengelompokkan broadcast yang sama
- title (string) - Judul notifikasi
- message (text) - Isi pesan
- image (string, nullable) - Path foto
- related_absensi_id (bigint, nullable, foreign key to absensis)
- is_read (boolean, default: false)
- created_at (timestamp)
- updated_at (timestamp)
```

### Notification Types:
- `izin_pending` - Pengajuan izin menunggu persetujuan
- `izin_approved` - Pengajuan izin disetujui
- `izin_rejected` - Pengajuan izin ditolak
- `sakit_pending` - Pengajuan sakit menunggu persetujuan
- `sakit_approved` - Pengajuan sakit disetujui
- `sakit_rejected` - Pengajuan sakit ditolak
- `broadcast` - Pesan broadcast dari admin
- `holiday` - Informasi hari libur (future feature)

---

## 📁 File yang Dibuat/Dimodifikasi

### **Models:**
- ✅ `app/Models/Notification.php` (NEW)

### **Controllers:**
- ✅ `app/Http/Controllers/NotificationController.php` (NEW)
- ✅ `app/Http/Controllers/Admin/BroadcastController.php` (NEW)
- ✅ `app/Http/Controllers/AbsensiController.php` (UPDATED)
- ✅ `app/Http/Controllers/AbsensiAdminController.php` (UPDATED)

### **Migrations:**
- ✅ `database/migrations/2026_02_10_031417_create_notifications_table.php` (NEW)
- ✅ `database/migrations/2026_02_10_033022_add_broadcast_id_to_notifications_table.php` (NEW)

### **Routes:**
- ✅ `routes/web.php` (UPDATED)

### **Views:**
- ✅ `resources/views/guru/notifications/index.blade.php` (NEW)
- ✅ `resources/views/admin/broadcast/create.blade.php` (NEW)
- ✅ `resources/views/admin/broadcast/index.blade.php` (NEW)
- ✅ `resources/views/admin/broadcast/edit.blade.php` (NEW)
- ✅ `resources/views/layouts/navigation.blade.php` (UPDATED)

---

## 🚀 Cara Penggunaan

### **Untuk Guru:**

#### 1. Melihat Notifikasi
1. Login sebagai guru
2. Klik menu **"📬 Informasi"** di navigation bar
3. Lihat semua notifikasi yang masuk
4. Badge merah di menu menunjukkan jumlah notifikasi belum dibaca

#### 2. Menandai Notifikasi Dibaca
- Klik tombol **"Tandai Dibaca"** pada notifikasi tertentu
- Atau klik **"✓ Tandai Semua Dibaca"** untuk semua notifikasi

#### 3. Menghapus Notifikasi
- Klik tombol **"Hapus"** pada notifikasi yang ingin dihapus
- Konfirmasi penghapusan

---

### **Untuk Admin:**

#### 1. Kirim Broadcast ke Semua Guru
1. Login sebagai admin
2. Klik menu **"📢 Broadcast"** di navigation bar
3. Isi form:
   - **Judul**: Judul informasi (wajib)
   - **Pesan**: Isi pesan (wajib)
   - **Foto**: Upload foto (opsional, max 2MB)
4. Klik **"📢 Kirim ke Semua Guru"**
5. Pesan akan otomatis terkirim ke semua guru

#### 2. Melihat Riwayat Broadcast
1. Klik menu **"📢 Broadcast"**
2. Lihat semua broadcast yang pernah dikirim
3. Setiap broadcast menampilkan:
   - Judul dan pesan
   - Foto (jika ada)
   - Timestamp
   - Tombol **Edit** dan **Hapus**

#### 3. Edit Broadcast yang Sudah Dikirim
1. Di halaman Riwayat Broadcast
2. Klik tombol **"Edit"** pada broadcast yang ingin diubah
3. Form edit akan muncul dengan data broadcast saat ini
4. Ubah judul, pesan, atau ganti foto
5. Klik **"💾 Simpan Perubahan"**
6. **Perubahan akan otomatis ter-update untuk SEMUA guru** yang menerima broadcast tersebut

**Catatan Penting:**
- Saat edit broadcast, semua notifikasi yang terkait dengan broadcast tersebut akan diperbarui
- Jika mengganti foto, foto lama akan otomatis dihapus
- Guru akan melihat versi terbaru dari broadcast

#### 4. Hapus Broadcast
1. Di halaman Riwayat Broadcast
2. Klik tombol **"Hapus"** pada broadcast yang ingin dihapus
3. Konfirmasi penghapusan
4. **Broadcast akan dihapus dari SEMUA guru** yang menerima broadcast tersebut

**Catatan Penting:**
- Saat hapus broadcast, semua notifikasi yang terkait akan dihapus dari semua guru
- Foto yang dilampirkan juga akan dihapus dari storage
- Aksi ini tidak bisa dibatalkan (permanent delete)

---

## 🎨 Visual Design

### Warna Badge Notifikasi:
- **Pending** (⏳): `bg-yellow-100 text-yellow-800`
- **Approved** (✅): `bg-green-100 text-green-800`
- **Rejected** (❌): `bg-red-100 text-red-800`
- **Broadcast** (📢): `bg-purple-100 text-purple-800`
- **Holiday** (🏖️): `bg-blue-100 text-blue-800`

### Badge "BARU":
- Background: `bg-blue-600`
- Text: `text-white`
- Font: `font-bold`

### Notifikasi Belum Dibaca:
- Border: `border-blue-400`
- Ring: `ring-2 ring-blue-100`

---

## 🔄 Flow Notifikasi Otomatis

### 1. Pengajuan Izin/Sakit:
```
Guru mengajukan izin/sakit
    ↓
AbsensiController@store
    ↓
Buat record absensi (pending: true)
    ↓
Buat notifikasi untuk guru (type: izin_pending/sakit_pending)
    ↓
Guru melihat notifikasi "Menunggu Persetujuan"
```

### 2. Persetujuan Admin:
```
Admin klik "Setujui"
    ↓
AbsensiAdminController@approve
    ↓
Update absensi (pending: false, is_valid: true)
    ↓
Buat notifikasi untuk guru (type: izin_approved/sakit_approved)
    ↓
Guru melihat notifikasi "Disetujui"
```

### 3. Penolakan Admin:
```
Admin klik "Tolak"
    ↓
AbsensiAdminController@reject
    ↓
Update absensi (status: bolos, pending: false)
    ↓
Buat notifikasi untuk guru (type: izin_rejected/sakit_rejected)
    ↓
Guru melihat notifikasi "Ditolak"
```

### 4. Broadcast Admin:
```
Admin isi form broadcast
    ↓
BroadcastController@store
    ↓
Upload foto (jika ada)
    ↓
Loop semua guru
    ↓
Buat notifikasi untuk setiap guru (type: broadcast)
    ↓
Semua guru melihat notifikasi broadcast
```

---

## 📊 Statistik & Monitoring

### Unread Count (Badge):
```php
$unreadCount = Notification::where('user_id', auth()->id())
    ->where('is_read', false)
    ->count();
```

### Total Notifikasi Guru:
```php
$totalNotifications = Notification::where('user_id', auth()->id())->count();
```

### Total Broadcast Admin:
```php
$totalBroadcasts = Notification::where('type', 'broadcast')
    ->select('title', 'message', 'created_at')
    ->groupBy('title', 'message', 'created_at')
    ->count();
```

---

## 🧪 Testing

### Test Notifikasi Pengajuan:
1. Login sebagai guru
2. Ajukan izin/sakit
3. Cek menu "Informasi" → Harus ada notifikasi "Menunggu Persetujuan"

### Test Notifikasi Persetujuan:
1. Login sebagai admin
2. Setujui pengajuan izin/sakit
3. Login sebagai guru yang mengajukan
4. Cek menu "Informasi" → Harus ada notifikasi "Disetujui"

### Test Notifikasi Penolakan:
1. Login sebagai admin
2. Tolak pengajuan izin/sakit
3. Login sebagai guru yang mengajukan
4. Cek menu "Informasi" → Harus ada notifikasi "Ditolak"

### Test Broadcast:
1. Login sebagai admin
2. Kirim broadcast dengan judul dan pesan
3. Login sebagai berbagai guru
4. Cek menu "Informasi" → Semua guru harus menerima notifikasi yang sama

### Test Upload Foto:
1. Login sebagai admin
2. Kirim broadcast dengan foto
3. Login sebagai guru
4. Cek menu "Informasi" → Foto harus muncul di notifikasi

---

## 🎯 Keuntungan Fitur Ini

### 1. **Komunikasi Real-time** 📱
- Guru langsung tahu status pengajuan mereka
- Admin bisa kirim info penting dengan cepat
- Tidak perlu WhatsApp atau aplikasi lain

### 2. **User Experience** 😊
- Interface mirip sosial media (familiar)
- Badge notifikasi yang jelas
- Timestamp yang user-friendly

### 3. **Transparansi** ✅
- Guru tahu kapan pengajuan disetujui/ditolak
- Riwayat notifikasi tersimpan
- Admin bisa tracking broadcast yang dikirim

### 4. **Efisiensi** 🚀
- Broadcast ke semua guru sekaligus
- Tidak perlu kirim pesan satu-satu
- Upload foto untuk info lebih jelas

---

## 📞 Troubleshooting

### Notifikasi tidak muncul?
1. Pastikan migration sudah dijalankan: `php artisan migrate`
2. Clear cache: `php artisan cache:clear`
3. Cek database: Apakah ada record di table `notifications`?

### Badge notifikasi tidak update?
1. Refresh halaman (F5)
2. Clear browser cache
3. Pastikan query unread count benar

### Foto tidak muncul?
1. Pastikan folder `storage/broadcasts` ada
2. Jalankan: `php artisan storage:link`
3. Cek permission folder storage

### Broadcast tidak terkirim ke semua guru?
1. Cek jumlah guru di database
2. Cek log Laravel: `storage/logs/laravel.log`
3. Pastikan tidak ada error saat loop

---

## ✅ Checklist Implementasi

- [x] Migration `notifications` table
- [x] Migration `broadcast_id` column
- [x] Model `Notification`
- [x] Controller `NotificationController` (Guru)
- [x] Controller `BroadcastController` (Admin)
- [x] Update `AbsensiController` (auto-notification)
- [x] Update `AbsensiAdminController` (auto-notification)
- [x] Routes untuk notifikasi & broadcast
- [x] View `guru/notifications/index.blade.php`
- [x] View `admin/broadcast/create.blade.php`
- [x] View `admin/broadcast/index.blade.php`
- [x] View `admin/broadcast/edit.blade.php`
- [x] Update navigation dengan menu baru
- [x] Badge notifikasi belum dibaca
- [x] **Fitur Edit Broadcast**
- [x] **Fitur Hapus Broadcast**
- [x] Dokumentasi lengkap

---

**Fitur ini sudah siap digunakan!** 🎉

Guru sekarang bisa:
- ✅ Melihat notifikasi pengajuan izin/sakit
- ✅ Melihat status persetujuan/penolakan
- ✅ Menerima broadcast dari admin
- ✅ Menandai notifikasi sebagai dibaca
- ✅ Menghapus notifikasi

Admin sekarang bisa:
- ✅ Kirim broadcast ke semua guru
- ✅ Upload foto di broadcast
- ✅ Melihat riwayat broadcast
- ✅ **Edit broadcast yang sudah dikirim**
- ✅ **Hapus broadcast yang sudah dikirim**
- ✅ Notifikasi otomatis saat approve/reject
