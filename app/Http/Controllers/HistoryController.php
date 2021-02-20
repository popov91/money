<?php

namespace App\Http\Controllers;

use App\Models\Valute;
use App\Services\CalculateResultService;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    private $resultService;

    public function __construct(CalculateResultService $resultService)
    {
        $this->resultService = $resultService;
    }

    public function index()
    {
        return view('history.index', [
            'valuteList' => Valute::select('char_code', 'name')->get(),
        ]);
    }

    public function getResult(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|uuid'
        ]);

        return $this->resultService->findResultById($request->post('id'));
    }

    public function updateComment(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|uuid',
            'comment' => 'required|string|max:255'
        ]);

        return $this->resultService->updateComment($request->all());
    }
}
