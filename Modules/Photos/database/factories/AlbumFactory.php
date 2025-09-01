<?php

namespace Modules\Photos\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AlbumFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Photos\Models\Album::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

