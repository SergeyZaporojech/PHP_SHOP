<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"Product"},
     *     path="/api/product",
     *     @OA\Response(response="200", description="Get All Products.")
     * )
     */
    public function index()
    {
        $products = Product::with('product_images')->get();

        return response()->json($products, 200, [
            'Content-Type' => 'application/json;charset=UTF-8',
            'Charset' => 'utf-8'
        ], JSON_UNESCAPED_UNICODE);
    }

    /**
     * @OA\Post(
     *     tags={"Product"},
     *     path="/api/product",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={},
     *
     *                 @OA\Property(
     *                     property="category_id",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="number"
     *                 ),
     *                 @OA\Property(
     *                     property="decsription",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Add Product.")
     * )
     */
    public function create(Request $request)
    {
        $input = $request->all(); //Отримав значення усіх полів, які прийшли від клієнта
        $message = array(
            'category_id.required' => 'Вкажіть категорію товара',
            'name.required' => 'Вкажіть назву товара',
            'price' => 'Вкажіть ціну товара',
            'decsription.required' => 'Вкажіть опис товара',
        );
        $validation = Validator::make($input, [
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'decsription' => 'required',
        ], $message);

        if ($validation->fails()) {
            return response()->json($validation->errors(), 400,
                ["Content-Type" => "application/json;charset=UTF-8", "Charset" => "utf-8"], JSON_UNESCAPED_UNICODE);
        }

        $product = Product::create($input);
        return response()->json($product, 201,
            ["Content-Type" => "application/json;charset=UTF-8", "Charset" => "utf-8"], JSON_UNESCAPED_UNICODE);
    }



}
