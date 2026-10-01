<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private function userWithRole(string $role): User
    {
        return User::factory()->create([
            'role_id' => Role::firstOrCreate(['name' => $role])->id,
        ]);
    }

    public function test_admin_can_delete_member(): void
    {
        $member = Member::factory()->create();

        $this->actingAs($this->userWithRole('admin'))
            ->delete(route('admin.members.destroy', $member))
            ->assertRedirect(route('admin.members.index'));

        $this->assertModelMissing($member);
    }

    public function test_librarian_can_view_but_not_delete_member(): void
    {
        $member = Member::factory()->create();
        $librarian = $this->userWithRole('librarian');

        $this->actingAs($librarian)
            ->get(route('admin.members.index'))
            ->assertOk();

        $this->actingAs($librarian)
            ->delete(route('admin.members.destroy', $member))
            ->assertForbidden();

        $this->assertModelExists($member);
    }

    public function test_librarian_can_view_pending_applications(): void
    {
        $this->actingAs($this->userWithRole('librarian'))
            ->get(route('admin.members.pending'))
            ->assertOk();
    }

    public function test_member_role_cannot_access_admin_members(): void
    {
        $this->actingAs($this->userWithRole('member'))
            ->get(route('admin.members.index'))
            ->assertForbidden();
    }
}