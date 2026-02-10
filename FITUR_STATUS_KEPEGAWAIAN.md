# 👥 Fitur Status Kepegawaian Guru (PNS & Honor) - Dokumentasi

## ✨ Ringkasan Fitur

Sistem untuk membedakan guru berdasarkan status kepegawaian (PNS atau Honor) dengan nomor identitas yang sesuai:
- **Guru PNS** → menggunakan **NIP** (Nomor Induk Pegawai)
- **Guru Honor** → menggunakan **NUPTK** (Nomor Unik Pendidik dan Tenaga Kependidikan)

---

## 🎯 Tujuan Fitur

1. **Membedakan status kepegawaian** guru PNS dan Honor
2. **Nomor identitas yang sesuai** (NIP untuk PNS, NUPTK untuk Honor)
3. **Badge visual** untuk identifikasi cepat
4. **Form dinamis** yang menyesuaikan label sesuai status

---

## 📊 Database Structure

### **Kolom Baru di Table `users`:**
```sql
status_kepegawaian ENUM('pns', 'honor') DEFAULT 'honor'
```

**Nilai:**
- `pns` - Guru PNS (Pegawai Negeri Sipil)
- `honor` - Guru Honor (Non-PNS)

---

## 🎨 Visual Design

### **Badge Status:**

#### **Guru PNS:**
```
┌─────────────────────┐
│ 👥 Guru PNS         │  ← Badge biru
└─────────────────────┘
```
- Background: `bg-blue-100`
- Text: `text-blue-800`
- Icon: Multiple users icon

#### **Guru Honor:**
```
┌─────────────────────┐
│ 👤 Guru Honor       │  ← Badge hijau
└─────────────────────┘
```
- Background: `bg-green-100`
- Text: `text-green-800`
- Icon: Single user icon

---

## 📱 Tampilan di Berbagai Halaman

### **1. Dashboard Guru**
```
┌──────────────────────────────────────┐
│  [Selamat Datang 🙌 | Waktu: 10:30]  │
│                                       │
│         [Foto Profil]                 │
│                                       │
│        Nama Guru                      │
│     197801012005011001                │
│            NIP                        │
│                                       │
│      [👥 Guru PNS]                    │
│      [✓ Guru Access]                  │
└──────────────────────────────────────┘
```

### **2. Kelola Guru (Admin)**
```
┌─────────────────────────────────────────────────────────────┐
│ No │ Nama Guru      │ Status      │ NIP/NUPTK    │ Email   │
├────┼────────────────┼─────────────┼──────────────┼─────────┤
│ 1  │ Budi Santoso   │ [👥 PNS]    │ 1978...      │ budi@   │
│    │                │             │ NIP          │         │
├────┼────────────────┼─────────────┼──────────────┼─────────┤
│ 2  │ Ani Wijaya     │ [👤 Honor]  │ 1234...      │ ani@    │
│    │                │             │ NUPTK        │         │
└─────────────────────────────────────────────────────────────┘
```

### **3. Form Tambah/Edit Guru**
```
┌──────────────────────────────────────┐
│ Status Kepegawaian                   │
│ [Guru Honor ▼]                       │  ← Dropdown
│ ℹ️ Pilih status kepegawaian guru     │
│                                       │
│ NUPTK (Wajib)                        │  ← Label berubah otomatis
│ [Nomor Unik Pendidik...]             │
│ NUPTK untuk guru honor               │
└──────────────────────────────────────┘

Jika pilih "Guru PNS":
┌──────────────────────────────────────┐
│ Status Kepegawaian                   │
│ [Guru PNS ▼]                         │
│ ℹ️ Pilih status kepegawaian guru     │
│                                       │
│ NIP (Wajib)                          │  ← Label berubah
│ [Nomor Induk Pegawai]                │
│ NIP untuk guru PNS                   │
└──────────────────────────────────────┘
```

---

## 🔧 Technical Implementation

### **1. Migration**
```php
Schema::table('users', function (Blueprint $table) {
    $table->enum('status_kepegawaian', ['pns', 'honor'])
          ->default('honor')
          ->after('role');
});
```

### **2. Model (User.php)**
```php
protected $fillable = [
    'name',
    'email',
    'password',
    'foto_profile',
    'nip',
    'status_kepegawaian', // ← Ditambahkan
];
```

### **3. Controller Validation**
```php
// GuruController@store & update
$request->validate([
    'name' => 'required',
    'email' => 'required|email|unique:users',
    'password' => 'required|min:6',
    'nip' => 'required|unique:users,nip',
    'status_kepegawaian' => 'required|in:pns,honor', // ← Ditambahkan
]);
```

### **4. Dynamic Label (JavaScript)**
```javascript
function updateNipLabel() {
    const status = document.getElementById('status_kepegawaian').value;
    const label = document.getElementById('nip-label');
    const input = document.getElementById('nip');
    const hint = document.getElementById('nip-hint');
    
    if (status === 'pns') {
        label.textContent = 'NIP';
        input.placeholder = 'Nomor Induk Pegawai';
        hint.textContent = 'NIP untuk guru PNS';
    } else {
        label.textContent = 'NUPTK';
        input.placeholder = 'Nomor Unik Pendidik dan Tenaga Kependidikan';
        hint.textContent = 'NUPTK untuk guru honor';
    }
}
```

---

## 📁 File yang Dibuat/Dimodifikasi

### **Migrations:**
- ✅ `database/migrations/2026_02_10_034705_add_status_kepegawaian_to_users_table.php` (NEW)

### **Seeders:**
- ✅ `database/seeders/UpdateGuruStatusSeeder.php` (NEW)

### **Models:**
- ✅ `app/Models/User.php` (UPDATED)

