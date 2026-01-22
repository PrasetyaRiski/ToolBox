# Google OAuth Setup - ProductiviTools

## Instalasi & Konfigurasi

### 1. Mendapatkan Google OAuth Credentials

#### Langkah 1: Buka Google Cloud Console
1. Kunjungi [Google Cloud Console](https://console.cloud.google.com/)
2. Login dengan akun Google Anda

#### Langkah 2: Buat Project Baru
1. Klik dropdown di samping "Google Cloud" di bagian atas
2. Pilih "Proyek Baru"
3. Masukkan nama: "ProductiviTools" (atau nama lainnya)
4. Klik "Buat"

#### Langkah 3: Aktifkan Google+ API
1. Di dashboard, cari "Google+ API"
2. Klik untuk memilih API tersebut
3. Klik tombol "AKTIFKAN"

#### Langkah 4: Buat OAuth Credentials
1. Di sidebar, klik "Kredensial"
2. Klik "Buat Kredensial" → "ID klien OAuth"
3. Jika diminta, klik "Konfigurasi Layar Persetujuan OAuth"
   - Pilih "External" untuk User Type
   - Klik "Buat"
   - Isi informasi dasar aplikasi
   - Di bagian "Authorized domains", tambahkan:
     - `localhost` (untuk development)
     - Domain Anda (untuk production)
   - Simpan dan lanjutkan

#### Langkah 5: Buat Klien OAuth
1. Kembali ke "Kredensial"
2. Klik "Buat Kredensial" → "ID klien OAuth"
3. Pilih "Aplikasi web"
4. Isi nama: "ProductiviTools Web Client"
5. Di bagian "URI pengalihan otorisasi", tambahkan:
   - `http://localhost:8000/auth/google/callback` (development)
   - `https://yourdomain.com/auth/google/callback` (production)
6. Klik "Buat"
7. Copy Client ID dan Client Secret

### 2. Konfigurasi Environment Variable

Buka file `.env` dan tambahkan:

```env
GOOGLE_CLIENT_ID=your_client_id_here
GOOGLE_CLIENT_SECRET=your_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

**Untuk Production:**
```env
GOOGLE_CLIENT_ID=your_client_id_here
GOOGLE_CLIENT_SECRET=your_client_secret_here
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
```

## Fitur Google Authentication

### 1. Login dengan Google
- User dapat login langsung dengan akun Google
- Jika email sudah terdaftar dengan cara tradisional, akun Google akan dihubungkan
- Otomatis redirect ke homepage setelah login berhasil

### 2. Register dengan Google
- User dapat membuat akun baru hanya dengan Google
- Nama dan email diambil dari profil Google
- Password tidak diperlukan untuk akun OAuth

### 3. Tampilan UI
Tombol "Login/Daftar dengan Google" tersedia di:
- Halaman Login (`/login`)
- Halaman Register (`/register`)
- Dengan desain yang sesuai tema aplikasi

## Database Schema

Tabel `users` telah ditambahkan kolom-kolom baru:

```sql
google_id              VARCHAR(255) -- ID unik dari Google
google_token           VARCHAR(255) -- Access token Google
google_refresh_token   VARCHAR(255) -- Refresh token Google
```

## Routes

### Google Authentication Routes
- `GET /auth/google` - Redirect ke Google login
- `GET /auth/google/callback` - Callback dari Google setelah login

## Cara Penggunaan

### Untuk User: Login dengan Google

1. **Di halaman Login:**
   - Klik tombol "Masuk dengan Google"
   - Pilih akun Google Anda
   - Redirect otomatis ke homepage

2. **Di halaman Register:**
   - Klik tombol "Daftar dengan Google"
   - Pilih akun Google Anda
   - Akun baru akan dibuat otomatis

### Untuk User: Linking Akun Existing
Jika user sudah memiliki akun dengan password tradisional:
- Login dengan email dan password
- Akun Google akan otomatis dilink saat pertama kali login dengan Google untuk email yang sama

## Security Considerations

### Password Handling
- User yang login via Google tidak memiliki password
- Mereka hanya dapat logout, tidak perlu reset password

### Token Management
- Google access token disimpan dalam database
- Token dapat digunakan untuk akses API Google di masa depan
- Refresh token disimpan untuk renovasi token yang expired

### Validation
- Google ID harus unique
- Email tetap unique (tidak boleh duplicate)
- Validasi CSRF protection tetap aktif

## Error Handling

Aplikasi menangani error berikut:

1. **Google Connection Failed**
   - User diredirect ke login dengan pesan error
   - Message: "Gagal terhubung dengan Google"

2. **Duplicate Google ID**
   - Jika Google ID sudah digunakan akun lain
   - Mencegah multiple account linking

## Testing

### Manual Testing Checklist

1. **Test Register dengan Google**
   - ✓ Buka `/register`
   - ✓ Klik "Daftar dengan Google"
   - ✓ Login dengan akun Google baru
   - ✓ Verifikasi user baru dibuat di database
   - ✓ Redirect ke homepage

2. **Test Login dengan Google**
   - ✓ Buka `/login`
   - ✓ Klik "Masuk dengan Google"
   - ✓ Login dengan akun Google yang sudah terdaftar
   - ✓ Redirect ke homepage
   - ✓ Verify user terlogin dengan benar

3. **Test Account Linking**
   - ✓ Daftar akun dengan email: `test@example.com` menggunakan password
   - ✓ Logout
   - ✓ Login dengan Google menggunakan email yang sama
   - ✓ Verify kedua metode login bekerja untuk akun yang sama

4. **Test Error Handling**
   - ✓ Simulasi network error
   - ✓ Verify error message ditampilkan

## Troubleshooting

### "Redirect URI Mismatch"
- Pastikan `GOOGLE_REDIRECT_URI` di `.env` sesuai dengan yang terdaftar di Google Cloud Console

### "Client ID Not Found"
- Pastikan `GOOGLE_CLIENT_ID` dan `GOOGLE_CLIENT_SECRET` sudah ditambahkan ke `.env`
- Pastikan tidak ada spasi di akhir nilai

### "Invalid State"
- Clear browser cookies
- Pastikan session storage berfungsi

## Environment Variables Checklist

```
GOOGLE_CLIENT_ID           ✓ Dari Google Cloud Console
GOOGLE_CLIENT_SECRET       ✓ Dari Google Cloud Console  
GOOGLE_REDIRECT_URI        ✓ Sesuai dengan registered URI
```

## Future Enhancements

Fitur yang dapat ditambahkan di masa depan:

1. **Google Calendar Integration**
   - Sinkronisasi jadwal dari Google Calendar

2. **Google Drive Integration**
   - Backup/restore settings ke Google Drive

3. **Google Meet Integration**
   - Schedule meeting langsung dari tools

4. **Multiple OAuth Provider**
   - GitHub OAuth
   - Microsoft OAuth
   - Facebook OAuth

5. **Disconnect Google**
   - User dapat disconnect Google jika sudah memiliki password
   - Fallback ke login tradisional

## Support

Untuk pertanyaan atau issues:
1. Check dokumentasi Google OAuth di [Google Developers](https://developers.google.com/)
2. Check dokumentasi Laravel Socialite di [Laravel Docs](https://laravel.com/docs/socialite)
