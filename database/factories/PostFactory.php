<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::all()->random()->id,
            'title' => $this->faker->name,
            'image' => $this->faker->imageUrl($width = 140, $height=300),
            'description' => $this->faker->sentence,
            'date' => $this->faker->date
        ];
    }
}
