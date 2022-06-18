<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'     => 1,
            'category_id' => 1,
            'title'       => $this->faker->sentence(),
            'image'       => $this->faker->url(),
            'video'       => $this->faker->url(),
            'description' => $this->faker->text(200),
            'likes'       => rand(0, 10),
            'dislikes'    => rand(0, 10),
            'views'       => rand(0, 10),
        ];
    }
}
