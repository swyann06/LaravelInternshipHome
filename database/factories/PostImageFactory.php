<?php

namespace Database\Factories;

use App\Models\PostImage;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostImageFactory extends Factory
{
    protected $model = PostImage::class;

    public function definition(): array
    {
        return [
            'post_id' => Post::factory(),
            'url' => $this->faker->imageUrl(640, 480, 'posts', true),
        ];
    }
}