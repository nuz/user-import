<?php

namespace App\Storages;

interface StorageStrategy
{
    public function all();

    public function store(array $attributes);

    public function find(array $attributes);

    public function delete(int $id);

    public function import(string $filename);
}
