<?php

namespace Database\Factories;

use App\Infrastructure\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;


class ContactFactory extends Factory
{
    protected $model = Contact::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'status' => 'pending',
            'score' => 0,
            'processed_at' => null,
        ];
    }
}
