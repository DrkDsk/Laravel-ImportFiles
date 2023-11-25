<?php

namespace App\Factories;

use App\Exceptions\DuplicatedRowException;
use App\Interfaces\ValidateMediumInterface;
use App\Models\Register;
use App\Repositorys\GeneralRepository;
use App\Traits\importValidatorTrait;
use Illuminate\Database\Eloquent\Model;

class OOHFactory implements ValidateMediumInterface
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
    public function validate(array $row, string $readedFile_id): ?Model
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
        $orientacion      = $row['orientacion_seccioninicio'];
        $pagina           = $row['id_paginaduracion'];
        $vista_posicion   = $row['vista_posicion'];
        $direccion        = $row['direccion'];
        $latitud          = doubleval($row['latitud']);
        $longitud         = doubleval($row['longitud']);
        $mes              = $row['mes'];
        $version          = $row['version'];

        $uniqueKey = "{$orientacion}-{$pagina}-{$vista_posicion}-{$direccion}-{$latitud}-{$longitud}";
        $this->validateIfRowIsDuplicated($uniqueKey, $this->rowNumber);
        $this->insertRowNotDuplicated($uniqueKey);

        return Register::create([
            'readed_file_id'   => $readedFile_id,
            'insertion_id'     => $insertion->id,
            'supplier_id'      => $supplier ? $supplier->id : null,
            'category_id'      => $category ? $category->id : null,
            'brand_id'         => $brand ? $brand->id : null,
            'state_id'         => $state ? $state->id : null,
            'product_id'       => $product ? $product->id : null,
            'origin_id'        => $origin->id,
            'orientacion'      => $orientacion,
            'pagina'           => $pagina,
            'vista_posicion'   => $vista_posicion,
            'direccion'        => $direccion,
            'latitud'          => $latitud,
            'longitud'         => $longitud,
            'state_name'       => $state ? $state->name : $row['estado'],
            'mes'              => $mes,
            'version'          => $version
        ]);
    }
}
