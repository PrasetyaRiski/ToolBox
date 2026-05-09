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

            if (trim($text) === '') {
                return response()->json(['success' => false, 'message' => 'Text cannot be empty.'], 422);
            }

            try {
                return response()->json([
                    'success' => true,
                    'data'    => [
                        'uppercase'    => mb_strtoupper($text, 'UTF-8'),
                        'lowercase'    => mb_strtolower($text, 'UTF-8'),
                        'titlecase'    => $this->toTitleCase($text),
                        'sentencecase' => $this->toSentenceCase($text),
                        'alternating'  => $this->toAlternatingCase($text),
                        'camelcase'    => $this->toCamelCase($text),
                        'pascalcase'   => $this->toPascalCase($text),
                        'snakecase'    => $this->toSnakeCase($text),
                        'kebabcase'    => $this->toKebabCase($text),
                    ],
                ]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Processing error: ' . $e->getMessage()], 500);
            }
        }

        return view('tools.text.case-converter');
    }

    public function loremIpsum(Request $request)
    {
        if ($request->isMethod('post')) {
            $type  = $request->input('type', 'paragraphs'); // paragraphs | words | sentences
            $count = (int) $request->input('count', 3);
            $count = max(1, min(100, $count));

            try {
                $result = $this->generateLoremIpsum($type, $count);
                return response()->json(['success' => true, 'data' => ['text' => $result]]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        return view('tools.text.lorem-ipsum');
    }

    public function letterCounter(Request $request)
    {
        if ($request->isMethod('post')) {
            $text = $request->input('text', '');

            try {
                $charCount      = mb_strlen($text, 'UTF-8');
                $charNoSpaces   = mb_strlen(preg_replace('/\s/u', '', $text), 'UTF-8');
                $wordCount      = $text !== '' ? count(preg_split('/\s+/u', trim($text), -1, PREG_SPLIT_NO_EMPTY)) : 0;
                $sentenceCount  = $text !== '' ? (int) preg_match_all('/[.!?]+(?:\s|$)/u', $text) : 0;
                $paragraphCount = $text !== '' ? count(array_filter(preg_split('/\n{2,}/u', trim($text)))) : 0;
                $lineCount      = $text !== '' ? count(explode("\n", $text)) : 0;
                $readingTimeSec = (int) ceil(($wordCount / 200) * 60);

                return response()->json([
                    'success' => true,
                    'data'    => [
                        'characters'           => $charCount,
                        'characters_no_spaces' => $charNoSpaces,
                        'words'                => $wordCount,
                        'sentences'            => $sentenceCount,
                        'paragraphs'           => $paragraphCount,
                        'lines'                => $lineCount,
                        'reading_time_sec'     => $readingTimeSec,
                    ],
                ]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        return view('tools.text.letter-counter');
    }

    public function whitespaceRemover(Request $request)
    {
        if ($request->isMethod('post')) {
            $text = $request->input('text', '');
            $type = $request->input('type', 'normalize');

            if ($text === '') {
                return response()->json(['success' => false, 'message' => 'Text cannot be empty.'], 422);
            }

            try {
                $result = match ($type) {
                    'trim'     => trim($text),
                    'all'      => preg_replace('/\s+/u', '', $text),
                    'newlines' => trim(preg_replace('/[\r\n]+/', ' ', $text)),
                    default    => trim(preg_replace(['/[^\S\n]+/u', '/\n{3,}/'], [' ', "\n\n"], $text)),
                };

                return response()->json(['success' => true, 'data' => ['result' => $result]]);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
        }

        return view('tools.text.whitespace-remover');
    }

    // ─── Private Helpers ─────────────────────────────────────────────────────

    private function toTitleCase(string $text): string
    {
        $lower = mb_strtolower($text, 'UTF-8');
        return preg_replace_callback('/\b\p{L}/u', fn($m) => mb_strtoupper($m[0], 'UTF-8'), $lower);
    }

    private function toSentenceCase(string $text): string
    {
        $lower = mb_strtolower($text, 'UTF-8');
        return preg_replace_callback('/(^|[.!?]\s+)(\p{Ll})/u', function ($m) {
            return $m[1] . mb_strtoupper($m[2], 'UTF-8');
        }, $lower);
    }

    private function toAlternatingCase(string $text): string
    {
        $chars  = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);
        $upper  = false;
        $result = '';
        foreach ($chars as $char) {
            if (preg_match('/\p{L}/u', $char)) {
                $result .= $upper ? mb_strtoupper($char, 'UTF-8') : mb_strtolower($char, 'UTF-8');
                $upper   = !$upper;
            } else {
                $result .= $char;
            }
        }
        return $result;
    }

    private function toCamelCase(string $text): string
    {
        $words = preg_split('/[\s_\-]+/u', $text);
        $first = mb_strtolower(array_shift($words), 'UTF-8');
        $rest  = array_map(
            fn($w) => mb_strtoupper(mb_substr($w, 0, 1, 'UTF-8'), 'UTF-8') . mb_strtolower(mb_substr($w, 1, null, 'UTF-8'), 'UTF-8'),
            $words
        );
        return $first . implode('', $rest);
    }

    private function toPascalCase(string $text): string
    {
        $words = preg_split('/[\s_\-]+/u', $text);
        return implode('', array_map(
            fn($w) => mb_strtoupper(mb_substr($w, 0, 1, 'UTF-8'), 'UTF-8') . mb_strtolower(mb_substr($w, 1, null, 'UTF-8'), 'UTF-8'),
            $words
        ));
    }

    private function toSnakeCase(string $text): string
    {
        $text = preg_replace('/[\s\-]+/', '_', trim($text));
        return mb_strtolower($text, 'UTF-8');
    }

    private function toKebabCase(string $text): string
    {
        $text = preg_replace('/[\s_]+/', '-', trim($text));
        return mb_strtolower($text, 'UTF-8');
    }

    private function generateLoremIpsum(string $type, int $count): string
    {
        $sentences = [
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit.",
            "Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
            "Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi.",
            "Duis aute irure dolor in reprehenderit in voluptate velit esse cillum.",
            "Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt.",
            "Curabitur pretium tincidunt lacus nec dignissim augue mollis eget.",
            "Morbi blandit ligula feugiat magna consequat, ut rutrum ex vulputate.",
            "Phasellus porta mauris at ante aliquet, at volutpat tortor aliquet.",
            "Pellentesque habitant morbi tristique senectus et netus et malesuada fames.",
            "Fusce dapibus tellus ac cursus commodo, tortor mauris condimentum nibh.",
            "Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere.",
            "Nullam quis risus eget urna mollis ornare vel eu leo.",
            "Cras mattis consectetur purus sit amet fermentum.",
            "Integer posuere erat a ante venenatis dapibus posuere velit aliquet.",
            "Aenean lacinia bibendum nulla sed consectetur.",
        ];

        $allWords = array_filter(
            array_map(fn($w) => preg_replace('/[^a-zA-Z]/u', '', $w), explode(' ', implode(' ', $sentences)))
        );
        $allWords = array_values($allWords);
        $totalWords = count($allWords);
        $totalSents = count($sentences);

        switch ($type) {
            case 'words':
                $selected   = [];
                for ($i = 0; $i < $count; $i++) {
                    $selected[] = $allWords[$i % $totalWords];
                }
                $selected[0] = ucfirst($selected[0]);
                return implode(' ', $selected) . '.';

            case 'sentences':
                $result = [];
                for ($i = 0; $i < $count; $i++) {
                    $result[] = $sentences[$i % $totalSents];
                }
                return implode(' ', $result);

            case 'paragraphs':
            default:
                $paras = [];
                for ($p = 0; $p < $count; $p++) {
                    $sentCount = rand(4, 7);
                    $para      = [];
                    for ($s = 0; $s < $sentCount; $s++) {
                        $para[] = $sentences[($p * 4 + $s) % $totalSents];
                    }
                    $paras[] = implode(' ', $para);
                }
                return implode("\n\n", $paras);
        }
    }
}
