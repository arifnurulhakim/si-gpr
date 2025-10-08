# Deployment Guide - SI-GPR

## 🚀 Persiapan Upload ke Hosting (Tanpa Terminal)

### **Prerequisites**
- File manager hosting (cPanel, Plesk, dll)
- Database access (phpMyAdmin)
- FTP access (jika diperlukan)

## 📦 Files yang Perlu Diupload

### **Core Application Files**
```
ekk/
├── app/                    # ✅ Upload semua
├── bootstrap/              # ✅ Upload semua
├── config/                 # ✅ Upload semua
├── database/               # ✅ Upload semua
├── public/                 # ✅ Upload semua
├── resources/              # ✅ Upload semua
├── routes/                 # ✅ Upload semua
├── storage/                # ✅ Upload semua
├── vendor/                 # ✅ Upload semua
├── .env                    # ⚠️ Setup manual
├── .htaccess              # ✅ Upload
├── artisan                 # ✅ Upload
├── composer.json           # ✅ Upload
└── composer.lock           # ✅ Upload
```

### **Frontend Assets (Pre-built)**
```
public/build/               # ✅ Upload semua
├── assets/
│   ├── app-*.js           # ✅ Compiled JavaScript
│   └── app-*.css          # ✅ Compiled CSS
└── manifest.json           # ✅ Asset manifest
```

## 🔧 Setup Environment File

### **1. Buat file .env di root folder**
```env
APP_NAME="SI-GPR"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### **2. Generate Application Key**
Jika tidak bisa akses terminal, gunakan key default atau generate manual:
```env
APP_KEY=base64:12345678901234567890123456789012
```

## 🗄️ Database Setup

### **1. Buat Database di phpMyAdmin**
```sql
-- Buat database baru
CREATE DATABASE ekk_database;

-- Buat user (jika diperlukan)
CREATE USER 'ekk_user'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON ekk_database.* TO 'ekk_user'@'localhost';
FLUSH PRIVILEGES;
```

### **2. Import Database Structure**
Jika hosting menyediakan SSH atau terminal:
```bash
php artisan migrate --force
```

Jika tidak ada terminal, import manual via phpMyAdmin:
```sql
-- Import file SQL yang sudah di-export dari local
-- File: database/ekk_database.sql
```

## 📁 File Permissions

### **Set Permissions via File Manager**
```
storage/                    # 755 atau 775
├── app/                   # 755
├── framework/             # 755
│   ├── cache/            # 755
│   ├── sessions/         # 755
│   └── views/            # 755
└── logs/                 # 755

bootstrap/cache/           # 755
public/                    # 755
.env                       # 644
```

## 🔧 Web Server Configuration

### **Apache (.htaccess)**
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### **Nginx Configuration**
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/ekk/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 📋 Pre-Upload Checklist

### **✅ Local Preparation**
- [ ] Build assets: `npm run build`
- [ ] Optimize for production
- [ ] Test application locally
- [ ] Export database structure
- [ ] Prepare .env file
- [ ] Check file permissions

### **✅ Files to Upload**
- [ ] All application files
- [ ] Compiled assets in public/build/
- [ ] .htaccess file
- [ ] .env file (configured)
- [ ] Database SQL file

### **✅ Hosting Setup**
- [ ] Create database
- [ ] Import database structure
- [ ] Configure .env file
- [ ] Set file permissions
- [ ] Configure web server

## 🚀 Upload Process

### **Step 1: Upload Files**
1. Upload semua file ke root domain atau subfolder
2. Pastikan struktur folder tetap sama
3. Upload .env file yang sudah dikonfigurasi

### **Step 2: Database Setup**
1. Buat database di phpMyAdmin
2. Import database structure
3. Update .env dengan database credentials

### **Step 3: Configure Environment**
1. Update APP_URL di .env
2. Set APP_ENV=production
3. Set APP_DEBUG=false
4. Generate APP_KEY jika diperlukan

### **Step 4: Set Permissions**
1. Set storage/ folder ke 755
2. Set bootstrap/cache/ ke 755
3. Set .env ke 644

## 🔍 Troubleshooting

### **Common Issues**

#### **1. 500 Internal Server Error**
- Check file permissions
- Check .env configuration
- Check error logs

#### **2. Database Connection Error**
- Verify database credentials
- Check database exists
- Verify database permissions

#### **3. Assets Not Loading**
- Check public/build/ folder exists
- Verify manifest.json
- Check file permissions

#### **4. Route Not Found**
- Check .htaccess file
- Verify mod_rewrite enabled
- Check web server configuration

### **Debug Steps**
1. Set APP_DEBUG=true temporarily
2. Check error logs
3. Verify file structure
4. Test database connection

## 📞 Support

### **Hosting Support**
- Contact hosting provider untuk PHP version
- Request SSH access jika diperlukan
- Ask about database setup

### **Application Support**
- Check Laravel documentation
- Review error logs
- Verify configuration files

## ✅ Success Indicators

### **Application Working**
- [ ] Homepage loads without errors
- [ ] Login page accessible
- [ ] Database connection working
- [ ] Assets loading properly
- [ ] Forms submitting correctly

### **Security Checklist**
- [ ] APP_DEBUG=false
- [ ] HTTPS enabled
- [ ] File permissions correct
- [ ] .env file secure
- [ ] Database credentials secure 
