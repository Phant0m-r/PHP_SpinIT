<?php
require_once "classes/Request.php";
require_once "classes/Task.php";
require_once "requests/form.php";

$request = new Request;

/*
$task = show($id);
$task["is_complete"] = 1;
$action = update($task, $id);
$message = $action["message"];
*/

if ($request->id) {
    $request->is_complete = 1;

    $message = update($request, $request->id)["message"];
} else {
    $message = "Не выбрана запись для удаления";
}

header("Location: /index.php?message=$message");