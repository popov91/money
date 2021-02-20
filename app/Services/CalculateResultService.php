<?php

namespace App\Services;

use App\Models\CalculateResult;
use Carbon\Carbon;

class CalculateResultService
{
    public function save($data)
    {
        $date = Carbon::parse($data['date'])->format('Y-m-d');
        $result = CalculateResult::create([
            'date' => $date,
            'comment' => $data['comment'],
            'data' => json_encode($data['data'])
        ]);

        return $result->id;
    }

    public function findResultById($id)
    {
        return CalculateResult::find($id);
    }

    public function updateComment($data)
    {
        $model = CalculateResult::find($data['id']);
        $model->comment = $data['comment'];

        return $model->save();
    }
}
