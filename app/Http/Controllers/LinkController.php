<?php

namespace App\Http\Controllers;

use App\Http\Services\FileService;
use App\Http\Services\ReportService;
use App\Http\Utilities\ISPWiper;
use App\Http\Utilities\ReportExportTypes;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LinkController extends Controller
{
    public function createLink($file_record_id)
    {
        $db_response = (new Link)->registerLinkToFile($file_record_id);
        if($db_response["status"]){
           return $db_response["req_id"];
        }else{
           return $this->response()->setStatus(500)->setErrors($db_response["info"])->build();
        }
    }

    /**
     * This method finding and download file from link
     * @param $link_record_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadFile($link_record_id)
    {
        $link_record_id = (new ISPWiper())->parseUuId($link_record_id);
       $db_response = (new Link)->getLinkParamsFromLinkRecId($link_record_id);
       if($db_response["status"]){
           $fileFields = (new FileController())->getFileFields($db_response["file_req_id"]);
           $fileService = new FileService();
           $fileService->setFileFolder($fileFields["sub_folder"]);
           $content_type = (new ReportExportTypes())->getContentType($fileFields["extension"]);
           $headers = [ 'Content-Type' => $content_type ];
           $file_path = $fileService->getPublicFilePath($fileFields["system_name"]);
           return Storage::download($file_path, $fileFields["display_name"].".".$fileFields["extension"], $headers);
       }else{
          return $this->response()->setStatus(500)->setErrors($db_response["info"])->build();
       }
    }


}
