<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OrderCollection;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        //فرستادن همراه با pagination برای سرعت بیشتر در رکورد های بالا
        return $this->success(new OrderCollection(Order::query()->paginate(10)));
    }
}
