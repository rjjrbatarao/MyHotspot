@extends('myhotspot.layout')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-end social_icon">
                        <span><i class="fab fa-facebook-square"></i></span>
                        <span><i class="fab fa-youtube-square"></i></span>
                        <span><i class="fab fa-twitter-square"></i></span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('myhotspot/img/wireless-2-128.png') }}" alt="banner" class="img-fluid">
                    </div>
                    <div class="text-center">
                        <h3><a href="/login">Logged Out</a></h3>
                    </div>
                    <div class="text-center text-light">
                        @isset($ip)
                            IP: {{ $ip }}
                        @endisset
                    </div>
                    <div class="text-center text-light">
                        @isset($mac)
                            MAC: {{ $mac }}
                        @endisset
                    </div>
                    <div class="text-center text-light">
                        @isset($sessionid)
                            SESSION: {{ $sessionid }}
                        @endisset
                    </div>
                    <form action="http://{{ $uamip }}:{{ $uamport }}" method="get" class="mt-3">
                        <input type="submit" value="Login" class="btn float-right login_btn">
                    </form>
                </div>
                @include('myhotspot.partials.footer')
            </div>
        </div>
    </div>
@endsection
