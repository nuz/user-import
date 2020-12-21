<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory()->create();
    }

    /** @test **/
    public function it_deletes_a_user(): void
    {
        $this->assertCount(1, User::all());

        $this->artisan('user:delete 1');

        $this->assertEmpty(User::all());
    }

    /** @test **/
    public function it_shows_a_message_if_user_does_not_exist(): void
    {
        $this->artisan('user:delete 2')
            ->expectsOutput('User does not exist.')
            ->assertExitCode(1);
    }
}
