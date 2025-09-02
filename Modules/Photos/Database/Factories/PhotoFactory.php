<?php

namespace Modules\Photos\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PhotoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Photos\Models\Photo::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

