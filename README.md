# ProductiviTools - All Online Tools in One Box

> **⚠️ PERLINDUNGAN HARTA CIPTA**  
> Karya ini dilindungi oleh hak cipta. Dilarang menyalin, mendistribusikan, atau menggunakan tanpa izin pemegang hak cipta.  
> © 2026 Prasetya Riski Wa'afan. Semua hak cipta dilindungi.

Sebuah platform all-in-one productivity tools yang mirip dengan 10015.io, dibangun dengan Laravel 12 dan MySQL.

## 🚀 Fitur

- ✅ **Text Tools**: Case Converter, Lorem Ipsum Generator, Letter Counter, Whitespace Remover
- ✅ **Image Tools**: Image Cropper, Resizer, Filters, Color Picker (dalam pengembangan)
- ✅ **CSS Tools**: Loader Generator, Gradient Generator, Box Shadow, Border Radius (dalam pengembangan)
- ✅ **Coding Tools**: Base64 Encoder/Decoder, URL Encoder/Decoder, JSON Formatter, HTML/CSS Minifier
- ✅ **Color Tools**: HEX to RGBA, RGBA to HEX, Color Shades Generator
- ✅ **Social Media Tools**: Tweet to Image, Instagram Post Generator (dalam pengembangan)
- ✅ **Miscellaneous Tools**: QR Code Generator, Password Generator, List Randomizer

## 📋 Persyaratan Sistem

- PHP >= 8.2
- MySQL >= 8.0
- Composer
- Node.js & NPM
- Apache/Nginx web server

## 🛠️ Instalasi

### 1. Clone atau Download Project

```bash
cd c:\Users\kiki4\Documents\productivitools
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Konfigurasi Environment

File `.env` sudah tersedia. Sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=productivitools
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Buat Database

Buat database MySQL dengan nama `productivitools`:

```sql
CREATE DATABASE productivitools CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Jalankan Migrasi dan Seeder

```bash
# Jalankan migrasi untuk membuat tabel
php artisan migrate

# Jalankan seeder untuk mengisi data
php artisan db:seed
```

### 7. Build Assets

```bash
# Development mode (dengan watch)
npm run dev

# Production mode
npm run build
```

### 8. Jalankan Server

```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## 📂 Struktur Database

### Tabel Utama:

- **tool_categories** - Kategori tools (Text, Image, CSS, dll)
- **tools** - Daftar semua tools
- **users** - Data pengguna (untuk autentikasi)
- **user_favorites** - Tools favorit pengguna
- **tool_usage_logs** - Log penggunaan tools

## 🎨 Kategori Tools yang Tersedia

1. **Text Tools** (📝)
   - Case Converter
   - Lorem Ipsum Generator
   - Letter Counter
   - Text to Handwriting Converter
   - Multiple Whitespace Remover

2. **Image Tools** (🖼️)
   - Image Cropper
   - Image Resizer
   - Image Filters
   - Image Color Picker
   - Image to Base64 Converter
   - Photo Censor

3. **CSS Tools** (🎨)
   - CSS Loader Generator
   - CSS Gradient Generator
   - CSS Box Shadow Generator
   - CSS Border Radius Generator
   - CSS Glassmorphism Generator

4. **Coding Tools** (💻)
   - Code to Image Converter
   - JSON Formatter
   - Base64 Encoder/Decoder
   - URL Encoder/Decoder
   - HTML Minifier
   - CSS Minifier
   - JavaScript Minifier

5. **Color Tools** (🌈)
   - AI Color Palette Generator
   - HEX to RGBA Converter
   - RGBA to HEX Converter
   - Color Shades Generator
   - Color Mixer

6. **Social Media Tools** (📱)
   - Tweet to Image Converter
   - Instagram Post Generator
   - YouTube Thumbnail Grabber
   - Open Graph Meta Generator

7. **Miscellaneous Tools** (🔧)
   - QR Code Generator
   - Password Generator
   - Barcode Generator
   - List Randomizer

## 🔧 Pengembangan

### Menambah Tool Baru

1. Tambahkan tool di seeder (`database/seeders/ToolSeeder.php`)
2. Buat controller di `app/Http/Controllers/Tools/`
3. Tambahkan route di `routes/web.php`
4. Buat view di `resources/views/tools/`

### Struktur Controller Tool

```php
public function toolName(Request $request)
{
    if ($request->isMethod('post')) {
        // Process tool logic
        return response()->json(['result' => $result]);
    }
    
    return view('tools.category.tool-name');
}
```

## 🎯 Fitur Utama

- **Responsive Design** - Bekerja sempurna di desktop dan mobile
- **Real-time Processing** - Tools bekerja secara real-time dengan AJAX
- **Usage Tracking** - Melacak penggunaan setiap tool
- **Favorites System** - Pengguna dapat menyimpan tools favorit
- **Search Functionality** - Cari tools dengan mudah
- **Category Organization** - Tools terorganisir dalam kategori

## 📱 Teknologi yang Digunakan

- **Backend**: Laravel 12
- **Frontend**: Blade Templates, Alpine.js
- **Styling**: Tailwind CSS
- **Database**: MySQL
- **Build Tool**: Vite

## 🚀 Deployment

Untuk production:

1. Set `APP_ENV=production` di `.env`
2. Set `APP_DEBUG=false`
3. Jalankan `composer install --optimize-autoloader --no-dev`
4. Jalankan `npm run build`
5. Set permission untuk storage: `chmod -R 775 storage bootstrap/cache`
6. Generate cache: `php artisan config:cache`, `php artisan route:cache`, `php artisan view:cache`

## 📄 License

Open Source - MIT License

## 👨‍💻 Developer

Dibuat dengan ❤️ menggunakan Laravel 12

## 🤝 Kontribusi

Silakan fork project ini dan buat pull request untuk kontribusi.

## 📞 Support

Untuk pertanyaan dan dukungan, silakan buat issue di repository.

---

**Selamat menggunakan ProductiviTools!** 🎉
