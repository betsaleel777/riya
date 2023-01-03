<?php

namespace App\Exports;

use App\Models\TypeClient;
use Maatwebsite\Excel\Concerns\FromCollection;

class TypeClientsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TypeClient::all();
    }
}
