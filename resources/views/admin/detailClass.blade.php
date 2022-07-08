@extends('admin/template')
@section('title')
    Class List / Class Detail
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
            <h6>{{'Class - '.$class->class.'.'.$class->indexClass}}</h6>
            <button class="btn bg-gradient-primary w-20" data-bs-toggle="modal" data-bs-target='#addCourse2Class'>Add Course to This CLass</button>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Course</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Teacher</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($clCourse as $item)
                        @if ($item->classID == $class->id)
                            @foreach ($course as $co)
                                @if ($co->id_course == $item->courseID)
                                <tr>
                                    <td>
                                      <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                          <h6 class="mb-0 text-sm">{{$co->courseName}}</h6>
                                        </div>
                                      </div>
                                    </td>
                                    <td>
                                      <p class="text-xs font-weight-bold mb-0">{{$co->name}}</p>
                                    </td>
                                    <td class="align-middle">
                                      <a delurl="{{url('deleteCourseClass/'.$item->id)}}" class="text-secondary font-weight-bold text-xs buttonDelete" style="cursor: pointer">Delete</a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="addCourse2Class" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Form Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: black;"
                    aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form action="{{url('addCourse2Class/'.$class->id)}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <span>Class :</span>
                      <select name="course" class="form-control form-control-lg">
                        <option disabled selected>--SELECT COURSE--</option>
                        @foreach ($course as $item)
                        <?php $existCourse = false?>
                            @if ($item->courseClass == $class->class)
                                @foreach ($clCourse as $clo)
                                    @if ($clo->courseID == $item->id_course)
                                        @if ($clo->classID == $class->id)
                                            <?php $existCourse = true?>
                                        @endif
                                    @endif
                                @endforeach
                                @if (!$existCourse)
                                <option value="{{$item->id_course}}">{{$item->courseName}} - {{$item->name}}</option>
                                @endif
                            @endif
                        @endforeach
                      </select>
                    </div>
                    @error('course')
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
@endsection
@section('body-script')
    
@endsection