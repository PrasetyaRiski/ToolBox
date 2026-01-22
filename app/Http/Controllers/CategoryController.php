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

namespace App\Http\Controllers;

use App\Models\ToolCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = ToolCategory::withCount('tools')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show($slug)
    {
        $category = ToolCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $tools = $category->activeTools()
            ->paginate(20);

        return view('categories.show', compact('category', 'tools'));
    }
}
