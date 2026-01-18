# 🎯 Quick Deploy to CleverCloud

## Checklist Sebelum Deploy ✅

- [ ] Update DB_PASSWORD di `.env` dengan password dari CleverCloud
- [ ] Pastikan APP_URL sudah benar di `.env`
- [ ] Pastikan SPOTIFY_CLIENT_ID & SPOTIFY_CLIENT_SECRET ada
- [ ] Push semua changes ke Git

## Deploy Steps

```bash
# 1. Login ke CleverCloud CLI (kalau belum)
clever login

# 2. Verifikasi konfigurasi
cat .env | grep DB_

# 3. Deploy
clever deploy

# 4. Monitor logs
clever logs --stream
```

## Environment Variables untuk CleverCloud Dashboard

Dalam panel CleverCloud, set environment variables berikut di "Environment Variables" section:

```
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:YOUR_KEY
APP_URL=https://YOUR_APP_NAME.cleverapps.io
DB_HOST=bswrtsm2g-t5d3khi5y2gy-mysql.services.clever-cloud.com
DB_PORT=3306
DB_DATABASE=bswrtsm2g-t5d3khi5y2gy
DB_USERNAME=uuxwm6a8gkDcEFjd
DB_PASSWORD=YOUR_PASSWORD
SPOTIFY_CLIENT_ID=YOUR_ID
SPOTIFY_CLIENT_SECRET=YOUR_SECRET
```

## Database Migration Otomatis

File `clevercloud/post_build.sh` akan otomatis:
- ✅ Menjalankan migrations
- ✅ Cache configuration
- ✅ Cache routes
- ✅ Cache views

## Helpful Commands

```bash
# SSH ke server
clever ssh

# Run commands
clever ssh php artisan migrate --force
clever ssh php artisan tinker

# View logs
clever logs --stream

# Restart app
clever restart
```

## Database Credentials dari Screenshot Anda

```
Host: bswrtsm2g-t5d3khi5y2gy-mysql.services.clever-cloud.com
Database: bswrtsm2g-t5d3khi5y2gy
User: uuxwm6a8gkDcEFjd
Port: 3306
Password: (dari panel CleverCloud)
```

---
**Note:** Password Anda sudah ada di `.env` file. Ganti `xxx_paste_your_password_here_xxx` dengan password sebenarnya!
