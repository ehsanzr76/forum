<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'slug' => Str::slug('title'),
            'body' => $this->faker->realText(),
            'user_id' => User::factory()->create()->id,
            'channel_id' => Channel::factory()->create()->id,
            'best_answer_id' =>$this->faker->randomNumber(100 || null)
            ];
    }
}
