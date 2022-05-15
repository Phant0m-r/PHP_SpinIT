<?php

require_once __DIR__ . "/../bootstrap.php";

use Adil\SpinitPhp\Http\Request;
use Adil\SpinitPhp\Http\Taskcontroller;

    $tasks = null;

    $request = new Request;
    $taskController = new TaskController($request);
    $tasks = $taskController->index();

    require_once __DIR__ . "/../resources/partials/head.php";

    notification($request->message);
?>

    <form method="get" action="">
        <label>Описание задачи</label>
        <label>
            <input type="text" name="filter[description]" value="<?= $request->filter["description"] ?? "" ?>">
        </label>
        <label>Приоритет</label>
        <label>
            <?php $priority = $request->filter["priority"] ?? null; ?>
            <select name="filter[priority]">
                <option <?= $priority == "all" ? "selected" : "" ?> value="all">Все</option>
                <option <?= $priority == "default" ? "selected" : "" ?> value="default">Обычный</option>
                <option <?= $priority == "high" ? "selected" : "" ?> value="high">Высший</option>
                <option <?= $priority == "low" ? "selected" : "" ?> value="low">Низкий</option>
            </select>
        </label>
        <label>Статус</label>
        <label>
            <?php $is_complete = $request->filter["is_complete"] ?? null; ?>
            <select name="filter[is_complete]">
                <option <?= $is_complete == "all" ? "selected" : "" ?> value="all">Все</option>
                <option <?= $is_complete == "0" ? "selected" : "" ?> value="0">Не выполнено</option>
                <option <?= $is_complete == "1" ? "selected" : "" ?> value="1">Выполнено</option>
            </select>
        </label>
        <label>Сортировка по:</label>
        <?php $column = $request->sort["column"] ?? null; ?>
        <select name="sort[column]">
            <option <?=$column == "none" ? "selected" : "" ?> value="none">Времени</option>
            <option <?=$column == "description" ? "selected" : "" ?> value="description">Описанию</option>
            <option <?=$column == "priority" ? "selected" : "" ?> value="priority">Приоритету</option>
            <option <?=$column == "is_complete" ? "selected" : "" ?> value="is_complete">Статусу</option>
        </select>
        <label>
            убыванию?
            <?php $direction = $request->sort["direction"] ?? null; ?>
            <input <?= $direction == "desc" ? "checked" : "" ?> type="checkbox" name="sort[direction]" value="desc">
           <!-- <input type="checkbox" name="sort[direction]" value="<?= $request->sort["direction"] ?? "desc"; ?>"> -->
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
            foreach ($tasks as $task)
            {
                task_block($task);
            }
        else : ?>
            <h1>Задач не найдено</h1>
    <?php endif; ?>

<?php require_once __DIR__ . "/../resources/partials/foot.php"; ?>
