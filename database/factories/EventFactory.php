<?php

namespace Database\Factories;

use App\Models\Event;
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
            'type' => $this->faker->randomElement(array_keys(Event::EVENT_TYPES)),
            'action_type' => $this->faker->randomElements(array_keys(Event::EVENT_ACTION_TYPES), 2),
            'note' => $this->faker->sentences(4, true),
            'participants_count' => $this->faker->randomDigitNotNull(),
        ];
    }
}
