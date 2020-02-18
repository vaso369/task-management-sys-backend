<?php

namespace App\Models\Messages;
use App\Config\DB;


class Message {
    private $db;

    public function __construct(DB $db){
        $this->db = $db;
    }
    public function sendMessage(string $query, Array $params){
        return $this->db->executeOneRow($query,$params);
    }
}