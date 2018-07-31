<?php

namespace App\Http\Controllers;

use App\Model\Task;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        return view('main.index', compact('tasks'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'text' => 'required | max: 600'
        ]);

        $task = new Task;
        $task->body = $request->text;
        $task->save();

        return 'done';
    }

    public function delete(Request $request) {

        $this->validate($request, [
            'id' => 'required'
        ]);

        Task::where('id', $request->id)->delete();

        return 'done';
    }

    public function update(Request $request) {
        //Task::where('id', $request->id)->update(['body' => $request->text]);

        $this->validate($request, [
            'text' => 'required | max: 600',
            'id' => 'required'
        ]);

        $task = Task::find($request->id);
        $task->body = $request->text;
        $task->save();

        return 'done';
    }

    public function search() {
        $tasks = null;

        foreach (Task::all() as $task) {
            $tasks[] = $task->body;
        }

        return $tasks ? $tasks : 'none';
    }
}
