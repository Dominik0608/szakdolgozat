<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class TaskController extends Controller
{
    protected function index($id)
    {
        $task = DB::table('tasks')->select('*')->where('id', '=', $id)->get()->first();
        
        $creator = DB::table('users')->select('name')->where('id', '=', $task->createdBy)->get()->first(); // feladat készítője

        $usertask = DB::table('usertask')->join('users', 'usertask.userid', '=', 'users.id')->select('usertask.*', 'users.name')->whereRaw('taskid = ? AND points IS NOT NULL', [$id])->orderByDesc('usertask.points')->limit(10)->get(); // feladatot már megoldók listája
        
        $mytask = DB::table('usertask')->select('*')->whereRaw('taskid = ? AND userid = ?', [$id, auth()->user()->id ?? -1])->get()->first();

        if ($task->createdBy == (auth()->user()->id ?? -1)) {
            $feedbacks = DB::table('feedbacks')->join('users', 'users.id', '=', 'feedbacks.userid')->select('users.name', 'feedbacks.feedback', 'feedbacks.date')->where('taskid', '=', $id)->orderByDesc('feedbackid')->get();
        }

        return view("layouts/task/task", [
            'task' => $task,
            'creator' => $creator ?? null,
            'usertask' => $usertask,
            'mytask' => $mytask ?? null,
            'feedbacks' => $feedbacks ?? [],
        ]);
    }

    protected function edit($id)
    {
        $task = DB::table('tasks')->select('*')->where('id', '=', $id)->get()->first();
        $testCases = DB::table('testcase')->select('*')->where('taskid', '=', $id)->get();
        $hints = DB::table('hints')->select('*')->where('taskid', '=', $id)->get();
        return view('layouts/task/edit', [
            'task' => $task,
            'testCases' => $testCases,
            'hints' => $hints,
        ]);
    }

    private function getTestCases($id)
    {
        $testCases = DB::table('testcase')->select('*')->where('taskid', '=', $id)->get();
        return $testCases;
    }

    protected function update($id)
    {
        $data = request()->validate([
            'title' => ['string', 'max:255'],
            'description' => ['string'],
        ]);
        DB::table('tasks')
              ->where('id', $id)
              ->update(['title' => $data['title'], 'description' => $data['description']]);
        return $this->edit($id);
    }


    // Hints

    protected function newhint($id)
    {
        $task = DB::table('tasks')->select('*')->where('id', '=', $id)->get()->first();
        return view('layouts/task/newhint', [
            'taskid' => $id,
            'taskowner' => $task->createdBy ?? -1,
        ]);
    }

    protected function savenewhint($id)
    {
        $data = request()->validate([
            'hint' => ['string'],
        ]);
        DB::table('hints')->insert(
            ['taskid' => $id, 'hint' => $data['hint']]
        );
        return $this->edit($id);
    }

    protected function hintedit($id, $hintid)
    {
        $hint = DB::table('hints')->select('*')->where('id', '=', $hintid)->get()->first();
        $task = DB::table('tasks')->select('*')->where('id', '=', $id)->get()->first();
        return view('layouts/task/hintedit', [
            'task' => $task,
            'hint' => $hint ?? null,
        ]);
    }

    protected function savehint(Request $request, $id, $hintid)
    {
        if ($request->submitbutton == "save") {
        $data = request()->validate([
            'hint' => ['string'],
        ]);
        
        DB::table('hints')
              ->where('id', $hintid)
              ->update(['hint' => $data['hint']]);
        } else {
            DB::table('hints')->where('id', '=', $hintid)->delete();
        }
        return $this->edit($id);
    }


    // Testcases

    protected function newtestcase($id)
    {
        $task = DB::table('tasks')->select('*')->where('id', '=', $id)->get()->first();
        return view('layouts/task/newtestcase', [
            'taskid' => $id,
            'taskowner' => $task->createdBy ?? -1,
        ]);
    }

    protected function savenewtestcase($id)
    {
        $data = request()->validate([
            'test_input' => ['string'],
            'test_output' => ['string'],
            'validator_input' => ['string'],
            'validator_output' => ['string'],
        ]);
        DB::table('testcase')->insert([
            'taskid' => $id,
            'test_input' => $data['test_input'],
            'test_output' => $data['test_output'],
            'validator_input' => $data['validator_input'],
            'validator_output' => $data['validator_output'],
        ]);
        return $this->edit($id);
    }

    protected function testcaseedit($id, $testcaseid)
    {
        $testcase = DB::table('testcase')->select('*')->where('id', '=', $testcaseid)->get()->first();
        $task = DB::table('tasks')->select('*')->where('id', '=', $id)->get()->first();
        return view('layouts/task/testcaseedit', [
            'task' => $task,
            'testcase' => $testcase ?? null,
        ]);
    }

    protected function savetestcase(Request $request, $id, $testcaseid)
    {
        if ($request->submitbutton == "save") {
            $data = request()->validate([
                'test_input' => ['string'],
                'test_output' => ['string'],
                'validator_input' => ['string'],
                'validator_output' => ['string'],
            ]);
            
            DB::table('testcase')
                ->where('id', $testcaseid)
                ->update([
                    'test_input' => $data['test_input'],
                    'test_output' => $data['test_output'],
                    'validator_input' => $data['validator_input'],
                    'validator_output' => $data['validator_output'],
                    ]);
        } else {
            DB::table('testcase')->where('id', '=', $testcaseid)->delete();
        }
        return $this->edit($id);
    }

    // feladat megoldása
    protected function ide($id)
    {
        $task = DB::table('tasks')->select('*')->where('id', '=', $id)->get()->first();
        $testCases = DB::table('testcase')->select('id')->where('taskid', '=', $id)->get();
        $usertask = DB::table('usertask')->select('*')->whereRaw('userid = ? AND taskid = ?', [auth()->user()->id ?? -1, $id])->get()->first();
        $hints = DB::table('hints')->select('*')->where('taskid', '=', $id)->get();

        return view('layouts/task/ide', [
            'task' => $task,
            'testCases' => $testCases,
            'usertask' => $usertask ?? [],
            'hints' => $hints ?? [],
        ]);
    }

    protected function test(Request $request)
    {
        $testCase = DB::table('testcase')->select('*')->where('id', '=', $request->testID)->get()->first();
        switch($request->lang) {
            case "python":
                Storage::disk('local')->put('/userCodes/'.$request->userid.'.py', $request->code);
                $python = 'C:\Users\danko\AppData\Local\Programs\Python\Python37-32\python.exe'; // ki kéne rakni majd valami konfig fájlba
                $process = new Process([$python, 'C:\wamp\www\blog\storage\app\userCodes/'.$request->userid.'.py']);
                $process->setInput($testCase->test_input);
                break;
            default:
                return "hibás programozási nyelv";
        }
        $process->setTimeout(10);
        $process->run();

        if (!$process->isSuccessful()) {
            $data->success = false;
            $data->text = nl2br(utf8_encode($process->getErrorOutput()));
            return json_encode($data);
        }

        $returnData = array("success" => (trim(strval(rtrim($process->getOutput(), "\n"))) == trim(strval($testCase->test_output))), "text" => nl2br(utf8_encode($process->getOutput())), "a" => rtrim($process->getOutput(), "\n"), "b" => $testCase->test_output);
        return json_encode($returnData);
    }

    protected function submitTask(Request $request)
    {
        $usertask = DB::table('usertask')->select('*')->whereRaw('userid = ? AND taskid = ?', [$request->userid, $request->taskid])->get()->first();
        if (isset($usertask)) {
            $returnData = array("success" => false);
            return json_encode($returnData);
        }

        DB::table('usertask')->insert([
            'userid' => $request->userid,
            'taskid' => $request->taskid,
            'code' => $request->code,
            'language' => $request->lang,
            'leftTime' => $request->leftTime ?? 0,
            'points' => $this->pointCalculation($request->taskid, $request->userid, $request->code, $request->lang, $request->leftTime ?? 0, $request->usedHintIndex, $request->maxHint),
            'usedHintIndex' => $request->usedHintIndex ?? 0,
        ]);

        $returnData = array("success" => true);
        return json_encode($returnData);
    }

    protected function hint(Request $request)
    {
        $hint = DB::table('hints')->select('*')->where('taskid', '=', $request->taskid)->offset(($request->hintIndex)-1)->limit(1)->get()->first();
        return $hint->hint;
    }

    private function pointCalculation($taskid = -1, $userid = -1, $code = "", $language = "python", $leftTime = 0, $usedHintIndex = 0, $maxHint = 0)
    {
        // hibátlan tesztek 100 pontot érnek | segítségek és idő max 25-25 pontot vehet el arányosan
        $point = 0;

        // tesztek
        $testCases = DB::table('testcase')->select('*')->where('taskid', '=', $taskid)->get();
        $testCaseCount = count($testCases) ?? 0;
        for($i = 0; $i < $testCaseCount; $i++)
        {
            switch($language) {
                case "python":
                    Storage::disk('local')->put('/userCodes/'.$userid.'.py', $code);
                    $python = 'C:\Users\danko\AppData\Local\Programs\Python\Python37-32\python.exe'; // ki kéne rakni majd valami konfig fájlba
                    $process = new Process([$python, 'C:\wamp\www\blog\storage\app\userCodes/'.$userid.'.py']);
                    $process->setInput($testCases[$i]->validator_input);
                    break;
                default:
                    return "hibás programozási nyelv";
            }
            $process->setTimeout(10);
            $process->run();

            if (!$process->isSuccessful()) {
                continue;
            }

            if (trim(strval(rtrim($process->getOutput(), "\n"))) == trim(strval($testCases[$i]->validator_output))) {
                $point += 100 / $testCaseCount;
            }
        }

        // segítségek
        if ($maxHint > 0) {
            $point -= $usedHintIndex / $maxHint * 25;
        }
        
        // idő (max 15 perc (900 mp))
        $point -= (900 - $leftTime) / 900 * 25;
        
        return max($point, 0);
    }

    protected function sendFeedback(Request $request)
    {
        // üres textarea
        if (strlen(trim($request->feedback)) == 0) {
            $returnData = array("success" => false, "error" => "Üresen hagytad a szöveg mezőt!");
            return json_encode($returnData);
        }

        // megvolt az 5 feedback a feladatra
        $feedbacks = DB::table('feedbacks')->whereRaw('taskid = ? AND userid = ?', [$request->taskid, $request->userid])->get();
        if (count($feedbacks) >= 5) {
            $returnData = array("success" => false, "error" => "Egy felhasználó maximum 5 visszajelzést küldhet feladatonként!");
            return json_encode($returnData);
        }
        

        // sql insert
        DB::table('feedbacks')->insert([
            'taskid' => $request->taskid,
            'userid' => $request->userid,
            'feedback' => $request->feedback,
        ]);
        $returnData = array("success" => $request->feedback);
        return json_encode($returnData);
    }
}