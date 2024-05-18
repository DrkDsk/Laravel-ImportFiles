<?php

namespace App\Imports;

use App\Enums\TypeOfMedium;
use App\Events\AfterImportEvent;
use App\Factories\PrensaFactory;
use App\Factories\GeneralFactory;
use App\Models\ReadedFile;
use App\Traits\sanitizadorTrait;
use Exception;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;

class PrensaImport implements ToModel, WithChunkReading, WithHeadingRow, WithEvents, WithStartRow, WithValidation
{
    use sanitizadorTrait;
    use RemembersRowNumber;
    private string $file_name;
    private ReadedFile $readed_file;
    private GeneralFactory $generalFactory;

    public function __construct(string $file_name)
    {
        $this->file_name = $file_name;
        $this->generalFactory = new GeneralFactory();
    }

    public function startRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function rules(): array
    {
        return [
            'medio' => 'required|string',
            'pais'  => 'required|string',
            'estado' => 'required|string',
            'avenida_titulo_canal_estacion' => 'required|string',
            'orientacion_seccioninicio' => 'nullable|string',
            'id_paginaduracion' => 'required',
            'vista_posicion' => 'nullable|string',
            'mes' => 'required|string',
            'marca' => 'required|string',
            'version' => 'required|string',
            'producto' => 'required|string',
            'categoria' => 'required|string',
            'testigo' => 'required|string',
        ];
    }

    public function model(array $row): void
    {
        $medium = $row['medio'] ?? "";
        $isLoadingTheCorrectMedium = $this->validateMedium($medium, strtoupper(TypeOfMedium::Prensa->value));

        if ($isLoadingTheCorrectMedium) {
            $this->generalFactory->proccessMedium($row, new PrensaFactory($this->rowNumber), $this->readed_file->id);
        }
    }

    /**
     * @throws Exception
     */
    public function registerEvents(): array
    {
        try {
            return  [
                BeforeImport::class => function (BeforeImport $beforeImport) {
                    $this->readed_file = ReadedFile::create([
                        'fileName' => $this->file_name,
                        'origin'   => 'prensa',
                        'start'    => now()->format('Y-m-d H:i:s')
                    ]);
                },
                AfterImport::class => function (AfterImport $event) {
                    AfterImportEvent::dispatch($this->readed_file, $this->file_name, 'prensa');
                }
            ];
        } catch (\Throwable $e) {
            throw new Exception("Error inesperado: " . $e->getMessage());
        }
    }
}
