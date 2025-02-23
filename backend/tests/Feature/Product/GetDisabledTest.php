<?php

namespace Tests\Feature\Product;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetDisabledTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_disabled_products(): void
    {
        $response = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertStatus(201);

        $login = $this->post('/api/login', [
            'email' => 'test@example.com',
        ]);

        $login->assertStatus(200);

        $login->assertExactJsonStructure(['token']);

        $store = $this->post('/api/store', [
            'name' => 'loja x',
            'description' => 'descrição',
            'whatsapp' => '+5584986460846',
        ]);

        $store->assertStatus(201);

        $storeId = $store->json('store')['id'];

        $product = $this->post('api/product', [
            'name' => 'Produto 1',
            'description' => 'Produto massa',
            'price' => 10.99,
            'store_id' => $storeId,
        ]);

        $product->assertStatus(201);

        $productId = $product->json('product')['id'];

        $productChanged = $this->put('api/product/active/' . $productId);

        $productChanged->assertStatus(200);

        $productsDisabled = $this->get('api/product/disabled/' . $storeId);

        $productsDisabled->assertStatus(200);

        $productsDisabled->assertJsonStructure([
            'products'
        ]);
    }
}
