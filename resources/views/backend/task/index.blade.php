@extends('admin')
@section('content')
<div class="card shadow p-4 d-flex flex-column">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary">+ Add New Task</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-primary text-center">
            <tr>
                <th style="width: 5%;">SL</th>
                <th>Title</th>
                <th>Description</th>
                <th style="width: 15%;">Created At</th>
                <th style="width: 10%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $key => $task)
            <tr id="task-row-{{ $task->id }}">
                <td class="text-center">{{ ($tasks->currentPage() - 1) * $tasks->perPage() + $key + 1 }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td class="text-center">{{ $task->created_at }}</td>
                <td class="text-center">
                    <!-- Delete Button -->
                    <button class="btn btn-sm btn-danger p-1 delete-task" 
                            data-id="{{ $task->id }}" style="font-size: 0.8rem;">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $tasks->links() }}
    </div>
</div>
@endsection