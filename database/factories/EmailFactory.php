<?php

namespace Database\Factories;

use App\Models\Email;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Email>
 */
class EmailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Email::class;
    public function definition(): array
    {
        return [
            'sender' => $this->faker->email,
            'subject' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'is_spam' => $this->faker->boolean,
        ];
    }
}
