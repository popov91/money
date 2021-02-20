<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValuteForm extends FormRequest
{
    public function rules()
    {
        return [
            'valute_in' => 'required|exists:valutes,char_code',
            'value_in' => 'required|numeric|min:0.01|max:9999999',
            'valute_out.*' => 'required|exists:valutes,char_code',
            'comment' => 'nullable|string|max:255',
        ];
    }
}
