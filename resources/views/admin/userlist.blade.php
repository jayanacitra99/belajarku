@extends('admin/template')
@section('title')
    User List
@endsection
@section('head-script')
  <script>
    $(document).ready(function(){
      $("#addNewUser").click(function(){
        $("#addUser").modal('show');
      });

      $(".btn-close").click(function() {
        $('.allForm').trigger("reset");
      });

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

      $(".selectRoleEdit").change(function() {
        var x = $(this).val();
        var y = $(this).attr('itemID');
        if (x != 'STUDENT') {
          $('#classRowEdit'+y).hide();
        } else {
          $('#classRowEdit'+y).show();
        }
      });
        
      $(".classOptionEdit").change(function() {
        var x = $(this).val();
        var y = $(this).attr('itemID');
        if(x == 'X'){
          $('.optionIndexEdit'+y).remove();
          $('#indexClassEdit'+y).append('@foreach ($class as $classitem)');
          $('#indexClassEdit'+y).append('@if ($classitem->class == 'X')');
          $('#indexClassEdit'+y).append(`<option class="optionIndexEdit" value="{{$classitem->indexClass}}">{{$classitem->indexClass}}</option>`);
          $('#indexClassEdit'+y).append('@endif');
          $('#indexClassEdit'+y).append('@endforeach');
        } else if(x == 'XI'){
          $('.optionIndexEdit'+y).remove();
          $('#indexClassEdit'+y).append('@foreach ($class as $classitem)');
          $('#indexClassEdit'+y).append('@if ($classitem->class == 'XI')');
          $('#indexClassEdit'+y).append(`<option class="optionIndexEdit" value="{{$classitem->indexClass}}">{{$classitem->indexClass}}</option>`);
          $('#indexClassEdit'+y).append('@endif');
          $('#indexClassEdit'+y).append('@endforeach');
        } else if(x == 'XII'){
          $('.optionIndexEdit'+y).remove();
          $('#indexClassEdit'+y).append('@foreach ($class as $classitem)');
          $('#indexClassEdit'+y).append('@if ($classitem->class == 'XII')');
          $('#indexClassEdit'+y).append(`<option class="optionIndexEdit" value="{{$classitem->indexClass}}">{{$classitem->indexClass}}</option>`);
          $('#indexClassEdit'+y).append('@endif');
          $('#indexClassEdit'+y).append('@endforeach');
        }
      });

      $(".classOption").change(function() {
        var x = $(this).val();
        var y = $(this).attr('itemID');
        $('#editClassButton'+y).show();
        if(x == 'X'){
          $('.optionIndex'+y).remove();
          $('#indexClass'+y).append('@foreach ($class as $classitem)');
          $('#indexClass'+y).append('@if ($classitem->class == 'X')');
          $('#indexClass'+y).append('<option class="optionIndex'+y+'" value="{{$classitem->indexClass}}">{{$classitem->indexClass}}</option>');
          $('#indexClass'+y).append('@endif');
          $('#indexClass'+y).append('@endforeach');
        } else if(x == 'XI'){
          $('.optionIndex'+y).remove();
          $('#indexClass'+y).append('@foreach ($class as $classitem)');
          $('#indexClass'+y).append('@if ($classitem->class == 'XI')');
          $('#indexClass'+y).append('<option class="optionIndex'+y+'" value="{{$classitem->indexClass}}">{{$classitem->indexClass}}</option>');
          $('#indexClass'+y).append('@endif');
          $('#indexClass'+y).append('@endforeach');
        } else if(x == 'XII'){
          $('.optionIndex'+y).remove();
          $('#indexClass'+y).append('@foreach ($class as $classitem)');
          $('#indexClass'+y).append('@if ($classitem->class == 'XII')');
          $('#indexClass'+y).append('<option class="optionIndex'+y+'" value="{{$classitem->indexClass}}">{{$classitem->indexClass}}</option>');
          $('#indexClass'+y).append('@endif');
          $('#indexClass'+y).append('@endforeach');
        }
      });
    });
  </script>
  <style>
    .editClassButton {
      background: none;
      color: inherit;
      border: none;
      padding: 0;
      font: inherit;
      cursor: pointer;
      outline: inherit;

    }
  </style>
