<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $validated_data = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|integer',
            'image' => 'required|image',

        ]);
        if ($validated_data->fails())
            return $this->error(Status::VALIDATION_FAILED, $validated_data->errors());


        DB::beginTransaction();
        try {
            $imageName = date('Ymdhis') . rand(100, 999) . '.' . $request->file('image')->extension();
            $product = Product::query()->Create([
                'title' => $request->title,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $imageName,
            ]);

            Storage::putFileAs('images', $request->file('image'), $imageName);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->error(Status::Unexpected_Problem,$exception->getMessage());
        }

        return $this->success('محصول ذخیره شد');

    }
}
