<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Exam;
use App\Models\QnaExam;
use App\Models\ExamAnswer;
use App\Models\ExamAttempt;
use Carbon\Carbon;

class ExamController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function studentExamIndex(){
        $qnaExam = Exam::with('getQnaExam')->get();
        $attemptCount = ExamAttempt::where(['exam_id'=>$qnaExam[0]['id'],'user_id'=> auth()->user()->id])->count();
        $exams = Exam::with('subjects')->get();
        return view('student/exam-dashboard',['exams'=>$exams,'attemptCount'=>$attemptCount]);
    }

    public function loadExamIndex($id){
        $qnaExam = Exam::where('enterance_id',$id)->with('getQnaExam')->get();
        if(count($qnaExam) > 0){
            $attemptCount = ExamAttempt::where(['exam_id'=>$qnaExam[0]['id'],'user_id'=> auth()->user()->id])->count();
            if($attemptCount >= $qnaExam[0]['attempt']){
                return view('student.exam-page',['success'=>false,'msg'=>'Your exam Attemption has been completed!','exam'=>$qnaExam]);
            }
            else if($qnaExam[0]['start_time'] >= date('Y-m-d H:i:s')){
                
                if(count($qnaExam[0]['getQnaExam']) > 0){

                    $qna = QnaExam::where('exam_id',$qnaExam[0]['id'])->with('question','answers')->inRandomOrder()->get();
                    return view('student.exam-page',['success'=>true,'exam'=>$qnaExam,'qna'=>$qna]);
                    
                }
                else{
                    return view('student.exam-page',['success'=>false,'msg'=>'This exam is not available for now!','exam'=>$qnaExam]);
                }
            }
            elseif($qnaExam[0]['start_time'] > date('Y-m-d H:i:s')){
                return view('student.exam-page',['success'=>false,'msg'=>'This exam will be start on '.$qnaExam[0]['date'],'exam'=>$qnaExam]);
            }
            else{
                return view('student.exam-page',['success'=>false,'msg'=>'This exam has been expired on '.$qnaExam[0]['date'],'exam'=>$qnaExam]);
            }
        }
        else{
            return view('404');
        }
    }


    public function examSubmit(Request $request){
        $attempt_id = ExamAttempt::insertGetId([
            'exam_id'=> $request->exam_id,
            'user_id' => Auth::user()->id
        ]);

        $qcount = count($request->q);
        if($qcount > 0){

            for($i = 0; $i < $qcount; $i++){
                if(!empty($request->input('ans_'.($i+1)))){
                    ExamAnswer::insert([
                        'attempt_id' => $attempt_id,
                        'question_id' => $request->q[$i],
                        'answer_id' => request()->input('ans_'.($i+1))
                    ]);
                }
            }
        }

        return view('student/thank-you');
    }

    public function resultIndex(){
        if(Auth::check())
        {
            if(Auth::user()->user_type == 'admin'){
                return redirect()->route('loadAdminRegister');
            }
            else if(Auth::user()->user_type == 'lecturer'){
                return redirect()->route('home');
            }
            else if(Auth::user()->user_type == 'student'){
                $attempts = ExamAttempt::where('user_id',Auth()->user()->id)->with('exam')->orderBy('updated_at')->get();
                return view('student/result',compact('attempts'));
            }
        }
        else
        {
            return redirect()->route('login');

        }

    }

    public function reviewResult(Request $request){
        try{

            $attemptData = ExamAnswer::where('attempt_id',$request->attempt_id)->with(['question','answers'])->get();
            return response()->json(['success'=>true,'msg'=>'Q&A Data','data'=>$attemptData]);

        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function returnPage(){
        if(Auth::user()->user_type == 'admin'){
            return redirect()->route('loadAdminRegister');
        } else {
            return redirect()->route('home');
        }
    }
}
