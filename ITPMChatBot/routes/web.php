<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminLoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* General */

Route::get('/', [App\Http\Controllers\Controller::class, 'home'])->name('/');

/* Admin */
Route::get('/loadAdminRegister',[AdminLoginController::class,'loadAdminRegister'])->name('loadAdminRegister');
Route::post('/adminRegister',[AdminLoginController::class,'adminRegister'])->name('adminRegister');
Route::get('/userDetail/{id}',[AdminLoginController::class,'getUserDetail'])->name('getUserDetail');
Route::post('/editAdminRegister',[AdminLoginController::class,'editAdminRegister'])->name('editAdminRegister');
Route::post('/deleteUser',[AdminLoginController::class,'deleteUser'])->name('deleteUser'); 

Route::get('/reviewUser',[AdminLoginController::class,'reviewUser'])->name('reviewUser');
Route::get('/reviewUserGet/{id}',[AdminLoginController::class,'reviewUserGet'])->name('reviewUserGet');
Route::post('/reviewUserEdit',[AdminLoginController::class,'reviewUserEdit'])->name('reviewUserEdit');
Route::post('/reviewUserDelete',[AdminLoginController::class,'reviewUserDelete'])->name('reviewUserDelete');

/* Register */
Route::get('/register',[AuthController::class,'loadRegister'])->name('register');
Route::post('/register',[AuthController::class,'userRegister'])->name('userRegister');

/* Login */
Route::get('/login',[AuthController::class,'loadLogin'])->name('login');
Route::post('/userLogin',[AuthController::class,'userLogin'])->name('userLogin');

Route::post('/logout',[AuthController::class,'logout'])->name('logout');

/* Reset Password */
Route::get('password/reset', [AuthController::class,'requestResetPassword'])->name('password.reset');
Route::post('password/reset', [AuthController::class,'checkResetPassword'])->name('password.update');

Route::get('password/confirm', 'App\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'App\Http\Controllers\Auth\ConfirmPasswordController@confirm');

Route::get('email/verify', 'App\Http\Controllers\Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'App\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');

/* About Us */

Route::get('/aboutus', [App\Http\Controllers\Controller::class, 'aboutus'])->name('aboutus');

/* Return Page */
Route::get('/returnPage',[App\Http\Controllers\ExamController::class,'returnPage'])->name('returnPage');

/* Home */
Route::get('/home',[App\Http\Controllers\HomeController::class,'index'])->name('home');

/* Chat */
Route::get('/aichat', [App\Http\Controllers\ChatController::class, 'newAiChat'])->name('aiChat');
Route::get('/aichat/{chatId}', [App\Http\Controllers\ChatController::class, 'getAiChat'])->name('aiChatHistory');
Route::post('/response', [App\Http\Controllers\ChatController::class, 'response'])->name('response');
Route::get('/renameAiChat/{chatId}', [App\Http\Controllers\ChatController::class,'renameAiChat'])->name('renameAiChat');
Route::get('/deleteAiChat/{chatId}', [App\Http\Controllers\ChatController::class,'deleteAiChat'])->name('deleteAiChat');

Route::get('/chat/{userId}', [App\Http\Controllers\ChatController::class, 'userChat'])->name('userChat');
Route::post('/send', [App\Http\Controllers\ChatController::class, 'send'])->name('send');

Route::post('/tts/{id}', [App\Http\Controllers\ChatController::class, 'tts'])->name('tts');

/* Subject */
Route::get('/assessment/subject', [App\Http\Controllers\AdminController::class, 'subjectIndex'])->name('subject');

Route::post('/addSubject', [App\Http\Controllers\AdminController::class, 'addSubject'])->name('addSubject');
Route::post('/editSubject', [App\Http\Controllers\AdminController::class, 'editSubject'])->name('editSubject');
Route::post('/deleteSubject', [App\Http\Controllers\AdminController::class, 'deleteSubject'])->name('deleteSubject');

/* Exam */
Route::get('/assessment/exam', [App\Http\Controllers\AdminController::class, 'examIndex'])->name('exam');

Route::post('/addExam', [App\Http\Controllers\AdminController::class, 'addExam'])->name('addExam');
Route::get('/getExamDetail/{id}', [App\Http\Controllers\AdminController::class, 'getExamDetail'])->name('getExamDetail');
Route::post('/editExam', [App\Http\Controllers\AdminController::class, 'editExam'])->name('editExam');
Route::post('/deleteExam', [App\Http\Controllers\AdminController::class, 'deleteExam'])->name('deleteExam');

/* Q&A */
Route::get('/questionAnswer', [App\Http\Controllers\AdminController::class, 'questionAnswerIndex'])->name('questionAnswer');
Route::post('/addQna', [App\Http\Controllers\AdminController::class, 'addQna'])->name('addQna');
Route::get('/getQnaDetails', [App\Http\Controllers\AdminController::class, 'getQnaDetails'])->name('getQnaDetails');
Route::post('/editQna', [App\Http\Controllers\AdminController::class, 'editQna'])->name('editQna');
Route::get('/deleteAns', [App\Http\Controllers\AdminController::class, 'deleteAns'])->name('deleteAns');
Route::post('/updateQna', [App\Http\Controllers\AdminController::class, 'updateQna'])->name('updateQna');
Route::post('/deleteQna', [App\Http\Controllers\AdminController::class, 'deleteQna'])->name('deleteQna');
Route::post('/importQna', [App\Http\Controllers\AdminController::class, 'importQna'])->name('importQna');

/* Students */
Route::get('/students/Exam', [App\Http\Controllers\ExamController::class, 'studentExamIndex'])->name('studentExamIndex');
Route::get('reviewResult', [App\Http\Controllers\ExamController::class, 'reviewResult'])->name('reviewResult');

/* Q&A Exam */
Route::get('/getQuestions', [App\Http\Controllers\AdminController::class, 'getQuestions'])->name('getQuestions');
Route::post('/addQuestions', [App\Http\Controllers\AdminController::class, 'addQuestions'])->name('addQuestions');
Route::get('/getExamQuestions', [App\Http\Controllers\AdminController::class, 'getExamQuestions'])->name('getExamQuestions');
Route::get('/deleteExamQuestions', [App\Http\Controllers\AdminController::class, 'deleteExamQuestions'])->name('deleteExamQuestions');

Route::get('/exam/{id}', [App\Http\Controllers\ExamController::class, 'loadExamIndex'])->name('loadExamIndex');
Route::post('/examSubmit', [App\Http\Controllers\ExamController::class, 'examSubmit'])->name('examSubmit');

/* Exam Mark */
Route::get('/assessment/mark', [App\Http\Controllers\AdminController::class, 'markIndex'])->name('mark');
Route::post('updateMarks', [App\Http\Controllers\AdminController::class, 'updateMarks'])->name('updateMarks');

/* Exam Review */
Route::get('/assessment/reviewExam', [App\Http\Controllers\AdminController::class, 'reviewExamIndex'])->name('reviewExam');
Route::get('reviewQna', [App\Http\Controllers\AdminController::class, 'reviewQna'])->name('reviewQna');
Route::post('approvedExam', [App\Http\Controllers\AdminController::class, 'approvedExam'])->name('approvedExam');

/* Result */
Route::get('result', [App\Http\Controllers\ExamController::class, 'resultIndex'])->name('resultIndex');
