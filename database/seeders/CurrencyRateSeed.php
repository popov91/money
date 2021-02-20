<?php

namespace Database\Seeders;

use App\Services\CbrApiService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencyRateSeed extends Seeder
{
    private $api;

    public function __construct(CbrApiService $api)
    {
        $this->api = $api;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency_rates')->insert($this->api->getCurrencyRateFromApi());
    }
}
