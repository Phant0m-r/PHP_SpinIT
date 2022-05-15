<?php

use Adil\SpinitPhp\Models\Task;

    function task_block ( Task $task)
    {
    ?>
        <div class="task">
            <ul class="actions">
                <?php if ($task->is_complete == "0"): ?>
                    <li><a href="../../public/complete.php?id=<?= $task->id ?>">Сделано</a></li>
                <?php endif; ?>
                <li><a href="form.php?id=<?= $task->id ?>">Редактировать</a></li>
                <li><a href="../../public/delete.php?id=<?= $task->id ?>">Удалить</a></li>
            </ul>
            Описание: <?= $task->description ?> <br>
            Приоритет: <?= $task->priority ?>  <br>
            Статус: <?= $task->is_complete ? "Выполнено" : "Не выполнено"?>  <br>

            <?php if ($task->getCreatedAt()) : ?>
                Дата создания: <?= $task->getCreatedAt()->setTimezone("+06:00")->diffForHumans() ?> <br>
            <?php endif; ?>

        </div>

<?php
    }
?>