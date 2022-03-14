<?php
function  parse(array $query = [] ): ?array
{
    $parameters = null;
    foreach ($query as $key => $value) {
        switch ($key) {
            default:
                $parameters[$key] = $value == "" ? null : $value;
        }
    }
    return $parameters;
}

function validate(array $parameters = null): ?array
{
    $errors = null;

    if (!$parameters) {
        return $errors;
    }


    foreach ($parameters as $key => $value) {
        if ($key != "id" && $value == "") {
            $errors[$key] = "Должно быть заполнено";
        }
    }
    return $errors;
}

function create(array $parameters): array
{
    $errors = validate($parameters);

    if ($errors) {
        $message = "Не все поля заполнены";

        return [
            "message" => $message,
            "errors" => $errors
        ];
    }

    $connection = mysqli_connect(
        "localhost",
        "adil",
        "password",
        "todolist"
    );
    $query = mysqli_prepare(
        $connection,
        "INSERT INTO tasks (description, priority) VALUES (?, ?)"
    );

    mysqli_stmt_bind_param($query, "ss", $parameters["description"], $parameters["priority"]);

    mysqli_stmt_execute($query);

    mysqli_close($connection);

    $message = "Данные формы сохранены";

    return [
        "message => $message",
        "errors" => $errors
    ];
}

function delete(int $id): string
{
    $connection = mysqli_connect(
        "localhost",
        "adil",
        "password",
        "todolist"
    );
    $statement = mysqli_prepare(
        $connection,
        "DELETE FROM tasks WHERE id = ?"
    );

    mysqli_stmt_bind_param($statement, "i", $id);

    mysqli_stmt_execute($statement);

    mysqli_close($connection);

    return "Запись удалена";
}

function show(int $id): array
{
    $connection = mysqli_connect(
        "localhost",
        "adil",
        "password",
        "todolist"
    );
    $statement = mysqli_prepare(
        $connection,
        "SELECT * FROM tasks WHERE id = ?"
    );
    mysqli_stmt_bind_param($statement, "i", $id);

    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    //$task = mysqli_fetch_array($result);

    $task = mysqli_fetch_array($result, MYSQLI_ASSOC);

    mysqli_close($connection);

    return $task;
}

function update(array $parameters, int $id): array
{
    $errors = validate($parameters);
    $bindings = [];
    $types = "";
    if ($errors) {
        $message = "Не все поля заполнены";

        return [
            "message" => $message,
            "errors" => $errors
        ];
    }

    $connection = mysqli_connect(
        "localhost",
        "adil",
        "password",
        "todolist"
    );

    $query = "UPDATE tasks SET ";

    $sets = [];

    foreach ($parameters as $key => $value) {
        if ($key != "id") {
            $sets[] = "$key = ?";

            switch (gettype($value)) {
                case "string":
                    $types .= "s";
                    break;

                case "boolean":
                    $types .="b";
                    break;

                case "integer":
                    $types .= "i";
                    break;
            }

            $bindings[] = $value;
        }
    }
    $query .= implode(", ", $sets);

    $query .= " WHERE id = ?";

    $types .= "i";
    $bindings[] = $id;

    $statement = mysqli_prepare(
        $connection,
        $query
    );
    mysqli_stmt_bind_param($statement, $types, ...$bindings);

    mysqli_stmt_execute($statement);
    mysqli_close($connection);

    $message = "Данные обновлены";

    return [
        "message" => $message,
        "errors" => $errors
    ];
}