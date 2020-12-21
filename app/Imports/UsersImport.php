<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class UsersImport implements ToModel, WithCustomCsvSettings, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row): User
    {
        return new User([
            'firstname' => $row[0],
            'lastname' => $row[1],
            'email' => $row[2],
            'phonenumber1' => $row[3],
            'phonenumber2' => $row[4],
            'comment' => $row[5]
        ]);
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ";"
        ];
    }

    public function rules(): array
    {
        return [
            '*.0' => ['required'],
            '*.1' => ['required'],
            '*.2' => ['required', 'email', 'unique:users,email'],
            '*.3' => ['required'],
            '*.4' => ['nullable'],
            '*.5' => ['nullable']
        ];
    }
}
