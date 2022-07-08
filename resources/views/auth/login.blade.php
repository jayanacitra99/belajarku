<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('')}}soft-ui/assets/img/belajarku-icon.png">
  <link rel="icon" type="image/png" href="{{asset('')}}soft-ui/assets/img/belajarku-icon.png">
  <title>
    BelajarKu
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
  <script type="text/javascript">
    function clickNotif(){
      document.getElementById('notifSwal').click();
    }
  </script>
</head>

<body class="">
    @if(session('success'))
		<div class="alert alert-success" id="notif" swalType="success" swalTitle="{{session('success')}}" style="display: none">{{session('success')}}</div>
		<script>window.addEventListener("load",clickNotif);</script>	
	@endif
	@if(session('notif'))
		<div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{session('notif')}}" style="display: none">{{session('notif')}}</div>
		<script>window.addEventListener("load",clickNotif);</script>	
	@endif
  <button type="button" id="notifSwal" class="btn btn-success notifSwal" style="display: none"></button>
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
          <div class="container-fluid pe-0">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="{{url('/')}}">
              BelajarKu
            </a>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>
                  <p class="mb-0">Enter your email and password to sign in</p>
                </div>
                <div class="card-body">
                  <form action="{{url('login')}}" method="POST" role="form">
                    @csrf
                    <label>Email</label>
                    <div class="mb-3">
                      <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="email-addon" value="{{old('email')}}" autofocus>
                    </div>
                    @error('email')
                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                    <script> window.addEventListener("load",clickNotif);</script>	
                    @enderror
                    <label>Password</label>
                    <div class="mb-3">
                      <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                    </div>
                    @error('password')
                    <div class="alert alert-danger" id="notif" swalType="error" swalTitle="{{$message}}" style="display: none">{{session('notif')}}</div>
                    <script> window.addEventListener("load",clickNotif);</script>	
                    @enderror
                    <div class="text-center">
                      <button type="submit" name="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign in</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('{{asset('')}}soft-ui/assets/img/curved-images/curved6.jpg')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!--   Core JS Files   -->
  <script src="{{asset('')}}soft-ui/assets/js/core/popper.min.js"></script>
  <script src="{{asset('')}}soft-ui/assets/js/core/bootstrap.min.js"></script>
  <script src="{{asset('')}}soft-ui/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{{asset('')}}soft-ui/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
     <!-- jQuery -->
    <script src="{{asset('')}}adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="{{asset('')}}adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="{{asset('')}}adminlte/plugins/toastr/toastr.min.js"></script>
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
</body>

</html>