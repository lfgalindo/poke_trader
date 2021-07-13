<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Contracts\{
    Trade as TradeContract,
    PokeTrade as PokeTradeContract
};
use App\Models\{Trade, PokeTrade};

use App\Repositories\Contracts\{
    TradeRepository as TradeRepositoryContract,
    PokeTradeRepository as PokeTradeRepositoryContract
};
use App\Repositories\Eloquent\{
    TradeRepository,
    PokeTradeRepository
};

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(TradeRepositoryContract::class, TradeRepository::class);
        $this->app->bind(PokeTradeRepositoryContract::class, PokeTradeRepository::class);

        $this->app->bind(TradeContract::class, Trade::class);
        $this->app->bind(PokeTradeContract::class, PokeTrade::class);
    }
}
