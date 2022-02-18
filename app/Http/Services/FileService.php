<?php


namespace App\Http\Services;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
    public function setFileFolder($file_folder="all"){$this->file_folder=$file_folder;return $this;}

    /**
     * @param $file_content
     * @return $this
     */
    public function setFileContent($file_content){$this->file_content=$file_content;return $this;}

    /**
     * creating file with content on the local folder
     */
    public function createFile(){
        $temp_file_name = $this->generateFileName();
        Storage::disk('public')->put($this->getSubFolder()."//".$this->file_folder."//".$temp_file_name, $this->file_content);
        return $temp_file_name;
    }

    function getPublicFilePath($file_name){
        return  "public//" . $this->getSubFolder()."//".$this->file_folder."//".$file_name;
    }

    function getFileRaw($file_name)
    {
       return Storage::disk('public')->get($this->getSubFolder()."//".$this->file_folder . "//" . $file_name);
    }

    private function getSubFolder(){
        return ENV("FILE_STORAGE_FOLDER","Uploads");
    }
    private function generateFileName(){
        return hash('sha256', Str::uuid()->toString());
    }
}
