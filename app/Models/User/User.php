<?php

namespace App\Models\User;
use App\Config\DB;


class User {
    private $db;
  //  private $table = "film";

    public function __construct(DB $db){
        $this->db = $db;
    }
    public function getUserById($id){
      return $this->db->executeSelectOneRow("SELECT u.id,u.first_name AS emp_first_name,u.last_name AS emp_last_name,u.username,u.email AS emp_email,u.imagePath,u.imagePathNew,u.idBoss,u.idSector,s.name,b.first_name AS boss_first_name,b.last_name AS boss_last_name,b.email AS boss_email,b.imagePath AS boss_imagePath,b.imagePathNew AS boss_imagePathNew FROM users u LEFT OUTER JOIN users b ON u.idBoss=b.id INNER JOIN sectors s ON u.idSector=s.idSector WHERE u.id=?",[$id]);
      }

    public function getUser($username,$pass){
    return $this->db->executeSelectOneRow("SELECT u.id,u.first_name AS emp_first_name,u.last_name AS emp_last_name,u.username,u.email AS emp_email,u.imagePath,u.imagePathNew,u.idBoss,u.idSector,s.name,b.first_name AS boss_first_name,b.last_name AS boss_last_name,b.email AS boss_email,b.imagePath AS boss_imagePath,b.imagePathNew AS boss_imagePathNew FROM users u LEFT OUTER JOIN users b ON u.idBoss=b.id INNER JOIN sectors s ON u.idSector=s.idSector WHERE u.username=? AND u.pass=MD5(?)",[$username,$pass]);
    }
    public function isBoss($userID){
      return $this->db->executeSelectOneRow("SELECT * FROM users WHERE idBoss=?",[$userID]);
    }
    public function getBoss($userID){
      return $this->db->executeSelectOneRow("SELECT u.id,u.first_name AS emp_first_name,u.last_name AS emp_last_name,u.username,u.email AS emp_email,u.idBoss,u.idSector,s.name,u.imagePath,u.imagePathNew FROM users u LEFT OUTER JOIN users b ON u.idBoss=b.id INNER JOIN sectors s ON u.idSector=s.idSector WHERE u.id=?",[$userID]);
    }
    public function insertUser(string $query, Array $params){
      return $this->db->executeOneRow($query,$params);
    }
    public function editUser(string $query, Array $params){
      return $this->db->executeOneRow($query,$params);
    }
    public function updatePicture(string $query, Array $params){
      return $this->db->executeOneRow($query,$params);
    }
}