<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\PokeTradeRepository as PokeTradeRepositoryContract;
use App\Models\Contracts\PokeTrade;

class PokeTradeRepository implements PokeTradeRepositoryContract
{
    private $pokeTradeModel;

    public function __construct(PokeTrade $pokeTradeModel)
    {
        $this->pokeTradeModel = $pokeTradeModel;
    }
    
    public function create(int $tradeId, int $playerId, int $pokeId, string $pokeName, int $pokeXp)
    {
        $pokeTrade = clone $this->pokeTradeModel;

        $pokeTrade->trade_id = $tradeId;
        $pokeTrade->player_id = $playerId;
        $pokeTrade->poke_id = $pokeId;
        $pokeTrade->name = $pokeName;
        $pokeTrade->xp = $pokeXp;
        $pokeTrade->save();

        return  $pokeTrade;
    }
}