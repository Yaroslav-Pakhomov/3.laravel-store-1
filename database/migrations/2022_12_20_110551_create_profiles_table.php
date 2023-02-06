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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            // название профиля
            $table->string('title')->nullable(false);
            // имя пользователя
            $table->string('name')->nullable(false);
            // почта пользователя
            $table->string('email')->nullable(false);
            // телефон пользователя
            $table->string('phone')->nullable(false);
            // адрес доставки заказа
            $table->string('address')->nullable(false);
            // комментарий к заказу
            $table->string('comment')->nullable();

            // FK
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();

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
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
