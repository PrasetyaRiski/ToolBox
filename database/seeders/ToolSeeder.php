<?php

namespace Database\Seeders;

use App\Models\Tool;
use App\Models\ToolCategory;
use Illuminate\Database\Seeder;

class ToolSeeder extends Seeder
{
    public function run(): void
    {
        $tools = [
            // Text Tools (4 functional tools)
            [
                'category' => 'text-tools',
                'tools' => [
                    [
                        'name' => 'Konverter Huruf',
                        'slug' => 'case-converter',
                        'description' => 'Konversi teks ke huruf besar, kecil, judul & kalimat',
                        'is_featured' => true,
                    ],
                    [
                        'name' => 'Generator Lorem Ipsum',
                        'slug' => 'lorem-ipsum-generator',
                        'description' => 'Generate teks placeholder dengan paragraf yang diinginkan',
                        'is_featured' => true,
                    ],
                    [
                        'name' => 'Penghitung Huruf',
                        'slug' => 'letter-counter',
                        'description' => 'Hitung huruf, kata dan kalimat dalam teks',
                    ],
                    [
                        'name' => 'Penghapus Spasi',
                        'slug' => 'whitespace-remover',
                        'description' => 'Hapus spasi berlebih dan baris kosong',
                    ],
                ],
            ],
            // Coding Tools (5 functional tools)
            [
                'category' => 'coding-tools',
                'tools' => [
                    [
                        'name' => 'Format JSON',
                        'slug' => 'json-formatter',
                        'description' => 'Format dan percantik kode JSON',
                        'is_featured' => true,
                    ],
                    [
                        'name' => 'Encoder/Decoder Base64',
                        'slug' => 'base64-encoder-decoder',
                        'description' => 'Encode atau decode string Base64',
                    ],
                    [
                        'name' => 'Encoder/Decoder URL',
                        'slug' => 'url-encoder-decoder',
                        'description' => 'Encode atau decode URL',
                    ],
                    [
                        'name' => 'Minify HTML',
                        'slug' => 'html-minifier',
                        'description' => 'Perkecil ukuran kode HTML',
                    ],
                    [
                        'name' => 'Minify CSS',
                        'slug' => 'css-minifier',
                        'description' => 'Perkecil ukuran kode CSS',
                    ],
                ],
            ],
            // Color Tools (3 functional tools)
            [
                'category' => 'color-tools',
                'tools' => [
                    [
                        'name' => 'Konverter HEX ke RGBA',
                        'slug' => 'hex-to-rgba-converter',
                        'description' => 'Konversi kode warna HEX ke RGBA',
                        'is_featured' => true,
                    ],
                    [
                        'name' => 'Konverter RGBA ke HEX',
                        'slug' => 'rgba-to-hex-converter',
                        'description' => 'Konversi kode warna RGBA ke HEX',
                    ],
                    [
                        'name' => 'Generator Gradasi Warna',
                        'slug' => 'color-shades-generator',
                        'description' => 'Generate gradasi terang dan gelap dari warna apapun',
                    ],
                ],
            ],
            // Miscellaneous Tools (3 functional tools)
            [
                'category' => 'miscellaneous-tools',
                'tools' => [
                    [
                        'name' => 'Generator QR Code',
                        'slug' => 'qr-code-generator',
                        'description' => 'Generate QR code untuk link atau teks',
                        'is_featured' => true,
                    ],
                    [
                        'name' => 'Generator Password',
                        'slug' => 'password-generator',
                        'description' => 'Generate password acak yang kuat',
                    ],
                    [
                        'name' => 'Pengacak List',
                        'slug' => 'list-randomizer',
                        'description' => 'Acak dan kocok daftar Anda',
                    ],
                ],
            ],
        ];

        foreach ($tools as $categoryData) {
            $category = ToolCategory::where('slug', $categoryData['category'])->first();

            if ($category) {
                foreach ($categoryData['tools'] as $index => $toolData) {
                    Tool::create([
                        'category_id' => $category->id,
                        'name' => $toolData['name'],
                        'slug' => $toolData['slug'],
                        'description' => $toolData['description'],
                        'is_featured' => $toolData['is_featured'] ?? false,
                        'is_new' => $toolData['is_new'] ?? false,
                        'order' => $index + 1,
                    ]);
                }
            }
        }
    }
}
