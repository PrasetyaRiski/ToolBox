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

use App\Models\Tool;
use App\Models\ToolCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredTools = Tool::with('category')
            ->featured()
            ->active()
            ->orderBy('order')
            ->limit(8)
            ->get();

        $categories = ToolCategory::with(['activeTools' => function ($query) {
            $query->limit(6);
        }])
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        return view('home', compact('featuredTools', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $tools = Tool::with('category')
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->orderBy('usage_count', 'desc')
            ->paginate(20);

        return view('search', compact('tools', 'query'));
    }
}
