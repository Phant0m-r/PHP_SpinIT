<?php

require_once __DIR__ . "/../bootstrap.php";

use Adil\SpinitPhp\Http\Request;
use Adil\SpinitPhp\Http\Taskcontroller;

$request = new Request;

$taskController = new TaskController($request);

if ($request->id) {
    $request->is_complete = 1;

    try {
        $message = $taskController->update()["message"];
    } catch (Exception $exception) {
        $message = "Не удалось обновить задачу";
    }
} else {
    $message = "Не выбрана запись для удаления";
}

header("Location: /index.php?message=$message");