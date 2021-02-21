<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConvertCurrencyRequest;
use App\Models\Exchange;
use Illuminate\Support\Facades\Log;

class PagesController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }

    public function convertCurrency(ConvertCurrencyRequest $request)
    {

        $validated = $request->validated();
        $amount = $validated['amount'];
        $source_currency = $validated['source_currency'];
        $target_currency = $validated['target_currency'];
        $endpoint = 'latest';
        $access_key = env('FIXER_ACCESS_KEY');

        try {
            // Initialize CURL:
            $ch = curl_init('http://data.fixer.io/api/'.$endpoint.'?access_key='.$access_key);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Store the data:
            $json = curl_exec($ch);
            curl_close($ch);

            // Decode JSON response:
            $exchangeRates = json_decode($json, true);

            // Get exchange rates for selected currencies
            $exchangeSource = $exchangeRates['rates'][$source_currency];
            $exchangeTarget = $exchangeRates['rates'][$target_currency];

            $exchangeRate = $exchangeTarget / $exchangeSource;

            $convertedAmount = $exchangeRate * $amount;

            Exchange::create([
                'amount' => $amount,
                'source_currency' => $source_currency,
                'target_currency' => $target_currency,
                'exchangeRate' => $exchangeRate,
                'convertedAmount' => $convertedAmount,
            ]);

            return view('pages.home', [
                'success' => true,
                'amount' => $amount,
                'source_currency' => $source_currency,
                'target_currency' => $target_currency,
                'exchangeRate' => $exchangeRate,
                'convertedAmount' => $convertedAmount,
            ]);

        } catch (\Exception $e) {
            Log::info('Error getting exchange rates');
            Log::info($e->getMessage());

            return response()->view('pages.home', [
                'success' => false,
                'message' => 'Error getting exchange rates'
            ])->setStatusCode(201);

        }

    }

}
