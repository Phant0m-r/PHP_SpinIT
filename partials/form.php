<?php
function form_create (array $errors = null, array $task = null) {
?>
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

<?php
}
?>