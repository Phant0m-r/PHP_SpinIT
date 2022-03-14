<?php
require_once "requests/form.php";

$id = (int)$_GET["id"] ?? null;

$task = show($id);

$task["is_complete"] = 1;
//$parameters["filter"] = $task;
$action = update($task, $id);
$message = $action["message"];

header("Location: /index.php?message=$message");