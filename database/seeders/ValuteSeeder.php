<?php

namespace Database\Seeders;

use App\Services\CbrApiService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ValuteSeeder extends Seeder
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
        DB::table('valutes')->insert($this->api->getValuteFromApi());
    }
}
