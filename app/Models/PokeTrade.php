<?php

namespace App\Models;

use App\Models\Contracts\PokeTrade as PokeTradeContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PokeTrade extends Model implements PokeTradeContract
{
    use HasFactory;

    public function trade()
    {
        return $this->belongsTo('App\Models\Trade');
    }
}
