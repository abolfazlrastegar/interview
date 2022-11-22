<?php

namespace app\Repository\v1;

use App\Repostory\Db\Db;

class Order implements Db
{
    private static $model;

    public function __construct(\App\Models\Order $order)
    {
        self::$model = $order;
    }

    public static function insert($data)
    {
        $order = self::$model::create()
    }

    public static function show($data)
    {
        // TODO: Implement show() method.
    }
}
