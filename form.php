<?php

require_once "classes/Request.php";
require_once "classes/Task.php";
require_once "requests/form.php";

    $message = null;
    $errors = null;
    $request = new Request;

    $task = null;

    if ($request->request_type == "POST") {
        if ($request->id) {
            $action = update($request, $request->id);
        } else {
            $action = create($request);
        }
        $message = $action["message"];
        $errors = $action["errors"];
    }

    if ($request->id) {
        $task = show($request->id);
    }

    require_once "partials/head.php";
    require_once "partials/myVardump.php";
    require_once "partials/menu.php";
    require_once "partials/notification.php";
    require_once "partials/form.php";
    notification($message);
?>
    <h1>Добавить задачу</h1>
<?php
    viewForm($errors, $task);
    require_once "partials/foot.php";
?>
