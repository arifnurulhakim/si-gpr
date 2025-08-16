# Hosting Troubleshooting Guide - E-Kartu Keluarga

## 🔍 Error 503 Service Unavailable

### **Penyebab Umum**
1. **PHP Version Mismatch**
2. **Missing Dependencies**
3. **File Permissions**
4. **Database Connection**
5. **Web Server Configuration**

## 🚀 Quick Fix Steps

### **Step 1: Check PHP Version**
```bash
# Buat file info.php di root
<?php
phpinfo();
?>
```

**Requirements:**
- PHP >= 8.2
- MySQL >= 5.7
- mod_rewrite enabled

### **Step 2: Verify File Structure**
```
public_html/
├── public/           # Document root harus point ke folder ini
│   ├── index.php
│   ├── .htaccess
│   └── build/
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/
└── .env
```

### **Step 3: Check .env Configuration**
```env
APP_NAME="E-Kartu Keluarga"
APP_ENV=production
APP_KEY=base64:YOUR_KEY_HERE
APP_DEBUG=false
APP_URL=https://ekartukeluarga.konek.web.id/ekk/public

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## 🔧 Common Solutions

### **1. Document Root Issue**
**Problem:** URL menunjukkan `/ekk/public/login` - ini salah
**Solution:** Set document root ke folder `public`

```apache
# .htaccess di root domain
RewriteEngine On
RewriteRule ^(.*)$ ekk/public/$1 [L]
```

### **2. PHP Version Check**
```php
// Buat file check.php
<?php
echo "PHP Version: " . phpversion();
echo "<br>Required: 8.2+";
echo "<br>Extensions: ";
echo "MySQL: " . (extension_loaded('pdo_mysql') ? 'OK' : 'MISSING');
echo "<br>JSON: " . (extension_loaded('json') ? 'OK' : 'MISSING');
echo "<br>OpenSSL: " . (extension_loaded('openssl') ? 'OK' : 'MISSING');
?>
```

### **3. File Permissions**
```bash
# Set permissions via File Manager
storage/                    # 755
bootstrap/cache/           # 755
public/                    # 755
.env                       # 644
```

### **4. Database Connection Test**
```php
// Buat file db-test.php
<?php
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=your_database",
        "your_username",
        "your_password"
    );
    echo "Database connection: OK";
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
```

## 📋 Hosting-Specific Fixes

### **cPanel Hosting**
1. **Set Document Root:**
   - Go to cPanel > Domains
   - Set document root to `/public_html/ekk/public`

2. **Create .htaccess in root:**
```apache
RewriteEngine On
RewriteRule ^(.*)$ ekk/public/$1 [L]
```

3. **Check PHP Version:**
   - cPanel > MultiPHP Manager
   - Set to PHP 8.2+

### **Plesk Hosting**
1. **Document Root:**
   - Domains > yourdomain.com > Apache & nginx
   - Set to `/httpdocs/ekk/public`

2. **PHP Settings:**
   - PHP Settings > PHP Version: 8.2+

### **Shared Hosting (Generic)**
1. **Upload Structure:**
```
public_html/
├── ekk/
│   ├── public/          # Document root
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   └── .env
```

2. **Create .htaccess in public_html:**
```apache
RewriteEngine On
RewriteRule ^(.*)$ ekk/public/$1 [L]
```

## 🔍 Debug Steps

### **Step 1: Enable Debug Mode**
```env
APP_DEBUG=true
APP_ENV=local
```

### **Step 2: Check Error Logs**
- cPanel > Error Logs
- Look for specific error messages
- Check PHP error log

### **Step 3: Test Basic Access**
```php
// Buat file test.php di root
<?php
echo "PHP is working!";
echo "<br>Current directory: " . __DIR__;
echo "<br>Laravel files exist: " . (file_exists('app') ? 'Yes' : 'No');
?>
```

### **Step 4: Check Laravel Requirements**
```php
// Buat file requirements.php
<?php
$requirements = [
    'PHP >= 8.2' => version_compare(PHP_VERSION, '8.2.0', '>='),
    'BCMath' => extension_loaded('bcmath'),
    'Ctype' => extension_loaded('ctype'),
    'JSON' => extension_loaded('json'),
    'Mbstring' => extension_loaded('mbstring'),
    'OpenSSL' => extension_loaded('openssl'),
    'PDO' => extension_loaded('pdo'),
    'Tokenizer' => extension_loaded('tokenizer'),
    'XML' => extension_loaded('xml'),
];

foreach ($requirements as $requirement => $satisfied) {
    echo $requirement . ': ' . ($satisfied ? '✅' : '❌') . '<br>';
}
?>
```

## 🚀 Quick Deployment Checklist

### **✅ Pre-Upload**
- [ ] Build assets: `npm run build`
- [ ] Test locally
- [ ] Export database
- [ ] Prepare .env

### **✅ Upload Process**
- [ ] Upload all files
- [ ] Set document root to `public/`
- [ ] Configure .env
- [ ] Set permissions

### **✅ Post-Upload**
- [ ] Test basic access
- [ ] Check database connection
- [ ] Verify assets loading
- [ ] Test login functionality

## 📞 Hosting Support Contact

### **Information to Provide**
1. **PHP Version:** Check via phpinfo()
2. **Error Logs:** From hosting control panel
3. **File Structure:** Screenshot of file manager
4. **Database Details:** Connection test results

### **Common Hosting Issues**
- **PHP Version:** Request upgrade to 8.2+
- **mod_rewrite:** Enable Apache mod_rewrite
- **File Permissions:** Set correct permissions
- **Memory Limit:** Increase PHP memory limit

## 🔧 Alternative Solutions

### **If Document Root Can't Be Changed**
1. **Use Subdirectory:**
   - Upload to `/ekk/`
   - Access via `domain.com/ekk/public/`

2. **Create Redirect:**
```apache
# .htaccess in root
RewriteEngine On
RewriteRule ^$ ekk/public/ [L]
RewriteRule (.*) ekk/public/$1 [L]
```

### **If PHP Version is Lower**
1. **Request Upgrade:** Contact hosting support
2. **Use Compatible Version:** Modify for PHP 8.1
3. **Alternative Hosting:** Consider VPS or cloud hosting

## ✅ Success Indicators

### **Application Working**
- [ ] Homepage loads: `domain.com/`
- [ ] Login accessible: `domain.com/login`
- [ ] No 503 errors
- [ ] Assets loading properly
- [ ] Database connection working

### **Security Checklist**
- [ ] APP_DEBUG=false in production
- [ ] HTTPS enabled
- [ ] File permissions correct
- [ ] .env file secure 
