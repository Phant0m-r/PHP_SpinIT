<?php
require_once "requests/filter.php";

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
        $parameters = parse($_GET);

        foreach ($parameters as $parameter => $value) {
            if (!is_null($value)&&$tasks) {
                $tasks = search($parameter, $value, $tasks);
            }
        }
    }

    require_once "partials/head.php";
    require_once "partials/myVardump.php";
    require_once "partials/menu.php";
?>

    <form method="get" action="">
        <label>Описание задачи</label>
        <label>
            <input type="text" name="description" value="<?= $_GET["description"] ?? "" ?>">
        </label>
        <label>Приоритет</label>
        <label>
            <?php $priority = $_GET["priority"] ?? null; ?>
            <select name="priority">
                <option <?= $priority == "all" ? "selected" : "" ?> value="all">Все</option>
                <option <?= $priority == "default" ? "selected" : "" ?> value="default">Обычный</option>
                <option <?= $priority == "high" ? "selected" : "" ?> value="high">Высший</option>
                <option <?= $priority == "low" ? "selected" : "" ?> value="low">Низкий</option>
            </select>
        </label>
        <label>Статус</label>
        <label>
            <?php $is_complete = $_GET["is_complete"] ?? null; ?>
            <select name="is_complete">
                <option <?= $is_complete == "all" ? "selected" : "" ?> value="all">Все</option>
                <option <?= $is_complete == "0" ? "selected" : "" ?> value="0">Не выполнено</option>
                <option <?= $is_complete == "1" ? "selected" : "" ?> value="1">Выполнено</option>
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
        <?php
            require_once "partials/task.php";
            foreach ($tasks as $task)
            {
                task_block($task);
            }
        else : ?>
            <h1>Задач не найдено</h1>
    <?php endif; ?>

<?php require_once "partials/foot.php"; ?>
