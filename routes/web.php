<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\Tools\TextToolsController;
use App\Http\Controllers\Tools\ColorToolsController;
use App\Http\Controllers\Tools\CodingToolsController;
use App\Http\Controllers\Tools\MiscToolsController;
use Illuminate\Support\Facades\Route;

// Home & Search
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password Routes
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['request' => request()]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');

// Google OAuth Routes
Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->middleware('auth')->name('categories.show');

// Protected Routes (Require Authentication)
Route::middleware('auth')->group(function () {
    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Text Tools
    Route::match(['get', 'post'], '/tools/case-converter', [TextToolsController::class, 'caseConverter'])->name('tools.case-converter');
    Route::match(['get', 'post'], '/tools/lorem-ipsum-generator', [TextToolsController::class, 'loremIpsum'])->name('tools.lorem-ipsum');
    Route::match(['get', 'post'], '/tools/letter-counter', [TextToolsController::class, 'letterCounter'])->name('tools.letter-counter');
    Route::match(['get', 'post'], '/tools/whitespace-remover', [TextToolsController::class, 'whitespaceRemover'])->name('tools.whitespace-remover');

    // Color Tools
    Route::match(['get', 'post'], '/tools/hex-to-rgba', [ColorToolsController::class, 'hexToRgba'])->name('tools.hex-to-rgba');
    Route::match(['get', 'post'], '/tools/rgba-to-hex', [ColorToolsController::class, 'rgbaToHex'])->name('tools.rgba-to-hex');
    Route::match(['get', 'post'], '/tools/color-shades', [ColorToolsController::class, 'colorShades'])->name('tools.color-shades');

    // Coding Tools
    Route::match(['get', 'post'], '/tools/base64-encoder-decoder', [CodingToolsController::class, 'base64Encode'])->name('tools.base64');
    Route::match(['get', 'post'], '/tools/url-encoder-decoder', [CodingToolsController::class, 'urlEncode'])->name('tools.url-encode');
    Route::match(['get', 'post'], '/tools/html-minifier', [CodingToolsController::class, 'htmlMinifier'])->name('tools.html-minifier');
    Route::match(['get', 'post'], '/tools/css-minifier', [CodingToolsController::class, 'cssMinifier'])->name('tools.css-minifier');
    Route::match(['get', 'post'], '/tools/json-formatter', [CodingToolsController::class, 'jsonFormatter'])->name('tools.json-formatter');

    // Miscellaneous Tools
    Route::match(['get', 'post'], '/tools/qr-code-generator', [MiscToolsController::class, 'qrCodeGenerator'])->name('tools.qr-code');
    Route::match(['get', 'post'], '/tools/password-generator', [MiscToolsController::class, 'passwordGenerator'])->name('tools.password-generator');
    Route::match(['get', 'post'], '/tools/list-randomizer', [MiscToolsController::class, 'listRandomizer'])->name('tools.list-randomizer');

    // Generic tool route (for tools without specific functionality yet)
    Route::get('/tools/{slug}', [ToolController::class, 'show'])->name('tools.show');
});
