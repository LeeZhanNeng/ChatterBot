<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mail;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;
use App\Imports\QnaImport;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\User;
use App\Models\Question;
use App\Models\Answer;
use App\Models\QnaExam;
use App\Models\ExamAnswer;
use App\Models\ExamAttempt;
use App\Models\UserEmailRegister;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function subjectIndex()
    {
        if(Auth::check())
        {
            if(Auth::user()->user_type == 'admin'){
                return redirect()->route('loadAdminRegister');
            }
            else if(Auth::user()->user_type == 'lecturer'){
                $subjects = Subject::all();
                $questions = Question::with('answers')->get();
                return view('assessment/subject',compact('questions'),compact('subjects'));
            }
            else if(Auth::user()->user_type == 'student'){
                return redirect()->route('home');
            }
        }
        else
        {
            return redirect()->route('login');
        }
    }

    //add Subject
    public function addSubject(Request $request) {
        try{
            Subject::insert([
                'subject' => $request->subject
            ]);

            return response()->json(['success'=>true,'msg'=>'Category added Successfully!']);
        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    //edit Subject
    public function editSubject(Request $request) {
        try{

            $subject = Subject::find($request->id);
            $subject->subject = $request->subject;
            $subject->save();

            return response()->json(['success'=>true,'msg'=>'Category updated Successfully!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    //delete Subject
    public function deleteSubject(Request $request) {
        try{
            Subject::where('id',$request->id)->delete();
            return response()->json(['success'=>true,'msg'=>'Category deleted Successfully!']);
        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    public function examIndex(){
        if(Auth::check()) {
                if(Auth::user()->user_type == 'admin'){
                    return redirect()->route('loadAdminRegister');
                }
                else if(Auth::user()->user_type == 'lecturer'){
                    $subjects = Subject::all();
                    $exams = Exam::with('subjects')->get();
                    $questions = Question::with('answers')->get();
                    return view('assessment/exam',compact('questions'),['subjects'=>$subjects, 'exams'=>$exams]);
                }
                else if(Auth::user()->user_type == 'student'){
                    return redirect()->route('home');
                }
        } else {
            return redirect()->route('login');
        }
    }

    //add Exam
    public function addExam(Request $request){
        try{
            $unique_id = uniqid('exid');

            $startTime = Carbon::parse($request->input('StartTime'))->toDateTimeString();
            $endTime = Carbon::parse($startTime)->addMinutes($request->atime)->toDateTimeString();

            Exam::insert([
                'exam_name' => $request->exam_name,
                'subject_id' => $request->subject_id,
                'time' => $request->time,  
                'start_time' => $startTime,
                'end_time' => $endTime,
                'attempt' => $request->attempt,
                'enterance_id' => $unique_id
            ]);
            return response()->json(['success'=>true,'msg'=>'Exam added Successfully!']);
        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    //get Exam Detail
    public function getExamDetail($id){
        try{
            $exam = Exam::where('id',$id)->get();
            return response()->json(['success'=>true,'data'=>$exam]);
        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    //edit Exam
    public function editExam(Request $request){
        try{
            $editStartTime = Carbon::parse($request->input('editStartTime'))->toDateTimeString();
            $editEndTime = Carbon::parse($editStartTime)->addMinutes($request->editaTime)->toDateTimeString();

            $exam = Exam::find($request->exam_id);
            $exam->exam_name = $request->exam_name;
            $exam->subject_id = $request->subject_id;
            $exam->time = $request->editTime;
            $exam->start_time = $editStartTime;
            $exam->end_time = $editEndTime; 
            $exam->attempt = $request->attempt;
            $exam->save();
            return response()->json(['success'=>true,'msg'=>'Exam updated Successfully!']);
        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }
        
    //delete Exam
    public function deleteExam(Request $request){
        try{
            Exam::where('id',$request->exam_id)->delete();
            QnaExam::where('exam_id',$request->exam_id)->each()->delete();
            ExamAttempt::where('exam_id',$request->exam_id)->each()->delete();
            return response()->json(['success'=>true,'msg'=>'Exam deleted Successfully!']);
            
        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    public function questionAnswerIndex(){
        if(Auth::check()) {
            if(Auth::user()->user_type == 'admin'){
                return redirect()->route('loadAdminRegister');
            }
            else if(Auth::user()->user_type == 'lecturer'){
                $subjects = Subject::all();
                $exams = Exam::with('subjects')->get();
                $questions = Question::with('answers')->get();
                return view('assessment/questionAnswer',compact('questions'),['subjects'=>$subjects, 'exams'=>$exams]);
            }
            else if(Auth::user()->user_type == 'student'){
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('login');
        }
    }

    //add Qna
    public function addQna(Request $request){
        try{
            // Handle image upload
            if($request->file('image')!=''){
                $image=$request->file('image');
                $image->move('images',$image->getClientOriginalName());
                $imageName=$image->getClientOriginalName(); 
            } else {
                $imageName = "empty.jpg"; 
            }
            // Insert question
            $questionId = Question::insertGetId([
                'question' => $request->question,
                'image'=> $imageName
            ]);

            foreach($request->answers as $answer){
                $is_correct = 0;
                if($request->is_correct == $answer){
                    $is_correct = 1;
                }

                Answer::insert([
                    'questions_id' =>$questionId,
                    'answer' =>$answer,
                    'is_correct' =>$is_correct
                ]);
            }

            return response()->json(['success'=>true,'msg'=>'Question added Successfully!']);
        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    public function getQnaDetails(Request $request){
        $qna = Question::where("id",$request->qid)->with('answers')->get();
        return response()->json(['data'=>$qna]);
    }

    public function deleteAns(Request $request){
        Answer::where('id',$request->id)->delete();
        return response()->json(['success'=>true,'msg'=>'Answer deleted success']);
    }

    public function updateQna(Request $request){
        try{
            // Insert question
            if($request->file('image')!=''){
                $image=$request->file('image');
                $image->move('images',$image->getClientOriginalName());
                $imageName=$image->getClientOriginalName(); 
            } else {
                $imageName = "empty.jpg"; 
            }
            
            Question::where('id',$request->question_id)->update([
                'question' => $request->question,
                'image' => $imageName
            ]);

            //old answer update
            if(isset($request->answers)){
                foreach($request->answers as $key => $value){
                    $is_correct = 0;
                    if($request->is_correct == $value){
                        $is_correct =1;
                    }
                    Answer::where('id',$key)
                    ->update([
                        'questions_id' => $request->question_id,
                        'answer' => $value,
                        'is_correct' => $is_correct
                        ]);
                }
            }
            //new answer update
            if(isset($request->new_answers)){
                foreach($request->new_answers as $answer){
                    $is_correct = 0;
                    if($request->is_correct == $answer){
                        $is_correct =1;
                    }
                    Answer::insert([
                        'questions_id' => $request->question_id,
                        'answer' => $answer,
                        'is_correct' => $is_correct
                    ]);
                }
            }
            return response()->json(['success'=>true,'msg'=>'Q&A updated successfully!']);
        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        };
    }

    public function deleteQna(Request $request){
        Question::where('id',$request->id)->delete();
        Answer::where('questions_id',$request->id)->delete();

        return response()->json(['success'=>true,'msg'=>'Q&A deleted successfully!']);
    }

    //import Excel
    public function importQna(Request $request){
        try{
            Excel::import(new QnaImport, $request->file('file'));

            return response()->json(['success'=>true,'msg'=>'Import Q&A successfully!']);
            
        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    //get questions
    public function getQuestions(Request $request){
        try{
            $questions = Question::all();
            if(count($questions) > 0){
                $data = [];
                $counter = 0;

                foreach($questions as $question){
                    $qnaExam = QnaExam::where(['exam_id'=>$request->exam_id,'question_id'=>$question->id])->get();
                    if(count($qnaExam) ==0){
                        $data[$counter]['id'] = $question->id;
                        $data[$counter]['questions'] = $question->question;
                        $counter++;
                    }
                }
                return response()->json(['success'=>true,'msg'=>'Questions data!','data'=>$data]);
            
            } else {
                return response()->json(['success'=>false,'msg'=>'Questions not Found!']);
            }
        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function addQuestions(Request $request){
        try{
            if(isset($request->questions_ids)){
                foreach($request->questions_ids as $qid){
                    QnaExam::insert([
                    'exam_id' => $request->exam_id,
                        'question_id' => $qid
                    ]);
                }
            }
            return response()->json(['success'=>true,'msg'=>'Questions added successfully!']);
        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function getExamQuestions(Request $request){
        try {
            $data = QnaExam::where('exam_id',$request->exam_id)->with('question')->get();
            return response()->json(['success'=>true,'msg'=>'Questions datails!','data'=>$data]);

        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function deleteExamQuestions(Request $request){
        try {
            QnaExam::where('id',$request->id)->delete();
            return response()->json(['success'=>true,'msg'=>'Questions deleted!']);

        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    //exam mark
    public function markIndex()
    {
        if(Auth::check()) {
            if(Auth::user()->user_type == 'admin'){
                return redirect()->route('loadAdminRegister');
            }
            else if(Auth::user()->user_type == 'lecturer'){
                $exams = Exam::with('getQnaExam')->get();
                return view('/assessment/mark',compact('exams'));
            }
            else if(Auth::user()->user_type == 'student'){
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function updateMarks(Request $request) {
        try{
            Exam::where('id',$request->exam_id)->update([
                'marks' => $request->marks,
                'carry_marks' => $request->carry_marks
            ]);
            return response()->json(['success'=>true,'msg'=>'Marks Updated!']);
        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function reviewExamIndex() {
        if(Auth::check()) {
            if(Auth::user()->user_type == 'admin'){
                return redirect()->route('loadAdminRegister');
            }
            else if(Auth::user()->user_type == 'lecturer'){
                $attempts = ExamAttempt::with(['user','exam'])->orderBy('id')->get();
                return view('assessment/review-exam',compact('attempts'));
            }
            else if(Auth::user()->user_type == 'student'){
                return redirect()->route('home');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function reviewQna(Request $request) {
        try{
            $attemptData = ExamAnswer::where('attempt_id',$request->attempt_id)->with(['question','answers'])->get();

            return response()->json(['success'=>true,'data'=>$attemptData]);
        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function approvedExam(Request $request) {
        try{
            $attemptId = $request->attempt_id;

            $examData = ExamAttempt::where('id',$attemptId)->with('exam')->get();

            $marks = $examData[0]['exam']['marks'];

            $attemptData = ExamAnswer::where('attempt_id',$attemptId)->with('answers')->get();

            $totalMarks = 0;

            if(count($attemptData) > 0){
                foreach($attemptData as $attempt){
                    if($attempt->answers->is_correct == 1){
                        $totalMarks += $marks;
                    }
                }
            }

            ExamAttempt::where('id',$attemptId)->update([
                'status' => 1,
                'tmarks' => $totalMarks
            ]);

            $url = URL::to('/');

            $data['url'] = $url.'/result';
            $data['name'] = $examData[0]['user']['name'];
            $data['email'] = $examData[0]['user']['email'];
            $data['exam_name'] = $examData[0]['exam']['exam_name'];
            $data['title'] = $examData[0]['exam']['exam_name'].' Result';

            Mail::send('result-mail',['data' => $data], function($message) use ($data){
                $message->to($data['email'])->subject($data['title']);
                $message->from('admin@sc.edu.my', 'SUC');
            });

            return response()->json(['success'=>true,'msg'=>'Approved Successfully!']);
        } catch(\Exception $e) {
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }
}