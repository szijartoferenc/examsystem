<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\User;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Question;
use App\Models\Answer;
use App\Models\QnAExam;
use App\Models\ExamAnswer;

use App\Imports\QnAImport;
use App\Exports\ExportStudent;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

// use Symfony\Component\HttpKernel\HttpCache\SubRequestHandler;

class AdminController extends Controller
{
    //addSubject

    public function addSubject(Request $request)
    {
        try{

            Subject::insert([
                'subject' => $request->subject
            ]);

            return response()->json(['success'=>true,'msg'=>'A tantárgy sikeresen hozzáadva!']);

        }catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    //editSubject

    public function editSubject(Request $request)
    {
        try{

            $subject = Subject::find($request->id);
            $subject->subject = $request->subject;
            $subject->save();
            return response()->json(['success'=>true,'msg'=>'A tantárgy sikeresen feltöltve!']);

        }catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    //deleteSubject

    public function deleteSubject(Request $request)
    {
        try{

            Subject::where('id', $request->id)->delete();
            return response()->json(['success'=>true,'msg'=>'A tantárgy sikeresen törölve!']);

        }catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

     //exam dashboard
     public function examDashboard()
     {
       $subjects = Subject::all();
       $exams = Exam::with('subjects')->get();
         return view('admin.exam-dashboard', ['subjects'=>$subjects,'exams'=>$exams]);
     }


     //add exam
     public function addExam(Request $request)
     {
        try{
            $unique_id = uniqid('exid');
            Exam::insert([
                'exam_name' => $request->exam_name,
                'subject_id' => $request->subject_id,
                'date' => $request->date,
                'time' => $request->time,
                'attempt'=> $request->attempt,
                'enterance_id'=>$unique_id
            ]);

            return response()->json(['success'=>true,'msg'=>'A vizsga adatok sikeresen hozzáadva!']);

        }catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
     }

     //editExam
     public function getExamDetail($id)
     {
        try{

            $exam = Exam::where('id',$id)->get();
            return response()->json(['success'=>true,'data'=>$exam]);

        }catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
     }

     public function updateExam(Request $request)
     {
        try{

            $exam = Exam::find($request->exam_id);
            $exam->exam_name = $request->exam_name;
            $exam->subject_id = $request->subject_id;
            $exam->date = $request->date;
            $exam->time = $request->time;
            $exam->attempt = $request->attempt;
            $exam->save();
            return response()->json(['success'=>true,'Vizsga sikeresen feltöltve!']);

        }catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
     }

    //deleteExam
     public function deleteExam(Request $request)
     {
         try{

             Exam::where('id', $request->exam_id)->delete();
             return response()->json(['success'=>true,'msg'=>'A vizsga sikeresen törölve!']);

         }catch(\Exception $e) {
             return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
         };
     }

     //QnA dashboard
     public function qnaDashboard()
     {
        $questions = Question::with('answers')->get();
         return view('admin.qnaDashboard', compact('questions'));
     }


     //add QnA
     public function addQnA(Request $request)
     {

        try{

            $explaination = null;
            if(isset($request->explaination)) {
                $explaination = $request->explaination;
            }

           $questionId = Question::insertGetId([
                'question' => $request->question,
                'explaination'=> $explaination
            ]);



            foreach($request->answers as $answer){

                $is_correct = 0;
                if($request->is_correct == $answer){
                    $is_correct = 1;
                }

                Answer::insert([
                    'questions_id'=> $questionId,
                    'answer'=> $answer,
                    'is_correct'=> $is_correct

                ]);
            }
            return response()->json(['success'=>true,'msg'=>'A kérdés-válasz sikeresen rögzítve!']);

        }catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };

     }

     //Edit QnA

     public function getQnADetails(Request $request)
     {
        $qna = Question::where('id', $request->qid)->with('answers')->get();

        return response()->json(['data'=>$qna]);
     }


     //delete Answers

     public function deleteAns(Request $request)
     {
        Answer::where('id', $request->id)->delete();

        return response()->json(['success'=>true, 'msg'=>'Válasz sikeresen törölve']);
     }

     //update QnA

     public function updateQnA(Request $request)
     {
        try{

            $explaination = null;
            if(isset($request->explaination)) {
                $explaination = $request->explaination;
            }

            Question::where('id', $request->question_id)->update([
               'question'=> $request->question,
               'explaination'=> $explaination
           ]);

           //old answers
           if(isset($request->answers)){

               foreach ($request->answers as $key => $value) {

                   $is_correct = 0;
                   if ($request->is_correct == $value) {
                       $is_correct = 1;
                   }

                   Answer::where('id', $key)
                   ->update([
                       'questions_id'=> $request->question_id,
                       'answer'=> $value,
                       'is_correct'=> $is_correct
                   ]);
               }
           }

           //new answers
           if(isset($request->new_answers)){

               foreach ($request->new_answers as $key => $answer) {

                   $is_correct = 0;
                   if ($request->is_correct == $answer) {
                       $is_correct = 1;
                   }

                   Answer::insert([
                       'questions_id'=> $request->question_id,
                       'answer'=> $answer,
                       'is_correct'=> $is_correct
                   ]);
               }
           }
           return response()->json(['success'=>true,'msg'=>'K&V sikeresen feltöltve!']);

       }catch(\Exception $e){
           return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
       };
        // return response()->json($request->all());



     }

     //delete QnA
     public function deleteQnA(Request $request)
     {
         Question::where('id', $request->id)->delete();
         Answer::where('questions_id', $request->id)->delete();

         return response()->json(['success'=>true,'msg'=>'K&V sikeresen törölve!']);
     }


     //import QnA
     public function importQnA(Request $request)
     {
        try{

            Excel::import(new QnAImport, $request->file('file'));

            return response()->json(['success'=>true,'msg'=>'K&V sikeresen importálva!']);

        }catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
     }

     //students dashboard

     public function studentsDashboard()
     {
        $students = User::where('admin_role', 0)->get();
        return view('admin.studentsDashboard', compact('students'));
     }

     //add students

     public function addStudent(Request $request)
    {
        try{

            $password = Str::random(8);

            User::insert([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=>Hash::make($password)
            ]);

            $url = URL::to('/');

            $data['url'] = $url;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['password'] = $password;
            $data['title'] = "Hallgatói regisztráció az online vizsgarendszeren";

            Mail::send('registrationMail',['data'=>$data],function($message) use ($data){
                $message->to($data['email'])->subject($data['title']);
            });
            return response()->json(['success'=>true,'msg'=>'Hallgató sikeresen hozzáadva!']);

        }catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

     //update students

     public function editStudent(Request $request)
    {
        try{


          $user = User::find($request->id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

           $url = URL::to('/');

            $data['url'] = $url;
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['title'] = "Hallgatói adat feltöltése az online vizsgarendszeren";

            Mail::send('updateProfileMail',['data'=>$data],function($message) use ($data){
                $message->to($data['email'])->subject($data['title']);
            });
            return response()->json(['success'=>true,'msg'=>'Hallgató sikeresen hozzáadva!']);

        }catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    //delete Student

    public function deleteStudent(Request $request)
    {
        try{

            User::where('id', $request->id)->delete();
            return response()->json(['success'=>true,'A hallgató sikeresen törölve!']);

        }catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    //Export Students
    public function exportStudents()
    {
        return Excel::download(new ExportStudent, 'students.xlsx');
    }

    //getQuestions

    public function getQuestions(Request $request)
    {

        try{

            $questions = Question::all();

            if(count($questions) > 0){

                $data = [];
                $counter = 0;

                foreach($questions as $question)
                {
                    $qnaExam = QnAExam::where(['exam_id'=>$request->exam_id, 'question_id'=>$question->id])->get();
                    if (count($qnaExam) == 0){
                        $data[$counter]['id'] = $question->id;
                        $data[$counter]['questions'] = $question->question;
                        $counter++;
                    }
                }
                return response()->json(['success'=>true,'Questions data!', 'data'=>$data]);

            }
            else{
                return response()->json(['success'=>false,'Kérdések nem találhatóak!']);
            }
        }catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    //vége
    public function addQuestions(Request $request)
    {
        try{

            if (isset($request->questions_ids)){

                foreach($request->questions_ids as $qid){
                    QnAExam::insert([
                        'exam_id' => $request->exam_id,
                        'question_id' => $qid

                    ]);
                }

            }
            return response()->json(['success'=>true,'Kérdések sikeresen hozzáadva']);

        }catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };

    }

    //Show examQuestions

    public function getExamQuestions(Request $request)
    {
        try {

          $data = QnAExam::where('exam_id', $request->exam_id)->with('question')->get();
            return response()->json(['success'=>true,'Questions details', 'data'=>$data]);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    //deleteExam Questions
    public function deleteExamQuestions(Request $request)
    {
        try {

          $data = QnAExam::where('id', $request->id)->delete();
            return response()->json(['success'=>true,'Kérdés törölve!']);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    //Exam marks
    public function loadMarks()
    {
        $exams = Exam::with('getQnAExam')->get();
        return view('admin.marksDashboard', compact('exams'));
    }

    //Exam marks update
    public function updateMarks(Request $request)
    {
        try {

            Exam::where('id',$request->exam_id)->update([
                'marks' => $request->marks,
                'passing_marks'=> $request->passing_marks
            ]);
            return response()->json(['success'=>true,'msg'=>'A pontszám feltöltve!']);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function reviewExams()
    {
       $attempts = ExamAttempt::with(['user','exam'])->orderBy('id')->get();

       return view('admin.review-exams', compact('attempts'));
    }

    public function reviewQnA(Request $request)
    {
        try {

            $attemptData = ExamAnswer::where('attempt_id', $request->attempt_id)->with(['question','answers'])->get();

            return response()->json(['success'=>true,'data'=>$attemptData]);

        } catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }

    }

    public function approvedQnA(Request $request)
    {
        try {

            $attemptId = $request->attempt_id;

            $examData = ExamAttempt::where('id',$attemptId)->with('user','exam')->get();
            $marks = $examData[0]['exam']['marks'];

            $attemptData = ExamAnswer::where('attempt_id' ,$attemptId)->with('answers')->get();

            $totalmarks = 0;

            if (count($attemptData) > 0) {

                foreach ($attemptData as $attempt) {

                    if($attempt->answers->is_correct == 1){
                        $totalmarks += $marks;
                    }
                }
            }

            ExamAttempt::where('id',$attemptId)->update([
                'status' => 1,
                'marks' => $totalmarks

            ]);

            $url = URL::to('/');

            $data['url'] = $url.'/results';
            $data['name'] = $examData[0]['user']['name'];
            $data['email'] = $examData[0]['user']['email'];
            $data['exam_name'] = $examData[0]['exam']['exam_name'];
            $data['title'] = $examData[0]['exam']['exam_name'].'Result';

            Mail::send('result-mail',['data'=>$data],function($message) use ($data){
                $message->to($data['email'])->subject($data['title']);
            });


            return response()->json(['success'=>true,'msg'=>'Approved successfully']);

        }catch (\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }


}
