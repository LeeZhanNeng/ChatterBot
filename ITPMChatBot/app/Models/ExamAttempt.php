<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    use HasFactory;

    protected $fillable = ['exam_id', 'user_id'];
    
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function exam()
    {
        Exam::with('getQnaExam')->get();
        return $this->hasOne(Exam::class,'id','exam_id');
    }
}
