<?php

namespace App\Models;

use App\Models\Contracts\Trade as TradeContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model implements TradeContract
{
    use HasFactory;

    public function setFair(bool $isFair)
    {
        $this->fair = $isFair ? 'JUSTA' : 'INJUSTA';
    }

    public function pokes()
    {
        return $this->hasMany('App\Models\PokeTrade');
    }
}
