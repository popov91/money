<?php

namespace App\Http\Controllers;

use App\Models\Valute;
use App\Services\CalculateResultService;
use App\Services\CbrApiService;
use App\Services\ConvertorService;
use Illuminate\Http\Request;

class CalculateController extends Controller
{
    private $api;
    private $convertor;
    private $resultService;

    public function __construct(
        CbrApiService $api,
        ConvertorService $convertor,
        CalculateResultService $resultService
    )
    {
        $this->api = $api;
        $this->convertor = $convertor;
        $this->resultService = $resultService;
    }

    public function index()
    {
        return view('calculate.index', [
            'valutes' => Valute::getListForUserSelect(),
        ]);
    }

    public function sendToCalculate(Request $request)
    {
        return response()->json($this->convertor->calculate($request->all()));
    }

    public function saveResult(Request $request)
    {
        return response()->json($this->resultService->save($request->all()));
    }
}
