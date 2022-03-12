<?php

    function task_block ( array $task)
    {
    ?>
        <div class="task">
            <ul class="actions">
                <li><a href="form.php?id=<?= $task["id"] ?>">Редактировать</a></li>
                <li><a href="../delete.php?id=<?= $task["id"] ?>">Удалить</a></li>
            </ul>
            Описание: <?= $task["description"] ?> <br>
            Приоритет: <?= $task["priority"] ?>  <br>
            Статус: <?= $task["is_complete"] ? "Выполнено" : "Не выполнено"?>  <br>
        </div>

<?php
    } ?>