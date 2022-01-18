<?php
    $errors = null;
    $message = null;

    if (count($_POST) > 0) {
        foreach ($_POST as $key => $value) {
            if ($value == "") {
                $errors[$key] = "Должно быть заполнено";
            }
        }

        if ($errors) {
            $message = "Не все поля заполнены";
        } else {
            $message = "Данные формы сохранены";
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
    <!-- Блок для var_dump() -->
    <pre>
        <?php var_dump($_POST);?>
    </pre>

    <nav>
        <li><a href="/index.php">Все задачи</a></li>
        <li><a href="/create.php">Добавить</a></li>
    </nav>

    <!-- Блок для сообщения -->
    <?php if ($message): ?>
    <div class="message">
        <?= $message?>
    </div>
    <?php endif; ?>

    <h1>Добавить задачу</h1>

    <form method="POST" action="">
        <label>Описание задачи</label>

            <input type="text" name="description" placeholder="Что вы хотите сделать?">

        <!-- Блок для отображения ошибки -->
        <?php if (isset($errors["description"])): ?>
         <div class="validate-error"> <?= $errors["description"] ?> </div>
        <?php endif; ?>
        <br>
        <label>Приоритет</label>

            <select name="priority">
                <option value="default">Обычный</option>
                <option value="high">Высший</option>
                <option value="low">Низкий</option>

            </select>
        <br>
        <div class="actions">
            <button type="submit">Отправить</button>
        </div>
    </form>
</body>

</html>
