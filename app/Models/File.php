<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use Uuids;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'system_name',
        'extension',
        'display_name',
        'sub_folder',
    ];

    /**
     * @param $req_id
     * @return array ["status"(bool),"system_name"(string),"sub_folder"(string),"extension"(string),"display_name"(string),"info"(string)"]
     */
    public function getFieldsByReqId($file_req_id){
        $result = ["status"=>false,"system_name"=>"","sub_folder"=>"","extension"=>"","display_name"=>"","info"=>""];
        if(isset($file_req_id)){
            $file = File::where("id","=",$file_req_id)->first();
            if($file){
                $result["system_name"] = $file->system_name;
                $result["extension"] = $file->extension;
                $result["display_name"] = $file->display_name;
                $result["sub_folder"] = $file->sub_folder;
                $result["status"] = true;
            }else{
                $result["info"] = "File not found by entered id";
            }
        }else{
            $result["info"] = "Error mismatch req_id";
        }
        return $result;
    }

    /**
     * Create record on db for file
     * @param $system_name
     * @param $extension
     * @param $display_name
     * @param $sub_folder
     * @return array ["status"(bool),"req_id"(integer),"info"(string)]
     */
    public function registerFile($system_name, $extension, $display_name, $sub_folder){
        $result = ["status"=>false,"req_id"=>-1,"info"=>""];
        if(!isset($system_name)){$result["info"]="Error mismatch system_name_value"; return $result;}
        if(!isset($extension)){$result["info"]="Error mismatch extension"; return $result;}
        if(!isset($display_name)){$result["info"]="Error mismatch display_name"; return $result;}
        if(!isset($sub_folder)){$result["info"]="Error mismatch sub_folder"; return $result;}
        $file = new File;
        $file->system_name = $system_name;
        $file->extension = $extension;
        $file->display_name = $display_name;
        $file->sub_folder = $sub_folder;
        if($file->save()) {
            $result["status"]=true;
            $result["req_id"]=$file->id;
            return $result;
        }else{
            $result["info"]="DB Save error";
            return $result;
        }
    }

}
