<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'event_start' => $this->faker->dateTimeInInterval('+1 week', '+3 week'),
            'event_end' => $this->faker->dateTimeInInterval('+4 week', '+10 week'),
            'type' => $this->faker->sentences(4, true),
            'note' => $this->faker->sentences(4, true),
            'attachment' => $this->faker->name(),
            'participants_count' => $this->faker->randomDigit(),
        ];
    }
}
