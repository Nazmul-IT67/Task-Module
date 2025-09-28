$(document).ready(function() {

    // CSRF setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let index = 1;

    // Add new task row
    $('#addTask').click(function() {
        $('#taskRepeater').append(`
            <div class="task-item row g-3 align-items-center mb-3">
                <div class="col-md-5">
                    <input type="text" class="form-control" name="tasks[${index}][title]" placeholder="Task Title" required>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="tasks[${index}][description]" placeholder="Description">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger removeTask w-100">Remove</button>
                </div>
            </div>
        `);
        index++;
    });

    // Remove task row
    $(document).on('click', '.removeTask', function() {
        $(this).closest('.task-item').remove();
    });

    // AJAX submit for adding tasks
    $('#taskForm').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "/tasks",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if(response.success){
                    toastr.success(response.message, 'Success', {timeOut: 3000});
                    $('#taskForm')[0].reset();
                    $('#taskRepeater').html(initialTaskRow());
                    index = 1;
                } else {
                    toastr.error(response.message, 'Error', {timeOut: 3000});
                }
            },
            error: function(xhr) {
                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value){
                        toastr.error(value[0], 'Validation Error', {timeOut: 3000});
                    });
                } else {
                    toastr.error("Something went wrong!", 'Error', {timeOut: 3000});
                }
            }
        });
    });

    // Delete single task
    $(document).on('click', '.delete-task', function() {
        let taskId = $(this).data('id');

        if(confirm('Are you sure you want to delete this task?')) {
            $.ajax({
                url: '/tasks/' + taskId,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#task-row-' + taskId).remove();
                    toastr.success('Task deleted successfully!', 'Success', {timeOut: 3000});
                },
                error: function(xhr) {
                    toastr.error('Something went wrong!', 'Error', {timeOut: 3000});
                }
            });
        }
    });

    // Initial task row
    function initialTaskRow() {
        return `
        <div class="task-item row g-3 align-items-center mb-3">
            <div class="col-md-5">
                <input type="text" class="form-control" name="tasks[0][title]" placeholder="Task Title" required>
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control" name="tasks[0][description]" placeholder="Description">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger removeTask w-100">Remove</button>
            </div>
        </div>`;
    }

});
