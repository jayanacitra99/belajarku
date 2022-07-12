<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\courseModel;
use App\Models\classCoursesModel;
use App\Models\classMemberModel;
use App\Models\classModel;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function __construct()
    {
        if($this->middleware('auth')){
            $this->middleware('admin');
        }
        
    }

    public function index(){
        return view('admin/dashboard');
    }

    public function userlist(){
        $data = [
            'user' => User::all(),
            'class'=> classModel::get(),
            'member'=> classMemberModel::get(),
        ];
        return view('admin/userlist', $data);
    }

    public function addNewUser(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $timestamp = date('Y-m-d H:i:s');
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|confirmed',
            'role'      => 'required'
        ]);

        if ($request->role == 'STUDENT') {
            $request->validate([
                'class'      => 'required',
            'indexClass'      => 'required'
            ]);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ];
        
        $class = classModel::get();
        $classMember = classMemberModel::get();
        if($request->role == 'STUDENT'){
            foreach ($class as $classItem) {
                if($request->class == $classItem->class){
                    if($request->indexClass == $classItem->indexClass){
                        $checkQuota = 0;
                        foreach ($classMember as $cMember) {
                            if($cMember->classID == $classItem->id){
                                $checkQuota += 1;
                            }
                        }
                        if ($checkQuota < $classItem->quota) {
                            User::insert($data);
                            $newUser = User::where('email',$request->email)->first();
                            $dataClassMember = [
                                'classID' => $classItem->id,
                                'studentID' => $newUser->id,
                            ];
                            classMemberModel::insert($dataClassMember);
                        } else {
                            $request->session()->flash('notif','This Class is Full');
                            return back(); 
                        }
                    }
                }
            }
        } else {
            User::insert($data);
        }

        $request->session()->flash('success','Add User Success!!');
        return back(); 
    }

    public function deleteUser($id){
        User::where('id',$id)->delete();

        Request()->session()->flash('success','User Deleted!!');
        return back(); 
    }

    public function editUser($id){
        date_default_timezone_set('Asia/Jakarta');
        $timestamp = date('Y-m-d H:i:s');
        $cek = User::where('id', $id)->first();
        Request()->validate([
            'name'      => 'required',
            'email'     => ($cek->email === Request()->email) ? 'required|email':'required|email|unique:users,email',
            'role'      => 'required'
        ]);

        if (Request()->role == "STUDENT") {
            Request()->validate([
                'class'           => 'required',
                'indexClass'      => 'required',
            ]);
        }

        $data = [
            'name' => Request()->name,
            'email' => Request()->email,
            'role' => Request()->role,
            'updated_at' => $timestamp,
        ];

        $class = classModel::get();
        $classMember = classMemberModel::get();
        if(Request()->role == 'STUDENT'){
            foreach ($class as $classItem) {
                if(Request()->class == $classItem->class){
                    if(Request()->indexClass == $classItem->indexClass){
                        $checkQuota = 0;
                        foreach ($classMember as $cMember) {
                            if($cMember->classID == $classItem->id){
                                $checkQuota += 1;
                            }
                        }
                        if ($checkQuota < $classItem->quota) {
                            User::where('id',$id)->update($data);
                            $dataClassMember = [
                                'classID' => $classItem->id,
                                'studentID' => $id,
                            ];
                            classMemberModel::insert($dataClassMember);
                        } else {
                            Request()->session()->flash('notif','This Class is Full');
                            return back(); 
                        }
                    }
                }
            }
        }

        Request()->session()->flash('success','User Edited!!');
        return back(); 
    }

    public function courselist(){
        $course = courseModel::join('users','courses.teacherID','=','users.id')->get();
        $user = User::all();
        return view('admin/courselist', compact('course','user'));
    }

    public function addNewCourse(){
        Request()->validate([
            'courseName'      => 'required|unique:courses,courseName',
            'courseClass'  => 'required',
            'teacherID'      => 'required'
        ]);

        $data = [
            'courseName' => Request()->courseName,
            'courseClass' => Request()->courseClass,
            'teacherID' => Request()->teacherID,
        ];

        courseModel::insert($data);
        Request()->session()->flash('success','Add New Course Success!!');
        return back(); 
    }

    public function deleteCourse($id){
        courseModel::where('id_course',$id)->delete();

        Request()->session()->flash('success','Course Deleted!!');
        return back(); 
    }

    public function classlist(){
        $data = [
            'class' => classModel::orderBy('class','asc')->get(),
            'classMember' => classMemberModel::get(),
        ];
        return view('admin/classlist', $data);
    }

    public function addNewClass(){
        Request()->validate([
            'indexClass' => 'required|unique:classes,indexClass',
            'class'      => 'required',
            'quota'      => 'required'
        ]);

        $data = [
            'class' => Request()->class,
            'indexClass' => Request()->indexClass,
            'quota' => Request()->quota,
        ];

        classModel::insert($data);
        Request()->session()->flash('success','Add New Class Success!!');
        return back(); 
    }

    public function editClass($cmemberID){
        $class = classModel::get();
        $classMember = classMemberModel::get();
        foreach ($class as $classItem) {
            if(Request()->class == $classItem->class){
                if(Request()->indexClass == $classItem->indexClass){
                    $checkQuota = 0;
                    foreach ($classMember as $cMember) {
                        if($cMember->classID == $classItem->id){
                            $checkQuota += 1;
                        }
                    }
                    if ($checkQuota < $classItem->quota) {
                        $dataClassMember = [
                            'classID' => $classItem->id,
                        ];
                        classMemberModel::where('id',$cmemberID)->update($dataClassMember);
                        Request()->session()->flash('success','Class Changed!'.Request()->class.Request()->indexClass.$classItem->id);
                        return back(); 
                    } else {
                        Request()->session()->flash('notif','This Class is Full');
                        return back(); 
                    }
                } 
            }
        }
    }

    public function editCourse($courseID){
        $cek = courseModel::where('id_course', $courseID)->first();
        Request()->validate([
            'courseName'      => ($cek->courseName === Request()->courseName) ? 'required':'required|unique:courses,courseName',
            'courseClass'  => 'required',
            'teacherID'      => 'required'
        ]);

        $data = [
            'courseName' => Request()->courseName,
            'courseClass' => Request()->courseClass,
            'teacherID' => Request()->teacherID,
        ];

        courseModel::where('id_course',$courseID)->update($data);
        Request()->session()->flash('success','Course Edited !');
        return back(); 
    }

    public function editClasslist($classID){
        $cek = classModel::where('id', $classID)->first();
        $allClass = classModel::get();
        Request()->validate([
            'indexClass' => 'required',
            'class'      => 'required',
            'quota'      => 'required'
        ]);

        foreach ($allClass as $check) {
            if ($cek->indexClass != Request()->indexClass) {
                if($check->indexClass == Request()->indexClass){
                    if($check->class == Request()->class){
                        Request()->session()->flash('notif','This Class Already Exist!!');
                        return back(); 
                    } else {
                        $data = [
                            'class' => Request()->class,
                            'indexClass' => Request()->indexClass,
                            'quota' => Request()->quota,
                        ];
                
                        classModel::where('id',$classID)->update($data);
                        Request()->session()->flash('success','Class Edited!');
                        return back(); 
                    }
                } else {
                    $data = [
                        'class' => Request()->class,
                        'indexClass' => Request()->indexClass,
                        'quota' => Request()->quota,
                    ];
            
                    classModel::where('id',$classID)->update($data);
                    Request()->session()->flash('success','Class Edited!');
                    return back(); 
                }
            } else {
                $data = [
                    'class' => Request()->class,
                    'indexClass' => Request()->indexClass,
                    'quota' => Request()->quota,
                ];
        
                classModel::where('id',$classID)->update($data);
                Request()->session()->flash('success','Class Edited!');
                return back(); 
            }
        }
    }

    public function deleteClass($classID){
        classModel::where('id',$classID)->delete();

        Request()->session()->flash('success','Course Deleted!!');
        return back(); 
    }

    public function detailClass($classID){
        $data = [
            'class' => classModel::where('id',$classID)->first(),
            'course' => courseModel::join('users','courses.teacherID','=','users.id')->get(),
            'clCourse' => classCoursesModel::get(),
        ];
        return view('admin/detailClass', $data);
    }

    public function addCourse2Class($classID){
        Request()->validate([
            'course' => 'required',
        ]);

        $data = [
            'classID' => $classID,
            'courseID' => Request()->course,
        ];

        classCoursesModel::insert($data);
        Request()->session()->flash('success','Add Course to This Class Success!!');
        return back(); 
    }

    public function deleteCourseClass($clCourseID){
        classCoursesModel::where('id',$clCourseID)->delete();

        Request()->session()->flash('success','Course Deleted From This Class!!');
        return back(); 
    }
}
