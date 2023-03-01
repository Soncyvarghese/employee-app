<!doctype html>
    <html lang="en">
        <head>
            <link href="{!! url('assets/jquery.dataTables.min.css') !!}" rel="stylesheet">
            <link href="{!! url('assets/bootstrap.min.css') !!}" rel="stylesheet">
            <script src="{!! url('assets/jquery.js') !!}"></script> 
            <script src="{!! url('assets/jquery.dataTables.min.js') !!}"></script>
            <script src="{!! url('assets/bootstrap.min.js') !!}"></script>
        </head>
        <body class="text-center">
            <main>
                @yield('content')
            </main>
        </body>
</html>