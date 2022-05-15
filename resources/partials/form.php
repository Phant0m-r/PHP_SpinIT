<?php

use Adil\SpinitPhp\Models\Task;

function viewForm (array $errors = null, Task $task = null)
{
    $id = $task->id ?? null;
    $description = $task->description ?? null;
    $priority = $task->priority ?? null;
?>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?= $id ?>">
        <label>Описание задачи</label>
        <input type="text" name="description" value="<?=$description?>" placeholder="Что вы хотите сделать?">
        <!-- Блок для отображения ошибки -->
        <?php if (isset($errors["description"])): ?>
            <div class="validate-error"> <?= $errors["description"] ?> </div>
        <?php endif; ?>
        <br>
        <label>Приоритет</label>

        <select name="priority">
            <option <?= $priority == "default" ? "selected" : "" ?> value="default">Обычный</option>
            <option <?= $priority == "high" ? "selected" : "" ?> value="high">Высший</option>
            <option <?= $priority == "low" ? "selected" : "" ?> value="low">Низкий</option>
        </select>
        <br>
        <div class="actions">
            <button type="submit">Отправить</button>
        </div>
    </form>

<?php
}
?>