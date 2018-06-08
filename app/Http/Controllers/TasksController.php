<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Task;    

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()

    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
            
            return view('welcome', $data);
        }else {
            return view('welcome');
        }
    }

    public function show($id)
    
    {
        if(\Auth::check())
        {
        $task = Task::find($id);
        $user = \Auth::user();
        $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
        
        if (\Auth::user()->id === $task->user_id) {
        return view('tasks.show', [
            'tasks' => $tasks,
            'task' => $task,
            'user' => $user,
        ]);
        }
        else{
       
            return redirect('/');
        }
       }
    else{
        return view ('welcome');
    }
}
    
     public function create()
    {
        $task = new Task;

        return view('tasks.create', [
            'task' => $task,
        ]);
    }
    
     public function store(Request $request)
    {
         $this->validate($request, [
             'status' => 'required|max:191', 
            'content' => 'required|max:191',
        ]);
        
         $request->user()->tasks()->create([
            'content' => $request->content,
            'status' => $request->status,
        ]);
        
       
        return redirect('/');
    }
    
     public function edit($id)
    
    {
        if(\Auth::check())
        {
        $task = Task::find($id);
        $user = \Auth::user();
        $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
        
        if (\Auth::user()->id === $task->user_id) {
        return view('tasks.edit', [
            'tasks' => $tasks,
            'task' => $task,
            'user' => $user,
        ]);
        }
        else{
           return redirect('/');
            }
        }
    else{
        return view ('welcome');
    }
}

     public function update(Request $request, $id)
    {
        $this->validate($request, [
        //'status' => 'required|max:191', 
         'status' => 'required|max:10',
         'content' => 'required|max:191',
    ]);

        $task = Task::find($id);
        //$task->status = $request->status;   
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
    
       
        return redirect('/');
    }
    
     public function destroy($id)
    {
       $task = \App\Task::find($id);

        if (\Auth::user()->id === $task->user_id) {
            $task->delete();
        }

        return redirect()->back();

}
}
