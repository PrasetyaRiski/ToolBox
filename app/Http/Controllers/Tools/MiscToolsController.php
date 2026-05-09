<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MiscToolsController extends Controller
{
    public function qrCodeGenerator(Request $request)
    {
        if ($request->isMethod('post')) {
            $text = trim($request->input('text', ''));
            $size = (int) $request->input('size', 200);

            if ($text === '') {
                return response()->json(['success' => false, 'message' => 'Text or URL cannot be empty.'], 422);
            }

            // Clamp size to sensible range
            $size = max(100, min(1000, $size));

            try {
                // goqr.me API — free, reliable, returns valid scannable QR
                $url = sprintf(
                    'https://api.qrserver.com/v1/create-qr-code/?size=%dx%d&data=%s&ecc=M&margin=10',
                    $size,
                    $size,
                    urlencode($text)
                );

                return response()->json([
                    'success' => true,
                    'data'    => [
                        'qr_url'  => $url,
                        'content' => $text,
                        'size'    => $size,
                    ],
                ]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        return view('tools.misc.qr-code-generator');
    }

    public function passwordGenerator(Request $request)
    {
        if ($request->isMethod('post')) {
            $length           = (int) $request->input('length', 16);
            $includeUppercase = filter_var($request->input('uppercase', true), FILTER_VALIDATE_BOOLEAN);
            $includeLowercase = filter_var($request->input('lowercase', true), FILTER_VALIDATE_BOOLEAN);
            $includeNumbers   = filter_var($request->input('numbers', true), FILTER_VALIDATE_BOOLEAN);
            $includeSymbols   = filter_var($request->input('symbols', false), FILTER_VALIDATE_BOOLEAN);

            // Clamp length
            $length = max(8, min(128, $length));

            if (!$includeUppercase && !$includeLowercase && !$includeNumbers && !$includeSymbols) {
                return response()->json(['success' => false, 'message' => 'Select at least one character type.'], 422);
            }

            try {
                $charsets = [];
                if ($includeLowercase) $charsets['lower']   = 'abcdefghijklmnopqrstuvwxyz';
                if ($includeUppercase) $charsets['upper']   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                if ($includeNumbers)   $charsets['numbers'] = '0123456789';
                if ($includeSymbols)   $charsets['symbols'] = '!@#$%^&*()-_=+[]{}|;:,.<>?';

                $allChars = implode('', $charsets);
                $password = '';

                // Guarantee at least one character from each selected charset
                foreach ($charsets as $set) {
                    $password .= $set[random_int(0, strlen($set) - 1)];
                }

                // Fill the rest randomly from the combined charset
                $remaining = $length - strlen($password);
                for ($i = 0; $i < $remaining; $i++) {
                    $password .= $allChars[random_int(0, strlen($allChars) - 1)];
                }

                // Shuffle to avoid predictable pattern at start
                $chars    = str_split($password);
                $shuffled = '';
                while (!empty($chars)) {
                    $idx      = random_int(0, count($chars) - 1);
                    $shuffled .= $chars[$idx];
                    array_splice($chars, $idx, 1);
                }

                return response()->json([
                    'success' => true,
                    'data'    => [
                        'password' => $shuffled,
                        'length'   => strlen($shuffled),
                        'strength' => $this->passwordStrength($shuffled),
                    ],
                ]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        return view('tools.misc.password-generator');
    }

    public function listRandomizer(Request $request)
    {
        if ($request->isMethod('post')) {
            $list   = $request->input('list', '');
            $action = $request->input('action', 'shuffle');

            if (trim($list) === '') {
                return response()->json(['success' => false, 'message' => 'List cannot be empty.'], 422);
            }

            // Split by newlines, trim each item, remove empty lines — preserve all non-empty items
            $items = array_values(array_filter(
                array_map('trim', preg_split('/\r?\n/', $list)),
                fn($item) => $item !== ''
            ));

            if (count($items) < 2 && $action === 'shuffle') {
                return response()->json(['success' => false, 'message' => 'Need at least 2 items to shuffle.'], 422);
            }

            if (empty($items)) {
                return response()->json(['success' => false, 'message' => 'No valid items found.'], 422);
            }

            try {
                if ($action === 'pick') {
                    $randomItem = $items[random_int(0, count($items) - 1)];
                    return response()->json([
                        'success' => true,
                        'data'    => [
                            'action' => 'pick',
                            'result' => $randomItem,
                            'total'  => count($items),
                        ],
                    ]);
                } else {
                    // Fisher-Yates shuffle using random_int for cryptographic randomness
                    $shuffled = $items;
                    for ($i = count($shuffled) - 1; $i > 0; $i--) {
                        $j             = random_int(0, $i);
                        [$shuffled[$i], $shuffled[$j]] = [$shuffled[$j], $shuffled[$i]];
                    }

                    return response()->json([
                        'success' => true,
                        'data'    => [
                            'action' => 'shuffle',
                            'result' => $shuffled,
                            'total'  => count($shuffled),
                        ],
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        return view('tools.misc.list-randomizer');
    }

    // ─── Private Helpers ─────────────────────────────────────────────────────

    private function passwordStrength(string $password): string
    {
        $score = 0;
        if (strlen($password) >= 12) $score++;
        if (strlen($password) >= 16) $score++;
        if (preg_match('/[a-z]/', $password)) $score++;
        if (preg_match('/[A-Z]/', $password)) $score++;
        if (preg_match('/[0-9]/', $password)) $score++;
        if (preg_match('/[^a-zA-Z0-9]/', $password)) $score++;

        return match (true) {
            $score <= 2 => 'weak',
            $score <= 4 => 'medium',
            default     => 'strong',
        };
    }
}
