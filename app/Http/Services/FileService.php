<?php


namespace App\Http\Services;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;

/**
 * Class FileService
 * @package App\Http\Services
 * Creates an anonymous file in the public storage (anonymization helps protect against malicious code execution by directly accessing the file via a link)
 */
class FileService
{
    private $file_content = null;
    private $file_folder = null;

    /**
     * @param string $file_folder
     * @return $this
     * select parent folder for creating file Public/Uploads...
     */
    public function setFileFolder($file_folder="Files"){$this->file_folder=$file_folder;return $this;}

    /**
     * @param $file_content
     * @return $this
     */
    public function setFileContent($file_content){$this->file_content=$file_content;return $this;}

    /**
     * creating file with content on the public folder
     * @return array ["status"(bool),"system_file_name"(string),"public_file_path"(string),"info"(string)]
     */
    public function createFile(){
        $result = ["status"=>false,"system_file_name"=>"","file_folder"=>"","public_file_path"=>"","info"=>""];
        if($this->file_folder == null) {
            $result["info"]="file folder not initialized";
            return $result;
        }
        if($this->file_content == null) {
            $result["info"]="file content is empty";
            return $result;
        }
        $system_file_name = $this->generateFileName();
        Storage::disk('public')->put("Uploads"."//".$this->file_folder."//".$system_file_name, $this->file_content);
        if(strlen($this->getFileRaw($system_file_name))>0){
            $result["status"]=true;
            $result["system_file_name"]=$system_file_name;
            $result["public_file_path"]=$this->getPublicFilePath($system_file_name);
            return $result;
        }else{
            $result["info"]="error on saving file";
            return $result;
        }
    }

    /**
     * Get parent public file path for downloading
     * @param $file_name
     * @return string
     */
    function getPublicFilePath($system_file_name){
        return  "public/"."Uploads"."/".$this->file_folder."//".$system_file_name;
    }

    /**
     * Get raw file content from system_file_name
     * @param $file_name
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    function getFileRaw($file_name)
    {
       return Storage::disk('public')->get("Uploads"."//".$this->file_folder . "//" . $file_name);
    }


    /**
     * Generate unique name for file
     * @return string
     */
    private function generateFileName(){
        return hash('sha256', Str::uuid()->toString());
    }
}
