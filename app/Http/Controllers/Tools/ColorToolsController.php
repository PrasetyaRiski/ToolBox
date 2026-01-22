<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ColorToolsController extends Controller
{
    public function hexToRgba(Request $request)
    {
        if ($request->isMethod('post')) {
            $hex = $request->input('hex');
            $opacity = $request->input('opacity', 1);
            $hex = ltrim($hex, '#');

            if (strlen($hex) === 3) {
                $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
            }

            if (strlen($hex) !== 6) {
                return response()->json(['error' => 'Invalid HEX color'], 400);
            }

            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));

            return response()->json([
                'rgba' => "rgba($r, $g, $b, $opacity)",
                'rgb' => "rgb($r, $g, $b)",
                'r' => $r,
                'g' => $g,
                'b' => $b,
            ]);
        }

        return view('tools.color.hex-to-rgba');
    }

    public function rgbaToHex(Request $request)
    {
        if ($request->isMethod('post')) {
            $r = $request->input('r');
            $g = $request->input('g');
            $b = $request->input('b');
            $a = $request->input('a', 1);

            $hex = '#' . sprintf('%02x%02x%02x', $r, $g, $b);

            return response()->json([
                'hex' => $hex,
                'hex8' => $hex . sprintf('%02x', round($a * 255)),
            ]);
        }

        return view('tools.color.rgba-to-hex');
    }

    public function colorShades(Request $request)
    {
        if ($request->isMethod('post')) {
            $color = $request->input('color');
            $hex = ltrim($color, '#');

            if (strlen($hex) === 3) {
                $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
            }

            if (strlen($hex) !== 6) {
                return response()->json(['error' => 'Invalid color'], 400);
            }

            $shades = [];

            // Generate darker shades
            for ($i = 5; $i > 0; $i--) {
                $shades[] = $this->adjustBrightness($hex, -($i * 0.15));
            }

            // Original color
            $shades[] = '#' . $hex;

            // Generate lighter shades
            for ($i = 1; $i <= 5; $i++) {
                $shades[] = $this->adjustBrightness($hex, $i * 0.15);
            }

            return response()->json(['shades' => $shades]);
        }

        return view('tools.color.color-shades');
    }

    private function adjustBrightness($hex, $factor)
    {
        $hex = ltrim($hex, '#');
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Adjust brightness
        if ($factor > 0) {
            // Lighten
            $r = min(255, $r + (255 - $r) * $factor);
            $g = min(255, $g + (255 - $g) * $factor);
            $b = min(255, $b + (255 - $b) * $factor);
        } else {
            // Darken
            $factor = abs($factor);
            $r = max(0, $r - ($r * $factor));
            $g = max(0, $g - ($g * $factor));
            $b = max(0, $b - ($b * $factor));
        }

        return '#' . sprintf('%02x%02x%02x', round($r), round($g), round($b));
    }
}
