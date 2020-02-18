<?php
namespace App\Controllers\Messages;
use App\Models\Messages\Message;
use App\Config\DB;

class MessageController {   
    private $model;
    public function __construct(){
        $this->model = new Message(DB::instance());     
    }
    public function sendMessage($request){
        header("Content-type:application/json");
        $idEmployee=$request['idEmployee'];
        $idBoss=$request['idBoss'];
        $messageValue=$request['message'];
        $data=null;
        $message = new Message(DB::instance());
        $code=$message->sendMessage("INSERT INTO messages VALUES (NULL,?,?,?)",[$idEmployee,$idBoss,$messageValue]);
        if($code===200){
            http_response_code($code);
            echo json_encode([
                "message"=>"Message successfuly sent!"
            ]);
        }
        
    }
}