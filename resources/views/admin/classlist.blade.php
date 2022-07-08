@extends('admin/template')
@section('title')
    Class List
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
            <h6>Class List</h6>
            <button class="btn bg-gradient-primary w-20" data-bs-toggle="modal" data-bs-target='#addClass'>Add New Class</button>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Class</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Current Member</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quota</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($class as $item)
                    <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">{{$item->class}}.{{$item->indexClass}}</h6>
                            </div>
                          </div>
                        </td>
                        <td>
                            <?php $countMember = 0?>
                        @foreach ($classMember as $cMember)
                            @if ($cMember->classID == $item->id)
                                <?php $countMember += 1?>
                            @endif
                        @endforeach
                          <p class="text-xs font-weight-bold mb-0">{{$countMember}}</p>
                        </td>
                        <td class="align-middle text-center text-sm">
                            <p class="text-xs font-weight-bold mb-0">{{$item->quota}}</p>
                        </td>
                        <td class="align-middle">
                          <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target='#editClasslist{{$item->id}}'>
                            Edit 
                          </a>
                          | 
                          <a delurl="{{url('deleteClass/'.$item->id)}}" class="text-secondary font-weight-bold text-xs buttonDelete" style="cursor: pointer">Delete</a>
                          <a href="{{url('detailClass/'.$item->id)}}" class="text-secondary font-weight-bold text-xs">| Detail</a>
                        </td>
                    </tr>
                    <div class="modal fade" id="editClasslist{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                      aria-labelledby="staticBackdropLabel" aria-hidden="true">
                      <div class="modal-dialog">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="staticBackdropLabel">Edit Class</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: black;"
                                      aria-label="Close">X</button>
                              </div>
                              <div class="modal-body">
                                  <form action="{{url('editClasslist/'.$item->id)}}" method="POST">
                                      @csrf
                                      <div class="mb-3">
                                        <span>Class :</span>
                                        <input type="text" class="form-control form-control-lg" placeholder="Class" name="class" value="{{$item->class}}" readonly>
                                      </div>
                                      @error('class')
                                      <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                                      <script> window.addEventListener("load",clickNotif);</script>
                                      @enderror
                                      <div class="mb-3">
                                        <span>Index of Class :</span>
                                          <input type="text" class="form-control form-control-lg" placeholder="Index Class" name="indexClass" value="{{$item->indexClass}}">
                                      </div>
                                      @error('indexClass')
                                      <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                                      <script> window.addEventListener("load",clickNotif);</script>
                                      @enderror
                                      <div class="mb-3">
                                        <span>Quota :</span>
                                          <input type="number" min="1" class="form-control form-control-lg" placeholder="Quota Class" name="quota" value="{{$item->quota}}">
                                      </div>
                                      @error('quota')
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
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="addClass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Form Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: black;"
                    aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form action="{{url('addNewClass')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <span>Class :</span>
                      <select name="class" class="form-control form-control-lg">
                        <option disabled selected>--SELECT CLASS--</option>
                        <option value="X">X</option>
                        <option value="XI">XI</option>
                        <option value="XII">XII</option>
                      </select>
                    </div>
                    @error('class')
                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                    <script> window.addEventListener("load",clickNotif);</script>
                    @enderror
                    <div class="mb-3">
                        <input type="text" class="form-control form-control-lg" placeholder="Index Class" name="indexClass" value="{{old('indexClass')}}">
                    </div>
                    @error('indexClass')
                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                    <script> window.addEventListener("load",clickNotif);</script>
                    @enderror
                    <div class="mb-3">
                        <input type="number" min="1" class="form-control form-control-lg" placeholder="Quota Class" name="quota" value="{{old('quota')}}">
                    </div>
                    @error('quota')
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