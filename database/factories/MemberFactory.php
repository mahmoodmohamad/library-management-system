<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'user_id' => null,
            'member_number' => $this->faker->unique()->numerify('MBR-####'),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'date_of_birth' => $this->faker->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
            'membership_type' => $this->faker->randomElement(['student', 'teacher', 'staff', 'public']),
            'membership_start_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'membership_expiry_date' => $this->faker->dateTimeBetween('+2 months', '+2 years')->format('Y-m-d'),
            'emergency_contact_name' => $this->faker->name(),
            'emergency_contact_phone' => $this->faker->phoneNumber(),
            'status' => 'active',
            'outstanding_fines' => 0,
            'notes' => $this->faker->optional()->sentence(10),
        ];
    }

    /** Link the member to an existing user (same name and email). */
    public function forUser(User $user): static
    {
        [$first, $last] = array_pad(explode(' ', trim($user->name), 2), 2, '');

        return $this->state(fn () => [
            'user_id' => $user->id,
            'email' => $user->email,
            'first_name' => $first,
            'last_name' => $last ?: $this->faker->lastName(),
        ]);
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'status' => 'active',
            'membership_expiry_date' => now()->addYear()->toDateString(),
        ]);
    }

    public function suspended(): static
    {
        return $this->state(fn () => ['status' => 'suspended']);
    }

    public function expired(): static
    {
        return $this->state(fn () => [
            'status' => 'expired',
            'membership_start_date' => now()->subYears(2)->toDateString(),
            'membership_expiry_date' => now()->subMonth()->toDateString(),
        ]);
    }

    public function withFines(float $amount = 25): static
    {
        return $this->state(fn () => ['outstanding_fines' => $amount]);
    }
}