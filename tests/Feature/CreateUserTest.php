<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function it_creates_user(): void
    {
        $this->artisan('user:create')
            ->expectsQuestion('Enter the first name*', 'Raimondas')
            ->expectsQuestion('Enter the last name*', 'Bazys')
            ->expectsQuestion('Enter the email*', 'raimondas.bazys@gmail.com')
            ->expectsQuestion('Enter the phone number #1*', '+37062146309')
            ->expectsQuestion('Enter the phone number #2', '+3701153913')
            ->expectsQuestion('Enter the comment', 'As')
            ->expectsOutput('User have been created.')
            ->assertExitCode(0);

        $this->assertCount(1, User::all());
    }

    /** @test **/
    public function it_shows_validation_error_if_value_is_not_provided(): void
    {
        $this->artisan('user:create')
            ->expectsQuestion('Enter the first name*', '')
            ->expectsOutput('The firstname field is required.')
            ->expectsQuestion('Enter the first name*', 'Raimondas')
            ->expectsQuestion('Enter the last name*', 'Bazys')
            ->expectsQuestion('Enter the email*', 'raimondas.bazys@gmail.com')
            ->expectsQuestion('Enter the phone number #1*', '+37062146309')
            ->expectsQuestion('Enter the phone number #2', '+3701153913')
            ->expectsQuestion('Enter the comment', 'As')
            ->expectsOutput('User have been created.')
            ->assertExitCode(0);
    }
}
