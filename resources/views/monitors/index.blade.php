
@extends('layouts.app')

@push('scripts')
    <script src="{{ elixir('js/monitors/index.js') }}"></script>
@endpush

@section('content')

<div class="row">
    <div class="col-md-12">
        @foreach($packages as $value)
        <a href="<?php echo url("$value->path/create"); ?>" class="btn btn-primary btn-lg">
            <i class="fa fa-{{ $value->icon }}"></i>
            New {{ $value->description }} Monitor
        </a>
        @endforeach
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h4>Monitors</h4><hr>
        <div id="root-app">
            {{-- data comes from ajax --}}
            <p class="text-center">
                Loading ...
            </p>
        </div>
    </div>
</div>

@endsection
