<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        // Demo login: member@example.com / password
        $demo = User::factory()->create(['name' => 'Demo Member', 'email' => 'member@example.com']);
        Member::factory()->active()->forUser($demo)->create();

        foreach (range(1, 7) as $_) {
            Member::factory()->active()->forUser(User::factory()->create())->create();
        }

        Member::factory()->suspended()->forUser(User::factory()->create())->create();
        Member::factory()->expired()->forUser(User::factory()->create())->create();
    }
}