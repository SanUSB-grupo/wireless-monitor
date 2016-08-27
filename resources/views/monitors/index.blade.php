
@extends('layouts.app')

@push('scripts')
    <script src="{{ elixir('js/monitors/index.js') }}"></script>
@endpush

@section('content')

<div class="row">
    <div class="col-md-12">
        <a href="<?php echo url('temperature/create'); ?>" class="btn btn-default btn-lg">
            <i class="fa fa-dashboard"></i>
            New Temperature Monitor
        </a>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h4>Monitors</h4><hr>
        <div id="root-app"></div>
    </div>
</div>

@include('monitors.index.components.temperature')

@endsection
