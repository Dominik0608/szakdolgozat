<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\TaskCreateRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class TasksController extends Controller
{
    private $MAX_DESCRIPTION_CHARACTER = 100;

    protected function taskList(Request $request)
    {
        $tasks = DB::table('tasks')->leftJoin('usertask', 'tasks.id', '=', 'usertask.taskid');   
        $tags = $request->input('tags');
        if ($tags) {
            foreach($this->tagsCorrector($tags) as $tag) {
                $tasks = $tasks->orWhere('tasks.tags', 'LIKE', '%'.$tag.'%');
            }
        }
        $tasks = $tasks->orderBy('id', 'desc')->get();
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
        
        $request->validate([
            'kép_1' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // max 2mb
            'kép_2' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'kép_3' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $id = DB::table('tasks')->insertGetId(
            [
                'title' => $data['title'],
                'description' => $data['description'],
                'createdBy' => auth()->user()->id ?? null,
                'tags' => implode(",", $this->tagsCorrector($data['tags'])),
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

            for ($i=1; $i <= 3; $i++) { 
                if ($request->has('kép_'.$i)) {
                    $image = $request->file('kép_'.$i);
                    $name = $id . "_" . $i;
                    $folder = "task-img";
                    $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
                    $this->uploadFile($image, $folder, 'public', $name);
                    //$user->profile_image = $filePath;
                }
            }
        }
        
        return redirect("/tasks");
    }

    private function tagsCorrector($tags)
    {
        $tempTags = array();
        foreach(explode(",", $tags) as $value) {
            $tempTags[] = trim($value);
        }
        //return implode(",", $tempTags);
        return $tempTags;
    }

    private function uploadFile(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : "ismeretlen";
        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);
        //dd($file);
        return $file;
    }
}
