<?php

namespace App\Models\Tasks;
use App\Config\DB;


class Tasks {
    private $db;
    public function __construct(DB $db){
        $this->db = $db;
    }

    public function getAllTasks($employeeId,$code){
        if($code==="200"){
             $queryId='t.idEmployee';

        }
        else{
             $queryId='t.idBoss';

        }
    return $this->db->executeQueryWithParam("SELECT t.idTask,t.idBoss,t.idEmployee,t.uniqueId,t.task_name,t.description,t.date,t.priority,t.done,u.first_name AS emp_first_name,u.last_name AS emp_last_name,u.imagePath,u.imagePathNew FROM tasks t INNER JOIN users u ON t.idEmployee=u.id WHERE $queryId=?",[$employeeId]);
    }
    public function getProgressTasks($employeeId,$code){
        if($code==="200"){
            $queryId='t.idEmployee';

       }
       else{
            $queryId='t.idBoss';

       }
   return $this->db->executeQueryWithParam("SELECT t.idTask,t.idBoss,t.idEmployee,t.uniqueId,t.task_name,t.description,t.date,t.priority,t.done,u.first_name AS emp_first_name,u.last_name AS emp_last_name,u.imagePath,u.imagePathNew FROM tasks t INNER JOIN users u ON t.idEmployee=u.id WHERE $queryId=? AND done=0",[$employeeId]);
    }
    public function getDoneTasks($employeeId,$code){
        if($code==="200"){
            $queryId='t.idEmployee';

       }
       else{
            $queryId='t.idBoss';

       }
   return $this->db->executeQueryWithParam("SELECT t.idTask,t.idBoss,t.idEmployee,t.uniqueId,t.task_name,t.description,t.date,t.priority,t.done,u.first_name AS emp_first_name,u.last_name AS emp_last_name,u.imagePath,u.imagePathNew FROM tasks t INNER JOIN users u ON t.idEmployee=u.id WHERE $queryId=? AND done=1",[$employeeId]);
    }
    public function updateDoneTasks($employeeId,$taskId){
         $this->db->executeOneRow("UPDATE tasks SET done=1 WHERE idEmployee=? AND idTask=?",[$employeeId,$taskId]);
    }
}