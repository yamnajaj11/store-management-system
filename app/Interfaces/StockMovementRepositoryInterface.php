<?php

namespace App\Interfaces;

interface StockMovementRepositoryInterface
{

    public function getAll(array $filters = []);

    public function getById($id);

}