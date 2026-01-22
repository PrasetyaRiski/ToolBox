# Environment Variables untuk Google OAuth

Copy-paste ke file `.env` Anda dan isi dengan credentials dari Google Cloud Console:

```env
# Google OAuth Configuration
GOOGLE_CLIENT_ID=your_client_id_from_google_cloud
GOOGLE_CLIENT_SECRET=your_client_secret_from_google_cloud
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

## Untuk Production, ubah menjadi:

```env
# Production
GOOGLE_CLIENT_ID=your_production_client_id
GOOGLE_CLIENT_SECRET=your_production_client_secret
GOOGLE_REDIRECT_URI=https://yourdomain.com/auth/google/callback
```

## Mendapatkan Credentials

1. **Buka Google Cloud Console**
   - https://console.cloud.google.com/

2. **Buat Project Baru**
   - Klik dropdown di atas
   - Pilih "Proyek Baru"
   - Nama: "ProductiviTools"
   - Klik "Buat"

3. **Aktifkan Google+ API**
   - Di dashboard, cari "Google+ API"
   - Klik untuk buka API
   - Klik tombol "AKTIFKAN"

4. **Setup OAuth Consent Screen** (Hanya perlu 1x)
   - Di sidebar, klik "Kredensial"
   - Klik "Konfigurasi Layar Persetujuan OAuth"
   - User Type: External
   - App name: ProductiviTools
   - User support email: your@email.com
   - Developer contact: your@email.com
   - Di bagian "Authorized domains", tambahkan:
     - `localhost` (untuk development)
     - `yourdomain.com` (untuk production)
   - Klik "Simpan dan Lanjutkan"
   - Di halaman Scopes, klik "Simpan dan Lanjutkan"
   - Review, kemudian "Kembali ke Dashboard"

5. **Buat OAuth 2.0 Credentials**
   - Di sidebar, klik "Kredensial"
   - Klik "Buat Kredensial" → "ID Klien OAuth"
   - Application type: "Aplikasi web"
   - Nama: "ProductiviTools Web Client"
   - Di bagian "URI pengalihan otorisasi yang sah", klik "Tambahkan URI"
   - Untuk development, tambahkan:
     ```
     http://localhost:8000/auth/google/callback
     ```
   - Untuk production, tambahkan:
     ```
     https://yourdomain.com/auth/google/callback
     ```
   - Klik "Buat"

6. **Copy Credentials**
   - Dialog akan menampilkan:
     - **Client ID** → Copy ke `GOOGLE_CLIENT_ID`
     - **Client Secret** → Copy ke `GOOGLE_CLIENT_SECRET`
   - Tutup dialog

7. **Simpan ke .env**
   - Buka file `.env` di root project
   - Tambahkan 3 variabel di atas
   - Simpan

8. **Test**
   - Jalankan: `php artisan serve`
   - Buka: http://localhost:8000/register
   - Klik "Daftar dengan Google"
   - Verifikasi login berhasil

## Troubleshooting

### "Invalid Client"
- Pastikan GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET benar
- Jangan ada spasi di depan/belakang nilai

### "Redirect URI Mismatch"
- GOOGLE_REDIRECT_URI harus **SAMA PERSIS** dengan yang terdaftar di Google Cloud Console
- Termasuk http:// atau https://
- Termasuk port number jika ada (8000)

### "Invalid Request"
- Clear browser cookies
- Clear Laravel cache: `php artisan cache:clear`
- Restart server: Ctrl+C, lalu `php artisan serve` lagi

## Environment Variables Checklist

```
GOOGLE_CLIENT_ID              ✓ Dari Google Cloud Console
GOOGLE_CLIENT_SECRET          ✓ Dari Google Cloud Console
GOOGLE_REDIRECT_URI           ✓ Sesuai registered URI
```

---

**✅ Setelah setup, silahkan restart server dan test di http://localhost:8000/register**
