<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('')}}soft-ui/assets/img/belajarku-icon.png">
  <link rel="icon" type="image/png" href="{{asset('')}}soft-ui/assets/img/belajarku-icon.png">
  <title>
    Assignment Review 
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{asset('')}}soft-ui/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="{{asset('')}}soft-ui/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{asset('')}}soft-ui/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{asset('')}}soft-ui/assets/css/soft-ui-dashboard.css?v=1.0.5" rel="stylesheet" />
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/toastr/toastr.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{asset('')}}adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script type="text/javascript">
    function clickNotif(){
      document.getElementById('notifSwal').click();
    }
  </script>
  @yield('head-script')
  <style>
    .sidenav {
      z-index: 1040; !important
    }
  </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
    @if(session('success'))
		<div class="alert alert-success" id="notif" swalType="success" swalTitle="{{session('success')}}" style="display: none">{{session('success')}}</div>
		<script>window.addEventListener("load",clickNotif);</script>	
	@endif
	@if(session('notif'))
		<div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{session('notif')}}" style="display: none">{{session('notif')}}</div>
		<script>window.addEventListener("load",clickNotif);</script>	
	@endif
  <button type="button" id="notifSwal" class="btn btn-success notifSwal" style="display: none"></button>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <div class="container-fluid py-4">
        <div class="row d-flex justify-content-center">
          <div class="col-md-7 mt-4">
            <div class="card">
              <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{$aLog->title}} - {{$aLog->name}}</h6>
              </div>
              <div class="card-body pt-4 p-3">
                <ul class="list-group">
                    @if ($aLog->type == 'QUIZ')
                    <?php $noAns = 1;?>
                        @foreach (unserialize($aLog->question) as $item)
                            <?php $ans = unserialize($aLog->answer);?>
                                <?php $correct = $ans[$noAns]['answer']?>
                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                <div class="d-flex flex-column">
                                <h6 class="mb-3 text-sm">{{$item['question']}}</h6>
                                <span class="mb-2 {{($correct === 'A') ? (($item['answer'] === $correct) ? 'text-success':'text-danger'):'text-dark'}} text-xs">A : <span class="{{($correct === 'A') ? (($item['answer'] === $correct) ? 'text-success':'text-danger'):'text-dark'}} font-weight-bold ms-sm-2">{{$item['optionA']}} {{($item['answer'] === 'A') ? '(Correct Answer)':''}}</span></span>
                                <span class="mb-2 {{($correct === 'B') ? (($item['answer'] === $correct) ? 'text-success':'text-danger'):'text-dark'}} text-xs">B : <span class="{{($correct === 'B') ? (($item['answer'] === $correct) ? 'text-success':'text-danger'):'text-dark'}} font-weight-bold ms-sm-2">{{$item['optionB']}} {{($item['answer'] === 'B') ? '(Correct Answer)':''}}</span></span>
                                <span class="mb-2 {{($correct === 'C') ? (($item['answer'] === $correct) ? 'text-success':'text-danger'):'text-dark'}} text-xs">C : <span class="{{($correct === 'C') ? (($item['answer'] === $correct) ? 'text-success':'text-danger'):'text-dark'}} font-weight-bold ms-sm-2">{{$item['optionC']}} {{($item['answer'] === 'C') ? '(Correct Answer)':''}}</span></span>
                                <span class="mb-2 {{($correct === 'D') ? (($item['answer'] === $correct) ? 'text-success':'text-danger'):'text-dark'}} text-xs">D : <span class="{{($correct === 'D') ? (($item['answer'] === $correct) ? 'text-success':'text-danger'):'text-dark'}} font-weight-bold ms-sm-2">{{$item['optionD']}} {{($item['answer'] === 'D') ? '(Correct Answer)':''}}</span></span>
                                </div>
                            </li>
                            <?php $noAns++?>
                        @endforeach
                    @elseif($aLog->type == 'ESSAY')
                    <?php $noAns = 1;?>
                        @foreach (unserialize($aLog->question) as $item)
                            <?php $ans = unserialize($aLog->answer);?>
                                <?php $correct = $ans[$noAns]['answer']?>
                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                <div class="d-flex flex-column">
                                <h6 class="mb-3 text-sm">{{$item['question']}}</h6>
                                <p>Answer : </p>
                                <p class="text-dark font-weight-bold ms-sm-2" style="word-wrap: break-word; width: 50vw">{{$correct}}</p>
                                </div>
                            </li>
                            <?php $noAns++?>
                        @endforeach
                    @endif
                </ul>
              </div>
            </div>
          </div>
        </div>
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="{{asset('')}}soft-ui/assets/js/core/popper.min.js"></script>
  <script src="{{asset('')}}soft-ui/assets/js/core/bootstrap.min.js"></script>
  <script src="{{asset('')}}soft-ui/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{asset('')}}soft-ui/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="{{asset('')}}soft-ui/assets/js/plugins/chartjs.min.js"></script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{asset('')}}soft-ui/assets/js/soft-ui-dashboard.min.js?v=1.0.5"></script>
  <!-- SweetAlert2 -->
  <script src="{{asset('')}}adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
  <!-- Bootstrap 4 -->
<script src="{{asset('')}}adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Toastr -->
  <script src="{{asset('')}}adminlte/plugins/toastr/toastr.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="{{asset('')}}adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="{{asset('')}}adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="{{asset('')}}adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="{{asset('')}}adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="{{asset('')}}adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="{{asset('')}}adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="{{asset('')}}adminlte/plugins/jszip/jszip.min.js"></script>
  <script src="{{asset('')}}adminlte/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="{{asset('')}}adminlte/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="{{asset('')}}adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="{{asset('')}}adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="{{asset('')}}adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script>
      $('.notifSwal').click(function() {
          Swal.fire({
              icon: $('#notif').attr('swalType'),
              title: $('#notif').attr('swalTitle'),
              showConfirmButton: true,
              timer: 5000
          })
      });
  </script>
  @yield('body-script')
</body>

</html>