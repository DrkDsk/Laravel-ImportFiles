<?php

namespace App\Services;

use App\Models\FileExport;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileSystemService {

    public function store(string $path_image)
    {
        $filename = time().'.'.request()->image->getClientOriginalExtension();
        return request()->image->storeAs($path_image, $filename, ['disk' => 'public']);
    }

    public function delete(string $imagePath): void
    {
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }

    public function downloadReport(FileExport $fileExport): BinaryFileResponse|bool
    {
        if ($fileExport->filePath) {
            $headers = array("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet‌​ml.sheet");
            return response()->download($fileExport->filePath, date('d-m-Y-H-i-s') . ".xlsx", $headers);
        }

        return false;
    }
}
