<?php

namespace App\Http\Controllers;

use App\Enums\TypeOfMedium;
use App\Models\FileExport;
use App\Repositorys\BrandRepository;
use App\Repositorys\OriginsRepository;
use App\Repositorys\StatesRepository;
use Inertia\Inertia;
use Inertia\Response;

class ExportController extends Controller
{

    public function __construct(
        protected BrandRepository $brandRepository,
        protected OriginsRepository $originsRepository,
        protected StatesRepository $statesRepository
    ){}

    public function index(): Response
    {
        $files = FileExport::with('medium')->get();

        return Inertia::render('Reports/Index', [
            'files' => $files
        ]);
    }

    public function show(FileExport $fileExport): Response
    {
        $dataRequest = $fileExport->data;
        $mediumName = $fileExport->medium->name;
        $brands  = $this->brandRepository->findByIds($dataRequest['brands_id'] ?? []);
        $origins = $this->originsRepository->findOriginsByIds($dataRequest['origins_id'] ?? []);
        $states  = $this->statesRepository->findStatesByIds($dataRequest['states_id'] ?? []);

        $originName = [
            strtoupper(TypeOfMedium::Prensa->value)     => 'Medios de prensa',
            strtoupper(TypeOfMedium::Revista->value)    => 'Revistas',
            strtoupper(TypeOfMedium::OOH->value)        => 'Estados',
            strtoupper(TypeOfMedium::Television->value) => 'Canales'
        ];

        $originName = $originName[$mediumName];

        $originsToList = [
            strtoupper(TypeOfMedium::Prensa->value)     => $origins,
            strtoupper(TypeOfMedium::Revista->value)    => $origins,
            strtoupper(TypeOfMedium::OOH->value)        => $states,
            strtoupper(TypeOfMedium::Television->value) => []
        ];

        $originsToList = $originsToList[$mediumName];

        return Inertia::render('Reports/Show', [
            'fileExport' => $fileExport,
            'medium'     => $fileExport->medium,
            'brands'     => $brands,
            'origins'    => $originsToList,
            'originName' => $originName,
            'mediumName' => ucfirst(strtolower($mediumName))
        ]);
    }
}
