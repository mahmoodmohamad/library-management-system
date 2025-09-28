<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Member::class;
    public function definition(): array
    {
        return [
            //
      'member_number'          => $this->faker->unique()->numerify('MBR-####'),
            'first_name'             => $this->faker->firstName,
            'last_name'              => $this->faker->lastName,
            'email'                  => $this->faker->unique()->safeEmail,
            'phone'                  => $this->faker->phoneNumber,
            'address'                => $this->faker->address,
            'date_of_birth'          => $this->faker->date('Y-m-d', '-18 years'),
            'membership_type' => $this->faker->randomElement(['student', 'teacher', 'staff', 'public']),
            'membership_start_date'  => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'membership_expiry_date' => $this->faker->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
            'emergency_contact_name' => $this->faker->name,
            'emergency_contact_phone'=> $this->faker->phoneNumber,
            'status' => $this->faker->randomElement(['active', 'suspended', 'expired']),
            'outstanding_fines'      => $this->faker->randomFloat(2, 0, 500), // مبلغ بين 0 و 500
            'notes'                  => $this->faker->optional()->sentence(10),
        ];
    }
}
