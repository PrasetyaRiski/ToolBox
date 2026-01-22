# 🎨 Visual Guide - Google OAuth Implementation

## 📊 Architecture Diagram

```
┌─────────────────────────────────────────────────────────────────────┐
│                         User Interface Layer                         │
├─────────────────────────────────────────────────────────────────────┤
│                                                                      │
│  ┌──────────────────┐  ┌──────────────────┐                        │
│  │   Login Page     │  │ Register Page    │                        │
│  │  /login          │  │  /register       │                        │
│  │                  │  │                  │                        │
│  │ ┌──────────────┐ │  │ ┌──────────────┐ │                        │
│  │ │ Email/Pass   │ │  │ │ Email/Pass   │ │                        │
│  │ │ Login Button │ │  │ │ Register Btn │ │                        │
│  │ └──────────────┘ │  │ └──────────────┘ │                        │
│  │                  │  │                  │                        │
│  │ ┌──────────────┐ │  │ ┌──────────────┐ │                        │
│  │ │Google Button │ │  │ │Google Button │ │                        │
│  │ └──────┬───────┘ │  │ └──────┬───────┘ │                        │
│  └────────┼─────────┘  └────────┼────────┘ │                        │
│           │                     │          │                        │
└───────────┼─────────────────────┼──────────┘                        │
            │                     │                                   │
            ├─────────────────────┘                                   │
            │                                                         │
┌───────────▼──────────────────────────────────────────────────────┐ │
│               Application Layer (Laravel Routes)                  │ │
├────────────────────────────────────────────────────────────────┤ │
│  GET /auth/google                                              │ │
│  └─> GoogleAuthController@redirectToGoogle()                  │ │
│                                                                │ │
│  GET /auth/google/callback                                    │ │
│  └─> GoogleAuthController@handleGoogleCallback()             │ │
└───────────┬────────────────────────────────────────────────────┘ │
            │                                                       │
            │                                                       │
┌───────────▼────────────────────────────────────────────────────┐ │
│                  Google OAuth Server                            │ │
├────────────────────────────────────────────────────────────────┤ │
│  1. Redirect user to Google login                             │ │
│  2. User authenticate & grant permissions                     │ │
│  3. Return authorization code                                 │ │
│  4. Exchange code for tokens                                  │ │
│  5. Return user profile data                                  │ │
└───────────┬────────────────────────────────────────────────────┘ │
            │                                                       │
            │ User ID, Email, Name, Profile Photo                  │
            │                                                       │
┌───────────▼────────────────────────────────────────────────────┐ │
│            Database Layer (User Processing)                    │ │
├────────────────────────────────────────────────────────────────┤ │
│  Check:                                                        │ │
│  ├─ google_id exists? (Return user & update tokens)           │ │
│  ├─ email exists? (Link google_id & return user)              │ │
│  └─ New user? (Create new user record)                        │ │
│                                                                │ │
│  Update: auth_token, google_id, google_token                  │ │
└───────────┬────────────────────────────────────────────────────┘ │
            │                                                       │
            │ Authenticated User                                    │
            │                                                       │
┌───────────▼────────────────────────────────────────────────────┐ │
│                   Redirect to Homepage                          │ │
│                   User is now logged in ✅                      │ │
└────────────────────────────────────────────────────────────────┘ │
```

---

## 🔄 Login Flow Diagram

```
Start
  │
  ▼
User clicks "Masuk dengan Google"
  │
  ├─► Redirect to: GET /auth/google
  │        │
  │        ├─► GoogleAuthController@redirectToGoogle()
  │        │        │
  │        ├─► Socialite::driver('google')->redirect()
  │        │
  │        └─► Redirect to Google OAuth Server
  │                 │
  ▼                 ▼
Google OAuth Server
  │
  ├─► User logs in with Google account
  │
  ├─► User grants permissions
  │
  └─► Redirect back to: /auth/google/callback?code=xxx&state=xxx
         │
         ▼
      GoogleAuthController@handleGoogleCallback()
         │
         ├─► Get Google user data via $googleUser = Socialite::user()
         │
         ├─► Check: does google_id exist in database?
         │
         ├─ YES ─► Update tokens, login user
         │         │
         │         └─► Redirect to /home
         │
         └─ NO ──► Check: does email exist?
                    │
                    ├─ YES ─► Link google_id, login user
                    │         │
                    │         └─► Redirect to /home + message "Linked"
                    │
                    └─ NO ──► Create new user, login
                              │
                              └─► Redirect to /home + message "Created"
         │
         ▼
    User is logged in ✅
```

---

## 📁 Database Schema Update

