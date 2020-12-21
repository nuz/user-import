<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Storages\StorageStrategy;
use Illuminate\Support\Facades\Validator;

abstract class BaseCommand extends Command
{
    protected StorageStrategy $strategy;

    public function __construct(StorageStrategy $strategy)
    {
        parent::__construct();

        $this->strategy = $strategy;
    }

    public function showUsers(array $users = null): void
    {
        $this->table(
            ['Id', 'First Name', 'Last Name', 'Email', 'Phone Number #1', 'Phone Number #2', 'Comment'],
            $users ?? $this->strategy->all()
        );
    }

    protected function validateInput($rules, $fieldName, $value): ?string
    {
        $validator = Validator::make([
            $fieldName => $value
        ], [
            $fieldName => $rules
        ]);

        return $validator->fails()
            ? $validator->errors()->first($fieldName)
            : null;
    }

    protected function askValid($question, $field, $rules)
    {
        $value = $this->ask($question);

        if ($message = $this->validateInput($rules, $field, $value)) {
            $this->error($message);

            return $this->askValid($question, $field, $rules);
        }

        return $value;
    }
}
