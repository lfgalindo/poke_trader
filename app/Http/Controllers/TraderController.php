<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\TradeStoreRequest;
use App\Repositories\Contracts\{TradeRepository, PokeTradeRepository};

class TraderController extends Controller
{
    private $fairTradeDiff = 50;
    private $maxPokeTrade = 6;
    
    private $tradeRepository;
    private $pokeTradeRepository;
    
    public function __construct (
        TradeRepository $tradeRepository,
        PokeTradeRepository $pokeTradeRepository
    ) {
        $this->tradeRepository = $tradeRepository;
        $this->pokeTradeRepository = $pokeTradeRepository;
    }

    public function create()
    {
        return view('trader.create', [
            'maxPokeTrade' => $this->maxPokeTrade,
            'fairTradeDiff' => $this->fairTradeDiff
        ]);
    }

    public function store(TradeStoreRequest $request)
    {
        try {
            $players = [
                '1' => $request->input('1'),
                '2' => $request->input('2')
            ];

            $diff = abs($players[1]['xp'] - $players[2]['xp']);
            $fair = $diff <= $this->fairTradeDiff;

            DB::beginTransaction();

            $trade = $this->tradeRepository->create($diff, $fair);

            foreach ($players as $player_id => $player) {
                foreach ($player['pokemons'] as $pokemon) {
                    $this->pokeTradeRepository->create(
                        $trade->id,
                        $player_id,
                        $pokemon['id'],
                        $pokemon['name'],
                        $pokemon['xp']
                    );
                }
            }

            DB::commit();

            return response()->json([
                'resource' => $trade
            ], 201);
        } catch (Exception $exception) {
            DB::rollback();

            return response()->json([
                'message' => $exception->getMessage()
            ], $exception->getCode());
        }
    }

    public function history()
    {
        $trades = $this->tradeRepository->listWithPokes();

        return view('trader.index', [
            'trades' => $trades
        ]);
    }
}
