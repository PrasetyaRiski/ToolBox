# Toolbox

All-in-one online tools platform built with Laravel 12 and MySQL.

> © 2026 Prasetya Riski Wa'afan. All rights reserved.

## Features

| Category | Tools |
|----------|-------|
| **Text** | Case Converter, Lorem Ipsum Generator, Letter Counter, Whitespace Remover |
| **Image** | Cropper, Resizer, Filters, Color Picker, Base64 Converter |
| **CSS** | Loader Generator, Gradient, Box Shadow, Border Radius, Glassmorphism |
| **Coding** | JSON Formatter, Base64/URL Encoder-Decoder, HTML/CSS/JS Minifier |
| **Color** | HEX-RGBA Converter, Shades Generator, Color Mixer |
| **Social Media** | Tweet to Image, Instagram Post Generator, YouTube Thumbnail |
| **Misc** | QR Code, Password Generator, Barcode, List Randomizer |

## Requirements

- PHP >= 8.2
- MySQL >= 8.0
- Composer
- Node.js & NPM

## Quick Start

```bash
# Clone repository
git clone https://github.com/PrasetyaRiski/ToolBox.git
cd ToolBox

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate --seed

# Run application
npm run dev        # Terminal 1
php artisan serve  # Terminal 2
```

Access: http://localhost:8000

## Database Configuration

Update `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=toolbox
DB_USERNAME=root
DB_PASSWORD=
```

## Tech Stack

- **Backend:** Laravel 12
- **Frontend:** Blade, Alpine.js
- **Styling:** Tailwind CSS
- **Database:** MySQL
- **Build:** Vite

## Production Deployment

```bash
# Optimize
composer install --optimize-autoloader --no-dev
npm run build

# Cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache
```

Set in `.env`:
```env
APP_ENV=production
APP_DEBUG=false
```

## License

MIT License
