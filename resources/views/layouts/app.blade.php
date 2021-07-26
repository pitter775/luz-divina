<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('paper') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('paper') }}/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <meta name="theme-color" content="#ebf1f5"> -->

    <!-- <link rel=mask-icon href="/safari-pinned-tab.svg" color="#ebf1f5"/>
    <meta name=msapplication-TileColor content="#ebf1f5"> -->
    <!-- <meta name=theme-color content="#ebf1f5"> -->
    <meta name="theme-color" content="#0054a7">

    <!-- <meta name="apple-mobile-web-app-status-bar-style" content="#ebf1f5">
    <meta name="msapplication-navbutton-color" content="#ebf1f5"> -->

    <!-- Extra details for Live View on GitHub Pages -->
    
    <title> {{ __('Controle de Contratos') }} </title>

        <!-- CSS Selects -->
        <link href="{{ asset('paper') }}/css/stylesheet.css?v=2.0.0" rel="stylesheet" />
    <link href="{{ asset('paper') }}/css/normalize.css?v=2.0.0" rel="stylesheet" />
    <link href="{{ asset('paper') }}/css/selectize.default.css?v=2.0.0" rel="stylesheet" />

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="{{ asset('paper') }}/css/bootstrap.min.css?1422981258" rel="stylesheet" />
    <link href="{{ asset('paper') }}/css/paper-dashboard.css?v=2.0.0" rel="stylesheet" />
    <link href="{{ asset('paper') }}/css/animate.min.css" rel="stylesheet" /> 
    <link href="{{ asset('paper') }}/css/bootstrap-select.css" rel="stylesheet" /> 
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('paper') }}/demo/demo.css?1422981258" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.css"> -->




    

</head>
<style>
    .modal { overflow: auto !important; }
    #blanket,#aguarde {position: fixed;display: none;}
    #blanket {left: 0;top: 0;background-color: #f0f0f0;filter: alpha(opacity = 65);height: 100%; width: 100%;-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=65)";opacity: 0.65; z-index: 9998;}
    #aguarde {width: 80px; height: 80px; top: 50%; left: 50%;  background: url('https://usevou.com/images/loading.gif') no-repeat 0 50%;  background-size: cover; z-index: 9999;}
    div.dropdown-menu{ margin-left: 20px; z-index: 9999999; max-height: 600px !important; }
    .bootstrap-select > .dropdown-toggle { width: 98% !important;}
    ul.dropdown-menu{ margin-left: 10px; z-index: 9999999; max-height: 400px !important; }

    .bootstrap-select > select.mobile-device:focus + .dropdown-toggle, .bootstrap-select .dropdown-toggle:focus {
    outline: thin dotted #333333 !important; 
    outline: 0px auto -webkit-focus-ring-color !important;
    outline-offset: 0 !important;}
</style>

<body class="{{ $class }}">
        
    
    @auth()
        <div id="blanket"></div>
        <div id="aguarde"></div>
        @include('layouts.page_templates.auth')
        @include('layouts.navbars.fixed-plugin')
    @endauth
    
    @guest

        @include('layouts.page_templates.guest')
    @endguest

    <!--   Core JS Files   -->
    <script src="{{ asset('paper') }}/js/core/jquery.min.js"></script>
    <script src="{{ asset('paper') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('paper') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('paper') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <!-- Chart JS -->
    <script src="{{ asset('paper') }}/js/plugins/chartjs.min.js"></script>
    
    <script src="{{ asset('paper') }}/js/plugins/nouislider.min.js"></script>
    <script src="{{ asset('paper') }}/js/plugins/bootstrap-notify.js"></script>
    <script src="{{ asset('paper') }}/js/paper-dashboard.min.js?v=2.0.0" type="text/javascript"></script>
    <script src="{{ asset('paper') }}/js/jquery.mask.js"></script>
    <script src="{{ asset('paper') }}/js/plugins/jquery.dataTables.min.js"></script>
    <script src="{{ asset('paper') }}/demo/demo.js"></script>
    <script src="{{ asset('paper') }}/demo/jquery.sharrre.js"></script>
    <script src="{{ asset('paper') }}/demo/moment.min.js"></script>
    <script src="{{ asset('paper') }}/demo/bootstrap-datetimepicker.js"></script>
    <script src="{{ asset('paper') }}/demo/locale.js"></script>
    <!-- <script src="https://cdn.ckeditor.com/4.15.1/standard-all/ckeditor.js"></script> -->
    <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
    <!-- https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js -->    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>


      <!-- Select JS -->
      <script src="{{ asset('paper') }}/js/index.js"></script>
      <script src="{{ asset('paper') }}/js/selectize.js"></script>

    
    @stack('scripts')



    @include('layouts.navbars.fixed-plugin-js')
</body>

</html>
