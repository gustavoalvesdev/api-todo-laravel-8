<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Todo;

class ApiController extends Controller
{
    public function createTodo(Request $request)
    {
        $array = ['error' => ''];

        $rules  = [
          'title' => 'required|min:3'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $array['error'] = $validator->messages();
            return $array;
        }

        $title = $request->input('title');

        $todo = new Todo();
        $todo->title = $title;
        $todo->save();

        return $array;
    }

    public function readAllTodos()
    {
        $array = ['error' => ''];

        $todos = Todo::simplePaginate(2);

        $array['list'] = $todos->items();
        $array['currentPage'] = $todos->currentPage();

        return $array;
    }

    public function readTodo($id)
    {
        $array = ['error' => ''];

        $todo = Todo::find($id);

        if ($todo) {
            $array['todo'] = $todo;
        } else {
            $array['error'] = 'A tarefa ' . $id . ' não existe';
        }

        return $array;
    }

    public function updateTodo($id, Request $request)
    {
        $array = ['error' => ''];

        $rules  = [
            'title' => 'min:3',
            'done' => 'boolean'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $array['error'] = $validator->messages();
            return $array;
        }

        $title = $request->input('title');
        $done = $request->input('done');

        $todo = Todo::find($id);

        if ($todo) {

            if ($title) {
                $todo->title = $title;
            }

            if ($done !== NULL) {
                $todo->done = $done;
            }

            $todo->save();

        } else {
            $array['error'] = 'Tarefa ' . $id . ' não existe, logo, não pode ser atualizada.';
        }

        return $array;
    }

    public function deleteTodo($id)
    {
        $array = ['error' => ''];

        $todo = Todo::find($id);
        $todo->delete();

        // $todo->destroy($id);

        return $array;
    }
}
