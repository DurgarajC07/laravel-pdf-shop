<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Barryvdh\DomPDF\Facade as PDF;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create a sample PDF file
        $content = "Sample PDF Content for our product";
        $tempFile = tempnam(sys_get_temp_dir(), 'pdf_');
        file_put_contents($tempFile, $content);
        
        // Store the file
        $path = Storage::putFile('products', new File($tempFile));
        
        // Create product record
        Product::create([
            'name' => 'Sample PDF Guide',
            'description' => 'This is a comprehensive guide on a very interesting topic. The PDF contains valuable information that will help you succeed.',
            'price' => 19.99,
            'file_path' => $path,
        ]);
        
        // Clean up temp file
        unlink($tempFile);
    }
}