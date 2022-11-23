<?php

namespace App\Repository\v1;

use App\Models\Coin;
use App\Repository\CoinInterface;

class RepositoryCoin implements CoinInterface
{

    public static function insert($data)
    {
        $coin = new Coin();
        $coin->user_id = $data['user_id'];
        $coin->quantity = $data['quantity'];
        $coin->type = $data['type'];

        return $coin->save();
    }

    public static function show($data = null)
    {
        // TODO: Implement show() method.
    }

    public static function sumCoinUser($user_id)
    {
        $sum_coin = Coin::query()->where('user_id', '=', $user_id)->sum('quantity');

        return $sum_coin;
    }
}
