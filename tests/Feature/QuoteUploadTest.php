<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class QuoteUploadTest extends TestCase
{
    use RefreshDatabase;
    public function test_quote_submission_with_file()
    {
        Storage::fake('local');

        $file = UploadedFile::fake()->create('image.jpg', 100);

        $response = $this->postJson('/quote', [
            'company_name' => 'Test Co',
            'name' => 'Tester',
            'email' => 'test@example.com',
            'service_type' => 'Sandalye Döşeme & Yenileme',
            'message' => 'Hello',
            'file' => $file
        ]);

        $response->assertStatus(200);
        
        // Verify quote was saved to database
        $this->assertDatabaseHas('quotes', [
            'company_name' => 'Test Co',
            'name' => 'Tester',
            'email' => 'test@example.com',
            'service_type' => 'Sandalye Döşeme & Yenileme',
            'message' => 'Hello',
        ]);
        
        // Verify file was stored
        $quote = \App\Models\Quote::where('email', 'test@example.com')->first();
        $this->assertNotNull($quote->file_path);
        Storage::disk('local')->assertExists($quote->file_path);
    }
}
