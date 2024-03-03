<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Validations</title>
    <!--JQUERY-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--DATATABLE CSS-->
    @include('dataTable.css')
</head>
<body>
    @yield('content')
</body>

    {{ $dataTable->scripts() }}
    
    <!--DATATABLE JS-->
@include('dataTable.js')
</html>