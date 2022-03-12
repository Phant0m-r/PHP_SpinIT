<?php
require_once "requests/form.php";

$id = (int)$_GET["id"] ?? null;

if ($id) {
    $message = delete($id);
} else {
    $message = "Не выбрана запись для удаления";
}

header("Location: /index.php?message=$message");