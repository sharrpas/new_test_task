<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Product $product)
    {
        $user = auth()->user();
// شناختن یوزر لاگین شده و ثبت سفارش
        $order = $user->orders()->create([
            'order_id' => date('Ymdhis') . rand(1000, 9999),
            'status' => 'recorded',
            'product_id' => $product->id,
        ]);

        return $this->success(OrderResource::make($order));

    }
}
