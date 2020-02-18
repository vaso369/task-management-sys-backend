<?php
require_once "app/Config/autoload.php";
require "vendor/autoload.php";
use App\Controllers\Boss\BossController;
use App\Controllers\Messages\MessageController;
use App\Controllers\Tasks\TasksController;
use App\Controllers\User\UserController;
use \Firebase\JWT\JWT;

if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'register':
            $user = new UserController();
            $user->register($_POST);
            break;
        case 'login':
            $user = new UserController();
            $user->login($_POST);
            break;
    }
}

if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
    $secret_key = "YOUR_SECRET_KEY";
    $jwt = null;

    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];

    $arr = explode(" ", $authHeader);

    /*echo json_encode(array(
    "message" => "sd" .$arr[1]
    ));*/

    $jwt = $arr[1];

    if ($jwt) {

        try {

            $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

            // Access is granted. Add code of the operation here

            if (isset($_GET['page'])) {
                switch ($_GET['page']) {
                    case 'tasks':
                        $tasks = new TasksController();
                        $tasks->getAllTasks($_POST);
                        break;
                    case 'progress_tasks':
                        $tasks = new TasksController();
                        $tasks->getProgressTasks($_POST);
                        break;
                    case 'done_tasks':
                        $tasks = new TasksController();
                        $tasks->getDoneTasks($_POST);
                        break;
                    case 'update_done_task':
                        $tasks = new TasksController();
                        $tasks->updateDoneTasks($_POST);
                        break;
                    case 'edit_user':
                        $user = new UserController();
                        $user->editUser($_POST);
                        break;
                    case 'send_message':
                        $message = new MessageController();
                        $message->sendMessage($_POST);
                        break;
                    case 'upload_photo':
                        $user = new UserController();
                        $user->uploadPicture($_POST);
                        break;
                    case 'get_team':
                        $boss = new BossController();
                        $boss->getTeam($_GET);
                        break;
                }
            }

        } catch (Exception $e) {

            http_response_code(401);

            echo json_encode(array(
                "message" => "Access denied.",
                "error" => $e->getMessage(),
            ));
        }

    }

}
