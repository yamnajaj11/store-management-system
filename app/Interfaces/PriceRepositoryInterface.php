<?php

namespace App\Interfaces;

interface PriceRepositoryInterface
{
    public function all();

    public function find($id);

    public function update($id, array $data);
}
