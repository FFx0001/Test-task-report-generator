<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;
    use Uuids;

    protected $fillable = [
        'id',
        'file_id',
    ];

    /**
     * Get file id from link id
     * @param $link_record_id
     * @return array
     */
    public function getLinkParamsFromLinkRecId($link_record_id)
    {
        $result = ["status" => false, "file_req_id" => -1, "info" => ""];
        if (!isset($link_record_id)) { $result["info"] = "Error mismatch link_record_id"; return $result; }
        $link = Link::where("id","=",$link_record_id)->first();
        if($link){
            $result["file_req_id"] = $link->file_id;
            $result["status"] = true;
        }else{
            $result["info"] = "Link not found by entered id";
        }
        return $result;
    }

    /**
     * save file info to table
     * @param $file_record_id
     * @return array
     */
    public function registerLinkToFile($file_record_id){
        $result = ["status"=>false,"req_id"=>-1,"info"=>""];
        if(!isset($file_record_id)){$result["info"]="Error mismatch file_record_id"; return $result;}
        $link = new Link;
        $link->file_id = $file_record_id;
        if($link->save()) {
            $result["status"]=true;
            $result["req_id"]=$link->id;
            return $result;
        }else{
            $result["info"]="DB Save error";
            return $result;
        }
    }
}
