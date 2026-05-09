<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CodingToolsController extends Controller
{
    public function base64Encode(Request $request)
    {
        if ($request->isMethod('post')) {
            $text   = $request->input('text', '');
            $action = $request->input('action', 'encode');

            if (trim($text) === '') {
                return response()->json(['success' => false, 'message' => 'Input cannot be empty.'], 422);
            }

            try {
                if ($action === 'encode') {
                    $result = base64_encode($text);
                } else {
                    // Strict validation: base64_decode with strict=true returns false on invalid input
                    $clean  = preg_replace('/\s+/', '', $text); // strip whitespace/newlines from pasted base64
                    $decoded = base64_decode($clean, true);

                    if ($decoded === false) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Invalid Base64 string. Make sure the input is valid Base64-encoded text.',
                        ], 422);
                    }
                    $result = $decoded;
                }

                return response()->json(['success' => true, 'data' => ['result' => $result]]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        return view('tools.coding.base64-encoder-decoder');
    }

    public function urlEncode(Request $request)
    {
        if ($request->isMethod('post')) {
            $text   = $request->input('text', '');
            $action = $request->input('action', 'encode');

            if ($text === '') {
                return response()->json(['success' => false, 'message' => 'Input cannot be empty.'], 422);
            }

            try {
                // rawurlencode is RFC 3986 compliant (encodes space as %20, not +)
                $result = $action === 'encode' ? rawurlencode($text) : rawurldecode($text);
                return response()->json(['success' => true, 'data' => ['result' => $result]]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        return view('tools.coding.url-encoder-decoder');
    }

    public function htmlMinifier(Request $request)
    {
        if ($request->isMethod('post')) {
            $html = $request->input('html', '');

            if (trim($html) === '') {
                return response()->json(['success' => false, 'message' => 'HTML cannot be empty.'], 422);
            }

            try {
                $minified = $this->minifyHtml($html);
                return response()->json(['success' => true, 'data' => ['minified' => $minified]]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        return view('tools.coding.html-minifier');
    }

    public function cssMinifier(Request $request)
    {
        if ($request->isMethod('post')) {
            $css = $request->input('css', '');

            if (trim($css) === '') {
                return response()->json(['success' => false, 'message' => 'CSS cannot be empty.'], 422);
            }

            try {
                $minified = $this->minifyCss($css);
                return response()->json(['success' => true, 'data' => ['minified' => $minified]]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        return view('tools.coding.css-minifier');
    }

    public function jsonFormatter(Request $request)
    {
        if ($request->isMethod('post')) {
            $json = $request->input('json', '');

            if (trim($json) === '') {
                return response()->json(['success' => false, 'message' => 'JSON input cannot be empty.'], 422);
            }

            try {
                // Use JSON_THROW_ON_ERROR so we get a real exception with a message
                $decoded   = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
                $formatted = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                $minified  = json_encode($decoded, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

                return response()->json([
                    'success' => true,
                    'data'    => [
                        'formatted' => $formatted,
                        'minified'  => $minified,
                        'valid'     => true,
                    ],
                ]);
            } catch (\JsonException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid JSON: ' . $e->getMessage(),
                    'data'    => ['valid' => false],
                ], 422);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        return view('tools.coding.json-formatter');
    }

    // ─── Private Helpers ─────────────────────────────────────────────────────

    private function minifyHtml(string $html): string
    {
        // 1. Preserve content inside <pre>, <script>, <style>, <textarea>
        $placeholders = [];
        $preservePattern = '/<(pre|script|style|textarea)(\s[^>]*)?>.*?<\/\1>/is';

        $html = preg_replace_callback($preservePattern, function ($m) use (&$placeholders) {
            $key = '<!--PRESERVE_' . count($placeholders) . '-->';
            $placeholders[$key] = $m[0];
            return $key;
        }, $html);

        // 2. Remove HTML comments (but not IE conditionals)
        $html = preg_replace('/<!--(?!\[if).*?-->/s', '', $html);

        // 3. Remove whitespace between tags
        $html = preg_replace('/>\s+</s', '><', $html);

        // 4. Collapse multiple spaces/tabs to single space (keep newlines for safety)
        $html = preg_replace('/[^\S\n]+/', ' ', $html);

        // 5. Restore preserved blocks
        foreach ($placeholders as $key => $val) {
            $html = str_replace($key, $val, $html);
        }

        return trim($html);
    }

    private function minifyCss(string $css): string
    {
        // 1. Remove block comments
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);

        // 2. Remove whitespace around selectors, braces, colons, semicolons
        $css = preg_replace('/\s*{\s*/', '{', $css);
        $css = preg_replace('/\s*}\s*/', '}', $css);
        $css = preg_replace('/\s*:\s*/', ':', $css);
        $css = preg_replace('/\s*;\s*/', ';', $css);
        $css = preg_replace('/\s*,\s*/', ',', $css);

        // 3. Remove last semicolon before closing brace
        $css = str_replace(';}', '}', $css);

        // 4. Collapse remaining whitespace
        $css = preg_replace('/\s+/', ' ', $css);

        return trim($css);
    }
}
