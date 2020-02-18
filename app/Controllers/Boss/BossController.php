<?php
namespace App\Controllers\Boss;
use App\Models\Boss\Boss;
use App\Config\DB;

class BossController {   
    private $model;
    public function __construct(){
        $this->model = new Boss(DB::instance());     
    }
    public function getTeam($request){
        $idBoss=$request['idBoss'];
        $team = $this->model->getTeam($idBoss);
        echo json_encode($team);
        
    }
}