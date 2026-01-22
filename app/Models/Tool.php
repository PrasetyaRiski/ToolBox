<?php

/**
 * ============================================================================
 * ProductiviTools - Semua Tools Online dalam Satu Tempat
 * ============================================================================
 *
 * Hak Cipta (C) 2026 Prasetya Riski Wa'afan
 *
 * PERNYATAAN PERLINDUNGAN HARTA CIPTA:
 * Karya ini dilindungi sepenuhnya oleh hak cipta dan undang-undang perlindungan
 * kekayaan intelektual. Dilarang keras menyalin, memodifikasi, atau mendistribusikan
 * tanpa izin tertulis dari pemegang hak cipta.
 *
 * Pelanggaran dapat mengakibatkan tuntutan hukum sesuai dengan peraturan yang berlaku.
 *
 * ============================================================================
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'icon',
        'is_new',
        'is_featured',
        'is_active',
        'usage_count',
        'order',
    ];

    protected $casts = [
        'is_new' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'usage_count' => 'integer',
        'order' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ToolCategory::class, 'category_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(UserFavorite::class);
    }

    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
