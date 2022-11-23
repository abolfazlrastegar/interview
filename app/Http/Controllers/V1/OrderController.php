<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Repository\FollowerInterface;
use App\Repository\OrderInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    private OrderInterface $repositoryOrder;
    private FollowerInterface $repositoryFollower;

    public function __construct(OrderInterface $RepositoryOrder, FollowerInterface $repositoryFollower)
    {
        $this->repositoryOrder = $RepositoryOrder;
        $this->repositoryFollower = $repositoryFollower;
    }

    /**
     * @param Request $request
     * @return mixed
     * save order user for getting follower
     */
    public function insert(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'quantity' => 'required|numeric',
            'username_instagram' => 'required|string'
        ]);

        if ($validation->fails())
            return Response::validation(message: $validation->errors(), code: 401);
        $order = $this->repositoryOrder::insert($request);
        if ($order)
            return Response::success(message: 'سفارش مورد نظر شما ثبت شد');

        return Response::error(message: ' مشکی در سفارش مورد نظر شما پیش آمد. لطفا دوباره تلاش کنید');
    }

    /**
     * @return mixed
     * Show all orders except user followed
     */
    public function show()
    {
        $orders = $this->repositoryOrder::show();

        foreach ($this->repositoryFollower::show() as $follower){
            foreach ($orders as $key => $order) {
                if ($order->id == $follower->order_id){
                    unset($orders[$key]);
                }
            }
        }

        return Response::success(data: $orders);
    }
}
