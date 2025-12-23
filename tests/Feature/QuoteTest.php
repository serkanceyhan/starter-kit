<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    public function test_mail_rendering()
    {
        $validated = [
            'company_name' => 'Test Company',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'service_type' => 'Tamirat',
            'message' => 'This is a test message.',
        ];

        $mail = new \App\Mail\QuoteRequestMail($validated, null);
        
        try {
            $content = $mail->render();
            $this->assertStringContainsString('Test Company', $content);
        } catch (\Exception $e) {
            $this->fail('Mail rendering failed: ' . $e->getMessage());
        }
    }

    public function test_mail_rendering_with_null_details()
    {
        // Simulate missing data
        $validated = []; 

        $mail = new \App\Mail\QuoteRequestMail($validated, null);
        
        try {
            $content = $mail->render();
            // Should verify that the template fills in the defaults or doesn't crash
            $this->assertStringContainsString('Yeni Teklif Talebi', $content);
        } catch (\Exception $e) {
            $this->fail('Mail rendering failed with null/empty details: ' . $e->getMessage());
        }
    }
}
