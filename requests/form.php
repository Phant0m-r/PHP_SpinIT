<?php
function  post_parse( array $errors, array $query ) : array
{
    foreach ($query as $key => $value) {
        if ($value == "") {
            $errors[$key] = "Должно быть заполнено";
        }
    }
    return $errors;
}

function errors_parse (array $errors): string
{

    if ($errors) {
        $message = "Не все поля заполнены";
    } else {
        $message = "Данные формы сохранены";
    }
    return $message;
}