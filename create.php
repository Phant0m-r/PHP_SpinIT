<?php
    require_once "requests/form.php";

    $errors = [];
    $message = null;

    if (count($_POST) > 0) {
        $errors = post_parse($errors, $_POST);
        $message = errors_parse($errors);
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
    $task = null;
    form_create($errors, $task);
    require_once "partials/foot.php";
?>
