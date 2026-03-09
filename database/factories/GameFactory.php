<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Counter-Strike 2', 'Valorant', 'Minecraft', 'Fortnite',
                'League of Legends', 'GTA V', 'Red Dead Redemption 2',
                'The Witcher 3', 'Elden Ring', 'Hollow Knight',
                'Stardew Valley', 'Among Us', 'Apex Legends',
                'Overwatch 2', 'Rocket League'
            ]),
            'description' => fake()->text(200),
            'link' => fake()->url(),
            'image' => fake()->imageUrl(),
            'clicks' => fake()->numberBetween(0, 100),
            'user_id' => User::inRandomOrder()->first()->id,
            'school_id' => School::inRandomOrder()->first()->id,
        ];
    }
}
