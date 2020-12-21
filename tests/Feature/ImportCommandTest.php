<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImportCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function it_imports_user_to_the_database(): void
    {
        $this->artisan('user:import')
            ->expectsQuestion('Please provide the CSV file name', 'test.csv')
            ->expectsOutput('Users have been imported.')
            ->assertExitCode(0);

        $this->assertCount(3, User::all());

        $this->assertDatabaseHas((new User)->getTable(), [
            'firstname' => 'Raimondas',
            'lastname' => 'Bazys',
            'email' => 'me@gmail.com',
            'phonenumber1' => '1234567890',
            'phonenumber2' => null,
            'comment' => 'As'
        ]);
    }

    /** @test **/
    public function it_accepts_filename_as_an_option(): void
    {
        $this->artisan('user:import test.csv')
            ->expectsOutput('Users have been imported.')
            ->assertExitCode(0);

        self::assertCount(3, User::all());
    }

    /** @test **/
    public function it_checks_if_file_exists(): void
    {
        $this->artisan('user:import test.md')
            ->assertExitCode(1);
    }

    /** @test **/
    public function its_not_import_duplicated_records(): void
    {
        $this->artisan('user:import duplicated.csv')
            ->expectsOutput('1 records were not imported.')
            ->expectsOutput('Users have been imported.')
            ->assertExitCode(0);

        self::assertCount(2, User::all());
    }
}
