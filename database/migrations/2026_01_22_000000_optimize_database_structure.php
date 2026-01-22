<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Optimasi database untuk efisiensi:
     * 1. Hapus tabel tool_usage_logs (boros storage)
     * 2. Hapus kolom token Google (hanya simpan google_id)
     * 3. Hapus kolom session_id dari user_favorites (favorites hanya untuk user login)
     * 4. Hapus kolom meta_data dari tools (tidak digunakan)
     */
    public function up(): void
    {
        // 1. Hapus tabel tool_usage_logs
        Schema::dropIfExists('tool_usage_logs');

        // 2. Hapus kolom token Google dari users
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_token', 'google_refresh_token']);
        });

        // 3. Hapus kolom session_id dari user_favorites
        Schema::table('user_favorites', function (Blueprint $table) {
            $table->dropIndex(['session_id']);
            $table->dropColumn('session_id');
        });

        // 4. Hapus kolom meta_data dari tools
        Schema::table('tools', function (Blueprint $table) {
            $table->dropColumn('meta_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore tool_usage_logs table
        Schema::create('tool_usage_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tool_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('session_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('used_at');
            $table->index(['tool_id', 'used_at']);
        });

        // Restore Google token columns
        Schema::table('users', function (Blueprint $table) {
            $table->text('google_token')->nullable();
            $table->text('google_refresh_token')->nullable();
        });

        // Restore session_id in user_favorites
        Schema::table('user_favorites', function (Blueprint $table) {
            $table->string('session_id')->nullable();
            $table->index('session_id');
        });

        // Restore meta_data in tools
        Schema::table('tools', function (Blueprint $table) {
            $table->json('meta_data')->nullable();
        });
    }
};
