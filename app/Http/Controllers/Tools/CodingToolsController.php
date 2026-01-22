<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CodingToolsController extends Controller
{
    public function base64Encode(Request $request)
    {
        if ($request->isMethod('post')) {
            $text = $request->input('text', '');
            $action = $request->input('action', 'encode');

            if ($action === 'encode') {
                $result = base64_encode($text);
            } else {
                $result = base64_decode($text);
            }

            return response()->json(['result' => $result]);
        }

        return view('tools.coding.base64-encoder-decoder');
    }

    public function urlEncode(Request $request)
    {
        if ($request->isMethod('post')) {
            $text = $request->input('text', '');
            $action = $request->input('action', 'encode');

            if ($action === 'encode') {
                $result = urlencode($text);
            } else {
                $result = urldecode($text);
            }

            return response()->json(['result' => $result]);
        }

        return view('tools.coding.url-encoder-decoder');
    }

    public function htmlMinifier(Request $request)
    {
        if ($request->isMethod('post')) {
            $html = $request->input('html', '');

            // Simple HTML minification
            $minified = preg_replace('/\s+/', ' ', $html);
            $minified = preg_replace('/>\s+</', '><', $minified);
            $minified = preg_replace('/\s+/', ' ', $minified);

            return response()->json(['minified' => trim($minified)]);
        }

        return view('tools.coding.html-minifier');
    }

    public function cssMinifier(Request $request)
    {
        if ($request->isMethod('post')) {
            $css = $request->input('css', '');

            // Simple CSS minification
            $minified = preg_replace('/\s+/', ' ', $css);
            $minified = preg_replace('/\s*{\s*/', '{', $minified);
            $minified = preg_replace('/\s*}\s*/', '}', $minified);
            $minified = preg_replace('/\s*:\s*/', ':', $minified);
            $minified = preg_replace('/\s*;\s*/', ';', $minified);
            $minified = preg_replace('/\/\*.*?\*\//', '', $minified); // Remove comments

            return response()->json(['minified' => trim($minified)]);
        }

        return view('tools.coding.css-minifier');
    }

    public function jsonFormatter(Request $request)
    {
        if ($request->isMethod('post')) {
            $json = $request->input('json', '');

            try {
                $decoded = json_decode($json);
                $formatted = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

                return response()->json([
                    'formatted' => $formatted,
                    'valid' => true,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Invalid JSON',
                    'valid' => false,
                ], 400);
            }
        }

        return view('tools.coding.json-formatter');
    }
}
