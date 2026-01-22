# ✅ Developer Checklist - Google OAuth Setup

## ⚡ QUICK START (5 Minutes)

- [ ] **1. Buka Google Cloud Console**
  - URL: https://console.cloud.google.com/
  - Buat project baru: "ProductiviTools"

- [ ] **2. Aktifkan API**
  - Cari "Google+ API"
  - Klik "AKTIFKAN"

- [ ] **3. Setup OAuth Consent Screen** (1x only)
  - Di sidebar → "Kredensial"
  - Klik "Konfigurasi Layar Persetujuan OAuth"
  - Pilih "External"
  - Isi app details
  - Add authorized domains: localhost, yourdomain.com
  - Simpan

- [ ] **4. Buat OAuth Credentials**
  - Di sidebar → "Kredensial"
  - "Buat Kredensial" → "ID Klien OAuth"
  - Type: "Aplikasi web"
  - Authorized redirect URIs:
    - `http://localhost:8000/auth/google/callback`
    - `https://yourdomain.com/auth/google/callback` (production)
  - Klik "Buat"
  - **COPY**: Client ID dan Client Secret

- [ ] **5. Update .env file**
  ```env
  GOOGLE_CLIENT_ID=your_client_id_here
  GOOGLE_CLIENT_SECRET=your_client_secret_here
  GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
  ```

- [ ] **6. Test Implementation**
  ```bash
  php artisan serve
  # Open: http://localhost:8000/register
  # Click: "Daftar dengan Google"
  # Verify: Login works!
  ```

---

## 📋 DETAILED CHECKLIST

### Phase 1: Google Cloud Setup ✅
- [ ] Google Cloud account created
- [ ] ProductiviTools project created
- [ ] Google+ API enabled
- [ ] OAuth Consent Screen configured
- [ ] OAuth 2.0 Credentials created
- [ ] Client ID copied
- [ ] Client Secret copied
- [ ] Redirect URIs added (both localhost and production)

### Phase 2: Laravel Configuration ✅
- [ ] Laravel Socialite installed (v5.24.0)
  ```bash
  composer require laravel/socialite
  ```

- [ ] Migration applied
  ```bash
  php artisan migrate
  ```

- [ ] .env variables added
  ```env
  GOOGLE_CLIENT_ID=...
  GOOGLE_CLIENT_SECRET=...
  GOOGLE_REDIRECT_URI=...
  ```

- [ ] config/services.php has Google config

### Phase 3: Code Implementation ✅
- [ ] GoogleAuthController created
  - Location: `app/Http/Controllers/GoogleAuthController.php`
  - Methods: redirectToGoogle(), handleGoogleCallback()

- [ ] User Model updated
  - Fields added: google_id, google_token, google_refresh_token
  - File: `app/Models/User.php`

- [ ] Routes added
  - File: `routes/web.php`
  - Routes: /auth/google, /auth/google/callback

- [ ] Login view updated
  - File: `resources/views/auth/login.blade.php`
  - Component: "Masuk dengan Google" button

- [ ] Register view updated
  - File: `resources/views/auth/register.blade.php`
  - Component: "Daftar dengan Google" button

### Phase 4: Database ✅
- [ ] Migration file created
  - File: `database/migrations/2026_01_06_000000_add_google_oauth_to_users_table.php`

- [ ] Migration executed
  ```bash
  php artisan migrate
  ```

- [ ] Verify columns in users table
  - [ ] google_id (unique, nullable)
  - [ ] google_token (nullable)
  - [ ] google_refresh_token (nullable)

### Phase 5: Testing 🧪

#### Manual Testing
- [ ] Register dengan Google
  - [ ] Click "Daftar dengan Google"
  - [ ] Login dengan akun Google
  - [ ] Verify user created in database
  - [ ] Verify auto-login works
  - [ ] Verify redirect to /home

- [ ] Login dengan Google (existing user)
  - [ ] Click "Masuk dengan Google"
  - [ ] Login dengan akun yang sudah punya email terdaftar
  - [ ] Verify account linking
  - [ ] Verify auto-login works

- [ ] Error Scenarios
  - [ ] Cancel Google login
  - [ ] Test network error handling
  - [ ] Verify error messages

- [ ] UI/UX Testing
  - [ ] Check login page responsive
  - [ ] Check register page responsive
  - [ ] Check Google button styling
  - [ ] Check dark mode compatibility
  - [ ] Check mobile layout

#### Database Verification
```sql
-- Check users table has new columns
DESCRIBE users;

-- Verify google_id is unique
SELECT COUNT(*) FROM users WHERE google_id IS NOT NULL;

-- Check user with Google ID
SELECT id, name, email, google_id FROM users LIMIT 1;
```

