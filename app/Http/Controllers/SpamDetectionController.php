<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SpamDetectionController extends Controller
{
    public function checkSpam(Request $request)
    {
        $emailContent = $request->input('email_content');
        
        // Call the Flask API
        $response = Http::post('http://localhost:5000/predict', [
            'email_content' => $emailContent,
        ]);

        return $response->json();
    }
}