### Before (Original)
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    remember_token VARCHAR(100),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### After (With Google OAuth)
```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    remember_token VARCHAR(100),
    google_id VARCHAR(255) UNIQUE,              ◄─── NEW
    google_token VARCHAR(255),                   ◄─── NEW
    google_refresh_token VARCHAR(255),           ◄─── NEW
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

---

## 🎯 User Journey Map

### Scenario 1: New User (Register dengan Google)

```
┌─────────────────────────────────────────────────────────────────┐
│ USER: Baru, belum punya akun                                    │
└─────────────────────────────────────────────────────────────────┘
           │
           ▼
    ┌──────────────┐
    │ /register    │  ◄─── USER MASUK
    │              │
    │ [Daftar]     │
    │ [Google]     │
    └──────┬───────┘
           │
           ▼ User klik "Daftar dengan Google"
    ┌──────────────┐
    │   Google     │  ◄─── REDIRECT KE GOOGLE
    │   Login      │
    └──────┬───────┘
           │
           ▼ User login & grant permission
    ┌──────────────┐
    │  Callback    │  ◄─── GOOGLE CALLBACK
    │  Handler     │
    └──────┬───────┘
           │
           ▼ Check: google_id ada?
    ┌──────────┬──────────┐
    │    NO    │ (new)    │
    └──────┬───────────────┘
           │
           ▼ Create new user
    ┌──────────────┐
    │ users table  │  ◄─── DATABASE INSERT
    │ ID: 123      │
    │ name: John   │
    │ google_id: 1 │
    │ email: j@g   │
    │ password: null
    └──────┬───────┘
           │
           ▼ Auto login
    ┌──────────────┐
    │   /home      │  ◄─── SUCCESS ✅
    │ Logged in!   │
    └──────────────┘
```

### Scenario 2: Existing User (Login dengan Google)

```
┌─────────────────────────────────────────────────────────────────┐
│ USER: Sudah punya akun, email=john@gmail.com                   │
└─────────────────────────────────────────────────────────────────┘
           │
           ▼
    ┌──────────────┐
    │   /login     │  ◄─── USER MASUK
    │              │
    │ [Masuk]      │
    │ [Google]     │
    └──────┬───────┘
           │
           ▼ User klik "Masuk dengan Google"
    ┌──────────────┐
    │   Google     │  ◄─── REDIRECT KE GOOGLE
    │   Login      │
    └──────┬───────┘
           │
           ▼ User login & grant permission
    ┌──────────────┐
    │  Callback    │  ◄─── GOOGLE CALLBACK
    │  Handler     │
    └──────┬───────┘
           │
           ▼ Check: google_id ada?
    ┌──────────┬──────────┐
    │    NO    │ check email
    └──────┬───────────────┘
           │
           ▼ Check: email ada?
    ┌──────────┬──────────┐
    │   YES    │ (link)   │
    └──────┬───────────────┘
           │
           ▼ Link google_id ke user existing
    ┌──────────────┐
    │ users table  │  ◄─── UPDATE
    │ ID: 123      │
    │ google_id: 1 │ (ADDED)
    │ google_token │ (UPDATED)
    └──────┬───────┘
           │
           ▼ Auto login
    ┌──────────────┐
    │   /home      │  ◄─── SUCCESS ✅
    │ Logged in!   │
    └──────────────┘
```

---

## 🔑 Key Components

### 1. Frontend Components
```
Login Page (/login)
├── Email & Password form
├── "Masuk" Button
├── Divider ─────────
├── "Masuk dengan Google" Button
└── "Daftar Akun Baru" Link

Register Page (/register)
├── Name, Email, Password form
├── "Daftar" Button
├── Divider ─────────
├── "Daftar dengan Google" Button
└── "Masuk di sini" Link
```

### 2. Backend Components
```
GoogleAuthController
├── redirectToGoogle()
│   └─ Redirect user to Google OAuth
│
├── handleGoogleCallback()
│   ├─ Get user from Google
│   ├─ Check google_id exists
│   ├─ Check email exists
│   ├─ Create or update user
│   └─ Login & redirect
│
├── linkGoogle()
│   └─ Link Google to existing account
│
└── handleLinkGoogleCallback()
    └─ Process linking
```

### 3. Database
```
users table modifications
├── google_id (unique, nullable)
├── google_token (nullable)
└── google_refresh_token (nullable)
```

---

## 🌐 Environment Setup

```
Developer Machine
│
├─ .env
│  ├─ GOOGLE_CLIENT_ID=...
│  ├─ GOOGLE_CLIENT_SECRET=...
│  └─ GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
│
├─ Google Cloud Console
│  ├─ Project: ProductiviTools
│  ├─ OAuth Credentials Created
│  └─ Redirect URI Registered
│
└─ Laravel Application
   ├─ config/services.php
   ├─ app/Http/Controllers/GoogleAuthController.php
   ├─ routes/web.php
   └─ database/migrations/...
```

---

## ✅ Status Summary

| Component | Status | Notes |
|-----------|--------|-------|
| **Package** | ✅ Installed | laravel/socialite v5.24.0 |
| **Migration** | ✅ Completed | google_id, google_token fields |
| **Controller** | ✅ Created | GoogleAuthController.php |
| **Config** | ✅ Setup | config/services.php |
| **Model** | ✅ Updated | User.php fillable fields |
| **Routes** | ✅ Added | auth.google, auth.google.callback |
| **UI** | ✅ Updated | Login & Register pages |
| **Database** | ✅ Applied | Tables updated |
| **Documentation** | ✅ Complete | 4 guide files |

**Status: READY TO USE ✅**

---

*Last Updated: January 6, 2026*
