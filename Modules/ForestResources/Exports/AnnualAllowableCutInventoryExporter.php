<?php


namespace Modules\ForestResources\Exports;


use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\ForestResources\Entities\AnnualAllowableCutInventory;

class AnnualAllowableCutInventoryExporter implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;

    public function query()
    {
        return AnnualAllowableCutInventory::query()->select('Id', 'AnnualAllowableCutName', 'Species', 'Quality', 'Parcel', 'TreeId', 'DiameterBreastHeight', 'Lat', 'Lon', 'GpsAccu');
    }

    public function headings(): array
    {
        return ['AnnualAllowableCut', 'Species', 'Quality', 'Parcel', 'TreeId', 'DiameterBreastHeight', 'Lat', 'Lon', 'GpsAccu'];
    }

    public function map($row): array
    {
        return [
            'AnnualAllowableCut' => $row->AnnualAllowableCutName,
            'Species' => $row->Species,
            'Quality' => $row->Quality,
            'Parcel' => $row->Parcel,
            'TreeId' => $row->TreeId,
            'DiameterBreastHeight' => $row->DiameterBreastHeight,
            'Lat' => $row->Lat,
            'Lon' => $row->Lon,
            'GpsAccu' => $row->GpsAccu
        ];
    }
}
