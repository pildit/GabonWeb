<?php

namespace Modules\Transport\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Exporter implements FromCollection, WithHeadings
{
    protected $collection;
    protected $headings;

    public function __construct($collection,$headings){
        $this->collection = $collection;
        $this->headings = $headings;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->collection;

    }

    public function headings(): array
    {
        return $this->headings;
    }
}
