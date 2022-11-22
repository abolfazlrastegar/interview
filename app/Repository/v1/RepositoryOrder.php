<?php

namespace App\Repository\v1;

use App\Models\Follower;
use App\Models\Order;
use App\Repository\Db;

class RepositoryOrder implements Db
{
    public static function insert($data)
    {
        $order = new Order();
        $order->user_id = \Auth::id();
        $order->quantity = $data->get('quantity');
        $order->username_instagram = $data->get('username_instagram');

        return $order->save();
    }

    public static function show($data = null)
    {
        $orders = Order::query()->where('user_id', '<>', \Auth::id())->paginate(25);

        return $orders;
    }

    public static function getOneOrder($id)
    {
        $order = Order::query()->where('id', '=', $id)->first();

        return $order;
    }
}
