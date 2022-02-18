<?php
namespace App\Http\Utilities;

class ReportExportTypes
{
    private $types = [
        "pdf" => 'application/pdf',
        "xlsx" => 'application/vnd.ms-excel',
        "docx" => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];

    public function getContentType($format){
        $result = ["status"=>false,"content_type"=>"","info"=>""];
        if($this->types[$format]) {
            $result["status"] = true;
            $result["content_type"] = $this->types[$format];
        }else{
            $result["info"] = "format not found";
        }
        return $result;
    }
}
