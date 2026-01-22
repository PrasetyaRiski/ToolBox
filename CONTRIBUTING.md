# Contributing to ProductiviTools

Thank you for considering contributing to ProductiviTools! 

## 🚀 How to Contribute

### Adding New Tools

1. **Add Tool to Database**
   - Edit `database/seeders/ToolSeeder.php`
   - Add your tool information

2. **Create Controller Method**
   - Add method to appropriate controller in `app/Http/Controllers/Tools/`
   - Or create new controller if needed

3. **Add Route**
   - Update `routes/web.php` with your tool route

4. **Create View**
   - Create Blade template in `resources/views/tools/[category]/`
   - Follow existing pattern for consistency

### Example: Adding a New Tool

```php
// 1. In ToolSeeder.php
[
    'name' => 'Your Tool Name',
    'slug' => 'your-tool-name',
    'description' => 'Tool description',
    'category' => 'text-tools', // or appropriate category
]

// 2. In TextToolsController.php (or appropriate controller)
public function yourToolName(Request $request)
{
    if ($request->isMethod('post')) {
        // Process logic here
        return response()->json(['result' => $result]);
    }
    
    return view('tools.text.your-tool-name');
}

// 3. In web.php
Route::match(['get', 'post'], '/tools/your-tool-name', 
    [TextToolsController::class, 'yourToolName'])
    ->name('tools.your-tool-name');
```

## 📝 Code Style Guidelines

- Follow PSR-12 coding standards for PHP
- Use 4 spaces for indentation
- Add comments for complex logic
- Keep controllers thin, models fat
- Use meaningful variable names

## 🔄 Pull Request Process

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingTool`)
3. Commit your changes (`git commit -m 'Add some AmazingTool'`)
4. Push to the branch (`git push origin feature/AmazingTool`)
5. Open a Pull Request

## 🐛 Reporting Bugs

- Use GitHub Issues
- Provide detailed description
- Include steps to reproduce
- Add screenshots if applicable

## 💡 Suggesting Enhancements

- Open an issue with [ENHANCEMENT] tag
- Describe the feature clearly
- Explain why it would be useful

## 📋 Development Setup

```bash
# Clone your fork
git clone https://github.com/your-username/productivitools.git

# Install dependencies
composer install
npm install

# Setup database
php artisan migrate
php artisan db:seed

# Start development
npm run dev
php artisan serve
```

## ✅ Testing

- Test your tool thoroughly
- Check responsive design
- Verify error handling
- Ensure AJAX requests work

## 📄 License

By contributing, you agree that your contributions will be licensed under the MIT License.

Thank you for making ProductiviTools better! 🎉
