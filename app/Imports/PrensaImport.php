<?php

namespace App\Imports;

use App\Enums\TypeOfMedium;
use App\Events\AfterImportEvent;
use App\Exceptions\HeaderFileException;
use App\Factories\PrensaFactory;
use App\Factories\GeneralFactory;
use App\Models\ReadedFile;
use App\Traits\sanitizadorTrait;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;

class PrensaImport implements ToModel, WithChunkReading, WithHeadingRow, WithEvents, WithStartRow
{
    use sanitizadorTrait;
    use RemembersRowNumber;
    private string $file_name, $origin;
    private ReadedFile $readed_file;
    private GeneralFactory $generalFactory;

    public function __construct(string $file_name, string $origin)
    {
        $this->file_name = $file_name;
        $this->origin    = $origin;
        $this->generalFactory = new GeneralFactory();
    }

    public function startRow(): int
    {
        return 1;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * @throws HeaderFileException
     */
    public function model(array $row): void
    {
        if ($this->rowNumber == 1) {

            $keys = array_keys($row);
            $this->validateHeadingRow($keys[0], "medio");
            $this->validateHeadingRow($keys[1], "pais");
            $this->validateHeadingRow($keys[2], "estado");
            $this->validateHeadingRow($keys[3], "avenida_titulo_canal_estacion");
            $this->validateHeadingRow($keys[4], "orientacion_seccioninicio");
            $this->validateHeadingRow($keys[5], "id_paginaduracion");
            $this->validateHeadingRow($keys[6], "tipo_insercion");
            $this->validateHeadingRow($keys[7], "vista_posicion");
            $this->validateHeadingRow($keys[8], "proveedor");
            $this->validateHeadingRow($keys[9], "direccion");
            $this->validateHeadingRow($keys[12], "mes");
            $this->validateHeadingRow($keys[13], "marca");
            $this->validateHeadingRow($keys[14], "version");
            $this->validateHeadingRow($keys[15], "producto");
            $this->validateHeadingRow($keys[16], "categoria");
            $this->validateHeadingRow($keys[17], "testigo");
        }

        $medium = $row['medio'] ?? "";
        $isLoadingTheCorrectMedium = $this->validateMedium($medium, strtoupper(TypeOfMedium::Prensa->value));

        if ($isLoadingTheCorrectMedium) {
            $this->generalFactory->proccessMedium($row, new PrensaFactory($this->rowNumber), $this->readed_file->id);
        }

        ++$this->rowNumber;
    }

    public function registerEvents(): array
    {
        try {
            return  [
                BeforeImport::class => function (BeforeImport $beforeImport) {
                    $this->readed_file = ReadedFile::create([
                        'fileName' => $this->file_name,
                        'origin'   => $this->origin,
                        'start'    => now()->format('Y-m-d H:i:s')
                    ]);
                },
                AfterImport::class => function (AfterImport $event) {
                    AfterImportEvent::dispatch($this->readed_file, $this->file_name, $this->origin);
                }
            ];
        } catch (\Throwable $e) {
            throw new \Exception("Error inesperado: " . $e->getMessage());
        }
    }
}
