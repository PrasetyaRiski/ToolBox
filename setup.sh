#!/usr/bin/env bash

echo "🚀 ProductiviTools Setup Script"
echo "================================"
echo ""

# Check if composer is installed
if ! command -v composer &> /dev/null
then
    echo "❌ Composer not found. Please install Composer first."
    exit 1
fi

# Check if npm is installed
if ! command -v npm &> /dev/null
then
    echo "❌ NPM not found. Please install Node.js and NPM first."
    exit 1
fi

# Check if php is installed
if ! command -v php &> /dev/null
then
    echo "❌ PHP not found. Please install PHP 8.2 or higher."
    exit 1
fi

echo "✅ All requirements met"
echo ""

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install

# Install JavaScript dependencies
echo "📦 Installing JavaScript dependencies..."
npm install

# Generate application key
echo "🔑 Generating application key..."
php artisan key:generate

echo ""
echo "✅ Installation complete!"
echo ""
echo "Next steps:"
echo "1. Create MySQL database: CREATE DATABASE productivitools;"
echo "2. Update .env file with your database credentials"
echo "3. Run: php artisan migrate"
echo "4. Run: php artisan db:seed"
echo "5. Run: npm run dev (in a separate terminal)"
echo "6. Run: php artisan serve"
echo ""
echo "Then visit: http://localhost:8000"
