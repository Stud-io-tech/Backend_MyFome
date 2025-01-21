<?php

use App\Models\Store;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->uuid('id');
            $table->foreignUuid('loja_id')->constrained('lojas');
            $table->string('nome');
            $table->text('descricao');
            $table->decimal('preco');
            $table->integer('quantidade')->nullable();
            $table->integer('vendido')->nullable();
            $table->boolean('ativo')->default(true);
            $table->string('imagem')->nullable();
            $table->string('public_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
