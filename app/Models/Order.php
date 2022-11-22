<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";


    public function Followers ()
    {
        return $this->hasMany(Follower::class, 'order_id', 'id',);
    }
}
