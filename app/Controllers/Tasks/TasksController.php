<?php
namespace App\Controllers\Tasks;
use App\Models\Tasks\Tasks;
use App\Config\DB;

class TasksController {   
    private $model;
    public function __construct(){
        $this->model = new Tasks(DB::instance());     
    }
    public function getAllTasks($request){
        $employeeId = $request['idEmployee'];
        $code=$request['code'];
   
        $tasks = $this->model->getAllTasks($employeeId,$code);
        echo json_encode($tasks);
    }
    public function getProgressTasks($request){
        $employeeId = $request['idEmployee'];
        $code=$request['code'];
        $tasks = $this->model->getProgressTasks($employeeId,$code);
        echo json_encode($tasks);
    }
    public function getDoneTasks($request){
        $employeeId = $request['idEmployee'];
        $code=$request['code'];
        $tasks = $this->model->getDoneTasks($employeeId,$code);
        echo json_encode($tasks);
    }
    public function updateDoneTasks($request){
        $employeeId = $request['idEmployee'];
        
        $taskId = $request['idTask'];
        $code = $this->model->updateDoneTasks($employeeId,$taskId);
        $tasks = $this->model->getProgressTasks($employeeId);
        echo json_encode($tasks);
    }
}