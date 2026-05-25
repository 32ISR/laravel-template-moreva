<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index() {

    /** @var User $user */
        $user = Auth::user();
        $tasks = $user
            ->tasks()
            ->with('category')
            ->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            "title" => "required|string|max:255",
            "description" => "string|nullable",
            "status" => "string|in:pending,in_progress,done|required",
            "priority" => "string|required|in:low,medium,high",
            "due_date" => "date|nullable|after_or_equal:today",
            "category_id" => "nullable|exists:categories:id"
        ]);
        /** @var User $user */
        $user = Auth::user();
        $user->tasks()->create($data);
        return redirect()->route('tasks.index')->with('success', 'Задача создана'); }

    public function create() {
         /** @var User $user */
        $user = Auth::user();
        $categories = $user->categories()->get();
        return view('tasks.create', compact('categories'));
    }

    public function edit() {
        
    }

    public function update() {
        
    }

    public function destroy() {
        
    }
}
