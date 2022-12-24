<?php

namespace App\Exports;

use App\Models\TypeTerrain;
use Maatwebsite\Excel\Concerns\FromCollection;

class TypeTerrainExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TypeTerrain::all();
    }
}
