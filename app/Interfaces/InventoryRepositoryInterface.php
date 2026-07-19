<?php

namespace App\Interfaces;

interface InventoryRepositoryInterface
{
    public function all();

    public function search($search = null);
}