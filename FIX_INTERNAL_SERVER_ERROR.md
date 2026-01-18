🔴 FIX INTERNAL SERVER ERROR

═══════════════════════════════════════════════════════════

MASALAH: 
Database file at path [.../database.sqlite] does not exist
(Connection: sqlite, ...)

PENYEBAB:
CleverCloud masih menggunakan DB_CONNECTION=sqlite 
padahal harusnya DB_CONNECTION=mysql

SOLUSI:
═══════════════════════════════════════════════════════════

STEP 1: Buka CleverCloud Dashboard
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
1. Go to: https://console.clever-cloud.com/
2. Pilih aplikasi "penyemangat-ella"
3. Klik tab "Environment variables"

STEP 2: Tambahkan/Update Variables
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
JANGAN copy-paste dari file, tapi input satu-satu:

KEY                    | VALUE
────────────────────────────────────────────────────────
APP_ENV                | production
APP_DEBUG              | false
DB_CONNECTION          | mysql
DB_HOST                | bswrtsm2g-t5d3khi5y2gy-mysql.services.clever-cloud.com
DB_PORT                | 3306
DB_DATABASE            | bswrtsm2g-t5d3khi5y2gy
DB_USERNAME            | uuxwm6a8gkDcEFjd
DB_PASSWORD            | [PASSWORD DARI CLEVER-CLOUD]
CACHE_STORE            | database
SESSION_DRIVER         | database
SPOTIFY_CLIENT_ID      | 11dda9b0b23147ccbae9a6a38a60222c
SPOTIFY_CLIENT_SECRET  | c4edee5e42e14aeb8f76afbad3305aa4

STEP 3: Save & Deploy
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
1. Klik "Save"
2. App akan auto-restart/deploy
3. Wait untuk deployment selesai (lihat logs)

STEP 4: Verify
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Buka aplikasi di: https://penyemangat-ella.cleverapps.io/adventure
Harusnya sudah jalan!

═══════════════════════════════════════════════════════════

📋 VARIABLE YANG PALING PENTING:

1. DB_CONNECTION=mysql (BUKAN sqlite!)
2. DB_PASSWORD (dari CleverCloud panel)
3. CACHE_STORE=database
4. SESSION_DRIVER=database

═══════════════════════════════════════════════════════════

❓ DIMANA DAPAT DB_PASSWORD?

1. Buka CleverCloud dashboard
2. Klik app Anda
3. Bagian "Database"
4. Lihat password di sana
5. Copy & paste ke ENV VAR "DB_PASSWORD"

═══════════════════════════════════════════════════════════

🚀 AFTER FIX:

1. App akan restart otomatis
2. Database migrations akan jalan
3. /adventure page akan bisa di-akses
4. Sudah siap pakai!

═══════════════════════════════════════════════════════════

❌ COMMON MISTAKES:

❌ Copy seluruh .env file → WON'T WORK
✅ Input satu-satu di Environment Variables dashboard

❌ Pakai placeholder password → WILL FAIL
✅ Pakai password real dari CleverCloud

❌ DB_CONNECTION=sqlite di production → ERROR!
✅ DB_CONNECTION=mysql WAJIB

═══════════════════════════════════════════════════════════

Lakukan langkah ini dan seharusnya fixed! 🎉
