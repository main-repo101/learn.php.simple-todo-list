//REM: [TODO, NOT_WORKING]
function deleteTask(taskId) {
    fetch('src/main/php/learn/php/simple_todo_list/util/delete-task.php', { 
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ id: taskId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log(data.message);
        } else {
            console.error(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}


const BTN_EDIT_TASK_ITEM = document.getElementsByClassName("btn-edit");

const BTN_EDIT_CANCEL = document.getElementById("btn-edit-cancel");
const BTN_EDIT_SAVE = document.getElementById("btn-edit-save");
const PNL_EDIT_MODE = document.getElementById("pnl-edit-mode");
const TXT_EDIT = document.getElementById("text-edit");


Array.from(BTN_EDIT_TASK_ITEM).forEach(function(btnEdit) {
    
    const TXT_TASK_ITEM = document.getElementById(`lbl-txt-task-item-${btnEdit.value}`);

    btnEdit.addEventListener('click', function(event) {
        event.preventDefault();
        PNL_EDIT_MODE.classList.toggle("active");
        BTN_EDIT_SAVE.value = btnEdit.value;
        TXT_EDIT.textContent = TXT_TASK_ITEM.innerText;
    });
});

BTN_EDIT_SAVE.addEventListener('click', function(event) {
    PNL_EDIT_MODE.classList.toggle("active");
});

BTN_EDIT_CANCEL.addEventListener('click', function(event) {
    event.preventDefault();
    PNL_EDIT_MODE.classList.toggle("active");
});