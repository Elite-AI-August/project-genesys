<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> Zizpic | {{   isset($page_title)?$page_title:'dashboard' }}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- jQuery 2.1.4 -->
        <script src="{{ asset('assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <!-- Bootstrap 3.3.4 -->
        <link href="{{ url('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/css/style.scss') }}" rel="stylesheet" type="text/css" />

        <link href="{{ url('assets/css/jquery-ui.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/css/bootstrap-image-gallery.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/css/blueimp-gallery.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- FontAwesome 4.3.0 -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons 2.0.0 -->
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{ url('css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('css/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('assets/dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link href="{{ url('assets/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('css/chosen.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('css/custom.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ url('css/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" />

    </head>
    <!-- body start here -->
    <body class="skin-black sidebar-mini">
