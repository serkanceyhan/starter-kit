<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Jobs\SendQuoteEmail;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'service_type' => 'required|string',
            'message' => 'nullable|string',
            'file' => 'nullable|file|max:5120|mimes:jpeg,png,jpg,pdf', // Max 5MB
        ]);

        try {
            // 1. Save quote to database
            $quote = Quote::create([
                'company_name' => $validated['company_name'],
                'name' => $validated['name'],
                'email' => $validated['email'],
                'service_type' => $validated['service_type'],
                'message' => $validated['message'] ?? null,
            ]);

            // 2. Attach file using Spatie Media Library (if present)
            if ($request->hasFile('file')) {
                $quote->addMedia($request->file('file'))
                    ->toMediaCollection('damage_photos');
            }

            // 3. Notify all super admins
            $admins = \App\Models\User::role('super_admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\NewQuoteNotification($quote));
            }

            // 4. Dispatch email job to queue (asynchronous)
            SendQuoteEmail::dispatch($quote);
            
            return response()->json([
                'message' => 'Teklif talebiniz başarıyla alındı.'
            ], 200);
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Quote submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'message' => 'Bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }
}
