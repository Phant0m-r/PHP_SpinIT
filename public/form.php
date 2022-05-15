<?php

require_once __DIR__ . "/../bootstrap.php";

use Adil\SpinitPhp\Http\Request;
use Adil\SpinitPhp\Http\Taskcontroller;

    $message = null;
    $errors = null;
    $request = new Request;

    $taskController = new TaskController($request);

    $task = null;

    if ($request->request_type == "POST") {
        if ($request->id) {
            $action = $taskController->update();
        } else {
            $action = $taskController->create();
        }
        $message = $action["message"];
        $errors = $action["errors"];
    }

    if ($request->id) {
        $task = $taskController->show();
    }

    require_once __DIR__ . "/../resources/partials/head.php";
    notification($message);
?>
    <h1>Добавить задачу</h1>
<?php
    viewForm($errors, $task);
    require_once __DIR__ . "/../resources/partials/foot.php";
?>
