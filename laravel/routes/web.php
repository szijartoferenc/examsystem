<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExamController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function(){
    return redirect('/');
});

Route::get('/register', [AuthController::class,'loadRegister']);
Route::post('/register', [AuthController::class,'studentRegister'])->name('studentRegister');

Route::get('/', [AuthController::class,'loadLogin']);
Route::post('/login', [AuthController::class,'userLogin'])->name('userLogin');

Route::get('/logout', [AuthController::class,'logout']);

Route::get('/forget-password', [AuthController::class,'forgetPasswordLoad']);
Route::post('/forget-password', [AuthController::class,'forgetPassword'])->name('forgetPassword');

Route::get('/reset-password', [AuthController::class,'resetPasswordLoad']);
Route::post('/reset-password', [AuthController::class,'resetPassword'])->name('resetPassword');

Route::group(['middleware'=>['web','checkAdmin']], function(){
    Route::get('/admin/dashboard', [AuthController::class,'adminDashboard']);

    //Tantárgy route
    Route::post('/add-subject', [AdminController::class,'addSubject'])->name('addSubject');
    Route::post('/edit-subject', [AdminController::class,'editSubject'])->name('editSubject');
    Route::post('/delete-subject', [AdminController::class,'deleteSubject'])->name('deleteSubject');

    //Vizsga route
    Route::get('/admin/exam', [AdminController::class,'examDashboard']);
    Route::post('/add-exam', [AdminController::class,'addExam'])->name('addExam');
    Route::get('/get-exam-detail/{id}', [AdminController::class,'getExamDetail'])->name('getExamDetail');
    Route::post('/update-exam', [AdminController::class,'updateExam'])->name('updateExam');
    Route::post('/delete-exam', [AdminController::class,'deleteExam'])->name('deleteExam');

    //Kérdések route
    Route::get('/admin/questions-answers', [AdminController::class,'qnaDashboard']);
    Route::post('/add-questions-answers', [AdminController::class,'addQnA'])->name('addQnA');
    Route::get('/get-questions-answers-details', [AdminController::class,'getQnADetails'])->name('getQnADetails');
    Route::get('/delete-answer', [AdminController::class,'deleteAns'])->name('deleteAns');
    Route::post('/update-questions-answers', [AdminController::class,'updateQnA'])->name('updateQnA');
    Route::post('/delete-questions-answers', [AdminController::class,'deleteQnA'])->name('deleteQnA');
    Route::post('/import-questions-answers', [AdminController::class,'importQnA'])->name('importQnA');

    //Hallgatók
    Route::get('/admin/students', [AdminController::class,'studentsDashboard']);
    Route::post('/add-student', [AdminController::class,'addStudent'])->name('addStudent');
    Route::post('/edit-student', [AdminController::class,'editStudent'])->name('editStudent');
    Route::post('/delete-student', [AdminController::class,'deleteStudent'])->name('deleteStudent');
    Route::get('/export-students', [AdminController::class,'exportStudents'])->name('exportStudents');

    //Vizsgakérdések
    Route::get('/get-questions', [AdminController::class,'getQuestions'])->name('getQuestions');
    Route::post('/add-questions', [AdminController::class,'addQuestions'])->name('addQuestions');
    Route::get('/get-exam-questions', [AdminController::class,'getExamQuestions'])->name('getExamQuestions');
    Route::get('/delete-exam-questions', [AdminController::class,'deleteExamQuestions'])->name('deleteExamQuestions');

    //Vizsga értékelése
    Route::get('/admin/marks', [AdminController::class,'loadMarks']);
    Route::post('/update-marks', [AdminController::class,'updateMarks'])->name('updateMarks');

    //Vizsga felülvizsgálat
    Route::get('/admin/review-exams', [AdminController::class,'reviewExams'])->name('reviewExams');
    Route::get('/get-reviewed-qna', [AdminController::class,'reviewQnA'])->name('reviewQnA');
    Route::post('/approved-qna/', [AdminController::class,'approvedQnA'])->name('approvedQnA');


});

Route::group(['middleware'=>['web','checkStudent']], function(){
    Route::get('/dashboard', [AuthController::class,'loadDashboard']);
    Route::get('/exam/{id}', [ExamController::class,'loadExamDashboard']);

    Route::post('/exam-submit', [ExamController::class,'examSubmit'])->name('examSubmit');

    Route::get('/results', [ExamController::class,'resultDashboard'])->name('resultDashboard');

    Route::get('/review-student-qna', [ExamController::class,'reviewQnA'])->name('resultStudentQnA');

});


