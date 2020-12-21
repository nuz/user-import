<?php

namespace App\Console\Commands;

use Exception;

class CreateUserCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    public function handle(): int
    {
        $attributes = [
            'firstname' => $this->askValid('Enter the first name*', 'firstname', ['required']),
            'lastname' => $this->askValid('Enter the last name*', 'lastname', ['required']),
            'email' => $this->askValid('Enter the email*', 'email', ['required', 'email', 'unique:users,email']),
            'phonenumber1' => $this->askValid('Enter the phone number #1*', 'phonenumber1', ['required']),
            'phonenumber2' => $this->askValid('Enter the phone number #2', 'phonenumber2', ['nullable']),
            'comment' => $this->askValid('Enter the comment', 'comment', ['nullable']),
        ];

        try {
            $this->strategy->store($attributes);
        } catch (Exception $exception) {
            $this->error($exception->getMessage());

            return 1;
        }

        $this->info('User have been created.');

        $this->showUsers();

        return 0;
    }

}
