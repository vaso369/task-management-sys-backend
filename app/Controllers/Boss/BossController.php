<?php
namespace App\Controllers\Boss;

use App\Config\DB;
use App\Models\Boss\Boss;
use PDOException;

class BossController
{
    private $model;
    public function __construct()
    {
        $this->model = new Boss(DB::instance());
    }
    public function getTeam($request)
    {
        try {
            $idBoss = $request['idBoss'];
            $team = $this->model->getTeam($idBoss);
            echo json_encode($team);
            \http_response_code(200);
        } catch (PDOException $ex) {
            \http_response_code(500);
            echo json_encode([
                "message" => $ex->getMessage(),
            ]);
        }

    }

}
