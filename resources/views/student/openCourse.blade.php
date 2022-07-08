@extends('student/template')
@section('title')
   {{$course->courseName}}
@endsection
@section('page')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{route('home')}}">BelajarKu</a></li>
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
      $(".buttonStart").click(function() {
        Swal.fire({
            title: 'Ready to start attempt?',
            text: "Attempt allowed : 1 time",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Start Attempt'
        }).then((result) => {
          if (result.isConfirmed) {
            var starturl = $(this).attr('starturl');
            window.location.replace(starturl);
          }
        })
      });
    });
  </script>
@endsection
@section('content')
<?php
    date_default_timezone_set('Asia/Jakarta');
    $today = date('Y-m-d');
?>
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-lg-4">
        <div class="card h-100">
          <div class="card-header pb-0 p-3">
            <div class="row">
              <div class="col-6 d-flex align-items-center">
                <h6 class="mb-0">Assignment</h6>
              </div>
            </div>
          </div>
          <div class="card-body p-3 pb-0 overflow-auto max-height-vh-60">
            <ul class="list-group">
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                    <div class="d-flex flex-column">
                    <h6 class="mb-1 text-dark font-weight-bold text-sm">Subject</h6>
                    </div>
                    <div class="d-flex align-items-center text-sm">
                    Due Date :
                    </div>
                </li>
                @foreach ($assignments as $item)
                    @if (($item->classID == $class->id) && ($item->courseID == $course->id_course))
                        @if ($item->type == 'ASSIGNMENT')
                            <?php $found = false?>
                            @foreach ($assLog as $AL)
                                @if (($AL->assignmentID == $item->id) && ($AL->studentID == Auth::user()->id))
                                    <?php $found = true?>
                                @endif
                            @endforeach
                            @if (!$found)
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">{{$item->title}}</h6>
                                    <span class="text-xs desc">{{$item->description}}</span>
                                    </div>
                                    <div class="d-flex align-items-center text-sm">
                                    {{date('D, d-M', strtotime($item->end_date))}}
                                    <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4 " data-bs-toggle="modal" data-bs-target='#openAE{{$item->id}}'><i class="fas fa-folder-open"></i></button>
                                    </div>
                                </li>
                                <div class="modal fade" id="openAE{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">{{$item->title}}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: black;"
                                                    aria-label="Close"><i class="fas fa-times-circle"></i></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="d-flex flex-column h-100">
                                                    <p class="mb-1 pt-2 text-bold text-center">{{$item->type}}</p>
                                                    <h5 class="font-weight-bolder">{{$item->title}}</h5>
                                                    <p class="mb-5">{{$item->description}}</p>
                                                    <a class="mb-1 text-bold" href="{{$item->link}}" target="_blank">{{$item->link}}</a>
                                                    @if ($item->files != NULL)
                                                    <p class="mb-1 pt-1 text-bold">Files :</p>
                                                    <div class="d-flex justify-content-center row">
                                                        @foreach (unserialize($item->files) as $file)
                                                            <a href="{{ asset('assignments/'.$item->id.'_'.$item->type.'/'.$file) }}" class="btn btn-sm btn-default col-4" download>{{$file}}</a>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                    <div class="d-flex justify-content-center">
                                                        <form action="{{url('assignAttempt/'.$item->id.'/'.Auth::user()->id)}}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            @if ((strtotime($today) >= strtotime($item->start_date)) && (strtotime($today) <= strtotime($item->end_date)))
                                                            <div class="form-group">
                                                                <input type="file" class="form-control" id="File" name="files[]" value="{{old('files[]')}}" multiple>
                                                                @error('files')
                                                                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                                                                    <script> window.addEventListener("load",clickNotif);</script>
                                                                @enderror
                                                                <button type="submit" value="submit" class="btn form-control bg-gradient-primary mt-1">Submit Assignment</button>
                                                            </div>
                                                            @else
                                                            <div class="form-group">
                                                                <input type="file" class="form-control" id="File" name="files[]" value="{{old('files[]')}}" multiple disabled>
                                                                @error('files')
                                                                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                                                                    <script> window.addEventListener("load",clickNotif);</script>
                                                                @enderror
                                                                <button type="submit" value="submit" class="btn form-control bg-gradient-primary mt-1" disabled>Submit Assignment</button>
                                                            </div>
                                                            @endif
                                                            
                                                        </form>
                                                    </div>
                                                    <p class="mb-1 pt-2 text-bold">Due Date :</p>
                                                    <p class="mb-1 text-bold">{{date('D, d M Y', strtotime($item->start_date))}} - {{date('D, d M Y', strtotime($item->end_date))}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                @endforeach
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card h-100">
          <div class="card-header pb-0 p-3">
            <div class="row">
              <div class="col-6 d-flex align-items-center">
                <h6 class="mb-0">Quizzes / Essay</h6>
              </div>
              
            </div>
          </div>
          <div class="card-body p-3 pb-0 overflow-auto max-height-vh-60">
            <ul class="list-group">
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                    <div class="d-flex flex-column">
                    <h6 class="mb-1 text-dark font-weight-bold text-sm">Subject</h6>
                    </div>
                    <div class="d-flex align-items-center text-sm">
                    Due Date :
                    </div>
                </li>
                @foreach ($assignments as $item)
                    @if (($item->classID == $class->id) && ($item->courseID == $course->id_course))
                        @if (($item->type == 'QUIZ') || ($item->type == 'ESSAY'))
                            <?php $found = false?>
                            @foreach ($assLog as $AL)
                                @if (($AL->assignmentID == $item->id) && ($AL->studentID == Auth::user()->id))
                                    <?php $found = true?>
                                @endif
                            @endforeach
                            @if (!$found)
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">{{$item->title}}</h6>
                                    <span class="text-xs desc">{{$item->description}}</span>
                                    </div>
                                    <div class="d-flex align-items-center text-sm">
                                    {{date('D, d-M', strtotime($item->end_date))}}
                                    <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4 " data-bs-toggle="modal" data-bs-target='#openQUIZ{{$item->id}}'><i class="fas fa-folder-open"></i></button>
                                    </div>
                                </li>
                                <div class="modal fade" id="openQUIZ{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">{{$item->title}}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: black;"
                                                    aria-label="Close"><i class="fas fa-times-circle"></i></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="d-flex flex-column h-100">
                                                    <p class="mb-1 pt-2 text-bold text-center">{{$item->type}}</p>
                                                    <h5 class="font-weight-bolder">{{$item->title}}</h5>
                                                    <p class="mb-5">{{$item->description}}</p>
                                                    <a class="mb-1 text-bold" href="{{$item->link}}" target="_blank">{{$item->link}}</a>
                                                    @if ($item->files != NULL)
                                                    <p class="mb-1 pt-1 text-bold">Files :</p>
                                                    <div class="d-flex justify-content-center row">
                                                        @foreach (unserialize($item->files) as $file)
                                                            <a href="{{ asset('assignments/'.$item->id.'_'.$item->type.'/'.$file) }}" class="btn btn-sm btn-default col-4" download>{{$file}}</a>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                    @if ((strtotime($today) >= strtotime($item->start_date)) && (strtotime($today) <= strtotime($item->end_date)))
                                                    <div class="d-flex justify-content-center">
                                                        <a class="icon-move-right btn btn-primary buttonStart" starturl="{{url('startAttempt/'.$item->id.'/'.$item->type)}}">
                                                            Start Attempt
                                                            <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                                                        </a>
                                                    </div>
                                                    @else
                                                    <div class="d-flex justify-content-center">
                                                        <button class="icon-move-right btn btn-primary buttonStart" starturl="{{url('startAttempt/'.$item->id.'/'.$item->type)}}" disabled>
                                                            Start Attempt
                                                            <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                    @endif
                                                    <p class="mb-1 pt-2 text-bold">Due Date :</p>
                                                    <p class="mb-1 text-bold">{{date('D, d M Y', strtotime($item->start_date))}} - {{date('D, d M Y', strtotime($item->end_date))}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                @endforeach
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card h-100">
          <div class="card-header pb-0 p-3">
            <div class="row">
              <div class="col-6 d-flex align-items-center">
                <h6 class="mb-0">Modules</h6>
              </div>
              
            </div>
          </div>
          <div class="card-body p-3 pb-0 overflow-auto max-height-vh-60">
            <ul class="list-group">
                @foreach ($assignments as $item)
                    @if (($item->classID == $class->id) && ($item->courseID == $course->id_course))
                        @if ($item->type == 'MODULE')
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark font-weight-bold text-sm">{{$item->title}}</h6>
                                <span class="text-xs desc">{{$item->description}}</span>
                                </div>
                                <div class="d-flex align-items-center text-sm">
                                <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4 " data-bs-toggle="modal" data-bs-target='#openModule{{$item->id}}'><i class="fas fa-folder-open"></i></button>
                                </div>
                            </li>
                            <div class="modal fade" id="openModule{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">{{$item->title}}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: black;"
                                                aria-label="Close"><i class="fas fa-times-circle"></i></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-flex flex-column h-100">
                                                <p class="mb-1 pt-2 text-bold text-center">{{$item->type}}</p>
                                                <h5 class="font-weight-bolder">{{$item->title}}</h5>
                                                <p class="mb-5">{{$item->description}}</p>
                                                <a class="mb-1 text-bold" href="{{$item->link}}" target="_blank">{{$item->link}}</a>
                                                @if ($item->files != NULL)
                                                <p class="mb-1 pt-1 text-bold">Files :</p>
                                                <div class="d-flex justify-content-center row">
                                                    @foreach (unserialize($item->files) as $file)
                                                        <a href="{{ asset('assignments/'.$item->id.'_'.$item->type.'/'.$file) }}" class="btn btn-sm btn-default col-4" download>{{$file}}</a>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-lg-4">
        <div class="card h-100">
          <div class="card-header pb-0 p-3">
            <div class="row">
              <div class="col-6 d-flex align-items-center">
                <h6 class="mb-0">Assignment Done</h6>
              </div>
            </div>
          </div>
          <div class="card-body p-3 pb-0 overflow-auto max-height-vh-60">
            <ul class="list-group">
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                    <div class="d-flex flex-column">
                    <h6 class="mb-1 text-dark font-weight-bold text-sm">Subject</h6>
                    </div>
                    <div class="d-flex align-items-center text-sm">
                    Due Date :
                    </div>
                </li>
                @foreach ($assignments as $item)
                    @if (($item->classID == $class->id) && ($item->courseID == $course->id_course))
                        @if ($item->type == 'ASSIGNMENT')
                            <?php $found = false?>
                            @foreach ($assLog as $AL)
                                @if (($AL->assignmentID == $item->id) && ($AL->studentID == Auth::user()->id))
                                    <?php $found = true?>
                                    <?php $grade = $AL->grade?>
                                    <?php $submittedAt = $AL->created_at?>
                                @endif
                            @endforeach
                            @if ($found)
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">{{$item->title}}</h6>
                                    <span class="text-xs desc">{{$item->description}}</span>
                                    </div>
                                    <div class="d-flex align-items-center text-sm">
                                    {{date('D, d-M', strtotime($item->end_date))}}
                                    <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4 " data-bs-toggle="modal" data-bs-target='#openAE{{$item->id}}'><i class="fas fa-folder-open"></i></button>
                                    </div>
                                </li>
                                <div class="modal fade" id="openAE{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">{{$item->title}}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: black;"
                                                    aria-label="Close"><i class="fas fa-times-circle"></i></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="d-flex flex-column h-100">
                                                    <p class="mb-1 pt-2 text-bold text-center">{{$item->type}}</p>
                                                    <h5 class="font-weight-bolder">{{$item->title}}</h5>
                                                    <p class="mb-5">{{$item->description}}</p>
                                                    <a class="mb-1 text-bold" href="{{$item->link}}" target="_blank">{{$item->link}}</a>
                                                    @if ($item->files != NULL)
                                                    <p class="mb-1 pt-1 text-bold">Files :</p>
                                                    <div class="d-flex justify-content-center row">
                                                        @foreach (unserialize($item->files) as $file)
                                                            <a href="{{ asset('assignments/'.$item->id.'_'.$item->type.'/'.$file) }}" class="btn btn-sm btn-default col-4" download>{{$file}}</a>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                    @foreach ($assLog as $AL)
                                                        @if (($AL->assignmentID == $item->id) && ($AL->studentID == Auth::user()->id))
                                                        <p class="mb-1 pt-1 text-bold">Submitted Files :</p>
                                                        <div class="d-flex justify-content-center row">
                                                            @foreach (unserialize($AL->files) as $file)
                                                                <a href="{{ asset('assignmentLog/'.$AL->id.'_'.$AL->assignmentID.'_'.$AL->studentID.'/'.$file) }}" class="btn btn-sm btn-default col-4" download>{{$file}}</a>
                                                            @endforeach
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                    <div>
                                                        <p class="mb-1 pt-2 text-bold">Submitted at :</p>
                                                        <p class="mb-1 text-bold">{{date('H:i:s D, d M Y', strtotime($submittedAt))}}</p>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <p class="mb-1 pt-2 text-bold">Due Date :</p>
                                                            <p class="mb-1 text-bold">{{date('D, d M Y', strtotime($item->start_date))}} - {{date('D, d M Y', strtotime($item->end_date))}}</p>
                                                        </div>
                                                        <div>
                                                            <p class="mb-1 pt-2 text-bold">Grade :</p>
                                                            <p class="mb-1 text-bold">{{($grade === NULL) ? 'Not graded yet':$grade}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                @endforeach
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card h-100">
          <div class="card-header pb-0 p-3">
            <div class="row">
              <div class="col-6 d-flex align-items-center">
                <h6 class="mb-0">Quizzes Done</h6>
              </div>
              
            </div>
          </div>
          <div class="card-body p-3 pb-0 overflow-auto max-height-vh-60">
            <ul class="list-group">
                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                    <div class="d-flex flex-column">
                    <h6 class="mb-1 text-dark font-weight-bold text-sm">Subject</h6>
                    </div>
                    <div class="d-flex align-items-center text-sm">
                    Due Date :
                    </div>
                </li>
                @foreach ($assignments as $item)
                    @if (($item->classID == $class->id) && ($item->courseID == $course->id_course))
                        @if (($item->type == 'QUIZ') || ($item->type == 'ESSAY'))
                            <?php $found = false?>
                            @foreach ($assLog as $AL)
                                @if (($AL->assignmentID == $item->id) && ($AL->studentID == Auth::user()->id))
                                    <?php $found = true?>
                                    <?php $grade = $AL->grade?>
                                    <?php $submittedAt = $AL->created_at?>
                                @endif
                            @endforeach
                            @if ($found)
                                <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                    <div class="d-flex flex-column">
                                    <h6 class="mb-1 text-dark font-weight-bold text-sm">{{$item->title}}</h6>
                                    <span class="text-xs desc">{{$item->description}}</span>
                                    </div>
                                    <div class="d-flex align-items-center text-sm">
                                    {{date('D, d-M', strtotime($item->end_date))}}
                                    <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4 " data-bs-toggle="modal" data-bs-target='#openQUIZ{{$item->id}}'><i class="fas fa-folder-open"></i></button>
                                    </div>
                                </li>
                                <div class="modal fade" id="openQUIZ{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">{{$item->title}}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: black;"
                                                    aria-label="Close"><i class="fas fa-times-circle"></i></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="d-flex flex-column h-100">
                                                    <p class="mb-1 pt-2 text-bold text-center">{{$item->type}}</p>
                                                    <h5 class="font-weight-bolder">{{$item->title}}</h5>
                                                    <p class="mb-5">{{$item->description}}</p>
                                                    <a class="mb-1 text-bold" href="{{$item->link}}" target="_blank">{{$item->link}}</a>
                                                    @if ($item->files != NULL)
                                                    <p class="mb-1 pt-1 text-bold">Files :</p>
                                                    <div class="d-flex justify-content-center row">
                                                        @foreach (unserialize($item->files) as $file)
                                                            <a href="{{ asset('assignments/'.$item->id.'_'.$item->type.'/'.$file) }}" class="btn btn-sm btn-default col-4" download>{{$file}}</a>
                                                        @endforeach
                                                    </div>
                                                    @endif
                                                    <div>
                                                        <p class="mb-1 pt-2 text-bold">Submitted at :</p>
                                                        <p class="mb-1 text-bold">{{date('H:i:s D, d M Y', strtotime($submittedAt))}}</p>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <p class="mb-1 pt-2 text-bold">Due Date :</p>
                                                            <p class="mb-1 text-bold">{{date('D, d M Y', strtotime($item->start_date))}} - {{date('D, d M Y', strtotime($item->end_date))}}</p>
                                                        </div>
                                                        <div>
                                                            <p class="mb-1 pt-2 text-bold">Grade :</p>
                                                            <p class="mb-1 text-bold">{{($grade === NULL) ? 'Not graded yet':$grade}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                @endforeach
            </ul>
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
                            <form action="{{url('sendMessage/'.$class->id.'/'.$course->id_course.'/'.Auth::user()->id)}}" id="formMessage"  method="POST">
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
@endsection