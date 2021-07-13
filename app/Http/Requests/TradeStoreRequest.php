<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TradeStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            '1.xp' => 'required',
            '2.xp' => 'required',
            '1.pokemons' => 'required',
            '2.pokemons' => 'required'
        ];
    }
}
