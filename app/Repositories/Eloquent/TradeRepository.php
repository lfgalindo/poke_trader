<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\TradeRepository as TradeRepositoryContract;
use App\Models\Contracts\Trade;

class TradeRepository implements TradeRepositoryContract
{
    private $tradeModel;

    public function __construct(Trade $tradeModel)
    {
        $this->tradeModel = $tradeModel;
    }
    
    public function create(int $diff, bool $fair)
    {
        $trade = clone $this->tradeModel;

        $trade->diff = $diff;
        $trade->setFair($fair);
        $trade->save();

        return  $trade;
    }

    public function listWithPokes()
    {
        return $this->tradeModel->with('pokes')->get();
    }
}