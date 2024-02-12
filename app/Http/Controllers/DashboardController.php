<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $task = Task::count();

        return view('dashboard.dashboard', [
            'task' => $task,
        ]);
    }
}
