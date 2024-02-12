<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task = Task::orderBy('name', 'asc')->get();

        return view('task.task', [
            'task' => $task
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('task.task-add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:tasks',
            'category' => 'required',
            'note' => 'max:1000',
        ]);

        $task = Task::create($request->all());

        Alert::success('Success', 'Task has been saved !');
        return redirect('/task');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($task_id)
    {
        $task = task::findOrFail($task_id);

        return view('task.task-edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $task_id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:tasks,name,' . $task_id . ',task_id',
            'category' => 'required',
            'note' => 'max:1000',
        ]);

        $task = Task::findOrFail($task_id);
        $task->update($validated);

        Alert::info('Success', 'Task has been updated !');
        return redirect('/task');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($task_id)
    {
        try {
            $deletedtask = Task::findOrFail($task_id);

            $deletedtask->delete();

            Alert::error('Success', 'Task has been deleted !');
            return redirect('/task');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Task already used !');
            return redirect('/task');
        }
    }
}