### **Controllers:**
- ✅ `app/Http/Controllers/GuruController.php` (UPDATED)

### **Views:**
- ✅ `resources/views/admin/guru/create.blade.php` (UPDATED)
- ✅ `resources/views/admin/guru/edit.blade.php` (UPDATED)
- ✅ `resources/views/admin/guru/index.blade.php` (UPDATED)
- ✅ `resources/views/dashboard.blade.php` (UPDATED)

---

## 🚀 Cara Penggunaan

### **Untuk Admin:**

#### **1. Tambah Guru Baru**
1. Login sebagai admin
2. Klik **"Kelola Guru"** → **"Tambah Guru"**
3. Pilih **Status Kepegawaian**:
   - **Guru PNS** → Label berubah menjadi "NIP"
   - **Guru Honor** → Label berubah menjadi "NUPTK"
4. Isi nomor identitas sesuai status
5. Klik **"Simpan Data"**

#### **2. Edit Guru**
1. Di halaman Kelola Guru, klik **"Edit"** pada guru yang ingin diubah
2. Ubah **Status Kepegawaian** jika diperlukan
3. Label NIP/NUPTK akan berubah otomatis
4. Klik **"Simpan Perubahan"**

#### **3. Lihat Daftar Guru**
- Kolom **"Status"** menampilkan badge:
  - **[👥 PNS]** - Badge biru untuk guru PNS
  - **[👤 Honor]** - Badge hijau untuk guru Honor
- Kolom **"NIP/NUPTK"** menampilkan:
  - Nomor identitas
  - Label kecil "NIP" atau "NUPTK"

---

### **Untuk Guru:**

#### **Dashboard**
- Melihat status kepegawaian di dashboard
- Badge **"Guru PNS"** (biru) atau **"Guru Honor"** (hijau)
- Nomor identitas dengan label NIP/NUPTK

---

## 📊 Statistik Data

### **Hasil Seeder:**
```
Total guru updated: 7
PNS: 3 | Honor: 4

Distribusi:
- Muhammad Alvafaz K. S.T → PNS
- Rapir Joy S.Pd → Honor
- Gilang Wardi S.T → Honor
- Refi Aura S.T → Honor
- Cristiano Ronaldo S.Pd. → Honor
- Intan Einstein S.Pd → PNS
- Dimas Anggara S.Pd → PNS
```

**Rasio:** 60% Honor, 40% PNS (random)

---

## 🎯 Keuntungan Fitur

### **1. Identifikasi Jelas** 🏷️
- Badge visual untuk membedakan PNS dan Honor
- Tidak perlu membaca nomor identitas untuk tahu statusnya

### **2. Data Akurat** ✅
- Nomor identitas sesuai dengan status kepegawaian
- NIP untuk PNS, NUPTK untuk Honor

### **3. Form Dinamis** 🔄
- Label dan placeholder berubah otomatis
- Mengurangi kesalahan input

### **4. User Experience** 😊
- Interface yang jelas dan informatif
- Warna badge yang berbeda untuk identifikasi cepat

---

## 🧪 Testing

### **Test Tambah Guru PNS:**
1. Login sebagai admin
2. Tambah guru baru
3. Pilih "Guru PNS"
4. Pastikan label berubah menjadi "NIP"
5. Isi NIP dan data lainnya
6. Simpan → Cek di daftar guru harus ada badge [👥 PNS]

### **Test Tambah Guru Honor:**
1. Login sebagai admin
2. Tambah guru baru
3. Pilih "Guru Honor"
4. Pastikan label berubah menjadi "NUPTK"
5. Isi NUPTK dan data lainnya
6. Simpan → Cek di daftar guru harus ada badge [👤 Honor]

### **Test Edit Status:**
1. Login sebagai admin
2. Edit guru yang sudah ada
3. Ubah status dari Honor ke PNS (atau sebaliknya)
4. Pastikan label berubah otomatis
5. Simpan → Cek badge di daftar guru harus berubah

### **Test Dashboard Guru:**
1. Login sebagai guru PNS
2. Cek dashboard → Harus ada badge "Guru PNS" (biru)
3. Cek nomor → Harus ada label "NIP"
4. Login sebagai guru Honor
5. Cek dashboard → Harus ada badge "Guru Honor" (hijau)
6. Cek nomor → Harus ada label "NUPTK"

---

## 📞 Troubleshooting

### **Label tidak berubah saat pilih status?**
1. Pastikan JavaScript sudah dimuat
2. Cek console browser untuk error
3. Refresh halaman (F5)

### **Badge tidak muncul di daftar guru?**
1. Pastikan guru sudah punya `status_kepegawaian`
2. Jalankan seeder: `php artisan db:seed --class=UpdateGuruStatusSeeder`
3. Clear cache: `php artisan cache:clear`

### **Validation error saat simpan?**
1. Pastikan status kepegawaian dipilih
2. Pastikan NIP/NUPTK diisi
3. Cek apakah NIP/NUPTK sudah digunakan guru lain

---

## ✅ Checklist Implementasi

- [x] Migration `status_kepegawaian` column
- [x] Update User model
- [x] Update GuruController (store & update)
- [x] Update form create guru
- [x] Update form edit guru
- [x] Update daftar guru (index)
- [x] Update dashboard
- [x] JavaScript untuk dynamic label
- [x] Badge visual (PNS & Honor)
- [x] Seeder untuk data existing
- [x] Dokumentasi lengkap

---

**Fitur ini sudah siap digunakan!** 🎉

Sekarang sistem bisa membedakan guru PNS dan Honor dengan jelas, lengkap dengan:
- ✅ Badge visual yang berbeda
- ✅ Nomor identitas yang sesuai (NIP/NUPTK)
- ✅ Form yang dinamis
- ✅ Tampilan yang informatif