#### Log Verification
- [ ] Check Laravel logs for errors
  - File: `storage/logs/laravel.log`

### Phase 6: Documentation ✅
- [ ] GOOGLE_OAUTH_SETUP.md created
  - Complete setup guide
  - Security considerations
  - Troubleshooting

- [ ] GOOGLE_OAUTH_QUICKSTART.md created
  - Quick start guide
  - Status summary

- [ ] ENV_SETUP.md created
  - Environment variables guide
  - Credentials setup

- [ ] VISUAL_GUIDE.md created
  - Architecture diagrams
  - User journey maps

- [ ] IMPLEMENTATION_SUMMARY.md created
  - Summary of all changes
  - Features list

### Phase 7: Production Preparation 🚀
- [ ] Create separate Google OAuth credentials for production
- [ ] Update production .env with new credentials
- [ ] Update GOOGLE_REDIRECT_URI to production URL
- [ ] Register production domain in Google Cloud Console
- [ ] Test on production URL
- [ ] Monitor logs after deployment

---

## 🔍 VERIFICATION CHECKLIST

Run these commands to verify setup:

```bash
# Check Socialite installed
composer show laravel/socialite

# Check migration ran
php artisan migrate:status

# Check config
php artisan tinker
>>> config('services.google')

# Check User model
php artisan tinker
>>> App\Models\User::first()

# Check routes
php artisan route:list | grep auth

# Check database columns
php artisan tinker
>>> \Illuminate\Support\Facades\Schema::getColumns('users')
```

---

## 🐛 TROUBLESHOOTING CHECKLIST

If something doesn't work, check:

- [ ] **Login page shows "Masuk dengan Google" button?**
  - Check: resources/views/auth/login.blade.php
  - Verify: Button is rendered

- [ ] **Google button is not clickable?**
  - Check: Route exists (GET /auth/google)
  - Check: href="{{ route('auth.google') }}"

- [ ] **"Redirect URI Mismatch" error?**
  - Check: GOOGLE_REDIRECT_URI in .env
  - Check: Registered URI in Google Cloud Console
  - Must match **exactly** (including protocol, domain, port)

- [ ] **"Invalid Client" error?**
  - Check: GOOGLE_CLIENT_ID in .env
  - Check: GOOGLE_CLIENT_SECRET in .env
  - No extra spaces or quotes

- [ ] **User not created after Google login?**
  - Check: Migration was applied
  - Check: User model has correct $fillable fields
  - Check: Database has google_id column

- [ ] **Session not working?**
  - Check: SESSION_DRIVER in .env
  - Clear cache: `php artisan cache:clear`
  - Clear sessions: `storage/framework/sessions/`

- [ ] **Google icon not showing?**
  - SVG should render inline in HTML
  - Check: Browser console for errors
  - Check: CSS not hiding it

- [ ] **Dark mode not working?**
  - Check: Alpine.js initialized
  - Check: x-data bound correctly
  - Check: CSS classes for dark mode

---

## 📊 HEALTH CHECK

**Before going to production, verify:**

```
✅ Google Cloud Setup        Complete
✅ Laravel Socialite         Installed
✅ Database Migration        Applied
✅ Environment Variables     Set
✅ Controller Created        Ready
✅ Routes Added              Working
✅ UI Updated                Rendered
✅ Manual Testing            Passed
✅ Error Handling            Working
✅ Documentation             Complete
✅ Security Review           Passed
```

---

## 📞 SUPPORT LINKS

- **Google Cloud Console**: https://console.cloud.google.com/
- **Google OAuth Docs**: https://developers.google.com/identity/protocols/oauth2
- **Laravel Socialite**: https://laravel.com/docs/socialite
- **Project Docs**: 
  - [GOOGLE_OAUTH_SETUP.md](GOOGLE_OAUTH_SETUP.md)
  - [ENV_SETUP.md](ENV_SETUP.md)
  - [VISUAL_GUIDE.md](VISUAL_GUIDE.md)

---

## 🎯 SUCCESS CRITERIA

✅ **Implementation is successful when:**

1. User dapat daftar dengan Google di /register
2. User dapat login dengan Google di /login  
3. User dengan email yang sama otomatis ter-link
4. Tokens tersimpan di database
5. User otomatis login setelah Google auth
6. UI responsive dan user-friendly
7. Error handling working properly
8. Documentation lengkap dan jelas
9. Tidak ada console errors
10. Database schema correct

---

**Status**: IMPLEMENTATION COMPLETE ✅
**Date**: January 6, 2026
**Ready for**: Development & Production Setup
