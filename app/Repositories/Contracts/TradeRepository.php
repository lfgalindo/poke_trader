<?php

namespace App\Repositories\Contracts;

interface TradeRepository
{
    public function create(int $diff, bool $fair);
    public function listWithPokes();
}