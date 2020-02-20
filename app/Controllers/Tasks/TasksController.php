<?php
namespace App\Controllers\Tasks;

use App\Config\DB;
use App\Models\Tasks\Tasks;
use PDOException;

class TasksController
{
    private $model;
    public function __construct()
    {
        $this->model = new Tasks(DB::instance());
    }
    public function getAllTasks($request)
    {
        $employeeId = $request['idEmployee'];
        $code = $request['code'];
        try {
            $tasks = $this->model->getAllTasks($employeeId, $code);
            \http_response_code(200);
            echo json_encode($tasks);
        } catch (PDOException $ex) {
            \http_response_code(500);
            echo json_encode([
                "message" => $ex->getMessage(),
            ]);
        }
    }
    public function getProgressTasks($request)
    {
        $employeeId = $request['idEmployee'];
        $code = $request['code'];
        try {
            $tasks = $this->model->getProgressTasks($employeeId, $code);
            \http_response_code(200);
            echo json_encode($tasks);
        } catch (PDOException $ex) {
            \http_response_code(500);
            echo json_encode([
                "message" => $ex->getMessage(),
            ]);
        }
    }
    public function getDoneTasks($request)
    {
        $employeeId = $request['idEmployee'];
        $code = $request['code'];
        try {
            $tasks = $this->model->getDoneTasks($employeeId, $code);
            \http_response_code(200);
            echo json_encode($tasks);
        } catch (PDOException $ex) {
            \http_response_code(500);
            echo json_encode([
                "message" => $ex->getMessage(),
            ]);
        }
    }
    public function updateDoneTasks($request)
    {
        header("Content-type:application/json");
        $employeeId = $request['idEmployee'];

        $taskId = $request['idTask'];
        try {
            $code = $this->model->updateDoneTasks($employeeId, $taskId);
            $tasks = $this->model->getProgressTasks($employeeId, "200");
            \http_response_code(204);
            echo json_encode([
                "message" => "Task updated successfuly!",
            ]);
        } catch (PDOException $ex) {
            \http_response_code(500);
            echo json_encode([
                "message" => $ex->getMessage(),
            ]);
        }

    }
    public function addTask($request)
    {
        $idBoss = $request['idBoss'];
        $idEmployee = $request['idEmployee'];
        $taskName = $request['taskName'];
        $description = $request['description'];
        $uniqueId = $request['idSend'];
        $date = $request['date'];

        $priority = $request['priority'];
        try {
            $idAdded = $this->model->addTask($idBoss, $idEmployee, $taskName, $description, $uniqueId, $date, $priority);
            \http_response_code(201);
            echo json_encode([
                "message" => "Task created successfuly",
                "iss" => $idAdded,
            ]);
        } catch (PDOException $ex) {
            \http_response_code(500);
            echo json_encode([
                "message" => $ex->getMessage(),
            ]);
        }

    }
}
