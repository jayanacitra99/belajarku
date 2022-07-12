@extends('teacher/template')
@section('title')
    Add Assignment
@endsection
@section('page')
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{route('home')}}">BelajarKu</a></li>
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{route('home')}}">Dashboard</a></li>
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{url('courseClass/'.$course->id_course)}}">{{$course->courseName}}</a></li>
<li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{url('classDetail/'.$class->id.'/'.$course->id_course)}}">{{$class->class}}.{{$class->indexClass}}</a></li>
@endsection
@section('head-script')

@endsection
@section('content')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-6">
        <div class="card mb-4">
          <div class="card-header pb-0 d-flex justify-content-between">
            <h6>Add New Assignment</h6>
            <button form="assForm" type="submit" value="submit" class="btn bg-gradient-primary">Submit Assignment</button>
          </div>
          <form action="{{url('addNewAss/'.$class->id.'/'.$course->id_course)}}" method="POST" enctype="multipart/form-data" id="assForm">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="assTitle">Assignment Title</label>
                <input type="text" name="title" class="form-control" id="assTitle" placeholder="Enter Assignment Title" value="{{old('title')}}">
                @error('title')
                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                    <script> window.addEventListener("load",clickNotif);</script>
                @enderror
              </div>
              <div class="form-group">
                <label for="assDesc">Assignment Description</label>
                <textarea name="desc" class="form-control" id="assDesc" cols="30" rows="2" placeholder="Enter Assignment Description">{{old('desc')}}</textarea>
                @error('desc')
                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                    <script> window.addEventListener("load",clickNotif);</script>
                @enderror
              </div>
              <div class="form-group">
                <label for="assType">Assignment Type</label>
                <select name="type" id="assType" class="form-control" onchange="showQuest()">
                    <option value="" selected disabled>-- Choose Assignment Type --</option>
                    <option value="ASSIGNMENT">ASSIGNMENT</option>
                    <option value="QUIZ">QUIZ</option>
                    <option value="ESSAY">ESSAY</option>
                    <option value="MODULE">MODULE</option>
                </select>
                @error('type')
                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                    <script> window.addEventListener("load",clickNotif);</script>
                @enderror
              </div>
              <div class="row"> 
                <div class="form-group col">
                    <label for="assFile">Assignment File</label>
                    <input type="file" class="form-control" id="assFile" name="files[]" value="{{old('files[]')}}" multiple>
                    @error('files')
                        <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                        <script> window.addEventListener("load",clickNotif);</script>
                    @enderror
                </div>
                <div class="form-group col">
                    <label for="assLink">Assignment Link</label>
                    <input type="text" class="form-control" id="assLink" name="link" value="{{old('link')}}">
                    @error('link')
                        <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                        <script> window.addEventListener("load",clickNotif);</script>
                    @enderror
                </div>
              </div>
            </div>
         
        </div>
      </div>
      <div class="col-6 " id="QA" style="display: none">
        <div class="card mb-4">
          <div class="card-header pb-0 d-flex justify-content-between">
            <h6>Question Answer</h6>
            <div id="addMinQuestion" style="display: ">
                <button type="button" id="addQuestion" class="btn bg-gradient-primary"><i class="fas fa-plus-circle"></i> Question</button>
                <button type="button" id="minQuestion" class="btn bg-gradient-primary"><i class="fas fa-min-circle"></i> Question</button>
            </div>
          </div>
        </div>
        <div class="card mb-4 max-height-vh-60 overflow-auto">
            <div class="card-body" >
              <div class="row" id="colQuest"> 
                <div class="form-group col">
                    <?php
                        date_default_timezone_set('Asia/Jakarta');
                        $today = date('Y-m-d');
                    ?>
                    <label for="assStart">Start Date</label>
                    <input type="date" class="form-control" min="{{$today}}" id="assStart" onchange="changeEnd()" name="start" value="{{old('start')}}">
                    @error('start')
                        <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                        <script> window.addEventListener("load",clickNotif);</script>
                    @enderror
                </div>
                <div class="form-group col">
                    <label for="assEnd">End Date</label>
                    <input type="date" class="form-control" id="assEnd" name="end" value="{{old('end')}}" disabled>
                    @error('end')
                        <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                        <script> window.addEventListener("load",clickNotif);</script>
                    @enderror
                </div>
              </div>
              {{-- <div  id="rowQuest'+no+'">
                <div class="row d-flex justify-content-between">
                  <div class="form-group col" style="display: none" id="inputVoice'+no+'">
                    <label for="assVoice'+no+'">Assignment Voice File '+no+'</label>
                    <input type="file" form="assForm" class="form-control" name="voices[]" id="assVoice'+no+'" accept="audio/*">
                  </div>
                  <div class="col">
                    <div>
                      <button type="button" id="addVoice'+no+'" minID="minVoice'+no+'" inputVoice="inputVoice'+no+'" vStatus="voiceStatus'+no+'" class="btn bg-gradient-primary addVoice" onclick="showVoice(this.id)"><i class="fas fa-plus-circle"></i> Add Voice</button>
                    </div>
                    <div >
                      <button type="button" id="minVoice'+no+'" addID="addVoice'+no+'" inputVoice="inputVoice'+no+'" vStatus="voiceStatus'+no+'" class="btn bg-gradient-primary minVoice" onclick="hideVoice(this.id)" style="display: none"><i class="fas fa-plus-circle"></i> Remove Voice</button>
                    </div>
                    <input type="text" id="voiceStatus'+no+'" form="assForm" name="question['+count+'][voice]" value="FALSE" readonly style="display: none">
                  </div>
                </div>
                <div class="row d-flex justify-content-between">
                  <div class="form-group col" style="display: none" id="inputImage'+no+'">
                    <label for="assImage'+no+'">Assignment Image File '+no+'</label>
                    <input type="file" form="assForm" class="form-control" name="images[]" id="assImage'+no+'" accept="image/*">
                  </div>
                  <div class="col">
                    <div>
                      <button type="button" id="addImage'+no+'" minID="minImage'+no+'" inputImage="inputImage'+no+'" vStatus="imageStatus'+no+'" class="btn bg-gradient-primary addImage" onclick="showImage(this.id)"><i class="fas fa-plus-circle"></i> Add Image</button>
                    </div>
                    <div >
                      <button type="button" id="minImage'+no+'" addID="addImage'+no+'" inputImage="inputImage'+no+'" vStatus="imageStatus'+no+'" class="btn bg-gradient-primary minImage" onclick="hideImage(this.id)" style="display: none"><i class="fas fa-plus-circle"></i> Remove Image</button>
                    </div>
                    <input type="text" id="imageStatus'+no+'" form="assForm" name="question['+count+'][image]" value="FALSE" readonly style="display: none">
                  </div>
                </div>
                <div class="row"> 
                  <div class="form-group w-1"><label>'+no+'</label></div> 
                  <div class="form-group col"> 
                    <label for="assQuest'+no+'">Question</label> 
                    <textarea form="assForm"  name="question['+count+'][question]" id="assQuest'+no+'" class="form-control" rows="10"></textarea> 
                    <div class="d-flex justify-content-between"><label >Answer </label> 
                      <div><input form="assForm" type="radio" name="question['+count+'][answer]" id="optA'+no+'" value="A"> <label for="optA'+no+'">A</label></div> 
                      <div><input form="assForm" type="radio" name="question['+count+'][answer]" id="optB'+no+'" value="B"> <label for="optB'+no+'">B</label></div> 
                      <div><input form="assForm" type="radio" name="question['+count+'][answer]" id="optC'+no+'" value="C"> <label for="optC'+no+'">C</label></div> 
                      <div><input form="assForm" type="radio" name="question['+count+'][answer]" id="optD'+no+'" value="D"> <label for="optD'+no+'">D</label></div>
                    </div>
                  </div> 
                  <div class="form-group col"> 
                    <label for="assOptA'+no+'">Option A</label>
                    <input type="text" form="assForm" class="form-control" id="assOptA'+no+'"  name="question['+count+'][optionA]"> 
                    <label for="assOptB'+no+'">Option B</label>
                    <input type="text" form="assForm" class="form-control" id="assOptB'+no+'"  name="question['+count+'][optionB]"> 
                    <label for="assOptC'+no+'">Option C</label>
                    <input type="text" form="assForm" class="form-control" id="assOptC'+no+'"  name="question['+count+'][optionC]"> 
                    <label for="assOptD'+no+'">Option D</label>
                    <input type="text" form="assForm" class="form-control" id="assOptD'+no+'"  name="question['+count+'][optionD]">
                  </div>
                </div>
              </div> --}}
              @error('voice')
                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                    <script> window.addEventListener("load",clickNotif);</script>
              @enderror
              @error('image')
                  <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                  <script> window.addEventListener("load",clickNotif);</script>
              @enderror
              @error('question')
                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                    <script> window.addEventListener("load",clickNotif);</script>
                @enderror
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection
@section('body-script')
<script type="text/javascript">
    var no = 1;
    var count = 0;
  function changeEnd(){
      document.getElementById('assEnd').disabled = false;
      assEnd.min = assStart.value;
  }

  function showVoice(clicked){
    const element = document.getElementById(clicked);
      var inputVoice = element.getAttribute("inputVoice");
      var minID = element.getAttribute("minID");
      var vStatus = element.getAttribute("vStatus");

      document.getElementById(inputVoice).style.display = 'block';
      document.getElementById(minID).style.display = 'block';
      document.getElementById(clicked).style.display = 'none';
      document.getElementById(vStatus).value = 'TRUE';
  }

  function hideVoice(clicked){
    const element = document.getElementById(clicked);
      var inputVoice = element.getAttribute("inputVoice");
      var addID = element.getAttribute("addID");
      var vStatus = element.getAttribute("vStatus");

      document.getElementById(inputVoice).style.display = 'none';
      document.getElementById(clicked).style.display = 'none';
      document.getElementById(addID).style.display = 'block';
      document.getElementById(vStatus).value = 'FALSE';
  }

  function showImage(clicked){
    const element = document.getElementById(clicked);
      var inputImage = element.getAttribute("inputImage");
      var minID = element.getAttribute("minID");
      var vStatus = element.getAttribute("vStatus");

      document.getElementById(inputImage).style.display = 'block';
      document.getElementById(minID).style.display = 'block';
      document.getElementById(clicked).style.display = 'none';
      document.getElementById(vStatus).value = 'TRUE';
  }

  function hideImage(clicked){
    const element = document.getElementById(clicked);
      var inputImage = element.getAttribute("inputImage");
      var addID = element.getAttribute("addID");
      var vStatus = element.getAttribute("vStatus");

      document.getElementById(inputImage).style.display = 'none';
      document.getElementById(clicked).style.display = 'none';
      document.getElementById(addID).style.display = 'block';
      document.getElementById(vStatus).value = 'FALSE';
  }

  function showQuest(){
      var x = document.getElementById('assType').value;

      if (x != 'MODULE') {
        if (x == 'ASSIGNMENT') {
          document.getElementById('addMinQuestion').style.visibility = 'hidden';
        } else {
          document.getElementById('addMinQuestion').style.visibility = 'visible';
        }
          var x = document.getElementsByClassName('allQuest');
          var total = x.length;
          for (var index = 0; index < total; index++) {
            document.getElementById('minQuestion').click();
          }
          document.getElementById('QA').style.display = 'block';
      } else {
          document.getElementById('QA').style.display = 'none';
      }
  }
    
    $('#addQuestion').click(function (){
      var x = $('#assType').val();
      if (x == "ESSAY") {
        $("#colQuest").append('<div  id="rowQuest'+no+'" class="allQuest"> <div class="form-group col"> <label for="assQuest'+no+'">Question '+no+'</label> <textarea form="assForm"  name="question['+count+'][question]" id="assQuest'+no+'" class="form-control" rows="5"></textarea> </div> </div>');
      } else {
        $("#colQuest").append('<div  id="rowQuest'+no+'"> <div class="row d-flex justify-content-between"> <div class="form-group col" style="display: none" id="inputVoice'+no+'"> <label for="assVoice'+no+'">Assignment Voice File '+no+'</label> <input type="file" form="assForm" class="form-control" name="voices[]" id="assVoice'+no+'" accept="audio/*"> </div> <div class="col"> <div> <button type="button" id="addVoice'+no+'" minID="minVoice'+no+'" inputVoice="inputVoice'+no+'" vStatus="voiceStatus'+no+'" class="btn bg-gradient-primary addVoice" onclick="showVoice(this.id)"><i class="fas fa-plus-circle"></i> Add Voice</button> </div> <div > <button type="button" id="minVoice'+no+'" addID="addVoice'+no+'" inputVoice="inputVoice'+no+'" vStatus="voiceStatus'+no+'" class="btn bg-gradient-primary minVoice" onclick="hideVoice(this.id)" style="display: none"><i class="fas fa-plus-circle"></i> Remove Voice</button> </div> <input type="text" id="voiceStatus'+no+'" form="assForm" name="question['+count+'][voice]" value="FALSE" readonly style="display: none"> </div> </div> <div class="row d-flex justify-content-between"> <div class="form-group col" style="display: none" id="inputImage'+no+'"> <label for="assImage'+no+'">Assignment Image File '+no+'</label> <input type="file" form="assForm" class="form-control" name="images[]" id="assImage'+no+'" accept="image/*"> </div> <div class="col"> <div> <button type="button" id="addImage'+no+'" minID="minImage'+no+'" inputImage="inputImage'+no+'" vStatus="imageStatus'+no+'" class="btn bg-gradient-primary addImage" onclick="showImage(this.id)"><i class="fas fa-plus-circle"></i> Add Image</button> </div> <div > <button type="button" id="minImage'+no+'" addID="addImage'+no+'" inputImage="inputImage'+no+'" vStatus="imageStatus'+no+'" class="btn bg-gradient-primary minImage" onclick="hideImage(this.id)" style="display: none"><i class="fas fa-plus-circle"></i> Remove Image</button> </div> <input type="text" id="imageStatus'+no+'" form="assForm" name="question['+count+'][image]" value="FALSE" readonly style="display: none"> </div> </div> <div class="row"> <div class="form-group w-1"><label>'+no+'</label></div> <div class="form-group col"> <label for="assQuest'+no+'">Question</label> <textarea form="assForm"  name="question['+count+'][question]" id="assQuest'+no+'" class="form-control" rows="10"></textarea> <div class="d-flex justify-content-between"><label >Answer </label> <div><input form="assForm" type="radio" name="question['+count+'][answer]" id="optA'+no+'" value="A"> <label for="optA'+no+'">A</label></div> <div><input form="assForm" type="radio" name="question['+count+'][answer]" id="optB'+no+'" value="B"> <label for="optB'+no+'">B</label></div> <div><input form="assForm" type="radio" name="question['+count+'][answer]" id="optC'+no+'" value="C"> <label for="optC'+no+'">C</label></div> <div><input form="assForm" type="radio" name="question['+count+'][answer]" id="optD'+no+'" value="D"> <label for="optD'+no+'">D</label></div> </div> </div> <div class="form-group col"> <label for="assOptA'+no+'">Option A</label> <input type="text" form="assForm" class="form-control" id="assOptA'+no+'"  name="question['+count+'][optionA]"> <label for="assOptB'+no+'">Option B</label> <input type="text" form="assForm" class="form-control" id="assOptB'+no+'"  name="question['+count+'][optionB]"> <label for="assOptC'+no+'">Option C</label> <input type="text" form="assForm" class="form-control" id="assOptC'+no+'"  name="question['+count+'][optionC]"> <label for="assOptD'+no+'">Option D</label> <input type="text" form="assForm" class="form-control" id="assOptD'+no+'"  name="question['+count+'][optionD]"> </div> </div> </div>');
      }
      count += 1;
      no += 1;
    });
    $('#minQuestion').click(function(){
        no -= 1;
        count -= 1;
        $('#rowQuest'+no).remove();            
    });
</script>

@endsection