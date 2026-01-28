<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Contact form submission received', $request->all());

        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);

            $lead = Lead::create($validated);

            Log::info('Lead created successfully', ['id' => $lead->id]);

            return response()->json([
                'message' => 'Message sent successfully',
                'data' => $lead
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error processing contact form', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Internal Server Error', 'error' => $e->getMessage()], 500);
        }
    }
}
