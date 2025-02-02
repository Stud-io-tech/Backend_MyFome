<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{

    private Product $product;

    public static function index()
    {
        $products = Product::all();

        return $products;
    }

    public static function getByStore(string $store_id)
    {
        $products = Product::where('store_id', $store_id)->get();

        return $products;
    }

    public function store(array $data)
    {
        $this->product = Product::create($data);

        return $this->product;
    }

    public function update(array $data, Product $product)
    {
        $this->product = $product;

        $this->product->update($data);

        return $this->product;
    }

    public function destroy(Product $product)
    {
        $this->product = $product;

        $this->product->delete();

        return $this->product;
    }

    public function changeActive(Product $product)
    {

        $this->product = $product;

        $this->product->update([
            'active' => !$product->active,
        ]);

        return $this->product;
    }

    public static function getDisabled() {
        $products = Product::where('active', false)->get();

        return $products;
    }

}
