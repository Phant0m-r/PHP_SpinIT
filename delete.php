<?php
require_once "classes/Request.php";
require_once "classes/Task.php";
require_once "requests/form.php";

$request = new Request;

if ($request->id) {
    $message = delete($request->id);
} else {
    $message = "Не выбрана запись для удаления";
}

header("Location: /index.php?message=$message");