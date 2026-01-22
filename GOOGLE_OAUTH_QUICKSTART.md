# SETUP RINGKAS - Google OAuth untuk ProductiviTools

## Yang Sudah Dilakukan

✅ **Package Installation**
- Laravel Socialite v5.24.0 sudah diinstall

✅ **Database Migration**
- Migration file dibuat: `2026_01_06_000000_add_google_oauth_to_users_table.php`
- Kolom ditambahkan ke tabel `users`:
  - `google_id` (nullable, unique)
  - `google_token` (nullable)
  - `google_refresh_token` (nullable)
- Migration sudah dijalankan ✓

✅ **Authentication Controller**
- File: `app/Http/Controllers/GoogleAuthController.php`
- Method yang tersedia:
  - `redirectToGoogle()` - Redirect ke Google OAuth
  - `handleGoogleCallback()` - Handle callback dari Google
  - `linkGoogle()` - Link Google ke akun existing
  - `handleLinkGoogleCallback()` - Handle linking callback

✅ **Configuration**
- File: `config/services.php`
- Setup untuk Google OAuth sudah dikonfigurasi

✅ **Models**
- File: `app/Models/User.php`
- Kolom `google_id`, `google_token`, `google_refresh_token` sudah di-add ke `$fillable`

✅ **UI Components**
- Login page (`resources/views/auth/login.blade.php`) - Sudah ditambahkan Google login button
- Register page (`resources/views/auth/register.blade.php`) - Sudah ditambahkan Google register button

✅ **Routes**
- File: `routes/web.php`
- Routes sudah ditambahkan:
  - `GET /auth/google` → `GoogleAuthController@redirectToGoogle` (nama: `auth.google`)
  - `GET /auth/google/callback` → `GoogleAuthController@handleGoogleCallback` (nama: `auth.google.callback`)

## LANGKAH SETUP SELANJUTNYA (untuk Developer)

### Step 1: Ambil Google OAuth Credentials

1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Buat project baru: "ProductiviTools"
3. Aktifkan Google+ API
4. Buat OAuth 2.0 credentials (ID Klien OAuth)
5. Tambahkan Authorized redirect URI:
   - `http://localhost:8000/auth/google/callback`

### Step 2: Konfigurasi .env

Buka file `.env` dan tambahkan:

```env
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### Step 3: Restart Server

```bash
php artisan serve
```

### Step 4: Testing

1. Buka http://localhost:8000/register
2. Klik "Daftar dengan Google"
3. Login dengan akun Google Anda
4. Verifikasi user berhasil dibuat dan otomatis login

## File-File yang Dibuat/Diubah

### Dibuat:
- `app/Http/Controllers/GoogleAuthController.php` - Controller untuk Google Auth
- `config/services.php` - Configuration untuk services termasuk Google
- `database/migrations/2026_01_06_000000_add_google_oauth_to_users_table.php` - Migration
- `GOOGLE_OAUTH_SETUP.md` - Dokumentasi lengkap
- `GOOGLE_OAUTH_QUICKSTART.md` - File ini

### Diubah:
- `app/Models/User.php` - Tambah kolom Google OAuth ke `$fillable`
- `resources/views/auth/login.blade.php` - Tambah tombol Google login
- `resources/views/auth/register.blade.php` - Tambah tombol Google register
- `routes/web.php` - Tambah Google OAuth routes
- `composer.json` - Tambah laravel/socialite dependency

## Database Structure (Setelah Migration)

```
users table:
├── id                       (primary key)
├── name
├── email
├── password                 (nullable untuk OAuth users)
├── remember_token
├── google_id                ✨ NEW (nullable, unique)
├── google_token             ✨ NEW (nullable)
├── google_refresh_token     ✨ NEW (nullable)
├── email_verified_at
├── created_at
└── updated_at
```

## Feature Checklist

- ✅ User bisa daftar dengan Google
- ✅ User bisa login dengan Google
- ✅ Email yang sama otomatis di-link ke akun existing
- ✅ Google tokens disimpan untuk penggunaan API di masa depan
- ✅ UI sudah diupdate di login/register pages
- ✅ Error handling untuk Google connection failures
- ✅ Unique constraint untuk google_id

## Kebutuhan untuk Production

1. Setup Google OAuth Credentials untuk domain production
2. Update GOOGLE_REDIRECT_URI di `.env` ke production URL
3. Update Authorized redirect URIs di Google Cloud Console
4. Test thoroughly dengan akun Google real

## Quick Links

- 📖 Dokumentasi Lengkap: [GOOGLE_OAUTH_SETUP.md](GOOGLE_OAUTH_SETUP.md)
- 🔗 Google OAuth Docs: https://developers.google.com/identity/protocols/oauth2
- 🔗 Laravel Socialite: https://laravel.com/docs/socialite

---

**Status**: ✅ Ready untuk digunakan (tinggal tambahkan Google credentials)
