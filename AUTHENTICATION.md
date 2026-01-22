# Authentication System - ProductiviTools

## Fitur yang Ditambahkan

### 1. Sistem Login dan Register
- **Halaman Login**: `/login` - Tampilan modern dan minimalis untuk login
- **Halaman Register**: `/register` - Form pendaftaran user baru
- **Logout**: Form POST ke `/logout`

### 2. Proteksi Route
Semua tools dan halaman kategori detail memerlukan autentikasi:
- `/tools/*` - Semua halaman tools
- `/category/{slug}` - Detail kategori
- `/favorites` - Halaman favorit

### 3. Tampilan untuk Guest Users
- **Homepage**: Menampilkan modal login saat klik tool
- **Categories Index**: Menampilkan modal login saat klik kategori
- Tools tetap terlihat tapi tidak bisa diakses tanpa login

### 4. Tampilan untuk Authenticated Users
- **Navigasi**: Menu user dengan nama dan dropdown logout
- **Homepage**: Akses langsung ke semua tools
- **Categories**: Akses langsung ke detail kategori

## Cara Penggunaan

### Register User Baru
1. Kunjungi `http://localhost:8000/register`
2. Isi form:
   - Nama Lengkap
   - Email
   - Password (minimal 8 karakter)
   - Konfirmasi Password
3. Klik "Daftar"
4. Otomatis login dan redirect ke homepage

### Login
1. Kunjungi `http://localhost:8000/login`
2. Masukkan email dan password
3. Opsional: Centang "Ingat saya"
4. Klik "Masuk"
5. Redirect ke homepage

### Logout
1. Klik nama user di navigasi (desktop)
2. Pilih "Keluar"
3. Atau di mobile menu, klik "Keluar"

## Keamanan

### Password Hashing
- Password di-hash menggunakan bcrypt
- Laravel Password validation (minimal 8 karakter)

### Session Management
- Session regeneration setelah login
- Session invalidation saat logout
- CSRF protection di semua form

### Middleware
- `auth` middleware melindungi route yang memerlukan autentikasi
- Otomatis redirect ke `/login` jika belum login
- Intended redirect setelah login

## Tampilan Modal

Modal login untuk guest users memiliki:
- ✅ Design modern dengan Tailwind CSS
- ✅ Icon yang informatif
- ✅ Tombol "Masuk" (primary)
- ✅ Tombol "Daftar Akun Baru" (outline)
- ✅ Tombol "Batal" untuk menutup modal
- ✅ Click outside untuk close modal
- ✅ Alpine.js untuk interaktivitas

## Database

Menggunakan tabel `users` yang sudah ada dengan kolom:
- `id` - Primary key
- `name` - Nama lengkap user
- `email` - Email (unique)
- `password` - Password (hashed)
- `remember_token` - Token untuk "remember me"
- `created_at`, `updated_at` - Timestamps

## Testing

### Test Manual
1. Buka `http://localhost:8000` tanpa login
2. Klik salah satu tool → modal login muncul
3. Klik "Daftar Akun Baru"
4. Isi form register
5. Setelah register, coba akses tool → langsung bisa digunakan
6. Logout dan coba login kembali
7. Test "Ingat saya" functionality

### Test Routes
```bash
# Test public routes
curl http://localhost:8000
curl http://localhost:8000/categories

# Test protected routes (should redirect)
curl -I http://localhost:8000/tools/case-converter
curl -I http://localhost:8000/favorites
```

## Customization

### Mengubah Redirect After Login
Edit `AuthController.php`:
```php
return redirect()->intended(route('home'));
// Ganti 'home' dengan route yang diinginkan
```

### Menambahkan Validasi Password
Edit `AuthController.php` di method `register()`:
```php
Password::min(8)
    ->letters()
    ->mixedCase()
    ->numbers()
    ->symbols()
```

### Mengubah Design Modal
Edit `resources/views/home.blade.php` dan `resources/views/categories/index.blade.php`
pada section modal Alpine.js

## Files Modified

1. **Controller Baru**:
   - `app/Http/Controllers/AuthController.php`

2. **Views Baru**:
   - `resources/views/auth/login.blade.php`
   - `resources/views/auth/register.blade.php`

3. **Views Modified**:
   - `resources/views/layouts/app.blade.php` (navigation dengan auth menu)
   - `resources/views/home.blade.php` (modal login untuk guest)
   - `resources/views/categories/index.blade.php` (modal login untuk guest)

4. **Routes Modified**:
   - `routes/web.php` (auth routes dan middleware)

5. **CSS Modified**:
   - `resources/css/app.css` (x-cloak style)

## Troubleshooting

### Modal tidak muncul
- Pastikan Alpine.js loaded dengan benar
- Check browser console untuk errors
- Pastikan `npm run build` sudah dijalankan

### Redirect loop setelah login
- Clear browser cache
- Check session configuration di `.env`

### Password tidak cocok saat login
- Pastikan password di-hash dengan benar
- Test dengan user baru hasil register
