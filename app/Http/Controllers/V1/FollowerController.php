<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Repository\CoinInterface;
use App\Repository\FollowerInterface;
use App\Repository\OrderInterface;
use App\Repository\v1\RepositoryCoin;
use App\Repository\v1\RepositoryFollower;
use App\Repository\v1\RepositoryOrder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FollowerController extends Controller
{
    private FollowerInterface $repositoryFollower;
    private OrderInterface $repositoryOrder;
    private CoinInterface $repositoryCoin;

    public function __construct(FollowerInterface $repositoryFollower,
                                OrderInterface $repositoryOrder, CoinInterface $repositoryCoin)
    {
        $this->repositoryFollower = $repositoryFollower;
        $this->repositoryOrder = $repositoryOrder;
        $this->repositoryCoin = $repositoryCoin;
    }

    public function insert (Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'order_id' => 'required|numeric'
        ]);

        if ($validation->fails())
            return Response::validation(message: $validation->errors(), code: 401);

        $order_id = $request->get('order_id');
        $order = $this->repositoryOrder::getOneOrder($order_id);
        if ($order->quantity > $this->repositoryFollower::followerCount($order_id))
        {
//            if (max(0, $this->repositoryCoin::sumCoinUser($order->user_id)) > config('coin.coin_to_follower'))
//            {
                try {
                    \DB::beginTransaction();

                    $this->repositoryFollower::insert($request);

                    /**
                     * Giving users two coins for following
                     */
                    $this->repositoryCoin::insert(['user_id' => auth()->id(), 'quantity' => config('coin.coin_to_follow'), 'type' => 'follow']);

                    /**
                     * Getting four coins from the user for the follower
                     */
                    $this->repositoryCoin::insert(['user_id' => $order->user_id, 'quantity' => '-' . config('coin.coin_to_follower'), 'type' => 'follower']);

                    \DB::commit();
                    return Response::success(message: 'عملیات مورد نظر شما انجام شد');

                }catch (\Exception $e){
                    \DB::rollBack();
                    return Response::error(message: 'مشگلی در انجام عملیات مورد نظر شما پیش آمد. لطفا دوباره تلاش کنید', code: 401);
                }
//            }
//            return Response::error(message: 'امکان فالو کرد این کاربر نیست', code: 401);
        }

        return Response::error(message: 'لطفا صفحه خود را بروز رسانی کنید', code: 401);

    }
}
