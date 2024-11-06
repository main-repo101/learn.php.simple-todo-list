<div id="pnl-task-list">
    <div id="pnl-edit-mode">
        <form id="form-edit-mode" method="POST">
            <textarea id="text-edit" name="text_edit"></textarea>
            <div id="pnl-btn-edit">
                <button
                    id="btn-edit-cancel"
                    type="button"
                    class="btn-cancel <?= $taskStatus ?>"
                    name="btn_cancel">
                    <i class="">cancel</i>
                </button>
                <button
                    id="btn-edit-save"
                    type="submit"
                    class="btn-save <?= $taskStatus ?>"
                    name="btn_save">
                    <i class="">save</i>
                </button>
            </div>
        </form>
    </div>
    <ul class="task-list">
        <?php foreach ($tasks as $task): ?>
            <?php
            $taskStatus = $task['completed'] ? 'completed' : '';
            $btnLblTaskStatus = $task['completed'] ? 'Undo' : 'To-do';
            ?>
            <li id="todo" class="">
                <form method="POST" class="task-item <?= $taskStatus ?>">
                    <div class="lbl-task-item <?= $taskStatus ?>">
                        <div id="lbl-txt-task-item-<?=$task["id"]?>">
                            <?= htmlspecialchars($task["title"]) ?>
                        </div>

                        <div class="btn-lbl-task-item <?= $taskStatus ?>">

                            <!-- <button 
                        type="button" 
                        class="btn-edit <?= $taskStatus ?>" 
                        onclick="editTask(<?= $task['id'] ?>)">
                            <i class="">edit</i>
                        </button>
                        <button type="button" class="btn-delete <?= $taskStatus ?>" onclick="deleteTask(<?= $task['id'] ?>)">
                            <i class="">delete</i>
                        </button> -->

                            <button
                                id="btn-edit-task-item"
                                type="button"
                                class="btn-edit <?= $taskStatus ?>"
                                name="btn_edit"
                                value=<?= $task["id"] ?>>
                                <i class="">edit</i>
                            </button>
                            <button
                                type="submit"
                                class="btn-delete <?= $taskStatus ?>"
                                name="btn_delete"
                                value=<?= $task["id"] ?>>
                                <i class="">delete</i>
                            </button>
                        </div>
                    </div>

                    <button
                        class="btn-task-item <?= $taskStatus ?>"
                        type="submit"
                        name="<?php echo $task['completed'] ? 'undo' : 'complete'; ?>"
                        value="<?php echo $task['id']; ?>">
                        <?= $btnLblTaskStatus ?>
                    </button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>