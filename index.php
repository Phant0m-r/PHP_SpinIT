<?php
    $tasks = [
        [
            "description" => "Создать форму",
            "priority" => "high",
            "is_complete" => true
        ],
        [
            "description" => "сделать дз",
            "priority" => "low",
            "is_complete" => false
        ],
        [
            "description" => "Создать страницу с задачами",
            "priority" => "low",
            "is_complete" => true
        ],
        [
            "description" => "сделать дз",
            "priority" => "default",
            "is_complete" => false
        ]
    ];

    if (count($_GET) > 0) {
        $description = $_GET["description"] = ""
            ? null
            : $_GET["description"];

        $priority = $_GET["priority"] = "all"
            ? null
            : $_GET["priority"];

        $is_complete = $_GET["is_complete"] = "all"
            ? null
            : $_GET["is_complete"];

        if ($description) {
            $foundTasks = null;
            $keys = array_keys(
                array_column($tasks, "description"),
                $description
            );

            if (count($keys) > 0 && count($tasks) > 0) {
                foreach ($keys as $key) {
                    $foundTasks[] = $tasks[$key];
                }
            }
            $tasks = $foundTasks;
        }

        if ($priority) {
            $foundTasks = null;
            $keys = array_keys(
                array_column($tasks, "priority"),
                $priority
            );

            if (count($keys) > 0 && count($tasks) > 0) {
                foreach ($keys as $key) {
                    $foundTasks[] = $tasks[$key];
                }
            }
            $tasks = $foundTasks;
        }
    }
?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToDo List</title>
    <style>
        body {
            font-family: sans-serif;
        }

        h1 {
            text-align: center;
        }

        nav {
            background: #666;
            text-align: center;
            margin-bottom: 24px;
        }

        nav li {
            display: inline-block;
            margin: 8px;
        }

        nav li a {
            color: white;
        }

        .task {
            background: #eee;
            width: 500px;
            margin: 8px auto 8px;
            padding: 16px;
        }

        .task .actions {
            background: #d9d9d9;
            text-align: right;
        }

        .task .actions {
            margin: 0 0 8px 0;
            padding: 4px;
        }

        .task .actions li {
            display: inline-block;
            margin: 0 4px;
        }

        .task .actions li a {
            font-size: 12px;
        }

        .message {
            width: 500px;
            padding: 16px;
            margin: 0 auto 16px auto;
            background: #ddddff;
        }

        form {
            background: #eee;
            width: 500px;
            margin: 0 auto 24px auto;
            padding: 16px;
            border: 1px solid #e6e6e6;
        }

        form label {
            display: inline-block;
            width: 200px;
        }

        form button {
            margin-top: 16px;
            padding: 8px 16px;
            background: blue;
            color: white;
            border: none;
        }

        form .validate-error {
            background: red;
            color: white;
            font-size: 10px;
        }

        form .actions {
            text-align: center;
        }

        pre {
            background: #ddd;
            padding: 8px;
            font-family: monospace;
        }
    </style>
</head>

<body>
    <!-- Блок для var_dump -->
    <pre>
        <?php var_dump($_GET);?>
    </pre>

    <nav>
        <li><a href="/index.php">Все задачи</a></li>
        <li><a href="/create.php">Добавить</a></li>
    </nav>

    <form method="get" action="">
        <label>Описание задачи</label>
        <label>
            <input type="text" name="description" value="<?= $_GET["description"] ?? "" ?>">
        </label>
        <label>Приоритет</label>
        <label>
            <?php $priority = $_GET["priority"] ?? null; ?>
            <select name="priority">
                <option <?= $priority = "all" ? "selected" : "" ?> value="all">Все</option>
                <option <?= $priority = "default" ? "selected" : "" ?> value="default">Обычный</option>
                <option <?= $priority = "high" ? "selected" : "" ?> value="high">Высший</option>
                <option value="low">Низкий</option>
            </select>
        </label>
        <label>Статус</label>
        <label>
            <?php $is_complete = $_GET["is_complete"] ?? null; ?>
            <select name="is_complete">
                <option <?= $is_complete = "all" ? "selected" : "" ?> value="all">Все</option>
                <option <?= $is_complete = false ? "selected" : "" ?> value="0">Не выполнено</option>
                <option <?= $is_complete = true ? "selected" : "" ?> value="1">Выполнено</option>
            </select>
        </label>
        <br>
        <div class="actions">
            <button type="submit">Искать</button>
        </div>
    </form>

    <!-- Для отображения списка задач -->
    <?php if ($tasks): ?>
        <h1>Задачи</h1>
        <?php foreach ($tasks as $task): ?>
            <div class="task">
                <ul class="actions">
                    <li><a href="">Редактировать</a></li>
                    <li><a href="">Удалить</a></li>
                </ul>
                Описание: <?= $task["description"] ?> <br>
                Приоритет: <?= $task["priority"] ?>  <br>
                Статус: <?= $task["is_complete"] ?>  <br>
            </div>
        <?php endforeach; ?>
        <!-- Если задач не найдено -->
        <?php else : ?>
            <h1>Задач не найдено</h1>
    <?php endif; ?>
</body>
</html>
