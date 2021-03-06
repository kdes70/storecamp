<head>
    <meta charset="UTF-8">
    <title> Online Store Platform- @yield('htmlheader_title', env("APP_NAME") ) </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="shortcut icon" href="{{asset('icon.gif')}}" type="image/gif">
    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset('plugins/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="{{ asset('custom_vendors/timepicker/bootstrap-timepicker.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">

    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('plugins/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/iCheck/skins/all.css')}}">
    <link href="{{ asset('/plugins/iCheck/skins/square/blue.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('plugins/plyr/dist/plyr.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/dropzone/dist/dropzone.css')}}">
    <link rel="stylesheet" href="{{asset('custom_vendors/jvectormap/jquery-jvectormap-1.2.2.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/summernote/dist/summernote.css')}}">


    <!-- Theme style -->
    <link href="{{ asset('/css/admin_lte.css') }}" rel="stylesheet" type="text/css" />

    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    {{--<link href="{{ asset('/css/skins/skin-black.css') }}" rel="stylesheet" type="text/css" />--}}
    {{--<link href="{{ asset('/css/skins/skin-blue.css') }}" rel="stylesheet" type="text/css" />--}}
    {{--<link href="{{ asset('/css/skins/skin-blue-light.css') }}" rel="stylesheet" type="text/css" />--}}
    {{--<link href="{{ asset('/css/skins/skin-green.css') }}" rel="stylesheet" type="text/css" />--}}
    {{--<link href="{{ asset('/css/skins/skin-blue.css') }}" rel="stylesheet" type="text/css" />--}}
    <link rel="stylesheet" href="{{ asset('/css/admin_skins.css') }}">
   <link rel="stylesheet" href="{{asset('/plugins/jquery-bar-rating/dist/themes/fontawesome-stars-o.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables.net-dt/css/jquery.dataTables.min.css')}}">
    <!-- iCheck -->
    <link href="{{ asset('/css/main/app.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app_less.css') }}" rel="stylesheet" type="text/css" />
    <!-- daterange picker -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>