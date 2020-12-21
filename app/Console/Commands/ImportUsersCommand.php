<?php

namespace App\Console\Commands;

use Exception;

class ImportUsersCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:import {filename?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import users to the register';

    public function handle(): int
    {
        $filename = $this->argument('filename') ?: $this->ask('Please provide the CSV file name');

        try {
            $response = $this->strategy->import($filename);
        } catch (Exception $exception) {
            $this->error($exception->getMessage());

            return 1;
        }

        $this->error($response);
        $this->info('Users have been imported.');

        $this->showUsers();

        return 0;
    }

}
