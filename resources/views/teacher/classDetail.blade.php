@extends('teacher/template')
@section('title')
    {{$course->courseName}} - {{$class->class}}.{{$class->indexClass}}
@endsection
@section('page')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{route('home')}}">BelajarKu</a></li>
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{route('home')}}">Dashboard</a></li>
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{url('courseClass/'.$course->id_course)}}">Course List</a></li>
@endsection
@section('head-script')
<style>
  .desc {
      display: -webkit-box;
      max-width: 12vw;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
  }
</style>
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
    $(".buttonGrade").click(function() {
      var mod = $(this).attr('modalID');
      $(mod).modal('hide')
            Swal.fire({
                title: 'Grade this Assignment',
                icon: 'question',
                input: 'number',
                inputValidator: (value) => {
                    if ((value > 100)||(value < 0)||(!value)) {
                    return 'Grade from 0-100!'+value
                    }
                },
                inputAttributes:{
                    min: 0,
                    max: 100,
                },
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Grade!',
                focusConfirm: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    var gradeurl = $(this).attr('gradeurl');
                    window.location.replace(gradeurl+'/'+result.value);
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
            <div class="card-header pb-0  d-flex justify-content-between">
              <h6>Assignment List </h6>
              <a href="{{url('addAssignment/'.$class->id.'/'.$course->id_course)}}" class="btn bg-gradient-primary w-20">Add New Assignment</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-3">
                <table class="table align-items-center pb-5" id="assList">
                  <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder w-1">No. </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Title</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Description</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Type</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Due Date</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Files</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Link</th>                 
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Created At</th>
                        <th class="text-secondary"></th>
                    </tr>
                  </thead>
                  <tbody class="">
                    <?php $no=1;?>
                    @foreach ($assignment as $item)
                        @if (($item->classID == $class->id) && ($item->courseID == $course->id_course))
                        <tr>
                            <td>
                                <p class="text-end text-xs font-weight-bold mb-0">{{$no++}}</p>
                            </td>
                            <td>
                                <h6 class="mb-0 text-sm">{{$item->title}}</h6>
                            </td>
                            <td>
                                <p class="text-xs text-secondary mb-0 desc">{{$item->description}}</p>
                            </td>
                            <td>
                                <p class="text-xs text-secondary mb-0">{{$item->type}}</p>
                            </td>
                            <td>
                                @if (($item->start_date != NULL) && ($item->end_date != NULL))
                                <p class="text-xs text-secondary mb-0">{{date('l d-m-y', strtotime($item->start_date))}} - {{date('l d-m-y', strtotime($item->end_date))}}</p>
                                @else
                                <p class="text-xs text-secondary mb-0"> - </p>
                                @endif                                
                            </td>
                            <td>
                                @if ($item->files != NULL)
                                    @foreach (unserialize($item->files) as $file)
                                        <a href="{{ asset('assignments/'.$item->id.'_'.$item->type.'/'.$file) }}" class="badge badge-sm bg-gradient-success" download>{{$file}}</a>
                                    @endforeach
                                @else
                                <p class="text-xs text-secondary mb-0"> - </p>
                                @endif
                            </td>
                            <td>
                                <a href="{{ $item->link }}" target="__blank" class="badge badge-sm bg-gradient-success">{{$item->link}}</a>
                            </td>
                            <td>
                                @if ($item->created_at != NULL)
                                <p class="text-xs text-secondary mb-0">{{date('l d-m-y', strtotime($item->created_at))}}</p>
                                @endif
                            </td>
                            <td class="align-middle">
                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit Ass" data-bs-toggle="modal" data-bs-target='#editAss{{$item->id}}'>
                                  Edit
                                </a>
                                <a href="javascript:;" delurl="{{url('deleteAss/'.$item->id)}}" class="text-secondary font-weight-bold text-xs buttonDelete">
                                  | Delete
                                </a>
                                @if ($item->type != 'MODULE')
                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Detail Ass" data-bs-toggle="modal" data-bs-target='#detailAss{{$item->id}}'>
                                  | Detail
                                </a>
                                @endif
                            </td>
                        </tr>
                        <div class="modal fade" id="editAss{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                          aria-labelledby="staticBackdropLabel" aria-hidden="true">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="staticBackdropLabel">Edit Assignment</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: black;"
                                          aria-label="Close">X</button>
                                  </div>
                                  <div class="modal-body">
                                      <form action="{{url('editAssignment/'.$item->id)}}" method="POST">
                                          @csrf
                                          <div class="mb-3">
                                            <span>Title :</span>
                                            <input type="text" class="form-control form-control-lg" placeholder="Title" name="title" value="{{$item->title}}">
                                          </div>
                                          @error('title')
                                          <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                                          <script> window.addEventListener("load",clickNotif);</script>
                                          @enderror
                                          <div class="mb-3">
                                            <span>Description :</span>
                                              <input type="text" class="form-control form-control-lg" placeholder="Description" name="desc" value="{{$item->description}}">
                                          </div>
                                          @error('desc')
                                          <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                                          <script> window.addEventListener("load",clickNotif);</script>
                                          @enderror
                                          <div class="mb-3">
                                            <span>Type :</span>
                                              <input type="text" class="form-control form-control-lg" placeholder="Type" name="type" value="{{$item->type}}" readonly>
                                          </div>
                                          @error('type')
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
                        @endif
                    @endforeach
                  </tbody>
                </table>
                @foreach ($assignment as $item)
                  @if (($item->classID == $class->id) && ($item->courseID == $course->id_course))
                  <div class="modal fade overflow-auto" id="detailAss{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Detail Assignment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: black;"
                                    aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                              <table class="table align-items-center pb-5 detailList overflow-auto" id="">
                                <thead>
                                  <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder w-1">No. </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Student</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Review</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Submitted Files</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Grade</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $noo=1?>
                                  @foreach ($cMember as $cm)
                                      @if ($cm->classID == $class->id)
                                        <tr>
                                          <td>
                                              <p class="text-end text-xs font-weight-bold mb-0">{{$noo++}} </p>
                                          </td>
                                          <td>
                                            <div class="d-flex px-2 py-1">
                                              <div>
                                                <img src="{{asset('')}}soft-ui/assets/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user1">
                                              </div>
                                              <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{$cm->name}}</h6>
                                                <p class="text-xs text-secondary mb-0">{{$cm->email}}</p>
                                              </div>
                                            </div>
                                          </td>
                                          <td>
                                            <?php $logg = false;?>
                                            @foreach ($assLog as $Alog)
                                                @if (($cm->studentID == $Alog->studentID) && ($item->id == $Alog->assignmentID))
                                                    <?php $logg = true?>
                                                    <?php $AlogID = $Alog->id?>
                                                @endif
                                            @endforeach
                                            @if ($logg)
                                              @if ($item->type != 'ASSIGNMENT')
                                              <a href="{{url('reviewAss/'.$AlogID)}}" class="btn btn-sm btn-dark" target="_blank">Review <i class="fas fa-search"></i></a>
                                              @else
                                              <span class="badge badge-sm bg-gradient-faded-info">Check Submitted Files</span>
                                              @endif
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">MISSING</span>
                                            @endif
                                          </td>
                                          <td class="">
                                            <?php $foundd = false?>
                                            @foreach ($assLog as $Alog)
                                              @if (($cm->studentID == $Alog->studentID) && ($item->id == $Alog->assignmentID))
                                                @if ($Alog->files != NULL)
                                                    <?php $foundd = true;?>
                                                @endif
                                              @endif
                                            @endforeach
                                            <div class="dropdown">
                                              @if (!$foundd)
                                              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>
                                                No Files
                                              </button>
                                              @else
                                              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Submitted Files
                                              </button>
                                              @endif
                                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                @foreach ($assLog as $Alog)
                                                  @if (($cm->studentID == $Alog->studentID) && ($item->id == $Alog->assignmentID))
                                                    @if ($Alog->files != NULL)
                                                        @foreach (unserialize($Alog->files) as $file)
                                                            <a href="{{ asset('assignmentLog/'.$item->id.'_'.$cm->studentID.'/'.$file) }}" class="dropdown-item" download>{{$file}}</a>
                                                        @endforeach
                                                    @else
                                                    <a class="dropdown-item" href="#">No Files</a>
                                                    @endif
                                                  @endif
                                                @endforeach
                                              </div>
                                            </div>
                                            
                                          </td>
                                          <td class="text-center">
                                            @foreach ($assLog as $Alog)
                                                @if (($cm->studentID == $Alog->studentID) && ($item->id == $Alog->assignmentID))
                                                    @if ($Alog->grade == NULL)
                                                      <a href="javascript:;" modalID="#detailAss{{$item->id}}" class="btn btn-sm btn-dark buttonGrade" data-dismiss="modal" gradeurl="{{url('gradeAssignment/'.$Alog->id)}}"><i class="far fa-edit"></i> Grade </a>
                                                    @else
                                                    <span class="badge badge-sm bg-gradient-dark">{{$Alog->grade}}</span>
                                                    @endif
                                                @endif
                                            @endforeach
                                          </td>
                                          <td class="align-middle text-center text-sm">
                                            <?php $log = false;?>
                                            @foreach ($assLog as $Alog)
                                                @if (($cm->studentID == $Alog->studentID) && ($item->id == $Alog->assignmentID))
                                                    <?php $log = true?>
                                                @endif
                                            @endforeach
                                            @if ($log)
                                                <span class="badge badge-sm bg-gradient-success">DONE</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">MISSING</span>
                                            @endif
                                          </td>
                                        </tr>
                                      @endif
                                  @endforeach
                                </tbody>
                              </table>
                            </div>
                        </div>
                    </div>
                  </div>
                  @endif
                @endforeach
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>Student List {{$class->class}}.{{$class->indexClass}}</h6>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-3">
              <table class="table align-items-center pb-5" id="studentList">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder w-1">No. </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Student</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2">Class</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Date</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder ">Today's Presence</th>
                  </tr>
                </thead>
                <tbody>
                <?php $no = 1?>
                <?php
                    date_default_timezone_set('Asia/Jakarta');
                    $today = date('Y-m-d');
                    // Declare the start date
                    $start_date = new DateTime('2022-06-28');
                    // Declare the DateInterval
                    $interval = new DateInterval('P1D');
                    // Declare the end date
                    $end_date = new DateTime(date('Y-m-d', strtotime($today . ' +1 day')));
                      
                    // Create a new DatePeriod object
                    $DP = new DatePeriod($start_date, $interval, $end_date);
                ?>
                @foreach ($DP as $dt)
                  @foreach ($cMember as $item)
                  @if ($item->classID == $class->id)
                  <tr>
                    <td>
                        <p class="text-end text-xs font-weight-bold mb-0">{{$no++}} </p>
                    </td>
                    <td>
                      <div class="d-flex px-2 py-1">
                        <div>
                          <img src="{{asset('')}}soft-ui/assets/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user1">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                          <h6 class="mb-0 text-sm">{{$item->name}}</h6>
                          <p class="text-xs text-secondary mb-0">{{$item->email}}</p>
                        </div>
                      </div>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Student</p>
                      <p class="text-xs text-secondary mb-0">{{$class->class}}.{{$class->indexClass}}</p>
                    </td>
                    <td>
                      <p class="text-xs font-weight-bold mb-0">Date</p>
                      <p class="text-xs text-secondary mb-0">{{$dt->format('Y-m-d')}}</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                        <?php $present = false;?>
                        @foreach ($attend as $absent)
                            @if ($item->studentID == $absent->studentID)
                                @if (date('Y-m-d', strtotime($absent->time)) == $dt->format('Y-m-d'))
                                    <?php $present = true?>
                                @endif
                            @endif
                        @endforeach
                        @if ($present)
                            <span class="badge badge-sm bg-gradient-success">PRESENT</span>
                        @else
                            <span class="badge badge-sm bg-gradient-secondary">ABSENT</span>
                        @endif
                    </td>
                  </tr>
                  @endif
                  @endforeach
                @endforeach
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card h-100">
          <div class="card-header pb-0 p-3">
            <div class="row">
                <div class="col-6 d-flex align-items-center">
                    <h6 class="mb-0">Forum</h6>
                </div>
                <div class="card-body overflow-auto max-height-vh-60">
                @foreach ($forum as $item)
                    @if ($item->userID != Auth::user()->id)
                        <div class="row justify-content-start mb-4">
                            <div class="col-auto">
                                <div class="card ">
                                    <small>{{$item->name}}</small>
                                    <div class="card-body py-2 px-3">
                                        <p class="mb-1">
                                        {{$item->chat}}
                                        </p>
                                        <div class="d-flex align-items-center text-sm opacity-6">
                                            <i class="ni ni-check-bold text-sm me-1"></i>
                                            <small>{{date('H:i D, d M Y', strtotime($item->timestamp))}}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row justify-content-end text-right mb-4">
                            <div class="col-auto">
                                <div class="card ">
                                    <div class="d-flex align-items-center justify-content-end ">
                                        <small>{{$item->name}}</small>
                                    </div>
                                    <div class="card-body bg-gray-200 py-2 px-3 border-radius-md">
                                        <p class="mb-1">
                                            {{$item->chat}}
                                        </p>
                                        <div class="d-flex align-items-center justify-content-end text-sm opacity-6">
                                            <i class="ni ni-check-bold text-sm me-1"></i>
                                            <small>{{date('H:i D, d M Y', strtotime($item->timestamp))}}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-facebook btn-sm" data-bs-toggle="modal" data-bs-target='#sendMessage'>Send Message <i class="fas fa-paper-plane"></i></button>
                </div>
                <div class="modal fade" id="sendMessage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Send Message</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: black;"
                                    aria-label="Close"><i class="fas fa-times-circle"></i></button>
                            </div>
                            <form action="{{url('sendMessageT/'.$class->id.'/'.$course->id_course.'/'.Auth::user()->id)}}" id="formMessage"  method="POST">
                                @csrf
                                <input type="text" class="modal-body border-0 w-100" name="message" placeholder="Type here ...">
                            </form>
                            <div class="modal-footer">
                                <button type="submit" form="formMessage" class="btn btn-sm btn-facebook" name="submit">Send <i class="fas fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="card-body p-3 pb-0 overflow-auto max-height-vh-60">
            <ul class="list-group">
            </ul>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('body-script')

<script>
    $(function () {
      $("#studentList").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false, "pageLength": 5,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#studentList_wrapper .col-md-6:eq(0)');

      $(".detailList").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false, "pageLength": 5,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('.detailList_wrapper .col-md-6:eq(0)');
      
      $("#assList").DataTable({
        "responsive": false, "lengthChange": false, "autoWidth": false, "pageLength": 5,
        "columnDefs": [
            {"targets": 4,"visible": false,},
            {"targets": 5,"visible": false,},
            {"targets": 6,"visible": false,},
            {"targets": 7,"visible": false,},
        ],
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#assList_wrapper .col-md-6:eq(0)');
    });
  </script>
@endsection