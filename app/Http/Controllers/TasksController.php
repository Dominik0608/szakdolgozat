<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TaskCreateRequest;

class TasksController extends Controller
{
    private $MAX_DESCRIPTION_CHARACTER = 100;

    protected function taskList()
    {
        $tasks = DB::table('tasks')->orderBy('id', 'desc')->get();
        foreach ($tasks as $key => $value) {
            $tasks[$key]->description = $this->descShorter($tasks[$key]->description);
        }
        return view('layouts/tasks', [
            'tasks' => $tasks,
        ]);
    }

    // Lerövidíti a leírást a maximális karakterszámra, de nem tördeli szét a szavakat.
    private function descShorter($text)
    {
        $textArray = explode(" ", $text);
        $characterLeft = $this->MAX_DESCRIPTION_CHARACTER;
        $newText = "";
        foreach ($textArray as $key => $value) {
            if ($characterLeft > strlen($value)) {
                $characterLeft -= strlen($value);
                $newText .= $value . " ";
            } else {
                return substr($newText, 0, -1) . "..."; // hosszabb szöveg esetén a végére rak 3 pontot
            }
        }
        return substr($newText, 0, -1);
    }

    protected function taskCreate()
    {
        return view('layouts/taskcreate');
    }

    public function taskUpload(TaskCreateRequest $request)
    {
        $data = request()->all(); // mindent visszaad

        $id = DB::table('tasks')->insertGetId(
            [
                'title' => $data['title'],
                'description' => $data['description'],
                'createdBy' => auth()->user()->id ?? null,
            ]
        );

        if(isset($id)){
            for ($i=0; $i < count($data['test_input']); $i++) { 
                DB::table('testcase')->insert(
                    [
                        'taskid' => $id,
                        'test_input' => $data['test_input'][$i],
                        'test_output' => $data['test_output'][$i],
                        'validator_input' => $data['validator_input'][$i],
                        'validator_output' => $data['validator_output'][$i],
                    ]
                );
            }

            if(isset($data['hint'])){
                for ($i=0; $i < count($data['hint']); $i++) { 
                    DB::table('hints')->insert(
                        [
                            'taskid' => $id,
                            'hint' => $data['hint'][$i],
                        ]
                    );
                }
            }
        }
        
        return redirect("/tasks");
    }
}
