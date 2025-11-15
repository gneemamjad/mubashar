<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExchangeRateUpdater
{
    protected $url = 'https://sp-today.com/app_api/cur_damascus.json';

    public function update()
    {
        Log::info('Call Exchange Rate');
        try {
            $response = Http::withoutVerifying()->get($this->url);

            if (!$response->ok()) {
                Log::error('Failed to fetch exchange rate', ['url' => $this->url]);
                return false;
            }

            $data = $response->json();

            $searchName = 'USD';

            $results = array_filter($data, function ($item) use ($searchName) {
                return $item['name'] === $searchName;
            });

            $result = reset($results);

            if (!$result) {
                Log::error('USD bid not found in response');
                return false;
            }
            
            if (!isset($result['bid'])) {
                Log::error('USD bid not found in response');
                return false;
            }
            
            $rate = floatval(str_replace(',', '', $result['bid']));
            DB::table('exchange_rates')->updateOrInsert(
                [
                    'base_currency_id' => 2,
                    'target_currency_id' => 1
                ],
                [
                    'rate' => $rate,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now()
                ]
            );
            DB::table('exchange_rates')->updateOrInsert(
                [
                    'base_currency_id' => 1,
                    'target_currency_id' => 2
                ],
                [
                    'rate' => 1/$rate,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now()
                ]
            );

            
            $searchName = 'AED';

            $results = array_filter($data, function ($item) use ($searchName) {
                return $item['name'] === $searchName;
            });

            $result = reset($results);

            if (!$result) {
                Log::error('AED bid not found in response');
                return false;
            }
            
            if (!isset($result['bid'])) {
                Log::error('AED bid not found in response');
                return false;
            }
            
            $rate = floatval(str_replace(',', '', $result['bid']));
            DB::table('exchange_rates')->updateOrInsert(
                [
                    'base_currency_id' => 3,
                    'target_currency_id' => 1
                ],
                [
                    'rate' => $rate,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now()
                ]
            );
            DB::table('exchange_rates')->updateOrInsert(
                [
                    'base_currency_id' => 1,
                    'target_currency_id' => 3
                ],
                [
                    'rate' => 1/$rate,
                    'updated_at' => Carbon::now(),
                    'created_at' => Carbon::now()
                ]
            );


            return true;

        } catch (\Exception $e) {
            Log::error('ExchangeRateUpdater error: ' . $e->getMessage());
            return false;
        }
    }
}
