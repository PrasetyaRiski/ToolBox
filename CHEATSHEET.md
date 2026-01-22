# CHEAT SHEET - ProductiviTools Commands

## 🚀 Quick Start Commands

### Setup Awal
```bash
# Install dependencies
composer install
npm install

# Generate key
php artisan key:generate

# Setup database
php artisan migrate
php artisan db:seed

# Build assets
npm run dev
# atau
npm run build

# Start server
php artisan serve
```

---

## 📦 Composer Commands

```bash
# Install dependencies
composer install

# Update dependencies
composer update

# Dump autoload (jika error class not found)
composer dump-autoload

# Install tanpa dev dependencies (production)
composer install --optimize-autoloader --no-dev
```

---

## 🎨 NPM Commands

```bash
# Install dependencies
npm install

# Development mode (with watch)
npm run dev

# Production build
npm run build

# Clear node_modules & reinstall
rm -rf node_modules
npm install
```

---

## 🔧 Artisan Commands

### Database
```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Fresh migration (drop all tables)
php artisan migrate:fresh

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Run seeders only
php artisan db:seed

# Specific seeder
php artisan db:seed --class=ToolSeeder
```

### Cache
```bash
# Clear all cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Create cache (production)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear compiled classes
php artisan clear-compiled
```

### Development
```bash
# Start development server
php artisan serve

# Custom host & port
php artisan serve --host=0.0.0.0 --port=8080

# Generate app key
php artisan key:generate

# List all routes
php artisan route:list

# Create controller
php artisan make:controller ToolController

# Create model with migration
php artisan make:model Tool -m

# Create seeder
php artisan make:seeder ToolSeeder
```

### Storage
```bash
# Create symbolic link for storage
php artisan storage:link

# Clear expired password reset tokens
php artisan auth:clear-resets
```

---

## 🗄️ MySQL Commands

```bash
# Login to MySQL
mysql -u root -p

# Create database
CREATE DATABASE productivitools;

# Show databases
SHOW DATABASES;

# Use database
USE productivitools;

# Show tables
SHOW TABLES;

# Drop database (CAREFUL!)
DROP DATABASE productivitools;
```

---

## 🐛 Debugging Commands

```bash
# Enable debug mode
# Set APP_DEBUG=true in .env

# View logs
tail -f storage/logs/laravel.log

# Tinker (REPL)
php artisan tinker

# Run tests
php artisan test
```

---

## 📝 Git Commands (Optional)

```bash
# Initialize git
git init

# Add all files
git add .

# Commit
git commit -m "Initial commit"

# Add remote
git remote add origin <url>

# Push
git push -u origin main
```

---

## 🚀 Production Deployment

```bash
# 1. Update .env
APP_ENV=production
APP_DEBUG=false

# 2. Install dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# 3. Setup database
php artisan migrate --force

# 4. Create cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Set permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 🔄 Update Commands

```bash
# Pull latest changes
git pull

# Update dependencies
composer update
npm update

# Re-migrate
php artisan migrate

# Re-seed (optional)
php artisan db:seed

# Rebuild assets
npm run build

# Clear & cache
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🆘 Emergency Commands

```bash
# Reset everything
php artisan migrate:fresh --seed
npm run build
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload

# Fix permissions (Linux/Mac)
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

# Reinstall everything
rm -rf vendor node_modules
composer install
npm install
npm run build
```

---

## 📊 Useful Queries

```sql
-- Count tools by category
SELECT c.name, COUNT(t.id) as tool_count 
FROM tool_categories c 
LEFT JOIN tools t ON c.id = t.category_id 
GROUP BY c.id;

-- Most used tools
SELECT name, usage_count 
FROM tools 
ORDER BY usage_count DESC 
LIMIT 10;

-- Active tools count
SELECT COUNT(*) FROM tools WHERE is_active = 1;
```

---

## 💡 Tips

- Selalu jalankan `npm run dev` saat development untuk auto-reload CSS/JS
- Gunakan `php artisan serve` untuk local development
- Jangan lupa `composer dump-autoload` jika ada error class not found
- Gunakan `.env` file untuk konfigurasi, jangan hardcode!
- Backup database sebelum `migrate:fresh`!

---

**Happy Coding! 🎉**
