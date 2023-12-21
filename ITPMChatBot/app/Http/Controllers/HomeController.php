<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Exam;
use App\Models\ExamAttempt;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        if(Auth::user()->user_type == 'admin'){
            return back();
        } else if(Auth::user()->user_type == 'lecturer') {
            return view('mainhome');
        } else {
            $qnaExam = Exam::with('getQnaExam')->get();
            $attemptCount = ExamAttempt::where(['exam_id'=>$qnaExam[0]['id'],'user_id'=> auth()->user()->id])->count();
            $exams = Exam::with('subjects')->get();
            $attempts = ExamAttempt::where('user_id',Auth()->user()->id)->with('exam')->orderBy('updated_at')->get();
            return view('mainhome',compact('attempts'),['exams'=>$exams,'attemptCount'=>$attemptCount]);
        }
    }
}
