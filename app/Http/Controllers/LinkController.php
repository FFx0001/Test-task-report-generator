<?php

namespace App\Http\Controllers;

use App\Http\Services\FileService;
use App\Http\Utilities\ISPWiper;
//use http\Client\Response;
use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Facades\Storage;

class LinkController extends Controller
{
    public function createLink ($uuid)
    {
        $ispw = new ISPWiper();
        $uuid = $ispw->parseUuId($uuid);
        $fileService = new FileService();
        $fileService->setFileFolder("reports");
        $fileService->setFileContent("123123123");
      $file_name =  $fileService->createFile();
        return $this->response()->setContent($file_name)->build();
    }
    public function downloadFile($file_id)
    {
        $fileService = new FileService();
        $fileService->setFileFolder("reports");
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
        $file_path = $fileService->getPublicFilePath($file_id);
        return Storage::download($file_path, 'filename.pdf', $headers);
    }
}
