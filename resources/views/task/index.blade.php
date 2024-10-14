@extends('Layout.baseview')
@section('title','All Tasks')
@section('style')
<style>
    .done{
        text-decoration: line-through;
    }
</style>
@section('content')
    @include('Layout.nav')
    <div class="container mt-5">
        <button type="button" class="btn btn-outline-primary mb-5 end-0" onclick="addTask()">Add Task</button>
        <div class="cart">
            <div class="cart-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Task Description</th>
                            <th scope="col">Task Owner</th>
                            <th scope="col">Task ETA</th>
                            <th scope="col">Action</th>                     
                        </tr>
                    </thead>
                    <tbody id="taskTable">
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="createTaskDescription">Task Description</label>
                            <input type="text" class="form-control" id="createTaskDescription" placeholder="Enter Task">
                        </div>
                        <div class="form-group">
                            <label for="createTaskOwner">Task Owner</label>
                            <input type="text" class="form-control" id="createTaskOwner" placeholder="Enter owner">
                        </div>
                        <div class="form-group">
                            <label for="createTaskEmail">Owner Email</label>
                            <input type="email" class="form-control" id="createTaskEmail" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="createTaskETA">ETA</label>
                            <input type="date" class="form-control" id="createTaskETA" placeholder="Enter ETA">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="createTask()">Save Task</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="editTaskDescription">Task Description</label>
                            <input type="text" class="form-control" id="editTaskDescription" placeholder="Enter Task">
                        </div>
                        <div class="form-group">
                            <label for="editTaskOwner">Task Owner</label>
                            <input type="text" class="form-control" id="editTaskOwner" placeholder="Enter owner">
                        </div>
                        <div class="form-group">
                            <label for="editTaskEmail">Owner Email</label>
                            <input type="email" class="form-control" id="editTaskEmail" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="editTaskETA">ETA</label>
                            <input type="date" class="form-control" id="editTaskETA" placeholder="Enter ETA">
                        </div>
                        <div class="form-group">
                            <label for="editTaskStatus">Status</label>
                            <select class="form-control" id="editTaskStatus">
                                <option value="">Set task status</option>
                                <option value="0">In Process</option>
                                <option value="1">Done</option>
                            </select>
                        </div>
                        <input type="hidden" id="editTaskId">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateTask()">Save Task</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="doneTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mark Task as Done</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to mark this task as done?</p>
                    <input type="hidden" id="doneTaskId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateMarkAsDone()">Save Task</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this task?</p>
                    <input type="hidden" id="deleteTaskId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateTaskDelete()">Save Task</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customjs')
