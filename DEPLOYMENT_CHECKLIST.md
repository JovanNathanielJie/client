# Pre-Deployment Checklist untuk CleverCloud

## 🔧 Konfigurasi File (✅ Sudah Dilakukan)

✅ `.env` - Updated untuk production & CleverCloud MySQL  
✅ `clevercloud.json` - Build configuration untuk PHP  
✅ `clevercloud/post_build.sh` - Auto migration & cache script  
✅ `QUICK_DEPLOY.md` - Quick reference guide  

## 📋 Yang Perlu Anda Lakukan

### 1. **Update Database Password** (PENTING!)
Edit `.env` line 28:
```
DB_PASSWORD=xxx_paste_your_password_here_xxx
```
Ganti dengan password database Anda dari CleverCloud panel.

### 2. **Verify APP_URL** (Sesuaikan)
Edit `.env` line 5:
```
APP_URL=https://penyemangat-ella.cleverapps.io
```
Ganti dengan URL app Anda di CleverCloud.

### 3. **Git Commit Changes**
```bash
git add .env clevercloud/ QUICK_DEPLOY.md DEPLOYMENT_GUIDE.md
git commit -m "Prepare for CleverCloud deployment"
git push origin main
```

### 4. **Deploy ke CleverCloud**
```bash
clever login
clever link
clever deploy
```

### 5. **Monitor Deployment**
```bash
clever logs --stream
```

## 🗂️ Database Info (Sudah di .env)

| Key | Value |
|-----|-------|
| Host | `bswrtsm2g-t5d3khi5y2gy-mysql.services.clever-cloud.com` |
| Database | `bswrtsm2g-t5d3khi5y2gy` |
| User | `uuxwm6a8gkDcEFjd` |
| Port | `3306` |
| Password | ⚠️ Update manually! |

## 🎵 Spotify Credentials (Sudah di .env)

✅ SPOTIFY_CLIENT_ID: `11dda9b0b23147ccbae9a6a38a60222c`  
✅ SPOTIFY_CLIENT_SECRET: `c4edee5e42e14aeb8f76afbad3305aa4`  

## 🚨 IMPORTANT NOTES

1. **Password** - JANGAN push password ke git! Saat ini file `.env` yang ada di git menggunakan placeholder. Update password hanya di local/production.

2. **APP_KEY** - Sudah generate, jangan ganti.

3. **CleverCloud Environment Variables** - Anda juga bisa set di CleverCloud dashboard untuk redundancy.

4. **Migrations** - Script `post_build.sh` akan otomatis run migrations saat deploy.

## ✅ Status Siap Deploy

| Item | Status |
|------|--------|
| Database Connection | ✅ Configured |
| Environment | ✅ Production |
| Migrations | ✅ Ready |
| Build Config | ✅ clevercloud.json |
| Post-Deploy Script | ✅ post_build.sh |
| Documentation | ✅ Complete |

---

**Next Step:** Ganti DB_PASSWORD dan APP_URL, kemudian `git push` dan `clever deploy`! 🚀
