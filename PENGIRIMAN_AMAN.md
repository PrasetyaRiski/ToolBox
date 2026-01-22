# 📤 PANDUAN PENGIRIMAN AMAN KE DOSEN

Dokumen ini berisi panduan untuk mengirimkan project **ProductiviTools** kepada dosen sambil mempertahankan perlindungan harta cipta.

---

## ✅ LANGKAH-LANGKAH PENGIRIMAN AMAN

### 1. **Persiapan Sebelum Pengiriman**

#### a. Verifikasi Kelengkapan
- [ ] Semua file ada dan tidak ada yang tertinggal
- [ ] Database migration sudah dijalankan
- [ ] File `.env` telah dikonfigurasi dengan benar
- [ ] Dependencies sudah diinstall (`composer install`, `npm install`)
- [ ] Watermark dan copyright header masih ada

#### b. Pembersihan File Tambahan
```bash
# Hapus file yang tidak perlu
rm -rf node_modules (jika diperlukan)
rm -rf vendor (jika diperlukan)
rm .env.local (jika ada file .env tambahan)
```

**CATATAN**: Jangan hapus file LICENSE, WATERMARK.md, atau header copyright di kode!

#### c. Persiapkan README
```bash
# Pastikan file berikut ada dan lengkap:
- README.md (dengan copyright notice)
- INSTALLATION.md
- QUICKSTART.md
- LICENSE (dengan perlindungan harta cipta)
- WATERMARK.md (dokumentasi proteksi)
```

---

### 2. **Cara Pengiriman**

#### **OPSI A: File Terkompres (ZIP/RAR) - REKOMENDASI TERBAIK** ✅

**Keuntungan:**
- Proteksi maksimal terhadap akses tidak sah
- Watermark tetap terlindungi
- Mencegah copy-paste dengan mudah
- Tracking pengiriman lebih baik

**Langkah:**
1. Buka Windows Explorer / File Manager
2. Klik kanan folder `productivitools`
3. Pilih "Send to" → "Compressed (zipped) folder"
4. Beri nama file: `ProductiviTools_2026_NIM_[NIM].zip`
5. Kirim melalui email ke dosen dengan subject:
   ```
   Pengumpulan Tugas: ProductiviTools - [Nama Lengkap]
   ```

**Contoh nama file:**
```
ProductiviTools_2026_NIM_2024001.zip
ProductiviTools_2026_01_12_Final.zip
```

#### **OPSI B: GitHub Private Repository (dengan catatan khusus)**

**Jika dosen meminta via GitHub:**

1. Buat repository PRIVATE di GitHub
2. Jangan buat PUBLIC
3. Tambahkan file `README.md` dengan catatan:
   ```markdown
   ## ⚠️ PERLINDUNGAN HARTA CIPTA
   
   Repository ini berisi karya akademik yang dilindungi hak cipta.
   Akses terbatas HANYA untuk:
   - Pemegang hak cipta
   - Dosen pengampu
   - Institusi pendidikan penyelenggara
   
   Lihat file LICENSE dan WATERMARK.md untuk detail perlindungan.
   ```
4. Invite dosen sebagai collaborator (read-only)
5. Catat waktu akses dosen sebagai bukti pengumpulan

**Penting:**
- ❌ JANGAN buat repository PUBLIC
- ❌ JANGAN bagikan link ke siapa pun
- ✅ JANGAN hapus watermark atau copyright

#### **OPSI C: Email Langsung**

**Jika dosen meminta via email:**

1. Kompres folder menjadi ZIP
2. Lampirkan ke email dengan subject jelas:
   ```
   Pengumpulan Tugas: ProductiviTools - [Nama Lengkap] - [Tanggal]
   ```
3. Isi email:
   ```
   Assalamu'alaikum Bapak/Ibu [Nama Dosen],
   
   Berikut adalah pengiriman tugas pemrograman saya:
   - Project: ProductiviTools
   - NIM: [NIM Anda]
   - Tanggal: [Tanggal Hari Ini]
   - File: ProductiviTools_[Tanggal].zip
   
   Proyek ini dilengkapi dengan:
   ✓ Dokumentasi lengkap (README.md, INSTALLATION.md)
   ✓ Perlindungan harta cipta (LICENSE, WATERMARK.md)
   ✓ Source code terstruktur dengan baik
   ✓ Instruksi instalasi dan penggunaan
   
   Terima kasih.
   
   [Nama Anda]
   [NIM Anda]
   ```

---

### 3. **Dokumentasi Pengumpulan**

Simpan bukti pengumpulan:

#### Untuk Email:
- [ ] Screenshot konfirmasi pengiriman
- [ ] Screenshot notifikasi read/delivered
- [ ] Print email masuk ke folder dosen

#### Untuk GitHub:
- [ ] Screenshot URL repository private
- [ ] Screenshot "Collaborators" (dosen sudah ditambahkan)
- [ ] Screenshot "Insights" → "Traffic" (akses dari dosen)

#### Untuk ZIP File:
- [ ] Foto/screenshot file yang dikirim
- [ ] Bukti pengiriman fisik atau digital

---

