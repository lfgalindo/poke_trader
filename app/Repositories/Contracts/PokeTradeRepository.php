<?php

namespace App\Repositories\Contracts;

interface PokeTradeRepository
{
    public function create(int $tradeId, int $playerId, int $pokeId, string $pokeName, int $pokeXp);
}