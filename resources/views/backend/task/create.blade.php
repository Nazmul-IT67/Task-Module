@extends('admin')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-info d-flex justify-content-between align-items-center">
            <!-- Left: Back Button -->
            <div>
                <a href="{{ route('tasks.index') }}" class="btn btn-light btn-sm">
                    <i class="fa fa-arrow-left me-1"></i> Back
                </a>
            </div>

            <!-- Right: Search Input -->
            <div>
                <input type="text" id="taskSearch" class="form-control form-control-sm" placeholder="Search Tasks">
            </div>
        </div>
        <div class="card-body">
            <form id="taskForm">
                <div id="taskRepeater">
                    <div class="task-item row g-3 align-items-center mb-3">
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="tasks[0][title]" placeholder="Task Title"
                                required>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="tasks[0][description]"
                                placeholder="Description">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger removeTask w-100">Remove</button>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" id="addTask" class="btn btn-secondary">+ Add Task</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>

            <div id="message" class="mt-3"></div>
        </div>
    </div>
</div>
@endsection
