<?php

namespace App\Exports;

use App\Models\Appartement;
use Maatwebsite\Excel\Concerns\FromCollection;

class AppartementExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Appartement::all();
    }
}
