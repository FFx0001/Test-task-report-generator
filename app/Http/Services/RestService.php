<?php


namespace App\Http\Services;

/**
 * Class RestService (class helper for create formatted json response api)
 * @package App\Http\Services
 */
class RestService
{
    private $content = [];
    private $success = true;
    private $error = "";
    private $status = 200;
    private $headers = [];
    function __construct() {
    }

    public function setContent($content=[]){$this->content=$content;return $this;}
    public function setSuccess($success=true){$this->success=$success;return $this;}
    public function setErrors($error=""){$this->error=$error;return $this;}
    public function setStatus($status=200){$this->status=$status;return $this;}
    public function setHeaders($headers=[]){$this->headers=$headers;return $this;}

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * required method to be included at the end of the call
     */
    public function build(){
        $ResponseFormat = [
            'success'=>$this->success,
            'errors'=>$this->error,
            'data'=>$this->content,
        ];
        $this->headers['Content-Type'] = 'application/json; charset=UTF-8';
        return response(json_encode($ResponseFormat, JSON_FORCE_OBJECT),$this->status,$this->headers);
    }
}
