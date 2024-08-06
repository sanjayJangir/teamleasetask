<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function fetchSync(Request $request)
    {
        try {
            $weatherResponse = Http::get('https://api.open-meteo.com/v1/forecast?latitude=35&longitude=139&hourly=temperature_2m');
            $quoteResponse = Http::get('https://api.quotable.io/random');

            if ($weatherResponse->successful() && $quoteResponse->successful()) {
                $weatherData = $weatherResponse->json();
                $quoteData = $quoteResponse->json();

                return view('results', ['weather' => $weatherData, 'quote' => $quoteData]);
            } else {
                return response()->json(['error' => 'Failed to fetch data'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
