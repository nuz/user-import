<?php

namespace App\Console\Commands;

use Exception;

class DeleteUserCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a user by it\'s id';

    public function handle(): int
    {
        $id = $this->argument('id');

        try {
            $this->strategy->delete($id);
        } catch (Exception $exception) {
            $this->error($exception->getMessage());

            return 1;
        }

        $this->info('User deleted.');

        $this->showUsers();

        return 0;
    }
}
