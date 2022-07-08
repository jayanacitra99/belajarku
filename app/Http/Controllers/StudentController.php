<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\courseModel;
use App\Models\classCoursesModel;
use App\Models\classMemberModel;
use App\Models\attendanceModel;
use App\Models\assignmentModel;
use App\Models\forumModel;
use App\Models\assignmentLogModel;
use App\Models\classModel;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    //
    public function __construct()
    {
        if($this->middleware('auth')){
            $this->middleware('student');
        }
    }

    public function index(){
        $data = [
            'classMember' => classMemberModel::get(),
            'classCourse' => classCoursesModel::join('courses','classcourses.courseID','=','courses.id_course')->join('users','courses.teacherID','=','users.id')->get(),
            'attend'    => attendanceModel::get(),
        ];
        return view('student/dashboard',$data);
    }

    public function openCourse($courseID,$classID){
        $data = [
            'course' => courseModel::where('id_course',$courseID)->first(),
            'class' => classModel::where('id',$classID)->first(),
            'assignments' =>assignmentModel::get(),
            'assLog'    => assignmentLogModel::get(),
            'attend'    => attendanceModel::get(),
            'forum'     => forumModel::where('classID',$classID)->where('courseID',$courseID)->join('users','forums.userID','=','users.id')->get(),
        ];
        return view('student/openCourse',$data);
    }

    public function startAttempt($assID,$type){
        $data = [
            'ass' => assignmentModel::where('id',$assID)->first(),
            'attend'    => attendanceModel::get(),
        ];
        return view('student/startAttempt', $data);
    }

    public function submitAttempt($assID,$studentID){
        date_default_timezone_set('Asia/Jakarta');
        $timestamp = date('Y-m-d H:i:s');
        if (Request()->answer != NULL) {
            $answer = serialize(Request()->answer);
        } else {
            $answer = NULL;
        }
        $assign = assignmentModel::where('id',$assID)->first();
        $ans = unserialize($answer);
        $grade = NULL;
        $inputFile = NULL;
        if ($assign->type == 'QUIZ') {
            $totans = 1;
            $grade = 0;
            foreach (unserialize($assign->question) as $item) {
                if($item['answer'] == $ans[$totans++]['answer']){
                    $grade++;
                }
            }
            $count = count(unserialize($assign->question));
            $grade = $grade / $count * 100;
        } else if ($assign->type == 'ASSIGNMENT'){
            Request()->validate([
                'files' => 'required',
            ]);

            if(Request()->file('files') != NULL){
                foreach (Request()->file('files') as $file) {
                    $filename = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME).'.'.$file->extension();
                    $allfiles[] = $filename;
                }
                $inputFile = serialize($allfiles);
            } else {
                $inputFile = NULL;
            }
        }
        $data = [
            'assignmentID'  => $assID,
            'studentID'     => $studentID,
            'answer'        => $answer,
            'grade'         => $grade,
            'files'         => $inputFile,
            'created_at'    => $timestamp,
            'updated_at'    => $timestamp,
        ];
        assignmentLogModel::create($data);

        $last = assignmentLogModel::orderBy('id','desc')->first();
        Storage::makeDirectory('assignmentLog/'.$assID.'_'.$studentID);

        if(Request()->file('files') != NULL){
            foreach (Request()->file('files') as $file) {
                $filename = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME).'.'.$file->extension();
                $file->move(public_path('assignmentLog/'.$last->id.'_'.$assID.'_'.$studentID),$filename);
            }
        }
        

        Request()->session()->flash('success','Attempt Success');
        return redirect('openCourse/'.$assign->courseID.'/'.$assign->classID); 
    }

    public function checkIn($studentID){
        date_default_timezone_set('Asia/Jakarta');
        $timestamp = date('Y-m-d H:i:s');
        $data = [
            'studentID' => $studentID,
            'time'      => $timestamp,
        ];
        attendanceModel::create($data);
        Request()->session()->flash('success','Check In Success');
        return redirect()->back(); 
    }

    public function sendMessage($classID,$courseID,$userID){
        date_default_timezone_set('Asia/Jakarta');
        $timestamp = date('Y-m-d H:i:s');
        Request()->validate([
            'message'   => 'required'
        ]);

        $data = [
            'classID'   => $classID,
            'courseID'  => $courseID,
            'userID'    => $userID,
            'chat'      => Request()->message,
            'timestamp' => $timestamp,
        ];
        forumModel::create($data);
        Request()->session()->flash('success','Message Sent');
        return redirect()->back(); 
    }
}
