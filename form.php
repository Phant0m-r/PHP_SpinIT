<?php
    require_once "requests/form.php";

    $message = null;
    $parameters = parse($_POST);
    $errors = validate($parameters);

    $id = (int)$_GET["id"] ?? null;
    $task = null;

    if ($parameters) {
        if ($parameters["id"]) {
            $action = update($parameters, $parameters["id"]);
        } else {
            $action = create($parameters);
        }
        $message = $action["message"];
        $errors = $action["errors"];
    }

    if ($id) {
        $task = show($id);
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
    form_create($errors, $task);
    require_once "partials/foot.php";
?>
