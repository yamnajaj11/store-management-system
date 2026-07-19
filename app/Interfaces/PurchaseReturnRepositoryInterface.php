<?php

namespace App\Interfaces;

interface PurchaseReturnRepositoryInterface
{
    public function all();

    public function find($id);

    public function create(array $data);
}