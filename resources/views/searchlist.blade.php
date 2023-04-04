<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="divport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>热门课包</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{asset('css/global.css')}}" rel="stylesheet">
        <link href="{{asset('css/page/searchlist.css')}}" rel="stylesheet">

        <!-- Styles -->
        <script src="{{asset('js/jquery.js')}}"></script>
        <script src="{{asset('js/page/searchlist.js')}}"></script>
        <style>

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

        </div>
    </body>
    <script type="text/javascript">
        var data = "{{$data}}";
        console.log("data=" + data)
        </script>
</html>
