<?php

namespace Database\Factories;

use App\Enums\Gender;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $country = Country::inRandomOrder()->first();
        $state = $country->states()->inRandomOrder()->first();
 return [
    'name'             => fake()->name(),
    'email'            => $email = fake()->unique()->safeEmail(),
    'username'         => fake()->unique()->userName(),
    'mobile'           => '+639' . fake()->numerify('########'),
    'gender'           => fake()->randomElement(Gender::all()),
    'address'          => fake()->address(),

    'country'          => 'PH',
    'province'         => 'Ilocos Norte',
    'province_code'    => '0128',
    'city'             => 'Laoag City',
    'city_code'        => '012801',
    'barangay'         => 'Barangay 1',
    'barangay_code'    => '012801001',

    'zip_code'         => fake()->postcode(),
    'avatar'           => get_random_avatar(),
    'password'         => bcrypt('password'),
    'email_verified_at'=> now(),
];

    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model's email address should be verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => now(),
            'email_verification_token' => null,
        ]);
    }

    /**
     * Indicate that the model's gender should be
     */
    public function gender(Gender $gender): static
    {
        return $this->state(fn (array $attributes) => [
            'gender' => $gender,
        ]);
    }
}
