<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public static function index()
    {
        $products = Product::all();

        return $products;
    }

    public static function getByStore(string $store_id)
    {
        $products = Product::where('loja_id', $store_id)->get();

        return $products;
    }

    public static function store(array $data)
    {
        $product = Product::create($data);

        return $product;
    }

    public static function update(array $data, Product $product)
    {
        $product->update($data);

        return $product;
    }

    public static function destroy(Product $product)
    {
        $product->delete();

        return $product;
    }

    public static function changeActive(Product $product)
    {
        $product->update([
            'ativo' => !$product->ativo,
        ]);

        return $product;
    }

    public static function getDisabled() {
        $products = Product::where('ativo', false)->get();

        return $products;
    }

}
