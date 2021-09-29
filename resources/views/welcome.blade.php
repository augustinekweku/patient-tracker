<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Patient Tracker</title>
    <script>
        (function () {
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            }
        })();
    </script>
</head>
<body>
    <div id="app">
        @if (Auth::check())
        <mainapp :user="{{Auth::user()}}"></mainapp>     
        @else
        <mainapp :user=false></mainapp>    
        @endif    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>