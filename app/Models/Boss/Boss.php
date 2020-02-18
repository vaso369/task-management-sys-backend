<?php

namespace App\Models\Boss;
use App\Config\DB;


class Boss {
    private $db;
    public function __construct(DB $db){
        $this->db = $db;
    }
    public function getTeam($idBoss){
        return $this->db->executeQueryWithParam("SELECT * FROM users WHERE idBoss=?",[$idBoss]);
    }
}