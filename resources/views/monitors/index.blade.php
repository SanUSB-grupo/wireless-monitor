
@extends('layouts.app')

@push('scripts')
    <script src="{{ elixir('js/monitors/index.js') }}"></script>
@endpush

@section('content')

<style>
    #root-app {
        display: flex;
        justify-content: flex-start;
        align-content: space-around;
        flex-wrap: wrap;
    }

    @media (max-width: 992px) {
        .btn-monitor {
            margin-bottom: 10px;
        }
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            @foreach($packages as $value)
            <div class="col-xs-12 col-sm-6 col-md-4">
                <a href="<?php echo url("{$value->path}/create"); ?>"
                    class="btn btn-primary btn-lg btn-block btn-monitor">
                    <i class="wm-icon wm-icon-{{ $value->icon }}"></i>
                    New {{ $value->description }} Monitor
                </a>
            </div>
            @endforeach
        </div>
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