@endsection
@section('content')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0 d-flex justify-content-between">
            <h6>User List</h6>
            <button class="btn bg-gradient-primary w-20" id="addNewUser">Add New User</button>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Class</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($user as $item)
                    <tr>
                        <td>
                          <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                              <h6 class="mb-0 text-sm">{{$item->name}}</h6>
                            </div>
                          </div>
                        </td>
                        <td>
                          <p class="text-xs font-weight-bold mb-0">{{$item->email}}</p>
                        </td>
                        <td class="align-middle text-center text-sm">
                            <p class="text-xs font-weight-bold mb-0">{{$item->role}}</p>
                        </td>
                        <td class="align-middle text-center text-sm">
                          @foreach ($member as $cMember)
                              @if ($cMember->studentID == $item->id)
                                  @foreach ($class as $classItem)
                                      @if ($classItem->id == $cMember->classID)
                                      <form action="{{url('editClass/'.$cMember->id)}}" class="allForm" id="editClass{{$item->id}}" method="POST">
                                        @csrf
                                        <select name="class" class="classOption form-control-sm" itemID="{{$item->id}}">
                                          <option value="X" {{($classItem->class === 'X') ? 'selected' : ''}}>X</option>
                                          <option value="XI" {{($classItem->class === 'XI') ? 'selected' : ''}}>XI</option>
                                          <option value="XII" {{($classItem->class === 'XII') ? 'selected' : ''}}>XII</option>
                                        </select>
                                        @error('class')
                                        <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                                        <script> window.addEventListener("load",clickNotif);</script>
                                        @enderror
                                        <select name="indexClass" id="indexClass{{$item->id}}" class="classOption form-control-sm" itemID="{{$item->id}}">
                                          <?php $idx = 1?>
                                          @foreach ($class as $indexClass)
                                              @if ($classItem->class == $indexClass->class)
                                              <option class="optionIndex{{$item->id}}" value="{{$indexClass->indexClass}}" {{($classItem->indexClass === $indexClass->indexClass) ? 'readonly selected' : ''}}>{{$indexClass->indexClass}}</option>
                                              @endif
                                          @endforeach
                                        </select>
                                        @error('indexClass')
                                        <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                                        <script> window.addEventListener("load",clickNotif);</script>
                                        @enderror
                                      </div>
                                      </form>
                                      @endif
                                  @endforeach
                              @endif
                          @endforeach
                      </td>
                        <td class="align-middle">
                          <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target='#editUser{{$item->id}}'>
                            Edit 
                          </a>
                          | 
                          <a delurl="{{url('deleteUser/'.$item->id)}}" class="text-secondary font-weight-bold text-xs buttonDelete" style="cursor: pointer">Delete</a>
                          @if ($item->role == 'STUDENT')
                          <button type="submit" value="submit" id="editClassButton{{$item->id}}" form="editClass{{$item->id}}" class="text-secondary editClassButton font-weight-bold text-xs" style="display: none">| Change Class</button>
                          @endif
                          
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="editUser{{$item->id}}" itemid="{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Edit User</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: black;"
                                    aria-label="Close"><i class="fas fa-times"></i></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{url('editUser/'.$item->id)}}" class="allForm" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                      <input type="text" class="form-control form-control-lg" placeholder="Name" name="name" value="{{$item->name}}">
                                    </div>
                                    @error('name')
                                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                                    <script> window.addEventListener("load",clickNotif);</script>
                                    @enderror
                                    <div class="mb-3">
                                      <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" value="{{$item->email}}">
                                    </div>
                                    @error('email')
                                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                                    <script> window.addEventListener("load",clickNotif);</script>
                                    @enderror
                                    <div class="mb-3">
                                        <select name="role" id="roleEdit" class="form-control form-control-lg selectRoleEdit" itemID="{{$item->id}}">
                                          <option value="STUDENT" {{($item->role === 'STUDENT') ? 'selected' : ''}}>STUDENT</option>
                                          <option value="ADMIN" {{($item->role === 'ADMIN') ? 'selected' : ''}}>ADMIN</option>
                                          <option value="TEACHER" {{($item->role === 'TEACHER') ? 'selected' : ''}}>TEACHER</option>
                                        </select>
                                    </div>
                                    @error('role')
                                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                                    <script> window.addEventListener("load",clickNotif);</script>
                                    @enderror
                                    <div class="mb-3 row" id="classRowEdit{{$item->id}}" itemID="{{$item->id}}"  style="display: none">
                                      <div class="col">
                                        <span>Class :</span>
                                      <select name="class" class="form-control form-control-lg classOptionEdit" itemID="{{$item->id}}">
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
                                      <div class="col">
                                        <span>Index Class :</span>
                                      <select name="indexClass" id="indexClassEdit{{$item->id}}" class="form-control form-control-lg">
                                        <option disabled selected>--SELECT INDEX OF CLASS--</option>
                                      </select>
                                      </div>
                                      @error('indexClass')
                                      <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                                      <script> window.addEventListener("load",clickNotif);</script>
                                      @enderror
                                    </div>
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
<div class="modal fade" id="addUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Form Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: black;"
                    aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{url('addNewUser')}}" method="POST" class="allForm">
                    @csrf
                    <div class="mb-3">
                      <input type="text" class="form-control form-control-lg" placeholder="Name" name="name" value="{{old('name')}}">
                    </div>
                    @error('name')
                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                    <script> window.addEventListener("load",clickNotif);</script>
                    @enderror
                    <div class="mb-3">
                      <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" value="{{old('email')}}">
                    </div>
                    @error('email')
                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                    <script> window.addEventListener("load",clickNotif);</script>
                    @enderror
                    <div class="mb-3">
                      <input type="password" class="form-control form-control-lg" placeholder="Password" name="password" >
                    </div>
                    @error('password')
                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                    <script> window.addEventListener("load",clickNotif);</script>
                    @enderror
                    <div class="mb-3">
                      <input type="password" class="form-control form-control-lg" placeholder="Retype password" id="password-confirm" name="password_confirmation" autocomplete="new-password" value="{{ old('password_confirmation') }}">
                    </div>
                    <div class="mb-3">
                      <span>Role :</span>
                        <select name="role" class="form-control form-control-lg" id="role" onchange="hideClass()">
                          <option disabled selected>--SELECT TYPE OF ROLE--</option>
                          <option value="STUDENT">STUDENT</option>
                          <option value="ADMIN">ADMIN</option>
                          <option value="TEACHER">TEACHER</option>
                        </select>
                    </div>
                    @error('role')
                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                    <script> window.addEventListener("load",clickNotif);</script>
                    @enderror
                    <div class="mb-3 row" id="classRow" style="display: none">
                      <div class="col">
                        <span>Class :</span>
                      <select name="class" id="class" class="form-control form-control-lg" onchange="getIndex()">
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
                      <div class="col">
                        <span>Index Class :</span>
                      <select name="indexClass" id="indexClass" class="form-control form-control-lg">
                        <option disabled selected>--SELECT INDEX OF CLASS--</option>
                      </select>
                      </div>
                      @error('indexClass')
                      <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                      <script> window.addEventListener("load",clickNotif);</script>
                      @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @foreach ($class as $classitem)
        
    @endforeach
