<?php

namespace App\Storages;

use Exception;
use App\Models\User;
use App\Imports\UsersImport;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class DatabaseStorage
 *
 * @package \App\Storages
 */
class DatabaseStorage implements StorageStrategy
{

    public function all(): Collection
    {
        return User::all();
    }

    public function store(array $attributes): User
    {
        return User::create($attributes);
    }

    public function find(array $attributes): Collection
    {
        return User::query()
            ->when(
                $attributes['firstname'],
                fn($query) => $query->where('firstname', $attributes['firstname'])
            )
            ->when(
                $attributes['lastname'],
                fn($query) => $query->where('lastname', $attributes['lastname'])
            )
            ->when(
                $attributes['email'],
                fn($query) => $query->where('email', $attributes['email'])
            )
            ->when(
                $attributes['phonenumber1'],
                fn($query) => $query->where('phonenumber1', $attributes['phonenumber1'])
            )
            ->when(
                $attributes['phonenumber2'],
                fn($query) => $query->where('phonenumber2', $attributes['phonenumber2'])
            )
            ->when(
                $attributes['comment'],
                fn($query) => $query->where('comment', 'like', '%' . $attributes['comment'] . '%')
            )
            ->get();
    }

    public function delete(int $id): void
    {
        if (! $user = User::find($id)) {
            throw new ModelNotFoundException('User does not exist.');
        }

        $user->delete();
    }

    public function import(string $filename)
    {
        $import = new UsersImport;
        $import->import(storage_path($filename));

        if ($import->failures()->isNotEmpty()) {
            return count($import->failures()) . ' records were not imported.';
        }

        return;
    }
}
