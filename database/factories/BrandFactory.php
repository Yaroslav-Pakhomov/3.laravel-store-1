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
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    #[ArrayShape([
        'name'    => "string",
        'content' => "string",
        'slug'    => "string",
    ])]
    public function definition(): array
    {
        $name = fake()->realText(random_int(20, 30));
        return [
            'name'    => $name,
            'content' => fake()->realText(random_int(150, 200)),
            'slug'    => Str::slug($name),
        ];
    }
}
