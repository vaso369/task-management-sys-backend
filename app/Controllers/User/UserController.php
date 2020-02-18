<?php
namespace App\Controllers\User;

use App\Config\DB;
use App\Models\User\User;

//use \Firebase\JWT\JWT;

class UserController
{
    private $model;
    public function __construct()
    {
        $this->model = new User(DB::instance());
    }
    public function getUser()
    {
        $user = $this->model->getUser();
        echo json_encode($user);
    }
    public function register($request)
    {
        header("Content-type:application/json");
        $code = 404;
        $data = null;

        $first_name = $request['firstName'];
        $last_name = $request['lastName'];
        $email = $request['email'];
        $username = $request['username'];
        $pass = md5($request['pass']);
        $uloga = 2;
        $defaultImage = "assets/avatar-placeholder.png";

        $errors = [];
        $reFirstLastName = "/^[A-Z][a-z]{2,15}$/";
        $rePass = "/^[A-z0-9]{6,20}$/";

        if (!$first_name) {
            array_push($errors, "You have to enter name!");

        } elseif (!preg_match($reFirstLastName, $first_name)) {
            array_push($errors, "Wrong name format!");
        }
        if (!$last_name) {
            array_push($errors, "You have to enter last name!");

        } elseif (!preg_match($reFirstLastName, $last_name)) {
            array_push($errors, "Wrong name format!");
        }
        if (!$username) {
            array_push($errors, "You have to enter username!");

        }
        if (!$_POST['pass']) {
            array_push($errors, "You have to enter password!");
        } elseif (!preg_match($rePass, $_POST["pass"])) {
            array_push($errors, "Wrong password format!");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Wrong email format!");
        }
        if (count($errors)) {
            $code = 422;
            $data = $errors;

        } else {
            $user = new User(DB::instance());
            $code = $user->insertUser("INSERT INTO users VALUES (NULL,?,?,?,?,?,2,?,?,0,4,5)", [$first_name, $last_name, $username, $email, $pass, $defaultImage, $defaultImage]);
            http_response_code($code);
            echo json_encode($data);
        }
    }

    public function login($request)
    {
        header("Content-type:application/json");
        $code = 404;
        $username = $request['username'];
        $password = $request['pass'];

        $user = new User(DB::instance());
        $employee = $user->getUser($username, $password);
        $isBoss = $user->isBoss($employee->id);
        $boss = $user->getBoss($employee->id);
        $boss->code = "201";
        $employee->code = "200";
        if ($isBoss) {

            $secret_key = "YOUR_SECRET_KEY";
            $issuer_claim = "THE_ISSUER"; // this can be the servername
            $audience_claim = "THE_AUDIENCE";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim; //not before in seconds
            $expire_claim = $issuedat_claim + 1200; // expire time in seconds
            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
            );

            http_response_code(200);

            $jwt = JWT::encode($token, $secret_key);
            echo json_encode(
                array(
                    "message" => "Successful login.",
                    "jwt" => $jwt,
                    "expireAt" => $expire_claim,
                    "user" => $boss,
                ));
            //     echo json_encode($boss);

        } elseif ($employee) {

            $secret_key = "YOUR_SECRET_KEY";
            $issuer_claim = "THE_ISSUER"; // this can be the servername
            $audience_claim = "THE_AUDIENCE";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim; //not before in seconds
            $expire_claim = $issuedat_claim + 1200; // expire time in seconds
            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
            );

            http_response_code(200);

