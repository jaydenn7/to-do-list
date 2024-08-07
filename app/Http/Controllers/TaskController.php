<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return view('tasks', [
            "tasks" => Task::all(),
        ]);
    }

    /**
     * Could pass $request->validated() but it's an MVP form with one field
     * So let's keep it simple until it's stated otherwise
     */
    public function store(Request $request)
    {
        $request->validate([
            "description" => ["string", "required", "max:255"],
        ]);

        Task::query()->create([
            "description" => $request->input("description"),
        ]);

        return redirect()->route("tasks.index");
    }

    /**
     * I understand the argument for solely using Resourceful Controllers
     * but in this MVP case, it's easier to keep it all in one place.
     *
     * So instead of a separate TaskCompletionController::update function that validates
     * a passed "completed_at" field or however, let's just update it manually here
     *
     * Also; I really like dates instead of bool fields for this kinda scenario
     */
    public function complete(Task $task)
    {
        $task->update(["completed_at" => Carbon::now()]);

        return redirect()->route("tasks.index");
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route("tasks.index");
    }
}
