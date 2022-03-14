<?php

function filterParam(string $field, $value): ?string
{
    switch ($field) {

        case "priority":
            $value = $value == "all"
                ? null
                : $value;
            break;

        case "is_complete":
            if (
                $value == "1"
                || $value == "0"
            ) {
                //$value = (boolean)$value;
                $value = (int)$value;
            } else {
                $value = null;
            }
            break;
/*
        case "column":
            $value = $value == "none"
                ? null
                : $value;
            break;
*/
        default:
            $value = $value == ""
                ? null
                : $value;
    }
    return $value;
}

function parse(array $query = []): ?array
{
    foreach ($query as $group => $params) {
        switch ($group) {
            case "sort":
            case "filter":
                foreach ($params as $field => $value) {
                    $value = filterParam($field, $value);

                    if ($value != null) {
                        $parameters[$group][$field] = $value;
                    }
                }
                break;

            default:
                $parameters[$group] = $params;
                break;
        }
    }
    return $parameters;
}

function loadTasks(array $parameters = null): ?array
{
    $tasks = null;
    $bindings = null;
    $types = null;

    $connection = mysqli_connect(
        "localhost",
        "adil",
        "password",
        "todolist"
    );

    $query = "SELECT * FROM tasks ";

    if ($parameters) {
        $bindings = [];
        foreach ($parameters as $group =>$fields) {
            switch ($group) {
                case "filter":
                    if (count($fields) > 0) {
                        $query .= "WHERE ";

                        $clauses = [];

                        foreach ($fields as $key => $value) {
                            $clauses[] = "$key = ?";
                            $types .= "s";
                            $bindings[] = $value;
                        }

                        $query .= implode(" AND ", $clauses);
                    }
                    break;

                case "sort":
                    foreach ($fields as $key => $value) {
                        switch ($key) {

                            case "column":
                                if ($value == "none") {
                                    $query .= " ORDER BY id";
                                } else {
                                    $query .= " ORDER BY $value";
                                }
                                break;

                            case "direction":
                                $query .= " DESC";
                                break;
                        }
                    }
                    break;
            }
        }
    }
    $statement = mysqli_prepare($connection, $query);

    if ($bindings) {
        mysqli_stmt_bind_param($statement, $types, ...$bindings);
    }

    mysqli_stmt_execute($statement);

    $rows = mysqli_stmt_get_result($statement);

    while ($row = mysqli_fetch_array($rows)) {
        $tasks[] = $row;
    }

    return $tasks;
}

/*
function loadTasks(array $parameters = null): ?array
{
    $tasks = null;
    $bindings = null;
    $types = null;

    $connection = mysqli_connect(
        "localhost",
        "adil",
        "password",
        "todolist"
    );

    $query = "SELECT * FROM tasks ";

    if ($parameters) {
        $bindings = [];
        foreach ($parameters as $group => $fields) {
            switch ($group) {
                case "filter":
                    if (count($fields) > 0) {
                        $query .= "WHERE ";

                        $clauses = [];

                        foreach ($fields as $key => $value) {
                            $clauses[] = "$key = ?";
                            $types .= "s";
                            $bindings[] = $value;
                        }

                        $query .= implode(" AND ", $clauses);
                    }
                    break;
            }
        }
    }

    $statement = mysqli_prepare($connection, $query);

    if ($bindings) {
        mysqli_stmt_bind_param($statement, $types, ...$bindings);
    }

    mysqli_stmt_execute($statement);

    $rows = mysqli_stmt_get_result($statement);

    while ($row = mysqli_fetch_array($rows)) {
        $tasks[] = $row;
    }

    return $tasks;
}
*/
function search($parameter, $value, array $tasks = null): ?array
{
    $foundTasks = null;
    $keys = array_keys(
        array_column($tasks, $parameter),
        $value
    );

    if (count($keys) > 0 && count($tasks) > 0) {
        foreach ($keys as $key) {
            $foundTasks[] = $tasks[$key];
        }
    }
    $tasks = $foundTasks;

    return $tasks;
}