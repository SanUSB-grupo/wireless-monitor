@extends('layouts.skeleton')

@section('container')
    <div class="container container__content">
        @include('flash::message')

        @yield('content')
    </div>
@endsection
