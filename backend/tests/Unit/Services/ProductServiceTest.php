<?php

// namespace Tests\Unit\Services;

use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_can_list_all_products(): void
    {
        // Criar instâncias no banco de teste
        Product::factory()->create(['name' => 'Produto 1', 'active' => true]);
        Product::factory()->create(['name' => 'Produto 2', 'active' => true]);

        // Chamar o serviço
        $products = ProductService::index();

        // Verificar se retornou os dois registros
        $this->assertCount(2, $products);
        $this->assertEquals('Produto 1', $products[0]->name);
    }

    /** @test */
    public function test_it_can_get_products_by_store(): void
    {
        $storeId = Store::factory()->create()->id;

        // Criar produtos associados ao store_id
        Product::factory()->create(['name' => 'Produto 1', 'store_id' => $storeId, 'active' => true]);
        Product::factory()->create(['name' => 'Produto 2', 'store_id' => $storeId, 'active' => true]);
        Product::factory()->create(['name' => 'Produto 3', 'active' => true]);

        // Chamar o serviço
        $products = ProductService::getByStore($storeId);

        // Verificar se retornou os dois produtos da loja especificada
        $this->assertCount(2, $products);
        $this->assertEquals('Produto 1', $products[0]->name);
        $this->assertEquals('Produto 2', $products[1]->name);
    }

    /** @test */
    public function test_it_can_store_a_product(): void
    {
        $user = User::factory()->create(); // Criar um usuário de teste

        $data = [
            'name' => 'Novo Produto',
            'store_id' => Store::factory()->create()->id,
            'description' => 'blablabla',
            'price' => 10,
            'amount' => 1,
            'active' => true
        ];

        $service = new ProductService();
        $product = $service->store($data);

        // Verifica se o produto foi criado no banco de dados
        $this->assertDatabaseHas('products', ['name' => 'Novo Produto']);

        // Verifica se o retorno do serviço contém os dados corretos
        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Novo Produto', $product->name);
    }

    /** @test */
    public function test_it_can_update_a_product(): void
    {
        // Criando um produto no banco de testes
        $product = Product::factory()->create(['name' => 'Produto Existente']);

        $service = new ProductService();
        $updatedProduct = $service->update(['name' => 'Produto Atualizado'], $product);

        // Verifica se o nome foi atualizado corretamente
        $this->assertEquals('Produto Atualizado', $updatedProduct->name);

        // Verifica se o banco de dados contém a atualização
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Produto Atualizado',
        ]);
    }

    /** @test */
    public function test_it_can_destroy_a_product(): void
    {
        // Criando um produto no banco de testes
        $product = Product::factory()->create();

        $service = new ProductService();
        $service->destroy($product);

        // Verifica se o produto foi deletado
        $this->assertDatabaseHas('products', ['deleted_at' => $product->deleted_at]);
    }

    /** @test */
    public function test_it_can_toggle_product_active_status(): void
    {
        // Criando um produto no banco de testes com active = true
        $product = Product::factory()->create(['active' => true]);

        $service = new ProductService();
        $service->changeActive($product);

        // Atualizando a instância do modelo após a mudança no banco de dados
        $product->refresh();

        // Verificando que o status foi alterado corretamente
        $this->assertFalse($product->active);
    }

    /** @test */
    public function test_it_can_get_disabled_products(): void
    {
        // Criando um produto inativo
        $product = Product::factory()->create(['name' => 'Produto Inativo', 'active' => false]);

        $service = new ProductService();
        $disabledProducts = $service->getDisabled($product->store->id);

        // Verificando que o produto inativo foi retornado
        $this->assertCount(1, $disabledProducts);
        $this->assertEquals('Produto Inativo', $disabledProducts[0]->name);
        $this->assertFalse($disabledProducts[0]->active);
    }
}