<script>
  $(document).ready(function() {
    console.log("Document is ready. Fetching tasks...");
    getAllTasks();
  });

  function getAllTasks() {
    console.log("Calling the API...");
    $.ajax({
        type: 'GET',
        url: "http://localhost:8000/api/task",
        success: function(result) {
            console.log("Tasks fetched successfully:", result);
            var html = '';
            for (var i = 0; i < result.length; i++) {
                var lineThrough = result[i]['status'] == 1? 'class="done"' : "";
                html += '<tr>'
                      + '<th scope="row" '+lineThrough+'>' + (i + 1) + '</th>'
                      + '<td '+lineThrough+'>' + result[i]['task_discription'] + '</td>'
                      + '<td '+lineThrough+'>' + result[i]['task_owner'] + '</td>'
                      + '<td '+lineThrough+'>' + result[i]['task_eta'] + '</td>'
                      + '<td>'
                          + '<i class="bi bi-pencil-square" onclick="editTask(' + result[i]['id'] + ')"></i>'
                          + '<i class="bi bi-check2-square" onclick="markAsDone(' + result[i]['id'] + ')"></i>'
                          + '<i class="bi bi-trash" onclick="deleteTask(' + result[i]['id'] + ')"></i>'
                      + '</td>'
                      + '</tr>';
            }
            $("#taskTable").html(html);
        },
        error: function(xhr, status, error) {
            console.error("Error fetching tasks:", xhr.status, error);
        }
    });
  }

  function addTask() {
    var myModal = new bootstrap.Modal(document.getElementById('createTaskModal'));
    myModal.show();
  }

  function createTask() {
    var taskDescription = $("#createTaskDescription").val();
    var taskOwner = $("#createTaskOwner").val();
    var ownerEmail = $("#createTaskEmail").val();
    var taskEta = $("#createTaskETA").val();

    $.ajax({
        type: 'POST',
        url: "http://localhost:8000/api/task",
        data: {
            task_discription: taskDescription,
            task_owner: taskOwner,
            owner_email: ownerEmail,
            task_eta: taskEta
        },
        success: function(result) {
            var myModal = bootstrap.Modal.getInstance(document.getElementById('createTaskModal'));
            myModal.hide();
            $("#createTaskDescription").val('');
            $("#createTaskOwner").val('');
            $("#createTaskEmail").val('');
            $("#createTaskETA").val('');
            getAllTasks();
        },
        error: function(xhr, status, error) {
            console.error("Error creating task:", xhr.status, error);
        }
    });
  }

  function editTask(id) {
    $.ajax({
        type: 'GET',
        url: "http://localhost:8000/api/task/" + id,
        success: function(result) {
            $("#editTaskDescription").val(result['task_discription']);
            $("#editTaskOwner").val(result['task_owner']);
            $("#editTaskEmail").val(result['owner_email']);
            $("#editTaskETA").val(result['task_eta']);
            $("#editTaskStatus").val(result['status']);
            $("#editTaskId").val(id);

            var myModal = new bootstrap.Modal(document.getElementById('editTaskModal'));
            myModal.show();
        },
        error: function(xhr, status, error) {
            console.error("Error fetching task for edit:", xhr.status, error);
        }
    });
  }

  function updateTask() {
    var id = $("#editTaskId").val();
    var taskDescription = $("#editTaskDescription").val();
    var taskOwner = $("#editTaskOwner").val();
    var ownerEmail = $("#editTaskEmail").val();
    var taskEta = $("#editTaskETA").val();
    var taskStatus = $("#editTaskStatus").val();

    $.ajax({
        type: 'PUT',
        url: "http://localhost:8000/api/task/" + id,
        data: {
            task_discription: taskDescription,
            task_owner: taskOwner,
            owner_email: ownerEmail,
            task_eta: taskEta,
            status: taskStatus
        },
        success: function(result) {
            var myModal = bootstrap.Modal.getInstance(document.getElementById('editTaskModal'));
            myModal.hide();
            getAllTasks();
        },
        error: function(xhr, status, error) {
            console.error("Error updating task:", xhr.status, error);
        }
    });
  }

  function markAsDone(id) {
    $("#doneTaskId").val(id);

    var doneModal = new bootstrap.Modal(document.getElementById('doneTaskModal'));
    doneModal.show();
  }

  function updateMarkAsDone() {
    var id = $("#doneTaskId").val();

    $.ajax({
        type: 'PUT',
        url: "http://localhost:8000/api/task/done/" + id,
        success: function(result) {
            var doneModal = bootstrap.Modal.getInstance(document.getElementById('doneTaskModal'));
            doneModal.hide();
            getAllTasks();
        },
        error: function(xhr, status, error) {
            console.error("Error marking task as done:", xhr.status, error);
        }
    });
  }
  function deleteTask(id) {
  $("#deleteTaskId").val(id);  // Set the ID in the hidden input
  var deleteModal = new bootstrap.Modal(document.getElementById('deleteTaskModal'));
  deleteModal.show();
}

function updateTaskDelete() {
  var id = $("#deleteTaskId").val();  // Get the ID from the hidden input

  if (!id) {
    console.error("Task ID is missing. Cannot delete.");
    return;
  }

  $.ajax({
    type: 'DELETE',
    url: "http://localhost:8000/api/task/" + id,
    success: function(result) {
      var deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteTaskModal'));
      deleteModal.hide();
      getAllTasks();
    },
    error: function(xhr, status, error) {
      console.error("Error deleting task:", xhr.status, error);
    }
  });
}

</script>
@endsection
