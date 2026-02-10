# Setup Offline untuk Sistem Absensi Guru

## Ringkasan Perubahan

Aplikasi ini telah dikonfigurasi untuk dapat berjalan **tanpa koneksi internet**. Semua resource eksternal (CSS, JavaScript, dan Fonts) telah diunduh dan disimpan secara lokal.

## Resource yang Telah Di-lokalkan

### 1. TailwindCSS
- **Sebelumnya**: Menggunakan CDN `https://cdn.tailwindcss.com`
- **Sekarang**: Dikompilasi menggunakan Vite dan disimpan di `public/build/assets/`
- **File konfigurasi**: `tailwind.config.js`, `postcss.config.js`

### 2. Google Fonts (Plus Jakarta Sans)
- **Sebelumnya**: Menggunakan Google Fonts CDN
- **Sekarang**: Font files (.ttf) disimpan di `public/fonts/`
- **Files**:
  - `plus-jakarta-sans-400.ttf` (Regular)
  - `plus-jakarta-sans-500.ttf` (Medium)
  - `plus-jakarta-sans-600.ttf` (Semi-Bold)
  - `plus-jakarta-sans-700.ttf` (Bold)
  - `plus-jakarta-sans.css` (Font face definitions)

### 3. Chart.js
- **Sebelumnya**: Menggunakan CDN `https://cdn.jsdelivr.net/npm/chart.js`
- **Sekarang**: Disimpan di `public/js/chart.js`

## File yang Telah Diupdate

1. **resources/css/app.css**
   - Menambahkan import font lokal
   - Menambahkan custom animations (float, shake)
   - Menggunakan Tailwind directives

2. **resources/views/welcome.blade.php**
   - Mengganti CDN dengan `@vite` directive

3. **resources/views/auth/login.blade.php**
   - Mengganti CDN dengan `@vite` directive

4. **resources/views/layouts/app.blade.php**
   - Menghapus link ke fonts.bunny.net

5. **resources/views/layouts/guest.blade.php**
   - Menghapus link ke fonts.bunny.net

6. **resources/views/admin/statistik/grafik.blade.php**
   - Mengganti Chart.js CDN dengan file lokal

## Cara Menggunakan

### Development Mode
Untuk menjalankan aplikasi dalam mode development:

```bash
# Terminal 1: Jalankan Vite dev server
npm run dev

# Terminal 2: Jalankan Laravel server
php artisan serve
```

### Production Mode
Untuk build production (sekali saja):

```bash
# Build assets
npm run build

# Jalankan Laravel server
php artisan serve
```

Setelah build, semua assets akan tersimpan di `public/build/` dan dapat diakses tanpa internet.

## Struktur Folder

```
public/
├── build/              # Compiled CSS & JS dari Vite (setelah npm run build)
│   ├── assets/
│   │   ├── app-*.css
│   │   ├── app-*.js
│   │   └── plus-jakarta-sans-*.ttf
│   └── manifest.json
├── fonts/              # Font files lokal
│   ├── plus-jakarta-sans.css
│   ├── plus-jakarta-sans-400.ttf
│   ├── plus-jakarta-sans-500.ttf
│   ├── plus-jakarta-sans-600.ttf
│   └── plus-jakarta-sans-700.ttf
└── js/                 # JavaScript libraries lokal
    └── chart.js
```

## Testing Offline

Untuk memastikan aplikasi bekerja offline:

1. Build production assets: `npm run build`
2. Jalankan server: `php artisan serve`
3. Matikan koneksi internet
4. Akses aplikasi di browser
5. Semua styling dan fungsi chart harus tetap berfungsi normal

## Catatan Penting

- **Lint warnings** untuk `@tailwind` di app.css adalah normal dan dapat diabaikan
- Jika ada perubahan di CSS, jalankan `npm run build` untuk recompile
- Font Plus Jakarta Sans sudah ter-embed di compiled CSS
- Chart.js versi yang digunakan: 4.4.1

## Troubleshooting

### Jika styling tidak muncul:
1. Pastikan sudah menjalankan `npm run build`
2. Clear browser cache
3. Periksa console browser untuk error

### Jika chart tidak muncul:
1. Pastikan file `public/js/chart.js` ada
2. Periksa console browser untuk error loading script

### Jika font tidak muncul:
1. Pastikan folder `public/fonts/` berisi semua file .ttf
2. Pastikan `npm run build` sudah dijalankan
3. Font akan otomatis ter-copy ke `public/build/assets/`
