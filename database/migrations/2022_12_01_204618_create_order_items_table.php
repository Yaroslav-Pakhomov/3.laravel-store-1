<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('order_items', static function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->decimal('price', 10)->unsigned();
            $table->tinyInteger('quantity')->unsigned()->default(1);
            $table->decimal('cost', 10)->unsigned();

            $table->timestamps();

            //FK
            $table->foreignId('order_id')->constrained('orders')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
