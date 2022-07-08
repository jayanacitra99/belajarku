@extends('teacher/template')
@section('title')
    Dashboard
@endsection
@section('page')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{route('home')}}">BelajarKu</a></li>
@endsection
@section('head-script')
    
@endsection
@section('content')
<div class="container-fluid py-4">
  <a href="{{route('back')}}"><i class="fas fa-chevron-circle-left"></i> Back</a>
  <?php $row = 0?>
  @foreach ($course as $item)
      @if ($row == 0)
      <div class="row">
      @endif
      @if ($item->teacherID == auth()->user()->id)
      <div class="col-3">
        <div class="card">
          <div class="card-header mx-4 p-3 text-center">
            <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
              <i class="fab fa-leanpub  opacity-10"></i>
            </div>
          </div>
          <div class="card-body pt-0 p-3 text-center">
            <h6 class="text-center mb-0">{{$item->courseName}}</h6>
            <span class="text-xs">Class : {{($item->courseClass === 'X') ? 'X (Sepuluh)' : (($item->courseClass === 'XI') ? 'XI (Sebelas)' : 'XII (Dua Belas)')}}</span>
            <hr class="horizontal dark my-3">
            <a href="{{url('courseClass/'.$item->id_course)}}"><h5 class="mb-0"><i class="fas fa-door-open"></i> Open Course</h5></a>
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