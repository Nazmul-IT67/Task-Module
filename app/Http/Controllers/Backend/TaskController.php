<?php

namespace App\Http\Controllers\Backend;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = 'Task List';
        $tasks = Task::latest()->paginate(10);
        return view('backend.task.index', compact('page_title','tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_title = 'Add New Task';
        return view('backend.task.create', compact('page_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tasks' => 'required|array|min:1',
            'tasks.*.title' => 'required|string|max:30',
            'tasks.*.description' => 'nullable|string|max:200',
        ]);

        foreach ($validated['tasks'] as $task) {
            Task::create($task);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tasks inserted successfully!'
        ]);
    }


// public function storeMultiple(Request $request)
//     {
//     // $validator = Validator::make($request->all(), [
//     //     'tasks' => 'required|array|min:1',
//     //     'tasks.*.title' => 'required|string|max:255',
//     //     'tasks.*.description' => 'nullable|string|max:1000',
//     // ]);

//     // if ($validator->fails()) {
//     //     return response()->json([
//     //         'success' => false,
//     //         'errors' => $validator->errors()
//     //     ], 422);
//     // }
// if($request->tasks){
//     dd($request->tasks);
//     foreach($request->tasks as $key=>$item){
//         dd($item);
//         $task = new Task;
//         $task->title = $item->title [$key];
//         $task->description = $item->description [$key];
//         $task->save();
//     }
// }


//     return response()->json([
//         'success' => true,
//         'message' => 'tasks added successfully!'
//     ], 201);
// }

public function storeMultiple(Request $request)
{
    $titles = $request->input('title', []);
    $descriptions = $request->input('description', []);

    if (empty($titles)) {
        return response()->json([
            'success' => false,
            'message' => 'Please add at least one task.'
        ], 422);
    }

    $tasks = [];

    foreach ($titles as $i => $title) {
        $tasks[] = [
            'title' => $title,
            'description' => $descriptions[$i] ?? null,
        ];
    }

    Task::insert($tasks);

    return response()->json([
        'success' => true,
        'message' => count($tasks) . ' tasks added successfully!'
    ], 201);
}




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
