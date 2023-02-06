<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        User::factory()->create([
                                    'name'     => 'admin',
                                    'email'    => 'pahomstyle90@mail.ru',
                                    'password' => Hash::make('Irina04071969i'),
                                    'admin'    => TRUE,
                                ]);

        $this->call(CategorySeeder::class);
        $this->command->info('Таблица категорий загружена данными');

        $this->call(BrandSeeder::class);
        $this->command->info('Таблица брендов загружена данными');

        $this->call(ProductSeeder::class);
        $this->command->info('Таблица товаров загружена данными');
    }
}
