@extends('myhotspot.layout')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-body mt-5">

                    <div class="text-center">
                        <h3><a href="/admin">No hotspot</a></h3>
                        <h6>Please create hotspot for this system.</h6>
                    </div>
                </div>
                @include('myhotspot.partials.footer')
            </div>
        </div>
    </div>
@endsection
