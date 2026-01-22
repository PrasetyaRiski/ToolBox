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
use App\Models\ToolUsageLog;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function show($slug)
    {
        // Mapping database slug to specific route names
        $routeMapping = [
            // Text Tools
            'case-converter' => 'tools.case-converter',
            'lorem-ipsum-generator' => 'tools.lorem-ipsum',
            'letter-counter' => 'tools.letter-counter',
            'whitespace-remover' => 'tools.whitespace-remover',
            'multiple-whitespace-remover' => 'tools.whitespace-remover',

            // Color Tools
            'hex-to-rgba-converter' => 'tools.hex-to-rgba',
            'rgba-to-hex-converter' => 'tools.rgba-to-hex',
            'color-shades-generator' => 'tools.color-shades',

            // Coding Tools
            'base64-encoder-decoder' => 'tools.base64',
            'url-encoder-decoder' => 'tools.url-encode',
            'html-minifier' => 'tools.html-minifier',
            'css-minifier' => 'tools.css-minifier',
            'json-formatter' => 'tools.json-formatter',

            // Misc Tools
            'qr-code-generator' => 'tools.qr-code',
            'password-generator' => 'tools.password-generator',
            'list-randomizer' => 'tools.list-randomizer',
        ];

        // If there's a specific route for this slug, redirect to it
        if (isset($routeMapping[$slug])) {
            return redirect()->route($routeMapping[$slug]);
        }

        // Otherwise, show generic tool page (for tools not yet implemented)
        $tool = Tool::with('category')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Log usage
        $this->logUsage($tool, request());

        // Increment usage count
        $tool->incrementUsage();

        return view('tools.show', compact('tool'));
    }

    protected function logUsage(Tool $tool, Request $request)
    {
        ToolUsageLog::create([
            'tool_id' => $tool->id,
            'user_id' => auth()->id(),
            'session_id' => session()->getId(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'used_at' => now(),
        ]);
    }
}
