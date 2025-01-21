<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());
        if ($request->store) {
            $products = ProductService::getByStore($request->store);
        } else {
            $products = ProductService::index();
        }

        return response(['products' => $products], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            $imageUrl = null;
            $publicId = null;
            if ($request->file('image')) {
                $uploadResult = cloudinary()->upload($request->file('image')->getRealPath(), [
                    'folder' => 'product_images',
                ]);

                $imageUrl = $uploadResult->getSecurePath();
                $publicId = $uploadResult->getPublicId();
            }

            $product = ProductService::store([
                'nome' => $request->name,
                'descricao' => $request->description,
                'imagem' => $imageUrl,
                'public_id' => $publicId,
                'preco' => $request->price,
                'loja_id' => $request->store_id
            ]);

            return response(['product' => $product], 201);
        } catch (Exception $e) {
            return response(['message' => $e], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response(['product' => $product], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        try {
            $imageUrl = null;
            $publicId = null;
            if ($request->file('image')) {
                if ($product->image && $product->public_id) {
                    cloudinary()->uploadApi()->destroy($product->public_id);
                }

                $uploadResult = cloudinary()->upload($request->file('image')->getRealPath(), [
                    'folder' => 'product_images',
                ]);

                $imageUrl = $uploadResult->getSecurePath();
                $publicId = $uploadResult->getPublicId();
            }

            $productUpdated = ProductService::update([
                'nome' => $request->name,
                'descricao' => $request->description,
                'imagem' => $imageUrl ?? $product->image,
                'public_id' => $publicId ?? $product->public_id,
                'preco' => $request->price
            ], $product);

            return response(['product' => $productUpdated], 200);
        } catch (Exception $e) {
            return response(['message' => $e], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            if ($product->image && $product->public_id) {
                cloudinary()->uploadApi()->destroy($product->public_id);
            }

            $productDeleted = ProductService::destroy($product);

            return response(['product' => $productDeleted], 200);
        } catch (Exception $e) {
            return response(['message' => $e], 500);
        }
    }

    public function changeActive(Product $product)
    {
        $productActived = ProductService::changeActive($product);

        return response(['product' => $productActived], 200);
    }
}
