# QUICK START GUIDE - ProductiviTools

## Setup Cepat (5 Menit!)

### 1. Buat Database
```sql
CREATE DATABASE productivitools;
```

### 2. Install & Setup
```bash
# Install dependencies
composer install
npm install

# Generate key
php artisan key:generate

# Setup database
php artisan migrate
php artisan db:seed

# Build assets
npm run dev
```

### 3. Jalankan Server
```bash
php artisan serve
```

Buka: http://localhost:8000

## Tools yang Sudah Berfungsi

✅ **Case Converter** - http://localhost:8000/tools/case-converter
✅ **Lorem Ipsum Generator** - http://localhost:8000/tools/lorem-ipsum-generator
✅ **Letter Counter** - http://localhost:8000/tools/letter-counter
✅ **QR Code Generator** - http://localhost:8000/tools/qr-code-generator
✅ **Password Generator** - http://localhost:8000/tools/password-generator
✅ **Base64 Encoder/Decoder** - http://localhost:8000/tools/base64-encoder-decoder
✅ **JSON Formatter** - http://localhost:8000/tools/json-formatter

## Troubleshooting

### Error: "SQLSTATE[HY000] [1049] Unknown database"
Pastikan database `productivitools` sudah dibuat

### Error: "Class 'App\...' not found"
Jalankan: `composer dump-autoload`

### Error: "Vite manifest not found"
Jalankan: `npm run dev` atau `npm run build`

### Error: "No application encryption key"
Jalankan: `php artisan key:generate`

## Development Tips

### Watch Mode (Auto-reload CSS/JS)
```bash
npm run dev
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Reset Database
```bash
php artisan migrate:fresh --seed
```

Selamat coding! 🚀
