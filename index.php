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
    <!-- <pre></pre> -->

    <nav>
        <li><a href="/index.php">Все задачи</a></li>
        <li><a href="/create.php">Добавить</a></li>
    </nav>

    <form method="get" action="">
        <label>Описание задачи</label>
        <input type="text" name="description" value="">
        <label>Приоритет</label>
        <select name="priority">
            <option value="all">Все</option>
            <option value="default">Обычный</option>
            <option value="high">Высший</option>
            <option value="low">Низкий</option>
        </select>
        <br>
        <div class="actions">
            <button type="submit">Искать</button>
        </div>
    </form>

    <!-- Для отображения списка задач -->
    <!-- <h1>Задачи</h1>
    <div class="task">
        <ul class="actions">
            <li><a href="">Редактировать</a></li>
            <li><a href="">Удалить</a></li>
        </ul>
        Описание: текст описания <br>
        Приоритет: тип приоритета <br>
    </div> -->

    <!-- Если задач не найдено -->
    <!-- <h1>Задач не найдено</h1> -->
</body>

</html>