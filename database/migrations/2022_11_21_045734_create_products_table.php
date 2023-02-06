<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('products', static function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->text('content')->nullable();
            $table->string('slug', 100)->unique();
            // $table->string('image', 50)->nullable();
            $table->string('full_image', 100)->nullable();
            $table->string('preview_image', 100)->nullable();
            $table->decimal('price', 10, 2, true)->default(0);

            // FK
            $table->foreignId('category_id')->nullable()->cascadeOnUpdate()->nullOnDelete()->constrained('categories');
            $table->foreignId('brand_id')->nullable()->cascadeOnUpdate()->nullOnDelete()->constrained('brands');

            // IDx
            $table->index('category_id');
            $table->index('brand_id');

            // Мягкое удаление
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
