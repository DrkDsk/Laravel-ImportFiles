<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportRegisters implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private Collection $dataExport;
    public function __construct($dataToExport)
    {
        $this->dataExport  = collect(json_decode($dataToExport));
    }

    public function map($row) : array
    {
        return [
            'MEDIO' => $row->origin->medium->name,
            'PAIS' => $row->state->country->name,
            'ESTADO' => $row->state->name,
            'AVENIDA/TITULO/CANAL/ESTACIÓN' => $row->origin->name,
            'ORIENTACIÓN/SECCIÓN/INICIO' => $row->orientacion,
            'ID/PÁGINA/DURACIÓN' => $row->pagina,
            'TIPO INSERCIÓN' => $row->insertion->name,
            'VISTA/POSICIÓN' => $row->vista_posicion,
            'PROVEEDOR' => $row->supplier->name,
            'DIRECCION' => $row->direccion,
            'LATITUD'   => $row->latitud,
            'LONGITUD'  => $row->longitud,
            'MES'       => $row->mes,
            'MARCA'     => $row->brand->name,
            'VERSION'   => $row->version,
            'PRODUCTO'  => $row->product->name,
            'CATEGORIA' => $row->category->name,
            'TESTIGO'   => $row->testigo
        ];
    }

    public function headings(): array
    {
        return [
            'MEDIO',
            'PAIS',
            'ESTADO',
            'AVENIDA/TITULO/CANAL/ESTACIÓN',
            'ORIENTACIÓN/SECCIÓN/INICIO',
            'ID/PÁGINA/DURACIÓN',
            'TIPO INSERCIÓN',
            'VISTA/POSICIÓN',
            'PROVEEDOR',
            'DIRECCION',
            'LATITUD',
            'LONGITUD',
            'MES',
            'MARCA',
            'VERSION',
            'PRODUCTO',
            'CATEGORIA',
            'TESTIGO'
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            'A1'    => ['font' => ['bold' => true]],
            'B1'    => ['font' => ['bold' => true]],
            'C1'    => ['font' => ['bold' => true]],
            'D1'    => ['font' => ['bold' => true]],
            'E1'    => ['font' => ['bold' => true]],
            'F1'    => ['font' => ['bold' => true]],
            'G1'    => ['font' => ['bold' => true]],
            'H1'    => ['font' => ['bold' => true]],
            'I1'    => ['font' => ['bold' => true]],
            'J1'    => ['font' => ['bold' => true]],
            'K1'    => ['font' => ['bold' => true]],
            'L1'    => ['font' => ['bold' => true]],
            'M1'    => ['font' => ['bold' => true]],
            'N1'    => ['font' => ['bold' => true]],
            'O1'    => ['font' => ['bold' => true]],
            'P1'    => ['font' => ['bold' => true]],
            'Q1'    => ['font' => ['bold' => true]],
            'R1'    => ['font' => ['bold' => true]],
        ];
    }

    public function collection(): Collection
    {
        return $this->dataExport;
    }
}
