<?php

namespace App\Http\Controllers;

use App\Http\Services\FileService;
use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    /**
     * Create new file on public storage
     * @param $file_display_name
     * @param $file_extension
     * @param $file_sub_folder_name
     * @param $raw_content
     * @return string (req_id)
     */
    public function CreatePublicFile($file_display_name,$file_extension,$file_sub_folder_name,$raw_content)
    {
        $fileService = new FileService();
        $fileService->setFileFolder($file_sub_folder_name);
        $fileService->setFileContent($raw_content);
        $file_data =  $fileService->createFile();
        if($file_data["status"]) {
            $db_response = (new File)->registerFile($file_data["system_file_name"], $file_extension, $file_display_name,$file_sub_folder_name);
            if($db_response["status"]){
                return $db_response["req_id"];
            }else{
                $this->response()->setSuccess(false)->setErrors($db_response["info"])->setStatus(500)->build();
            }
        }else{
            $this->response()->setSuccess(false)->setErrors($file_data["info"])->setStatus(500)->build();
        }
    }

    /**
     * Get raw file content by file req_id
     * @param $req_id
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getRawFile($req_id){
       $db_response =  (new File)->getFieldsByReqId($req_id);
       if($db_response["status"]) {
           $fileService = new FileService();
           $fileService->setFileFolder($db_response["sub_folder"]);
          $raw_data = $fileService->getFileRaw($db_response["system_name"]);
          if(!empty($raw_data)){
              return $raw_data;
          }else{
              $this->response()->setSuccess(false)->setErrors("File not found")->setStatus(404)->build();
          }
       }else{
           $this->response()->setSuccess(false)->setErrors($db_response["info"])->setStatus(500)->build();
       }
    }

    /**
     * Proxy method
     * @param $id
     * @return array
     */
    public function getFileFields($id){
       $db_response = (new File())->getFieldsByReqId($id);
       if($db_response["status"]){
           return $db_response;
       }else{
           $this->response()->setSuccess(false)->setErrors($db_response["info"])->setStatus(500)->build();
       }
    }
}
