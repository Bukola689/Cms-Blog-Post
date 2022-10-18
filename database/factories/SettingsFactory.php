<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SettingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'header_logo' => 'picture',
            'footer_logo'  => 'picture',
            'footer_desc'  => $this->faker->paragraph(),
            'email'  => $this->faker->email,
            'phone'  => '08105155989',
            'address'  => 'nigeria',
            'facebook'  => 'facebook',
            'instagram'  => 'instagram',
            'youtube'  => 'youtube',
            'about_title'  => $this->faker->sentence(),
            'about_desc'  => $this->faker->paragraph(3),
        ];
    }
}
