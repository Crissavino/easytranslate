<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PagesController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }

    public function convertCurrency(Request $request)
    {
        $amount = $request->amount;
        $source_currency = $request->source_currency;
        $target_currency = $request->target_currency;
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
            $exchangeSource = $exchangeRates['rates'][$source_currency];
            $exchangeTarget = $exchangeRates['rates'][$target_currency];
            $exchangeRate = $exchangeTarget / $exchangeSource;
//            $exchangeRate = floatval(number_format($exchangeRate,2));

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

            return view('pages.home', [
                'success' => false,
                'message' => 'Error getting exchange rates'
            ]);
        }

    }

}
