<?php

namespace App\Http\Controllers;

use App\Models\assignmentLogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\courseModel;
use App\Models\classCoursesModel;
use App\Models\classMemberModel;
use App\Models\attendanceModel;
use App\Models\assignmentModel;
use App\Models\forumModel;
use App\Models\classModel;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    //
    public function __construct()
    {
        if($this->middleware('auth')){
            $this->middleware('teacher');
        }
    }

    public function index(){
        $data = [
            'course' => courseModel::get(),
        ];
        return view('teacher/dashboard',$data);
    }

    public function courseClass($courseID){
        $data = [
            'course'    => courseModel::where('id_course',$courseID)->first(),
            'clCourse'  => classCoursesModel::join('classes','classes.id','=','classcourses.classID')->get(), 
        ];
        return view('teacher/courseClass',$data);
    }

    public function classDetail($classID,$courseID){
        $data = [
            'course'    => courseModel::where('id_course',$courseID)->first(),
            'class'     => classModel::where('id',$classID)->first(),
            'cMember'   => classMemberModel::join('users','users.id','=','classmember.studentID')->get(), 
            'attend'    => attendanceModel::get(),
            'assignment'=> assignmentModel::get(),
            'assLog'    => assignmentLogModel::get(),
            'forum'     => forumModel::where('classID',$classID)->where('courseID',$courseID)->join('users','forums.userID','=','users.id')->get(),
        ];
        return view('teacher/classDetail',$data);
    }

    public function addAssignment($classID,$courseID){
        $data = [
            'course'    => courseModel::where('id_course',$courseID)->first(),
            'class'     => classModel::where('id',$classID)->first(),
        ];
        return view('teacher/addAssignment',$data);
    }

    public function addNewAss($classID,$courseID){
        date_default_timezone_set('Asia/Jakarta');
        $timestamp = date('Y-m-d H:i:s');
        Request()->validate([
            'title'      => 'required',
            'desc'     => 'required',
            'type'      => 'required',
        ]);

        if(Request()->type != 'MODULE'){
            Request()->validate([
                'start'      => 'required',
                'end'     => 'required',
            ]);
        }

        if(Request()->link != NULL){
            Request()->validate([
                'link'      => 'url'
            ]);
        }

        

        if (Request()->question != NULL) {
            $question = serialize(Request()->question);
        } else {
            $question = NULL;
        }

        if(Request()->file('files') != NULL){
            foreach (Request()->file('files') as $file) {
                $filename = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME).'.'.$file->extension();
                $allfiles[] = $filename;
            }
            $inputFile = serialize($allfiles);
        } else {
            $inputFile = NULL;
        }

        if(Request()->file('voices') != NULL){
            foreach (Request()->file('voices') as $file) {
                $voicename = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME).'.'.$file->extension();
                $allvoices[] = $voicename;
            }
            $inputVoice = serialize($allvoices);
        } else {
            $inputVoice = NULL;
        }

        // if(Request()->file('voice') != NULL){
        //     $voice = Request()->voice;
        //     $voiceName = Request()->type.'_'.pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME).'_'.time().'.'.$file->extension();
        //     $voice->move(public_path('assignments'),$voiceName);
        // } else {
        //     $voiceName = NULL;
        // }
        
        $data = [
            'classID' => $classID,
            'courseID' => $courseID,
            'title' => Request()->title,
            'description' => Request()->desc,
            'type' => Request()->type,
            'files' => $inputFile,
            'link' => Request()->link,
            'start_date' => Request()->start,
            'end_date' => Request()->end,
            'voice' => $inputVoice,
            'question' => $question,
        ];
        assignmentModel::create($data);

        $last = assignmentModel::orderBy('id','desc')->first();
        Storage::makeDirectory('assignments/'.$last->id.'_'.Request()->type);
        Storage::makeDirectory('assignments/'.$last->id.'_'.Request()->type.'/voices');

        if(Request()->file('files') != NULL){
            foreach (Request()->file('files') as $file) {
                $filename = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME).'.'.$file->extension();
                $file->move(public_path('assignments/'.$last->id.'_'.Request()->type),$filename);
            }
        }

        if(Request()->file('voices') != NULL){
            foreach (Request()->file('voices') as $file) {
                $voicename = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME).'.'.$file->extension();
                $file->move(public_path('assignments/'.$last->id.'_'.Request()->type.'/voices'),$voicename);
            }
        }

        Request()->session()->flash('success','Add Assignment Success');
        return redirect('classDetail/'.$classID.'/'.$courseID); 
    }

    public function editAssignment($assID){
        date_default_timezone_set('Asia/Jakarta');
        $timestamp = date('Y-m-d H:i:s');
        Request()->validate([
            'title'      => 'required',
            'desc'     => 'required',
            'type'      => 'required',
        ]);

        $data = [
            'title' => Request()->title,
            'description' => Request()->desc,
            'type' => Request()->type,
            'updated_at' => $timestamp,
        ];

        assignmentModel::where('id',$assID)->update($data);

        Request()->session()->flash('success','edit Assignment Success');
        return back(); 
    }

    public function deleteAss($assID){
        $ass = assignmentModel::where('id',$assID)->first();
        if ($ass->files != NULL) {
            foreach (unserialize($ass->files) as $file) {
                unlink(public_path('assignments/'.$ass->id.'_'.$ass->type).'/'.$file);
            }
        }

        if ($ass->voice != NULL) {
            foreach (unserialize($ass->voice) as $file) {
                unlink(public_path('assignments/'.$ass->id.'_'.$ass->type).'/'.$file);
            }
        }
        assignmentModel::where('id',$assID)->delete();

        Request()->session()->flash('success','Assignment Deleted');
        return back();
    }

    public function gradeAssignment($assLogID, $grade){
        date_default_timezone_set('Asia/Jakarta');
        $timestamp = date('Y-m-d H:i:s');
        $data = [
            'grade' => $grade,
            'updated_at'    => $timestamp,
        ];
        assignmentLogModel::where('id',$assLogID)->update($data);
        Request()->session()->flash('success','Grade Success');
        return back();
    }

    public function reviewAss($aLog){
        $data = [
            'aLog'  => assignmentLogModel::where('assignmentLog.id',$aLog)->join('assignments','assignmentLog.assignmentID','=','assignments.id')->join('users','assignmentLog.studentID','=','users.id')->first(),
        ];
        return view('teacher/review',$data);
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
