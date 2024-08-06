<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Laravel\Prompts\Prompt;

class ApiController extends Controller
{
    public function fetchSync(Request $request)
    {
        try {
            $weatherResponse = Http::get('https://api.open-meteo.com/v1/forecast?latitude=35&longitude=139&hourly=temperature_2m');
            $currentpriceResponse = Http::get('https://api.coindesk.com/v1/bpi/currentprice.json');


            if ($weatherResponse->successful() && $currentpriceResponse->successful()) {
                $weatherData = $weatherResponse->json();
                $currentpriceData = $currentpriceResponse->json();

                return view('welcome', ['weather' => $weatherData, 'currentprice' => $currentpriceData]);
            } else {
                return response()->json(['error' => 'Failed to fetch data'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchAsync(Request $request)
    {
        $client = new Client();

        $weatherPromise = $client->getAsync('https://api.open-meteo.com/v1/forecast?latitude=35&longitude=139&hourly=temperature_2m');
        $currentpriceResponse = $client->getAsync('https://api.coindesk.com/v1/bpi/currentprice.json');


        try {
            $responses = Promise\Utils::settle([$weatherPromise, $currentpriceResponse])->wait();

            if ($responses[0]['state'] === 'fulfilled' && $responses[1]['state'] === 'fulfilled') {
                $weatherData = json_decode($responses[0]['value']->getBody()->getContents(), true);
                $currentpriceData = json_decode($responses[1]['value']->getBody()->getContents(), true);

                return view('welcome', ['weather' => $weatherData, 'currentprice' => $currentpriceData]);
            } else {
                return response()->json(['error' => 'Failed to fetch data'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
