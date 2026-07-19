<?php

namespace App\Http\Controllers;

use App\Interfaces\InventoryRepositoryInterface;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    protected InventoryRepositoryInterface $inventoryRepo;


    public function __construct(InventoryRepositoryInterface $inventoryRepo)
    {
        $this->inventoryRepo = $inventoryRepo;
    }


    public function index(Request $request)
    {
        $search = $request->input('search');


        $products = $this->inventoryRepo->search($search);


        return view('inventory.index', compact('products'));
    }
}
