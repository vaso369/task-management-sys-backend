<?php
namespace App\Controllers\Messages;

use App\Config\DB;
use App\Models\Messages\Message;
use PDOException;

class MessageController
{
    private $model;
    public function __construct()
    {
        $this->model = new Message(DB::instance());
    }
    public function sendMessage($request)
    {
        header("Content-type:application/json");
        $idEmployee = $request['idEmployee'];
        $idBoss = $request['idBoss'];
        $messageValue = $request['message'];
        $data = null;
        $message = new Message(DB::instance());
        try {
            $isInserted = $message->sendMessage("INSERT INTO messages VALUES (NULL,?,?,?)", [$idEmployee, $idBoss, $messageValue]);
            if ($isInserted) {
                http_response_code(201);
                echo json_encode([
                    "message" => "Message successfuly sent!",
                ]);
            }
        } catch (PDOException $ex) {
            \http_response_code(500);
            echo json_encode([
                "message" => $ex->getMessage(),
            ]);
        }

    }
}
