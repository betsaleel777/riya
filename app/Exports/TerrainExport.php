<?php

namespace App\Exports;

use App\Models\Terrain;
use Maatwebsite\Excel\Concerns\FromCollection;

class TerrainExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Terrain::all();
    }
}
