# ToolBox

All-in-one online tools platform for your daily productivity needs.

![Language](https://img.shields.io/badge/Language-PHP%20%7C%20Blade%20%7C%20JavaScript-blue?style=flat-square)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

## 📖 About

**ToolBox** is a comprehensive web application project created as part of the Web Programming course (UAS PEMWEB). It provides a collection of useful tools designed to help users with various daily tasks, featuring an intuitive interface and reliable functionality.

## ✨ Features

- 🛠️ **Multiple Utility Tools** - Wide range of tools for different purposes
- 🎨 **Responsive Design** - Works seamlessly on desktop and mobile devices
- ⚡ **Fast Performance** - Optimized for quick processing
- 🔧 **Easy to Use** - User-friendly interface and intuitive navigation
- 🎯 **Practical Solutions** - Designed to solve real-world problems

## 🛠️ Tech Stack

- **Backend:** PHP (64.8%)
- **Frontend:** Blade Templating (8.1%), JavaScript (0.2%), CSS (0.3%)
- **Additional:** Hack (26.4%), Batchfile (0.1%), Shell (0.1%)
- **Server:** Apache or Nginx

## 🚀 Getting Started

### Prerequisites

- PHP 7.4 or higher
- Composer
- Web server (Apache/Nginx)
- MySQL (optional, if database is used)

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/PrasetyaRiski/ToolBox.git
   cd ToolBox
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Configure your web server:**
   - Point the document root to the project directory
   - Ensure PHP is properly configured

4. **Run the application:**
   - Open your browser and navigate to `http://localhost` (or your configured URL)

### Optional Database Setup

If the project uses a database:

```bash
# Create database
mysql -u root -p -e "CREATE DATABASE toolbox;"

# Configure .env file (if exists)
cp .env.example .env

# Run migrations (if applicable)
php artisan migrate
```

## 📁 Project Structure

```
ToolBox/
├── public/              # Publicly accessible files
├── src/                 # Source code
├── vendor/              # Composer dependencies
├── README.md            # This file
└── composer.json        # PHP dependencies
```

## 💡 Usage

Detailed usage instructions for each tool will be added to this section.

## 🔐 Security

- Regular security updates recommended
- Validate all user inputs
- Use HTTPS in production
- Keep dependencies up-to-date

## 📝 Contributing

We welcome contributions! If you have suggestions or find bugs:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

## 👤 Author

**Prasetya Riski Wa'afan**

---

*Last Updated: May 9, 2026*
