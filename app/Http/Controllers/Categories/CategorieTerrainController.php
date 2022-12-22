<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Models\TypeTerrain;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategorieTerrainController extends Controller
{
    public function index(): View
    {
        $types = TypeTerrain::paginate(8);
        return view('categories.terrain.index', compact('types'));
    }

    public function show(int $id): View
    {
        return view('categories.terrain.show');
    }

    public function create(): View
    {
        return view('categories.terrain.create');
    }

    public function store(Request $request)
    {

    }
}