            $jwt = JWT::encode($token, $secret_key);
            echo json_encode(
                array(
                    "message" => "Successful login.",
                    "jwt" => $jwt,
                    "expireAt" => $expire_claim,
                    "user" => $employee,
                ));

        } else {
            // $_SESSION['errors'] ="Korisnik nije registrovan!";
            echo json_encode([
                "message" => "Nema korisnika",
            ]);
        }

    }
    public function logout()
    {
        header("Content-type:application/json");
        unset($_SESSION['user']);
        echo json_encode([
            "message" => "logged out",
        ]);
    }
    public function editUser($request)
    {
        header("Content-type:application/json");
        $code = 404;
        $data = null;
        $idEmployee = $request['idEmployee'];
        $first_name = $request['firstName'];
        $last_name = $request['lastName'];
        $email = $request['email'];
        $username = $request['username'];
        $pass = md5($request['pass']);
        $uloga = 2;

        $errors = [];
        $reFirstLastName = "/^[A-Z][a-z]{2,15}$/";
        $rePass = "/^[A-z0-9]{6,20}$/";

        if (!$first_name) {
            array_push($errors, "You have to enter name!");

        } elseif (!preg_match($reFirstLastName, $first_name)) {
            array_push($errors, "Wrong name format!");
        }
        if (!$last_name) {
            array_push($errors, "You have to enter last name!");

        } elseif (!preg_match($reFirstLastName, $last_name)) {
            array_push($errors, "Wrong name format!");
        }
        if (!$username) {
            array_push($errors, "You have to enter username!");

        }
        if (!$_POST['pass']) {
            array_push($errors, "You have to enter password!");
        } elseif (!preg_match($rePass, $_POST["pass"])) {
            array_push($errors, "Wrong password format!");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Wrong email format!");
        }
        if (count($errors)) {
            $code = 422;
            $data = $errors;

        } else {
            $user = new User(DB::instance());
            $code = $user->editUser("UPDATE users SET first_name=?,last_name=?,username=?,email=?,pass=? WHERE id=?", [$first_name, $last_name, $username, $email, $pass, $idEmployee]);
            // if($code === 200){
            //     $data=[
            //         "message" => "Succesful insert"
            //     ]
            // }

        }
        http_response_code($code);
        echo json_encode($data);
    }
    public function uploadPicture($request)
    {

        header("Content-type:application/json");
        if ($_FILES["file"]["name"] != '') {
            $code = 404;
            $idEmployee = $request['idEmployee'];
            $file_name = $_FILES['file']['name'];
            $file_tmpLocation = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];
            $dimensions = getimagesize($file_tmpLocation);
            $width = $dimensions[0];
            $height = $dimensions[1];

            $existingPicture = null;
            switch ($file_type) {
                case 'image/jpeg':
                    $existingPicture = imagecreatefromjpeg($file_tmpLocation);
                    break;
                case 'image/png':
                    $existingPicture = imagecreatefrompng($file_tmpLocation);
                    break;
            }

            $newWidth = 150;
            $newHeight = 150;

            $newPicture = imagecreatetruecolor($newWidth, $newHeight);

            imagecopyresampled($newPicture, $existingPicture, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            // UPLOAD NOVE SLIKE
            $picName = time() . $file_name;
            $pathNewPicture = 'assets/new_' . $picName;

            switch ($file_type) {
                case 'image/jpeg':
                    imagejpeg($newPicture, 'app/' . $pathNewPicture, 75);
                    break;
                case 'image/png':
                    imagepng($newPicture, 'app/' . $pathNewPicture);
                    break;
            }

            $pathOriginalPicture = 'assets/' . $picName;

            if (move_uploaded_file($file_tmpLocation, 'app/' . $pathOriginalPicture)) {

                try {
                    $user = new User(DB::instance());
                    $isUpdated = $user->updatePicture("UPDATE users SET imagePath=?,imagePathNew=? WHERE id=?", [$pathOriginalPicture, $pathNewPicture, $idEmployee]);

                    if ($isUpdated) {
                        $userData = $user->getUserById($idEmployee);
                        if ($userData->idBoss === 0) {
                            $userData->code = "201";
                        } else {
                            $userData->code = "200";
                        }

                        echo json_encode($userData);
                        $code = 200;
                    }

                } catch (PDOException $ex) {
                    $code = 500;
                }
            }

            // brisanje iz memorije
            imagedestroy($existingPicture);
            imagedestroy($newPicture);
            //  move_uploaded_file($_FILES["file"]["tmp_name"], $location);

        }
    }
}
