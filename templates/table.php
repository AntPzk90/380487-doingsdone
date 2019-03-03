<?php if (!$task_item["status"] && !$show_complete_tasks): ?>
    <tr class="tasks__item task <?php if(days_counter($task_item["deadline"]) <= 24): ?> task--important <?php endif; ?>">
        <td class="task__select">
            <label class="checkbox task__checkbox">
                <input class="checkbox__input visually-hidden" type="checkbox">
                <span class="checkbox__text"><?= htmlspecialchars($task_item["title"]); ?></span>
            </label>
        </td>
        <td class="task__date">
            <?= ($task_item["deadline"]) ? $task_item["deadline"] : "Нет"; ?>
        </td>

        <td class="task__controls">
            <?= ($task_item["status"]) ? "Да" : "Нет"; ?>
        </td>
    </tr>
    <?php elseif($task_item["status"] && $show_complete_tasks): ?>
    <tr class="tasks__item task <?php if($task_item["status"]): ?> task--completed <?php endif; ?>">
        <td class="task__select">
            <label class="checkbox task__checkbox">
                <input class="checkbox__input visually-hidden" type="checkbox" <?= ($show_complete_tasks) ? "checked" : ""; ?>>
                <span class="checkbox__text"><?= htmlspecialchars($task_item["title"]); ?></span>
            </label>
        </td>
        <td class="task__date">
            <?= ($task_item["deadline"])? $task_item["deadline"] : "Нет"; ?>
        </td>

        <td class="task__controls">
            <?= ($task_item["status"])? "Да" : "Нет"; ?>
        </td>
    </tr> 
<?php endif; ?>