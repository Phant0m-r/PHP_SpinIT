<?php

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

function create(Request $request)
{
    $errors = validate($request->parameters);

    if ($errors) {
        $message = "Не все поля заполнены";

        return [
            "message" => $message,
            "errors" => $errors
        ];
    }

    (new Task($request->parameters))->create();

    $message = "Данные формы сохранены";

    return [
        "message => $message",
        "errors" => $errors
    ];
}

function delete(int $id): string
{
    $task = new Task();
    $task->id = $id;

    $task->delete();

    return "Запись удалена";
}

function show(int $id): Task
{
    $task = (new Task(["id" => $id]))->find();

    return $task;
}

function update(Request $request, int $id): array
{
    $errors = validate($request->parameters);
    $bindings = [];
    $types = "";
    if ($errors) {
        $message = "Не все поля заполнены";

        return [
            "message" => $message,
            "errors" => $errors
        ];
    }
    (new Task(["id" => $id]))->update($request->parameters);

 /*   $connection = mysqli_connect(
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
*/
    $message = "Данные обновлены";

    return [
        "message" => $message,
        "errors" => $errors
    ];
}

function index(Request $request): ?array
{
    return (new Task())->get(
        $request->parameters
    );
}