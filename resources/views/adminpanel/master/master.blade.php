<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-signin-client_id"
        content="818453823928-5pgqc1bv0h8f4vhbmpv2gbt7pptmbttv.apps.googleusercontent.com">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/x-icon">

    
    <link rel="stylesheet"
        href="{{ asset('adminpanel/css/adminlte.min.css') }}?{{ filemtime(public_path('adminpanel/css/adminlte.min.css')) }}">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('adminpanel/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('adminpanel/css/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('adminpanel/css/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet"
        href="{{ asset('adminpanel/css/fontawesome-free/all.min.css') }}" >
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('adminpanel/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    {{--<link rel="stylesheet" href="{{ url('assets/admin') }}/plugins/daterangepicker/daterangepicker.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('adminpanel/css/summernote-bs4.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminpanel/css/dataTables.bootstrap4.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    {{--datepicker--}}

    <link href="https://festivalstudio365.freefestivalpost.com/test" rel="stylesheet">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" class="nav-link dropdown-toggle">
                        Rahul Chocha
                    </a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="http://bjppost.rahulchocha.com/admin/profile" class="dropdown-item">Profile</a>
                        </li>

                        <!-- Level two dropdown-->

                        <!-- End Level two -->
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="{{route('logout')}}">
                        Logout &nbsp; <i class="fa fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        @include('adminpanel.master.sidebar')

        {{-- <div class="content-wrapper"> --}}
            @yield('content')
        {{-- </div> --}}

        <!-- NEWS -->

    </div>
    
    <script src="{{ asset('adminpanel/js/jquery.min.js') }}"></script>
    <script src="{{ asset('adminpanel/js/adminlte.js') }}"></script>

    <script src="{{ asset('adminpanel/js/bootstrap.min.js') }}"></script>
    <script src="{{asset('adminpanel/js/slick.min.js') }}"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- jQuery -->
    <script src="{{asset('adminpanel/js/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('adminpanel/js/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    {{--http://www.bootstraptoggle.com/--}}
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <!-- Bootstrap 4 -->
    <script src="{{asset('adminpanel/js/bootstrap.bundle.min.js')}}"></script>
    {{--<!-- ChartJS -->--}}
    {{--<script src="{{ url('assets/admin') }}/plugins/chart.js/Chart.min.js"></script>--}}
    {{--<!-- Sparkline -->--}}
    {{--<script src="{{ url('assets/admin') }}/plugins/sparklines/sparkline.js"></script>--}}
    {{--<!-- JQVMap -->--}}
    {{--<script src="{{ url('assets/admin') }}/plugins/jqvmap/jquery.vmap.min.js"></script>--}}
    {{--<script src="{{ url('assets/admin') }}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>--}}
    {{--<!-- jQuery Knob Chart -->--}}
    {{--<script src="{{ url('assets/admin') }}/plugins/jquery-knob/jquery.knob.min.js"></script>--}}

    <!-- daterangepicker -->
    <script src="{{ asset('adminpanel/js/moment.min.js')}}"></script>
    {{--<script src="{{ url('assets/admin') }}/plugins/daterangepicker/daterangepicker.js"></script>--}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


    <!-- Tempusdominus Bootstrap 4 -->
    {{--<script src="{{ url('assets/admin') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>--}}
    {{--<!-- Summernote -->--}}
    {{--<script src="{{ url('assets/admin') }}/plugins/summernote/summernote-bs4.min.js"></script>--}}
    {{--<!-- overlayScrollbars -->--}}
    {{--<script src="{{ url('assets/admin') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>--}}

    <!-- DataTables -->
    <script src="{{ asset('adminpanel/js/jquery.dataTables.js')}}"></script>
    <script src="{{ asset('adminpanel/js/dataTables.bootstrap4.js')}}"></script>

    <!-- WaitMe -->
    <link rel="stylesheet" href="{{ asset('adminpanel/css/waitMe.min.css')}}">
    <script src="{{ asset('adminpanel/js/waitMe.min.js')}}"></script>

    <!-- bs-custom-file-input -->
    <script src="{{ asset('adminpanel/js/bs-custom-file-input.min.js')}}"></script>

    <!-- AdminLTE App -->
    <script src="{{asset('adminpanel/js/adminlte.js')}}"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('adminpanel/js/demo.js')}}"></script>

    {{--//datepicker--}}

    <script type="text/javascript">
        $(document).ready(function () {
            bsCustomFileInput.init();
            $(".datepicker").attr("autocomplete", "off");
            $( ".datepicker" ).datepicker({
                format: "yyyy-mm-dd",
                //startDate: new Date()

            });
        });
    </script>
    @yield('script')



    @if (Session::has('success'))
        <script>
            $(document).ready(function() {
                toastr["success"]("{{ Session::get('success') }}")
            })
        </script>
        @php
            Session::forget('success');
        @endphp
    @endif
    @if ($errors->any())
        <script>
            $(document).ready(function() {
                // console.log(@json($errors));
                toastr["error"]("{{ __('admin.Fill in all the required fields') }}")
            })
        </script>
    @endif
    <script>
      
    </script>
</body>

</html>
