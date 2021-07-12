<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TraderController extends Controller
{
    public function create()
    {
        $maxPokeTrade = 6;
        $fairTradeDiff = 50;

        return view('trader.create', [
            'maxPokeTrade' => $maxPokeTrade,
            'fairTradeDiff' => $fairTradeDiff
        ]);
    }
}
