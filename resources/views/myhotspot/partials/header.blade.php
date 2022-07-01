<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>
    @isset($mytitle)
        {{ $mytitle }}
    @endisset
</title>
<link rel="stylesheet" href="{{ asset('myhotspot/css/bootstrap4.1.1.min.css') }}">
<link rel="stylesheet" href="{{ asset('myhotspot/css/bootstrap4-toggle.min.css') }}">
<link rel="stylesheet" href="{{ asset('myhotspot/css/noty.css') }}">
<link rel="stylesheet" href="{{ asset('myhotspot/css/noty.bootstrap4.css') }}">
<script src="{{ asset('myhotspot/js/jquery3.6.0.min.js') }}"></script>
<script src="{{ asset('myhotspot/js/bootstrap4.1.1.min.js') }}"></script>
<script src="{{ asset('myhotspot/js/noty.min.js') }}"></script>
<script src="{{ asset('myhotspot/js/bootstrap4-toggle.min.js') }}"></script>
<script src="{{ asset('myhotspot/js/myhotspot.js') }}"></script>
<link rel="stylesheet" href="{{ asset('myhotspot/css/all.css') }}">
<link rel="stylesheet" href="{{ asset('myhotspot/uploads/myhotspot.css') }}">
<style>
    @font-face {
        font-family: 'Numans';
        font-style: normal;
        font-weight: 400;
        src: url({{ asset('myhotspot/font/SlGRmQmGupYAfH84ZhIh.woff2') }});
    }

    html,
    body {
        @if ($mybackgroundenable ?? false)background-image: url('{{ asset('storage/') . $mybackgroundimage }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100%;
        font-family: 'Numans', sans-serif;
    @else background-color: {{ $mybackgroundcolor ?? '#26c6da' }};
        font-family: 'Numans', sans-serif;
        @endif
    }

</style>
