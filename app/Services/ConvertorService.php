<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ConvertorService
{
    private $api;

    public function __construct(CbrApiService $api)
    {
        $this->api = $api;
    }

    public function calculate(array $data)
    {
        $targetValute = $data['targetValute'];
        $targetMoneyAmount = $data['targetMoneyAmount'];
        $selectValutes = $data['selectElements'];
        $date = Carbon::parse($data['date'])->format('Y-m-d');
        $this->createRateRecordsIfNotExist($date);
        $rates = $this->getExchangeRate($date);
        $targetValueRate = $rates->filter(function($item) use ($targetValute) {
            return $item->char_code == $targetValute;
        })->first();

        $result = [];
        foreach ($selectValutes as $selectValute) {
            $selectValuteRate = $rates->filter(function($item) use ($selectValute) {
                return $item->char_code == $selectValute;
            })->first();
            $result[] = ($targetMoneyAmount * $targetValueRate->value * $selectValuteRate->nominal) / $selectValuteRate->value;
        }

        return $result;
    }

    private function getExchangeRate($date)
    {
        $sql = "
            SELECT date_req, v.num_code, nominal, value, v.char_code
            FROM currency_rates
                     JOIN valutes v on currency_rates.num_code = v.num_code
            WHERE date_req LIKE :date
        ";

        $params = [
            'date' => $date,
        ];

        return collect(DB::select($sql, $params));
    }

    private function createRateRecordsIfNotExist($date)
    {
        $sql = "
        SELECT COUNT(*) as result
        FROM currency_rates
        WHERE DATE(date_req) = :date
        ";
        $params = [
            'date' => $date,
        ];
        $data = DB::select($sql, $params);
        if ($data[0]->result !== 0) {
            return false;
        }

        return DB::table('currency_rates')->insert($this->api->getCurrencyRateFromApi($date));
    }
}
