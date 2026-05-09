<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ColorToolsController extends Controller
{
    public function hexToRgba(Request $request)
    {
        if ($request->isMethod('post')) {
            $hex     = trim($request->input('hex', ''));
            $opacity = (float) $request->input('opacity', 1);
            $opacity = max(0.0, min(1.0, $opacity)); // clamp 0–1

            $hex = ltrim($hex, '#');

            // Expand 3-char shorthand (#abc → #aabbcc)
            if (strlen($hex) === 3) {
                $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
            }

            // Support 8-char hex with alpha (#rrggbbaa)
            $alpha = 1.0;
            if (strlen($hex) === 8) {
                $alpha = round(hexdec(substr($hex, 6, 2)) / 255, 2);
                $hex   = substr($hex, 0, 6);
                $opacity = $alpha; // override with embedded alpha
            }

            if (strlen($hex) !== 6 || !ctype_xdigit($hex)) {
                return response()->json(['success' => false, 'message' => 'Invalid HEX color format. Use #RRGGBB or #RGB.'], 422);
            }

            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));

            return response()->json([
                'success' => true,
                'data'    => [
                    'rgba' => "rgba($r, $g, $b, $opacity)",
                    'rgb'  => "rgb($r, $g, $b)",
                    'r'    => $r,
                    'g'    => $g,
                    'b'    => $b,
                    'a'    => $opacity,
                ],
            ]);
        }

        return view('tools.color.hex-to-rgba');
    }

    public function rgbaToHex(Request $request)
    {
        if ($request->isMethod('post')) {
            $r = (int) $request->input('r', 0);
            $g = (int) $request->input('g', 0);
            $b = (int) $request->input('b', 0);
            $a = (float) $request->input('a', 1);

            // Validate ranges
            if ($r < 0 || $r > 255 || $g < 0 || $g > 255 || $b < 0 || $b > 255) {
                return response()->json(['success' => false, 'message' => 'R, G, B values must be between 0 and 255.'], 422);
            }
            if ($a < 0 || $a > 1) {
                return response()->json(['success' => false, 'message' => 'Alpha (A) must be between 0 and 1.'], 422);
            }

            $hex   = '#' . sprintf('%02x%02x%02x', $r, $g, $b);
            $hex8  = '#' . sprintf('%02x%02x%02x%02x', $r, $g, $b, (int) round($a * 255));

            return response()->json([
                'success' => true,
                'data'    => [
                    'hex'  => strtoupper($hex),
                    'hex8' => strtoupper($hex8),
                ],
            ]);
        }

        return view('tools.color.rgba-to-hex');
    }

    public function colorShades(Request $request)
    {
        if ($request->isMethod('post')) {
            $color = trim($request->input('color', ''));
            $hex   = ltrim($color, '#');

            if (strlen($hex) === 3) {
                $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
            }

            if (strlen($hex) !== 6 || !ctype_xdigit($hex)) {
                return response()->json(['success' => false, 'message' => 'Invalid HEX color format.'], 422);
            }

            try {
                // Generate 10 shades: 100 (lightest) to 900 (darkest), with 500 = original
                // Steps: -80%, -60%, -40%, -20%, -10%, 0% (original), +20%, +40%, +60%, +80%
                $steps  = [-0.80, -0.60, -0.40, -0.20, -0.10, 0, 0.20, 0.40, 0.60, 0.80];
                $labels = [100, 200, 300, 400, 450, 500, 600, 700, 800, 900];
                $shades = [];

                foreach ($steps as $i => $step) {
                    $shades[] = [
                        'label' => $labels[$i],
                        'hex'   => $this->adjustBrightness($hex, $step),
                    ];
                }

                return response()->json(['success' => true, 'data' => ['shades' => $shades, 'original' => '#' . strtoupper($hex)]]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        return view('tools.color.color-shades');
    }

    // ─── Private Helpers ─────────────────────────────────────────────────────

    /**
     * Adjust brightness of a hex color.
     * Positive factor lightens (blends toward white), negative darkens (blends toward black).
     * Factor range: -1.0 to +1.0
     */
    private function adjustBrightness(string $hex, float $factor): string
    {
        $hex = ltrim($hex, '#');
        $r   = hexdec(substr($hex, 0, 2));
        $g   = hexdec(substr($hex, 2, 2));
        $b   = hexdec(substr($hex, 4, 2));

        if ($factor > 0) {
            // Lighten: blend toward white (255)
            $r = (int) round($r + (255 - $r) * $factor);
            $g = (int) round($g + (255 - $g) * $factor);
            $b = (int) round($b + (255 - $b) * $factor);
        } elseif ($factor < 0) {
            // Darken: blend toward black (0)
            $f = abs($factor);
            $r = (int) round($r * (1 - $f));
            $g = (int) round($g * (1 - $f));
            $b = (int) round($b * (1 - $f));
        }

        $r = max(0, min(255, $r));
        $g = max(0, min(255, $g));
        $b = max(0, min(255, $b));

        return '#' . strtoupper(sprintf('%02x%02x%02x', $r, $g, $b));
    }
}
