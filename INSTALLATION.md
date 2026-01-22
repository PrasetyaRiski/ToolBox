# 🚀 CARA MENJALANKAN PRODUCTIVITOOLS

## Langkah-langkah Setup (Windows)

### 1️⃣ Persiapan Database

Buka MySQL command line atau phpMyAdmin, lalu jalankan:

```sql
CREATE DATABASE productivitools CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2️⃣ Setup Otomatis (Recommended)

Jalankan file batch setup:

```bash
setup.bat
```

File ini akan otomatis:
- Install PHP dependencies (composer)
- Install JavaScript dependencies (npm)
- Generate application key

### 3️⃣ Konfigurasi Database

File `.env` sudah ada. Cek dan sesuaikan jika perlu:

```env
DB_DATABASE=productivitools
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Migrasi Database & Seeding

```bash
php artisan migrate
php artisan db:seed
```

Ini akan membuat:
- Semua tabel yang diperlukan
- 7 kategori tools
- 40+ tools siap pakai

### 5️⃣ Build Assets

**Development mode (dengan auto-reload):**
```bash
npm run dev
```

Biarkan terminal ini tetap berjalan!

**ATAU Production mode:**
```bash
npm run build
```

### 6️⃣ Jalankan Server

Buka terminal baru, jalankan:

```bash
php artisan serve
```

### 7️⃣ Akses Website

Buka browser: **http://localhost:8000**

---

## 🎯 Tools yang Sudah Berfungsi Penuh

### Text Tools
- ✅ Case Converter - http://localhost:8000/tools/case-converter
- ✅ Lorem Ipsum Generator - http://localhost:8000/tools/lorem-ipsum-generator
- ✅ Letter Counter - http://localhost:8000/tools/letter-counter
- ✅ Whitespace Remover - http://localhost:8000/tools/whitespace-remover

### Coding Tools
- ✅ Base64 Encoder/Decoder - http://localhost:8000/tools/base64-encoder-decoder
- ✅ URL Encoder/Decoder - http://localhost:8000/tools/url-encoder-decoder
- ✅ JSON Formatter - http://localhost:8000/tools/json-formatter
- ✅ HTML Minifier - http://localhost:8000/tools/html-minifier
- ✅ CSS Minifier - http://localhost:8000/tools/css-minifier

### Color Tools
- ✅ HEX to RGBA - http://localhost:8000/tools/hex-to-rgba
- ✅ RGBA to HEX - http://localhost:8000/tools/rgba-to-hex
- ✅ Color Shades - http://localhost:8000/tools/color-shades

### Misc Tools
- ✅ QR Code Generator - http://localhost:8000/tools/qr-code-generator
- ✅ Password Generator - http://localhost:8000/tools/password-generator
- ✅ List Randomizer - http://localhost:8000/tools/list-randomizer

---

## 🔧 Troubleshooting

### Error: "Class not found"
```bash
composer dump-autoload
```

### Error: "Vite manifest not found"
```bash
npm run build
```

### Error: "No encryption key"
```bash
php artisan key:generate
```

### Cache Issues
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Reset Database Lengkap
```bash
php artisan migrate:fresh --seed
```

---

## 📁 Struktur Project

```
productivitools/
├── app/
│   ├── Http/Controllers/      # Controllers
│   └── Models/                # Database Models
├── database/
│   ├── migrations/            # Database structure
│   └── seeders/              # Sample data
├── resources/
│   ├── css/                  # Tailwind CSS
│   ├── js/                   # JavaScript
│   └── views/                # Blade templates
├── routes/
│   └── web.php              # Routes definition
└── public/                   # Public assets
```

---

## 🎨 Fitur Utama

1. **40+ Tools** dalam 7 kategori
2. **Responsive Design** - Mobile & Desktop
3. **Real-time Processing** dengan AJAX
4. **Search Functionality**
5. **Category Organization**
6. **Usage Tracking**
7. **Favorites System** (untuk pengguna)

---

## 📱 Development Mode

Saat development, jalankan 2 terminal:

**Terminal 1 - Vite (untuk CSS/JS auto-reload):**
```bash
npm run dev
```

**Terminal 2 - Laravel Server:**
```bash
php artisan serve
```

---

## 🚀 Production Deployment

1. Update `.env`:
```env
APP_ENV=production
APP_DEBUG=false
```

2. Optimize:
```bash
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Set permissions:
```bash
chmod -R 775 storage bootstrap/cache
```

---

## � Troubleshooting

### Error: "Script @php artisan package:discover --ansi handling the post-autoload-dump event returned with error code 1"

**Solusi:**

1. **Jalankan setup.bat yang sudah diperbaiki** - Script sudah diupdate untuk handle error ini
2. **Atau manual:**
   ```bash
   # Install tanpa menjalankan scripts
   composer install --no-scripts
   
   # Generate app key
   php artisan key:generate
   
   # Buat direktori yang dibutuhkan
   mkdir bootstrap\cache
   mkdir storage\framework\cache
   mkdir storage\framework\sessions
   mkdir storage\framework\views
   
   # Jalankan autoload
   composer dump-autoload
   
   # Discover packages
   php artisan package:discover --ansi
   ```

3. **Cek file .env** - Pastikan APP_KEY sudah terisi

### Error lainnya

- **"Class not found"**: Jalankan `composer dump-autoload`
- **"Permission denied"**: Set permissions untuk storage dan bootstrap/cache
- **Database connection error**: Cek kredensial di .env dan pastikan MySQL running

---

## 💡 Tips

- Semua tools menggunakan AJAX untuk processing real-time
- Data tersimpan di database MySQL
- Menggunakan Tailwind CSS untuk styling
- Alpine.js untuk interactivity ringan

---

## 📞 Bantuan

Jika ada masalah:
1. Cek file `QUICKSTART.md` untuk solusi cepat
2. Cek file `README.md` untuk dokumentasi lengkap
3. Pastikan PHP >= 8.2, MySQL >= 8.0

**Selamat menggunakan ProductiviTools!** 🎉

