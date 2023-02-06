<?php

declare(strict_types=1);

namespace Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    #[ArrayShape([
        'name'        => "string",
        'content'     => "string",
        'slug'        => "string",
        'price'       => "int",
        'category_id' => "int",
        'brand_id'    => "int",
        'sale'        => "int",
        'hit'         => "int",
        'new'         => "int",
    ])]
    public function definition(): array
    {
        $name = fake()->realText(random_int(40, 50));
        return [
            'name'    => $name,
            'content' => fake()->realText(random_int(400, 500)),
            'slug'    => Str::slug($name),
            'price'   => random_int(1000, 2000),

            'category_id' => random_int(1, 10),
            'brand_id'    => random_int(1, 4),
            'sale'        => random_int(0, 1),
            'hit'         => random_int(0, 1),
            'new'         => random_int(0, 1),
        ];
    }
}
