<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\HomeController;


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


Route::group(['middleware'=>'guest'], function(){
    Route::get('/',[LoginController::class,'index'])->name('login');
    Route::post('/login',[LoginController::class,'login'])->name('dologin');
});

Route::group(['middleware'=>'auth'], function(){
    Route::get('/home',[HomeController::class,'index'])->name('home');
    Route::post('/logout',[LoginController::class,'logout'])->name('logout');
    Route::get('/back',[HomeController::class,'back'])->name('back');
});

Route::group(['middleware'=>'admin'], function(){
    Route::get('/admin',[AdminController::class,'index'])->name('admin');
    Route::get('/admin/userlist',[AdminController::class,'userlist'])->name('userlist');
    Route::post('/addNewUser',[AdminController::class,'addNewUser'])->name('addNewUser');
    Route::get('/deleteUser/{id}',[AdminController::class,'deleteUser'])->name('deleteUser');
    Route::post('/editUser/{id}',[AdminController::class,'editUser'])->name('editUser');
    Route::get('/admin/courselist',[AdminController::class,'courselist'])->name('courselist');
    Route::post('/addNewCourse',[AdminController::class,'addNewCourse'])->name('addNewCourse');
    Route::get('/admin/classlist',[AdminController::class,'classlist'])->name('classlist');
    Route::post('/addNewClass',[AdminController::class,'addNewClass'])->name('addNewClass');
    Route::post('/editClass/{memberID}',[AdminController::class,'editClass'])->name('editClass');
    Route::post('/editCourse/{courseID}',[AdminController::class,'editCourse'])->name('editCourse');
    Route::get('/deleteCourse/{courseID}',[AdminController::class,'deleteCourse'])->name('deleteCourse');
    Route::post('/editClasslist/{classID}',[AdminController::class,'editClasslist'])->name('editClasslist');
    Route::get('/deleteClass/{classID}',[AdminController::class,'deleteClass'])->name('deleteClass');
    Route::get('/detailClass/{classID}',[AdminController::class,'detailClass'])->name('detailClass');
    Route::post('/addCourse2Class/{classID}',[AdminController::class,'addCourse2Class'])->name('addCourse2Class');
    Route::get('/deleteCourseClass/{clCourseID}',[AdminController::class,'deleteCourseClass'])->name('deleteCourseClass');
});

Route::group(['middleware'=>'teacher'], function(){
    Route::get('/teacher',[TeacherController::class,'index'])->name('teacher');
    Route::get('/courseClass/{courseID}',[TeacherController::class,'courseClass'])->name('courseClass');
    Route::get('/classDetail/{classID}/{courseID}',[TeacherController::class,'classDetail'])->name('classDetail');
    Route::get('/addAssignment/{classID}/{courseID}',[TeacherController::class,'addAssignment'])->name('addAssignment');
    Route::post('/addNewAss/{classID}/{courseID}',[TeacherController::class,'addNewAss'])->name('addNewAss');
    Route::post('/editAssignment/{assID}',[TeacherController::class,'editAssignment'])->name('editAssignment');
    Route::get('/deleteAss/{assID}',[TeacherController::class,'deleteAss'])->name('deleteAss');
    Route::get('/gradeAssignment/{assLogID}/{grade}',[TeacherController::class,'gradeAssignment'])->name('gradeAssignment');
    Route::get('/reviewAss/{assLogID}',[TeacherController::class,'reviewAss'])->name('reviewAss');
    Route::post('/sendMessageT/{classID}/{courseID}/{userID}',[TeacherController::class,'sendMessage'])->name('sendMessageT');
});

Route::group(['middleware'=>'student'], function(){
    Route::get('/student',[StudentController::class,'index'])->name('student');
    Route::get('/openCourse/{courseID}/{classiD}',[StudentController::class,'openCourse'])->name('openCourse');
    Route::get('/startAttempt/{assID}/{type}',[StudentController::class,'startAttempt'])->name('startAttempt');
    Route::post('/assignAttempt/{assID}/{studentID}',[StudentController::class,'submitAttempt'])->name('assignAttempt');
    Route::post('/submitAttempt/{assID}/{studentID}',[StudentController::class,'submitAttempt'])->name('submitAttempt');
    Route::post('/sendMessage/{classID}/{courseID}/{userID}',[StudentController::class,'sendMessage'])->name('sendMessage');
    Route::get('/checkIn/{studentID}',[StudentController::class,'checkIn'])->name('checkIn');
});

