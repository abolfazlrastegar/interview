<?php

namespace App\Repository\v1;

use App\Models\Follower;
use App\Models\Order;

class RepositoryFollower implements \App\Repository\Db
{

    public static function insert($data)
    {
        $follower = new Follower();
        $follower->user_id = \Auth::id();
        $follower->order_id = $data->get('order_id');

        return $follower->save();
    }

    public static function show($data = null)
    {
        $follower_user = Follower::query()->where('user_id', '=', \Auth::id())->get();

        return $follower_user;
    }

    public static function followerCount($order_id)
    {
        $follower_count = Follower::query()->where('order_id', '=', $order_id)->count('id');

        return $follower_count;
    }
}
