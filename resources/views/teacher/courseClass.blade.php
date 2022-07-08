@extends('teacher/template')
@section('title')
    {{$course->courseName}} Classes
@endsection
@section('page')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{route('home')}}">BelajarKu</a></li>
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{route('home')}}">Dashboard</a></li>
@endsection
@section('head-script')
@endsection
@section('content')
<div class="container-fluid py-4">
    <a href="{{route('home')}}"><i class="fas fa-chevron-circle-left"></i> Back</a>
    <?php $row = 0?>
    @foreach ($clCourse as $item)
        @if ($row == 0)
        <div class="row">
        @endif
        @if ($item->courseID == $course->id_course)
        <div class="col-3">
          <div class="card">
            <div class="card-header mx-4 p-3 text-center">
              <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                <i class="fab fa-leanpub  opacity-10"></i>
              </div>
            </div>
            <div class="card-body pt-0 p-3 text-center">
              <h6 class="text-center mb-0">{{$item->class}}.{{$item->indexClass}}</h6>
              <hr class="horizontal dark my-3">
              <a href="{{url('classDetail/'.$item->classID.'/'.$item->courseID)}}"><h5 class="mb-0"><i class="fas fa-door-open"></i> Open Class</h5></a>
            </div>
          </div>
        </div>
        @endif
        <?php $row++?>
        @if ($row == 4)
            <?php $row = 0?>
        </div>
        @endif
    @endforeach
</div>
@endsection
@section('body-script')
@endsection