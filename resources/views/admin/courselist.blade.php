@extends('admin/template')
@section('title')
    Course List
@endsection
@section('head-script')
<script>
    $(document).ready(function(){
      $(".buttonDelete").click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            var delurl = $(this).attr('delurl');
            window.location.replace(delurl);
          }
        })
      });
    });
  </script>
@endsection
@section('content')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0 d-flex justify-content-between">
            <h6>Course List</h6>
            <button class="btn bg-gradient-primary w-20" id="addNewCourse" data-bs-toggle="modal" data-bs-target='#addCourse'>Add New Course</button>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Course Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Class</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Teacher</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($course as $item)
                    <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">{{$item->courseName}}</h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{$item->courseClass}}</p>
                        </td>
                        <td class="align-middle text-center text-sm">
                            <p class="text-xs font-weight-bold mb-0">{{$item->name}}</p>
                        </td>
                        <td class="align-middle">
                          <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target='#editCourse{{$item->id_course}}'>
                            Edit 
                          </a>
                          | 
                          <a delurl="{{url('deleteCourse/'.$item->id_course)}}" class="text-secondary font-weight-bold text-xs buttonDelete" style="cursor: pointer">Delete</a>
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="editCourse{{$item->id_course}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Edit Course</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: black;"
                                    aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('editCourse/'.$item->id_course)}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                      <input type="text" class="form-control form-control-lg" placeholder="Course Name" name="courseName" value="{{$item->courseName}}">
                                    </div>
                                    @error('courseName')
                                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                                    <script> window.addEventListener("load",clickNotif);</script>
                                    @enderror
                                    <div class="mb-3">
                                        <select name="courseClass" class="form-control form-control-lg">
                                            <option value="X" {{($item->courseClass === 'X') ? 'selected' : ''}}>X</option>
                                            <option value="XI" {{($item->courseClass === 'XI') ? 'selected' : ''}}>XI</option>
                                            <option value="XII" {{($item->courseClass === 'XII') ? 'selected' : ''}}>XII</option>
                                        </select>
                                    </div>
                                    @error('courseClass')
                                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                                    <script> window.addEventListener("load",clickNotif);</script>
                                    @enderror
                                    <div class="mb-3">
                                        <select name="teacherID" class="form-control form-control-lg">
                                            @foreach ($user as $teacher)
                                                @if ($teacher->role == 'TEACHER')
                                                    <option value="{{$teacher->id}}" {{($teacher->id === $item->teacherID) ? 'selected' : ''}}>{{$teacher->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('teacherID')
                                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                                    <script> window.addEventListener("load",clickNotif);</script>
                                    @enderror
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>

                    <!-- Modal -->
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addCourse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Form Add Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: black;"
                    aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form action="{{url('addNewCourse')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" placeholder="Course Name" name="courseName" value="{{old('courseName')}}">
                    </div>
                    @error('courseName')
                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                    <script> window.addEventListener("load",clickNotif);</script>
                    @enderror
                    <div class="mb-3">
                        <select name="courseClass" class="form-control form-control-lg">
                          <option value="X">X</option>
                          <option value="XI">XI</option>
                          <option value="XII">XII</option>
                        </select>
                    </div>
                    @error('courseClass')
                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                    <script> window.addEventListener("load",clickNotif);</script>
                    @enderror
                    <div class="mb-3">
                        <select name="teacherID" class="form-control form-control-lg">
                            @foreach ($user as $teacher)
                                @if ($teacher->role == 'TEACHER')
                                    <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    @error('teacherID')
                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                    <script> window.addEventListener("load",clickNotif);</script>
                    @enderror
                    <div class="text-center">
                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
@endsection
@section('body-script')
    
@endsection