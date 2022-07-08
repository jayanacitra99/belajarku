@extends('student/template')
@section('title')
    {{$ass->type}} - {{$ass->title}}
@endsection
@section('page')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">BelajarKu</a></li>
@endsection
@section('head-script')
<script>
    $(document).ready(function(){
      $(".buttonSubmit").click(function() {
        Swal.fire({
            title: 'Finish Attempt',
            text: "Are you sure?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No, Check Again',
            confirmButtonText: 'Finish Attempt'
        }).then((result) => {
          if (result.isConfirmed) {
            $('form').submit();
          }
        })
      });
    });
</script>
@endsection
@section('content')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-md-7 mt-4">
        <div class="card">
          <div class="card-header pb-0 px-3">
            <h6 class="mb-0">Question</h6>
          </div>
          <div class="card-body pt-4 p-3 overflow-auto max-height-vh-70">
            <ul class="list-group">
                <?php $number = 1; $audio = 0?>
                @foreach (unserialize($ass->question) as $item)
                    <li class="list-group-item border-0 p-4 mb-2 bg-gray-100 border-radius-lg ">
                        <div class="d-flex flex-column">
                        <h6 class="mb-3 text-sm">{{$number++}}. {{$item['question']}}</h6>
                        @if ($ass->type == 'QUIZ')
                            @if ($item['voice'] != 'FALSE')
                            <audio class="mb-2" controls>
                                <source src="{{asset('assignments/'.$ass->id.'_'.$ass->type.'/voices'.'/'.unserialize($ass->voice)[$audio++])}}">
                            </audio>
                            @endif
                            <div class="d-flex justify-content-between row">
                                <div class="d-flex flex-column col-4">
                                    <span class="mb-2 text-xs">A : <span class="text-dark font-weight-bold ms-sm-2">{{$item['optionA']}}</span></span>
                                    <span class="mb-2 text-xs">B : <span class="text-dark ms-sm-2 font-weight-bold">{{$item['optionB']}}</span></span>
                                </div>
                                <div class="d-flex flex-column col-4">
                                    <span class="mb-2 text-xs">C : <span class="text-dark font-weight-bold ms-sm-2">{{$item['optionC']}}</span></span>
                                    <span class="mb-2 text-xs">D : <span class="text-dark ms-sm-2 font-weight-bold">{{$item['optionD']}}</span></span>
                                </div>
                            </div>
                        @endif
                        </div>
                    </li>
                @endforeach
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-5 mt-4">
        <div class="card h-100 mb-4">
          <div class="card-header pb-0 px-3">
            <div class="row">
              <div class="col-md-6">
                <h6 class="mb-0">Answer Sheet</h6>
              </div>
              <div class="col-md-6 d-flex justify-content-end align-items-center">
                <button class="btn bg-gradient-primary buttonSubmit">SUBMIT</button>
              </div>
            </div>
          </div>
          <div class="card-body pt-4 p-3 overflow-auto max-height-vh-70">
            <ul class="list-group">
                <?php $no = 1?>
                <form action="{{url('submitAttempt/'.$ass->id.'/'.Auth::user()->id)}}" method="POST">
                @csrf
                @foreach (unserialize($ass->question) as $item)
                    <li class="list-group-item border-0 border-bottom-lg">
                        <div class="d-flex justify-content-between row">
                            <span id="span{{$no}}" class="btn btn-icon-only btn-outline-danger btn-rounded mb-0 me-3 btn-sm d-flex align-items-center justify-content-center col-1">{{$no}}</span>
                            @if ($ass->type == 'QUIZ')
                                <div class="col-2">
                                    <input type="radio" onchange="checked{{$no}}(this)" name="answer[{{$no}}][answer]" value="A" id="optA{{$no}}" spanID="span{{$no}}">
                                    <label for="optA{{$no}}">A</label>
                                </div>
                                <div class="col-2">
                                    <input type="radio" onchange="checked{{$no}}(this)" name="answer[{{$no}}][answer]" value="B" id="optB{{$no}}" spanID="span{{$no}}">
                                    <label for="optB{{$no}}">B</label>
                                </div>
                                <div class="col-2">
                                    <input type="radio" onchange="checked{{$no}}(this)" name="answer[{{$no}}][answer]" value="C" id="optC{{$no}}" spanID="span{{$no}}">
                                    <label for="optC{{$no}}">C</label>
                                </div>
                                <div class="col-2">
                                    <input type="radio" onchange="checked{{$no}}(this)" name="answer[{{$no}}][answer]" value="D" id="optD{{$no}}" spanID="span{{$no}}">
                                    <label for="optD{{$no}}">D</label>
                                </div>
                                <input type="radio" onchange="checked(this)" name="answer[{{$no}}][answer]" value="NULL" checked style="display: none">
                            @endif
                            @if ($ass->type == 'ESSAY')
                            <input class="col form-control" type="text" name="answer[{{$no}}][answer]" tempID="temp{{$no}}" onchange="checked{{$no}}(this)" id="" value="" spanID="span{{$no}}" placeholder="Answer here!">
                            <input class="col form-control" type="text" name="answer[{{$no}}][answer]" id="temp{{$no}}" value="NULL" style="display: none">
                            @endif
                            <script>
                                function checked{{$no++}}(src){
                                    var element = src.getAttribute("spanID");
                                    var temp = src.getAttribute("tempID");
                                    var span = document.getElementById(element);
                                    var tempIn = document.getElementById(temp);
                                    span.classList.remove("btn-outline-danger");
                                    span.classList.add("btn-outline-success");
                                    tempIn.setAttribute('disabled','');
                                    if (src.value == '') {
                                        span.classList.add("btn-outline-danger");
                                        span.classList.remove("btn-outline-success");
                                        tempIn.removeAttribute('disabled','');
                                    }
                                }
                            </script>
                        </div>
                    </li>
                @endforeach
                </form>
            </ul>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('body-script')

@endsection