<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MiscToolsController extends Controller
{
    public function qrCodeGenerator(Request $request)
    {
        if ($request->isMethod('post')) {
            $text = $request->input('text', '');
            $size = $request->input('size', 200);

            // Using QR Server API for QR code generation
            $url = "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data=" . urlencode($text);

            return response()->json(['qr_url' => $url]);
        }

        return view('tools.misc.qr-code-generator');
    }

    public function passwordGenerator(Request $request)
    {
        if ($request->isMethod('post')) {
            $length = $request->input('length', 16);
            $includeUppercase = $request->input('uppercase', true);
            $includeLowercase = $request->input('lowercase', true);
            $includeNumbers = $request->input('numbers', true);
            $includeSymbols = $request->input('symbols', true);

            $chars = '';
            if ($includeLowercase) $chars .= 'abcdefghijklmnopqrstuvwxyz';
            if ($includeUppercase) $chars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            if ($includeNumbers) $chars .= '0123456789';
            if ($includeSymbols) $chars .= '!@#$%^&*()_+-=[]{}|;:,.<>?';

            $password = '';
            for ($i = 0; $i < $length; $i++) {
                $password .= $chars[random_int(0, strlen($chars) - 1)];
            }

            return response()->json(['password' => $password]);
        }

        return view('tools.misc.password-generator');
    }

    public function listRandomizer(Request $request)
    {
        if ($request->isMethod('post')) {
            $list = $request->input('list', '');
            $action = $request->input('action', 'shuffle');
            $items = array_filter(array_map('trim', explode("\n", $list)));

            if (empty($items)) {
                return response()->json(['error' => 'Empty list'], 400);
            }

            if ($action === 'pick') {
                // Pick random item
                $randomItem = $items[array_rand($items)];
                return response()->json(['result' => $randomItem]);
            } else {
                // Shuffle list
                shuffle($items);
                return response()->json(['result' => $items]);
            }
        }

        return view('tools.misc.list-randomizer');
    }
}
