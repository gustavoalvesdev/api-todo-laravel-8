<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Todo;
use function GuzzleHttp\Promise\all;

class ApiController extends Controller
{
    public function createTodo(Request $request) {
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

    public function readAllTodos() {
        $array = ['error' => ''];

        $todos = Todo::all();

        $array['list'] = Todo::all();

        return $array;
    }

    public function readTodo($id) {
        $array = ['error' => ''];

        $todo = Todo::find($id);

        if ($todo) {
            $array['todo'] = $todo;
        } else {
            $array['error'] = 'A tarefa ' . $id . ' não existe';
        }

        return $array;
    }

    public function updateTodo() {

    }

    public function deleteTodo() {

    }
}
