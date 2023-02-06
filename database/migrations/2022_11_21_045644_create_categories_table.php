<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    // private con
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('categories', static function (Blueprint $table) {
            // $name = fake()->realText(random_int(30, 50));
            // ->default($name)
            // ->default(Str::slug($name))

            $table->id();

            $table->string('name', 100);
            $table->string('content', 300)->nullable();
            $table->string('slug', 100)->unique();
            $table->string('full_image', 100)->nullable();
            $table->string('preview_image', 100)->nullable();
            $table->unsignedBigInteger('parent_id')->nullable()->default(0);

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
        Schema::dropIfExists('categories');
    }
};
