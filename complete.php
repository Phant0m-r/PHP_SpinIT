<?php
require_once "classes/Request.php";
require_once "classes/Task.php";
require_once "classes/TaskController.php";

$request = new Request;

$taskController = new TaskController($request);

if ($request->id) {
    $request->is_complete = 1;

    $message = $taskController->update()["message"];
} else {
    $message = "Не выбрана запись для удаления";
}

header("Location: /index.php?message=$message");