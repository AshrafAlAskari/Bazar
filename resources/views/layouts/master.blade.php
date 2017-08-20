<!DOCTYPE html>
<html lang=en>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:500,600" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ URL::to('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::to('css/main.css') }}" />
</head>
<body>
    @include('includes.header')
    <div class="container" id="app">
        @yield('content')
    </div>
</div>

<script>
var token = '{{ Session::token() }}';
</script>

<script src="{{ URL::to('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ URL::to('js/popper.min.js') }}"></script>
<script src="{{ URL::to('js/bootstrap.min.js') }}"></script>
<script src="{{ URL::to('js/vue@2.4.2.js') }}"></script>
<script src="{{ URL::to('js/main.js') }}"></script>
@yield('js')
</body>
</html>
