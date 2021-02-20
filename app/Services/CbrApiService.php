<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Mockery\Exception;
use SimpleXMLElement;

class CbrApiService
{
    const URL = 'http://www.cbr.ru/scripts/XML_daily.asp';
    const HTTP_STATUS_SUCCESS = 200;

    public function getXml(string $dateReq = null)
    {
        $date = Carbon::parse($dateReq)->format('d/m/Y');
        $response = Http::withHeaders(
            ['Content-Type' => 'application/json',]
        )->get(self::URL . '?date_req=' . $date);

        if ($response->status() !== self::HTTP_STATUS_SUCCESS) {
            throw new Exception('http error' . $response->status());
        }

        return new SimpleXMLElement($response->body()) ;
    }

    public function getValuteFromApi(): array
    {
        $data = [];
        foreach ($this->getXml() as $item) {
            $data[] = [
                'num_code' => $item->{'NumCode'},
                'char_code' => $item->{'CharCode'},
                'name' => $item->{'Name'}
            ];
        }

        return $data;
    }

    public function getCurrencyRateFromApi(string $dateReq = null)
    {
        $data = [];
        foreach ($this->getXml($dateReq) as $item) {
            $data[] = [
                'num_code' => $item->{'NumCode'},
                'date_req' => Carbon::parse($dateReq)->format('Y-m-d'),
                'nominal' => $item->{'Nominal'},
                'value' => str_replace(',','.', $item->{'Value'}),
            ];
        }

        return $data;
    }
}
