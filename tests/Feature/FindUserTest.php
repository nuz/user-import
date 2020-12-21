<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FindUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function it_show_results_table(): void
    {
        $user = User::factory()->create();

        $this->artisan('user:find --email=' . $user->email)
             ->expectsTable(
                 [
                     'Id',
                     'First Name',
                     'Last Name',
                     'Email',
                     'Phone Number #1',
                     'Phone Number #2',
                     'Comment'
                 ],
                 [
                     0 => [
                         $user->id,
                         $user->firstname,
                         $user->lastname,
                         $user->email,
                         $user->phonenumber1,
                         $user->phonenumber2,
                         $user->comment
                     ]
                 ]
             );
    }

    /** @test **/
    public function it_shows_message_if_search_results_are_empty(): void
    {
        $this->artisan('user:find --email=test@gmail.com')
            ->expectsOutput('Nothing found.')
            ->assertExitCode(1);
    }
}
