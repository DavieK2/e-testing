<?php

namespace App\Modules\Excel;

use Maatwebsite\Excel\Concerns\FromCollection;

class Export implements FromCollection
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    
    public function collection()
    {
        return $this->data;
    }
}