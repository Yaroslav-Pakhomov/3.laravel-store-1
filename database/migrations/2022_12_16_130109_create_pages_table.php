<?php

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
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100)->nullable(false);
            $table->text('content', 300)->nullable(false);
            $table->string('slug', 100)->unique()->nullable(false);

            $table->string('full_image', 100)->nullable();
            $table->string('preview_image', 100)->nullable();

            $table->unsignedBigInteger('parent_id')->nullable(false)->default(0);

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
};
