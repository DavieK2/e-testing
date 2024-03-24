<?php

namespace App\Modules\SchoolManager\Services;

use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;

class UploadCSVService {

    public function saveFileToLocalDiskAndReturnFirstRowWithPath($path, $file)
    {
        $upload = Storage::disk('local')->putFile($path, $file);

        $rows = SimpleExcelReader::create(storage_path("app/".$upload))->take(1)->getRows()->toArray();
        
        return  ['key' => $upload, 'headings' => $rows[0] ];
    }
}