## 🔒 PERLINDUNGAN SAAT PENGIRIMAN

### Apa yang Dilindungi?

✅ **Selalu Terlindungi:**
- Watermark di halaman web
- Copyright header di file PHP
- File LICENSE dengan pernyataan harta cipta
- File WATERMARK.md

❌ **JANGAN Hapus:**
```
DILARANG KERAS menghapus atau mengubah:
- File LICENSE
- File WATERMARK.md  
- Meta tags copyright
- Copyright header di PHP
- Watermark CSS
- Notasi hak cipta di dokumentasi
```

### Checklist Pre-Pengiriman:
```
Sebelum mengirim, pastikan:
☑️ Watermark masih tampil di halaman web
☑️ File LICENSE ada dan utuh
☑️ File WATERMARK.md ada dan utuh
☑️ Header copyright ada di file PHP
☑️ Meta tags copyright ada di HTML
☑️ Tidak ada file yang dihapus
☑️ Kode tidak diobfuscate atau dimimimify (kecuali sudah dibuild)
☑️ Dokumentasi lengkap
```

---

## 📋 INFORMASI UNTUK DOSEN

### Template Email ke Dosen (Opsional):

```
Kepada Bapak/Ibu [Nama Dosen],

Saya mengirimkan ProjectiviTools yang merupakan tugas [Mata Kuliah].

CATATAN PENTING:
Proyek ini dilengkapi dengan sistem perlindungan harta cipta. 
Perlindungan ini bersifat akademik untuk mencegah pembajakan dan plagiasi.

Fitur perlindungan yang ada:
1. Watermark otomatis di halaman web
2. Copyright header di setiap file kode
3. File LICENSE dengan pernyataan hak cipta
4. Dokumentasi lengkap (WATERMARK.md)

Perlindungan ini TIDAK menghalangi:
✓ Evaluasi akademik
✓ Pembelajaran dari kode
✓ Pengajaran di kelas (dengan atribusi)
✓ Penyimpanan arsip institusi

Jika Bapak/Ibu membutuhkan akses khusus atau modifikasi lisensi,
silakan hubungi saya.

Terima kasih,
[Nama Anda]
```

---

## ⚠️ RISIKO YANG HARUS DIHINDARI

### JANGAN Lakukan Hal Berikut:

1. ❌ **Hapus watermark sebelum mengirim**
   - Ini adalah bukti kesengajaan menghilangkan proteksi
   - Dapat dianggap sebagai pelanggaran hak cipta

2. ❌ **Ubah nama project/penulis sebelum pengiriman**
   - Jangan klaim sebagai karya sendiri (sudah terlambat)
   - Tetap berikan atribusi jika menggunakan kode orang lain

3. ❌ **Bagikan ke teman sebelum pengumpulan**
   - Ini akan dianggap distribusi tanpa izin
   - Teman yang menerima juga dapat dipertanyakan

4. ❌ **Upload ke platform publik (GitHub, GitLab, Bitbucket public)**
   - Repository harus PRIVATE
   - Akses terbatas untuk dosen dan institusi saja

5. ❌ **Hapus atau ubah file perlindungan**
   - LICENSE
   - WATERMARK.md
   - Copyright headers
   - Meta tags

---

## 📊 TIMELINE REKOMENDASI

### Beberapa Hari Sebelum Deadline:
- [ ] Finalisasi kode dan dokumentasi
- [ ] Test aplikasi dari awal
- [ ] Verifikasi semua perlindungan masih ada
- [ ] Persiapkan README dan instruksi instalasi

### 1 Hari Sebelum Deadline:
- [ ] Kompres file menjadi ZIP
- [ ] Test ekstrak ZIP untuk pastikan semua file ada
- [ ] Persiapkan email dan bukti pengiriman

### Hari Pengumpulan:
- [ ] Kirim file ke dosen sebelum deadline
- [ ] Simpan bukti pengiriman
- [ ] Jangan hapus file lokal sampai dosen konfirmasi

---

## 🎯 RINGKASAN

| Aspek | Status | Keterangan |
|-------|--------|-----------|
| **Proteksi Harta Cipta** | ✅ Aktif | Selalu ada di setiap pengiriman |
| **Watermark** | ✅ Terlindungi | Tidak bisa dihapus tanpa modifikasi kode |
| **Akses Dosen** | ✅ Terbuka | Dosen bisa lihat dan evaluasi |
| **Akses Publik** | ❌ Terblokir | Hanya dosen & institusi yang boleh |
| **Distribusi Teman** | ❌ Dilarang | Melanggar hak cipta |
| **Komersialisasi** | ❌ Dilarang | Izin khusus diperlukan |

---

## 📞 BANTUAN

Jika Anda memiliki pertanyaan tentang:
- **Pengiriman**: Lihat opsi A, B, atau C di atas
- **Perlindungan**: Baca file WATERMARK.md
- **Instalasi**: Baca file INSTALLATION.md
- **Lisensi**: Baca file LICENSE

---

**Last Updated**: January 12, 2026  
**Version**: 1.0.0  
✅ Panduan Pengiriman Aman Siap Digunakan
