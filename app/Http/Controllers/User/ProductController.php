<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return $this->success(new ProductCollection(Product::query()->paginate(10)));
    }

    public function show(Product $product)
    {
        return $this->success(ProductResource::make($product));
    }
}
