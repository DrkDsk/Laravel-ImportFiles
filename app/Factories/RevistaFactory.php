<?php

namespace App\Factories;

use App\Exceptions\DuplicatedRowException;
use App\Interfaces\ValidateMediumInterface;
use App\Models\Register;
use App\Repositorys\GeneralRepository;
use App\Traits\importValidatorTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class RevistaFactory implements ValidateMediumInterface
{

    use importValidatorTrait;

    private GeneralRepository $generalRepository;
    private int $rowNumber;

    public function __construct(int $rowNumber)
    {
        $this->generalRepository = new GeneralRepository();
        $this->rowNumber = $rowNumber;
    }

    /**
     * @throws DuplicatedRowException
     */
    public function validate(array $row, string $readedFile_id): null|Model
    {
        $medium           = $this->generalRepository->createMediumIfNotExists($row['medio']);
        $country          = $this->generalRepository->createCountryIfNotExists($row['pais']);
        $state            = $this->generalRepository->getStateByAlias($row['estado'], $country->id);
        $insertion        = $this->generalRepository->createInsertionIfNotExists($row['tipo_insercion'], $medium->id);
        $supplier         = $this->generalRepository->createSupplierIfNotExists($row['proveedor'], $medium->id);
        $brand            = $this->generalRepository->createBrandIfNotExists($row['marca']);
        $product          = $this->generalRepository->createProductIfNotExists($row['producto'], $medium->id);
        $category         = $this->generalRepository->createCategoryIfNotExists($row['categoria']);
        $origin           = $this->generalRepository->createOriginIfNotExists($row['avenida_titulo_canal_estacion'],$medium->id);
        $pagina           = $row['id_paginaduracion'];
        $vista_posicion   = $row['vista_posicion'];
        $publication_date = Carbon::instance(Date::excelToDateTimeObject( $row['longitud']))->format("Y-m-d");
        $mes              = $row['mes'];
        $version          = $row['version'];
        $testigo          = $row['testigo'];

        $uniqueKey = "{$insertion}-{$pagina}-{$vista_posicion}-{$publication_date}-{$testigo}";
        $this->validateIfRowIsDuplicated($uniqueKey, $this->rowNumber);
        $this->insertRowNotDuplicated($uniqueKey);

        return Register::create([
            'readed_file_id'   => $readedFile_id,
            'insertion_id'     => $insertion->id,
            'supplier_id'      => $supplier->id,
            'category_id'      => $category->id,
            'brand_id'         => $brand->id,
            'state_id'         => $state ? $state->id : null,
            'product_id'       => $product->id,
            'origin_id'        => $origin->id,
            'pagina'           => $pagina,
            'vista_posicion'   => $vista_posicion,
            'publicacion_date' => $publication_date,
            'state_name'       => $state ? $state->name : $row['estado'],
            'mes'              => $mes,
            'version'          => $version,
            'testigo'          => $testigo
        ]);
    }
}
