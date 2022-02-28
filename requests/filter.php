<?php

function parse(array $query = []): ?array
{
    foreach ($query as $key => $value) {
        switch ($key) {
            case "priority":
                $value = $_GET[$key] == "all"
                    ? null
                    : $_GET[$key];

                break;
            case "is_complete":
                if (
                    $_GET[$key] == "1"
                    || $_GET[$key] == "0"
                ) {
                    $value = (boolean)$_GET[$key];
                } else {
                    $value = null;
                }

                break;
            default:
                $value = $_GET[$key] ==""
                    ? null
                    : $_GET[$key];

        }
        $parameters[$key] = $value;
    }

    return $parameters;
}


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