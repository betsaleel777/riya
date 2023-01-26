<?php

namespace App\Exports;

use App\Models\Proprietaire;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProprietaireExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Proprietaire::all();
    }
}
