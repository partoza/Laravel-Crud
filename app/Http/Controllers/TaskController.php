<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        return view('tasks.index', [
            'tasks' => Task::with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'status' => 'in:pending,complete',
        ]);
    
        // Ensure the task is always created with a 'pending' status
        $validated['status'] = 'pending';
    
        // Create the task using the authenticated user
        $request->user()->tasks()->create($validated);
    
        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
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
    public function edit(Task $task): View
    {
        Gate::authorize('update', $task);

        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'message' => 'required|max:255',
            'status' => 'in:pending,complete', // Ensure valid status
        ]);
    
        $task->update([
            'message' => $request->message,
            'status' => $request->status,
        ]);
    
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);
 
        $task->delete();
 
        return redirect(route('tasks.index'));
    }
}
