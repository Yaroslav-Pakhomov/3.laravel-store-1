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
        Schema::create('brands', static function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->string('content', 200)->nullable();
            $table->string('slug', 100)->unique();
            $table->string('full_image', 100)->nullable();
            $table->string('preview_image', 100)->nullable();

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
        Schema::dropIfExists('brands');
    }
};
