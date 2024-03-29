<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Http\Controllers\BadgeController;

class TaskController extends Controller
{
    private $forbiddenExpressions = array(
        "python" => array("mysql", "open", "os.")
    );

    protected function index($id)
    {
        $task = DB::table('tasks')->select('*')->where('id', '=', $id)->get()->first();
        
        $creator = DB::table('users')->select('name', 'currentBadge')->where('id', '=', $task->createdBy)->get()->first(); // feladat készítője

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
            ['taskid' => $id, 'hint' => strval($data['hint'])]
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
              ->update(['hint' => strval($data['hint'])]);
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
        $testCases = DB::table('testcase')->select('*')->where('taskid', '=', $id)->get();
        $usertask = DB::table('usertask')->select('*')->whereRaw('userid = ? AND taskid = ?', [auth()->user()->id ?? -1, $id])->get()->first();
        $hints = DB::table('hints')->select('*')->where('taskid', '=', $id)->get();

        $exists = Storage::disk('public')->exists('task-img/30_1.jpg');

        $images = Storage::url('public/task-img/30_1.jpg');

        return view('layouts/task/ide', [
            'task' => $task,
            'testCases' => $testCases,
            'usertask' => $usertask ?? [],
            'hints' => $hints ?? [],
            'images' => $this->getTaskImages($task->id),
        ]);
    }

    private function getTaskImages($taskid)
    {
        $images = array();
        $imgExtensions = array("jpeg", "png", "jpg", "gif");
        for ($i=1; $i <= 3; $i++) {
            foreach($imgExtensions as $ext) {
                if (Storage::disk('public')->exists('task-img/'.$taskid.'_'.$i.'.'.$ext)) {
                    $images[] = $taskid.'_'.$i.'.'.$ext;
                    break;
                }
            }
        }
        return $images;
    }

    protected function test(Request $request)
    {
        $testCase = DB::table('testcase')->select('*')->where('id', '=', $request->testID)->get()->first();
        switch($request->lang) {
            case "python":
                $foundForbiddenExpressions = $this->checkForbiddenExpressions($request->lang, $request->code);
                if (empty($foundForbiddenExpressions)) {
                    Storage::disk('local')->put('/userCodes/'.$request->userid.'.py', $request->code);
                    $python = env('PYTHON_COMPILER', 'python3');
                    $process = new Process([$python, env('PROCESS_FOLDER', '/var/www/').$request->userid.'.py']);
                    $process->setInput($testCase->test_input);
                } else {
                    $returnData = array("foundForbiddenExpressions" => true, "text" => "Tiltott kifejezés található a kódodban: " . implode(", ", $foundForbiddenExpressions));
                    return json_encode($returnData); 
                }
                break;
            default:
                return "hibás programozási nyelv";
        }
        
        $process->setTimeout(10);
        $run = $process->run();
        
        if (!$process->isSuccessful()) {
            $data = array();
            $data['success'] = false;
            $data['text'] = nl2br(utf8_encode($process->getErrorOutput()));
            $data['output'] = $process->getErrorOutput();
            $data['test_output'] = $testCase->test_output;
            return json_encode($data);
        }
        
        $returnData = array("success" => (trim(strval(rtrim($process->getOutput(), "\n"))) == trim(strval($testCase->test_output))), "text" => nl2br($process->getOutput()), "a" => rtrim($process->getOutput(), "\n"), "test_output" => $testCase->test_output);
        return json_encode($returnData);
    }

    protected function submitTask(Request $request)
    {
        $usertask = DB::table('usertask')->select('*')->whereRaw('userid = ? AND taskid = ?', [$request->userid, $request->taskid])->get()->first();
        if (isset($usertask)) {
            $returnData = array("success" => false);
            return json_encode($returnData);
        }

        $point = $this->pointCalculation($request->taskid, $request->userid, $request->code, $request->lang, $request->timeLeft ?? 0, $request->usedHintIndex, $request->maxHint);

        DB::table('usertask')->insert([
            'userid' => $request->userid,
            'taskid' => $request->taskid,
            'code' => $request->code,
            'language' => $request->lang,
            'leftTime' => $request->timeLeft ?? 0,
            'points' => $point,
            'usedHintIndex' => $request->usedHintIndex ?? 0,
        ]);

        if ($point > 0 && $request->lang == "python") {
            BadgeController::tryToAddBadge($request->userid, 1);
        }

        if ($point >= 100) {
            BadgeController::tryToAddBadge($request->userid, 2);
        }
        

        $returnData = array("success" => true);
        return json_encode($returnData);
    }

    protected function hint(Request $request)
    {
        $hint = DB::table('hints')->select('*')->where('taskid', '=', $request->taskid)->offset(($request->hintIndex)-1)->limit(1)->get()->first();
        return $hint->hint;
    }

    private function pointCalculation($taskid = -1, $userid = -1, $code = "", $language = "python", $timeLeft = 0, $usedHintIndex = 0, $maxHint = 0)
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
                    $foundForbiddenExpressions = $this->checkForbiddenExpressions($language, $code);
                    if (empty($foundForbiddenExpressions)) {
                        Storage::disk('local')->put('/userCodes/'.$userid.'.py', $code);
                        $python = env('PYTHON_COMPILER', 'python3');
                        $process = new Process([$python, env('PROCESS_FOLDER', '/var/www/').$userid.'.py']);
                        $process->setInput($testCases[$i]->validator_input);
                    } else {
                        return 0;
                    }
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
        
        // idő (max 15 perc (900 mp)) (600 másodperc alatt vesz csak el pontot)
        if ($timeLeft < 600) {
            $timeLeft = max($timeLeft, 0);
            $point -= (600 - $timeLeft) / 600 * 25;
        }

        DB::table('log')->insert(
            [
                'text' => $timeLeft,
            ]
        );
        
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

    protected function checkForbiddenExpressions($language, $code)
    {
        $results = array();
        foreach ($this->forbiddenExpressions[$language] as $key => $value) {
            if (strpos($code, $value) !== false) {
                $results[] = $value;
            }
        }
        return $results;
    }
}