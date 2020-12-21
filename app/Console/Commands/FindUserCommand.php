<?php

namespace App\Console\Commands;

use Exception;

class FindUserCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:find
        {--firstname= : Find user by the first name}
        {--lastname= : Find user by the last name}
        {--email= : Find user by the email}
        {--phonenumber1= : Find user by the first phone number}
        {--phonenumber2= : Find user by the second phone number}
        {--comment= : Find user by the part of the comment }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find a user in a register';

    public function handle(): int
    {
        $attributes = [
            'firstname' => $this->option('firstname'),
            'lastname' => $this->option('lastname'),
            'email' => $this->option('email'),
            'phonenumber1' => $this->option('phonenumber1'),
            'phonenumber2' => $this->option('phonenumber2'),
            'comment' => $this->option('comment'),
        ];

        try {
            $users = $this->strategy->find($attributes);

            if ($users->isEmpty()) {
                throw new Exception('Nothing found.');
            }
        } catch (Exception $exception) {
            $this->error($exception->getMessage());

            return 1;
        }

        $this->showUsers($users->toArray());

        return 0;
    }

}
