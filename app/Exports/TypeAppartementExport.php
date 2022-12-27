<?php

namespace App\Exports;

use App\Models\TypeAppartement;
use Maatwebsite\Excel\Concerns\FromCollection;

class TypeAppartementExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TypeAppartement::all();
    }
}
