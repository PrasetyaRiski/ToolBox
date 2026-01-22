<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TextToolsController extends Controller
{
    public function caseConverter(Request $request)
    {
        if ($request->isMethod('post')) {
            $text = $request->input('text', '');

            return response()->json([
                'uppercase' => strtoupper($text),
                'lowercase' => strtolower($text),
                'titlecase' => ucwords(strtolower($text)),
                'sentencecase' => ucfirst(strtolower($text)),
                'camelcase' => lcfirst(str_replace(' ', '', ucwords($text))),
                'pascalcase' => str_replace(' ', '', ucwords($text)),
                'snakecase' => strtolower(str_replace(' ', '_', $text)),
                'kebabcase' => strtolower(str_replace(' ', '-', $text)),
            ]);
        }

        return view('tools.text.case-converter');
    }

    public function loremIpsum(Request $request)
    {
        if ($request->isMethod('post')) {
            $paragraphs = $request->input('paragraphs', 3);
            $words = $request->input('words', 50);

            $lorem = "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

            $result = [];
            for ($i = 0; $i < $paragraphs; $i++) {
                $result[] = $lorem;
            }

            return response()->json(['text' => implode("\n\n", $result)]);
        }

        return view('tools.text.lorem-ipsum');
    }

    public function letterCounter(Request $request)
    {
        if ($request->isMethod('post')) {
            $text = $request->input('text', '');

            return response()->json([
                'characters' => strlen($text),
                'characters_no_spaces' => strlen(str_replace(' ', '', $text)),
                'words' => str_word_count($text),
                'sentences' => preg_match_all('/[.!?]+/', $text),
                'paragraphs' => count(array_filter(explode("\n", $text))),
                'lines' => substr_count($text, "\n") + 1,
            ]);
        }

        return view('tools.text.letter-counter');
    }

    public function whitespaceRemover(Request $request)
    {
        if ($request->isMethod('post')) {
            $text = $request->input('text', '');
            $type = $request->input('type', 'extra');

            $result = $text;

            switch ($type) {
                case 'all':
                    // Remove all spaces
                    $result = str_replace([' ', "\t", "\n", "\r"], '', $text);
                    break;
                case 'newlines':
                    // Remove newlines
                    $result = str_replace(["\n", "\r"], ' ', $text);
                    $result = preg_replace('/\s+/', ' ', $result);
                    break;
                case 'extra':
                default:
                    // Remove extra spaces (default)
                    $result = preg_replace('/\s+/', ' ', $text);
                    $result = preg_replace('/\n+/', "\n", $result);
                    break;
            }

            return response()->json(['result' => trim($result)]);
        }

        return view('tools.text.whitespace-remover');
    }
}
