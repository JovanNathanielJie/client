# 🚀 CleverCloud Deployment Guide

## Persiapan Sebelum Deploy

### 1. Update Password Database
Buka file `.env` dan ganti password database:
```
DB_PASSWORD=password_anda_dari_clevercloud
```

### 2. Generate APP_KEY (jika belum ada)
```bash
php artisan key:generate
```

Kemudian update di `.env`:
```
APP_KEY=base64:xxxxxxxxxxxxx
```

### 3. Update APP_URL
Ganti dengan URL CleverCloud Anda:
```
APP_URL=https://your-app-name.cleverapps.io
```

## Langkah-Langkah Deploy

### 1. Push ke Repository
```bash
git add .
git commit -m "Deploy to CleverCloud"
git push origin main
```

### 2. Connect ke CleverCloud
Jika belum terhubung:
```bash
clever login
clever link
```

### 3. Set Environment Variables di CleverCloud
Di dashboard CleverCloud, tambahkan environment variables:
- `APP_KEY` → dari file `.env`
- `APP_ENV` → `production`
- `APP_URL` → URL app Anda
- `APP_DEBUG` → `false`
- Semua `DB_*` variables
- `SPOTIFY_CLIENT_ID` & `SPOTIFY_CLIENT_SECRET`

### 4. Deploy
```bash
clever deploy
```

## Troubleshooting

### Problem: Database Error
**Solusi:**
```bash
# SSH ke CleverCloud
clever ssh

# Run migrations
php artisan migrate --force

# Jika perlu reset (HATI-HATI!)
php artisan migrate:reset --force
php artisan migrate --force
```

### Problem: Blank Page / 500 Error
**Solusi:**
```bash
# Clear all caches
clever ssh
php artisan cache:clear
php artisan view:clear
php artisan config:clear
exit
```

### Problem: Aplikasi Tidak Merespons
**Solusi:**
```bash
# Lihat logs
clever logs --stream

# Restart aplikasi
clever restart
```

## Informasi Database CleverCloud

Dari screenshot Anda:
- **Host:** `bswrtsm2g-t5d3khi5y2gy-mysql.services.clever-cloud.com`
- **Database:** `bswrtsm2g-t5d3khi5y2gy`
- **User:** `uuxwm6a8gkDcEFjd`
- **Password:** (dari panel CleverCloud)
- **Port:** `3306`

## File Penting untuk Deployment

✅ `clevercloud.json` - Konfigurasi build
✅ `.env` - Environment variables (update sebelum deploy)
✅ `.env.example` - Template environment variables
✅ `clevercloud/post_build.sh` - Script post-deployment

## Monitoring

Gunakan dashboard CleverCloud untuk:
- Melihat logs realtime
- Monitor resource usage (CPU, RAM, storage)
- Manage databases
- Configure domains dan SSL

---
**Catatan:** Jangan pernah share password atau credentials di public repository! Gunakan environment variables di CleverCloud dashboard.
