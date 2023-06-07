<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\QnAExam;
use App\Models\ExamAttempt;
use App\Models\ExamAnswer;
use Illuminate\Support\Facades\Auth;
class ExamController extends Controller
{
    //
    public function loadExamDashboard($id)
    {
       $qnaExam = Exam::where('enterance_id',$id)->with('getQnAExam')->get();
       if (count($qnaExam) > 0) {

        $attemptCount = ExamAttempt::where(['exam_id'=>$qnaExam[0]['id'],'user_id'=>auth()->user()->id])->count();
        if ($attemptCount >= $qnaExam[0]['attempt']) {
            return view('student.exam-dashboard',['success'=>false,'msg'=>'A vizsga próbálkozások számát elérte','exam'=>$qnaExam]);
        }
       else if($qnaExam[0]['date'] == date('Y-m-d')){

            if (count($qnaExam[0]['getQnAExam']) > 0) {

                $qna = QnAExam::where('exam_id',$qnaExam[0]['id'])->with('question','answers')->inRandomOrder()->get();
                return view('student.exam-dashboard',['success'=>true,'exam'=>$qnaExam,'qna'=>$qna]);

            }
            else {
                return view('student.exam-dashboard',['success'=>false,'msg'=>'A vizsga vizsga nem elérhető'.$qnaExam[0]['date'],'exam'=>$qnaExam]);
            }
        }
        else if ($qnaExam[0]['date'] > date('Y-m-d')) {
            return view('student.exam-dashboard',['success'=>false,'msg'=>'A vizsga kezdődik'.$qnaExam[0]['date'],'exam'=>$qnaExam]);
        }
        else {
            return view('student.exam-dashboard',['success'=>false,'msg'=>'A vizsga lejárt'.$qnaExam[0]['date'],'exam'=>$qnaExam]);

        }

       }
       else{
        return view('404');
       }
    }

    public function examSubmit(Request $request)
    {

        $attempt_id = ExamAttempt::insertGetId([
            'exam_id' => $request->exam_id,
            'user_id' => Auth::user()->id
        ]);

        $qcount = count($request->q);
        if ($qcount > 0) {

            for($i = 1; $i < $qcount; $i++){
                if (!empty($request->input('ans_'.($i+1)))) {
                    ExamAnswer::insert([
                        'attempt_id'=> $attempt_id,
                        'question_id'=>$request->q[$i],
                        'answer_id'=>request()->input('ans_'.($i+1))

                    ]);
                }
            }

        }
        return view('thank-you');
    }

    public function resultDashboard()
    {
        $attempts = ExamAttempt::where('user_id', Auth()->user()->id)->with('exam')->orderBy('updated_at')->get();
        return view('student.results', compact('attempts'));
    }

    public function reviewQnA(Request $request)
    {
        try {

            $attemptData = ExamAnswer::where('attempt_id' ,$request->attempt_id)->with('question','answers')->get();

            return response()->json(['success'=>true,'msg'=>'K&V Data','data'=>$attemptData]);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }


}