</div>

<!-- Modal -->
@endsection
@section('body-script')
    <script>
      function hideClass() {
          var x = document.getElementById("role").value;
          if (x != "STUDENT") {
              document.getElementById("classRow").style.display = 'none';
          } else {
              document.getElementById("classRow").style.display = 'block';
          }
      }

      function getIndex(){
        var x = document.getElementById("class").value;
        
        if(x == 'X'){
          $('.optionIndex').remove();
          $('#indexClass').append('@foreach ($class as $classitem)');
          $('#indexClass').append('@if ($classitem->class == 'X')');
          $('#indexClass').append(`<option class="optionIndex" value="{{$classitem->indexClass}}">{{$classitem->indexClass}}</option>`);
          $('#indexClass').append('@endif');
          $('#indexClass').append('@endforeach');
        } else if(x == 'XI'){
          $('.optionIndex').remove();
          $('#indexClass').append('@foreach ($class as $classitem)');
          $('#indexClass').append('@if ($classitem->class == 'XI')');
          $('#indexClass').append(`<option class="optionIndex" value="{{$classitem->indexClass}}">{{$classitem->indexClass}}</option>`);
          $('#indexClass').append('@endif');
          $('#indexClass').append('@endforeach');
        } else if(x == 'XII'){
          $('.optionIndex').remove();
          $('#indexClass').append('@foreach ($class as $classitem)');
          $('#indexClass').append('@if ($classitem->class == 'XII')');
          $('#indexClass').append(`<option class="optionIndex" value="{{$classitem->indexClass}}">{{$classitem->indexClass}}</option>`);
          $('#indexClass').append('@endif');
          $('#indexClass').append('@endforeach');
        }
        
      }
    </script>
@endsection