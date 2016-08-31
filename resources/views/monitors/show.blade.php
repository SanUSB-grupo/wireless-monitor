
@extends('layouts.app')

@push('scripts')
    <script src="{{ elixir('js/monitors/show.js') }}"></script>
@endpush

@section('content')

<style>
    .img-responsive {
        margin: 0 auto;
        margin-bottom: 16px;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#setup" aria-controls="setup" role="tab" data-toggle="tab">Setup</a>
            </li>
            <li role="presentation">
                <a href="#view" aria-controls="view" role="tab" data-toggle="tab">View Data</a>
            </li>
            <li role="presentation">
                <a href="#graph" aria-controls="view" role="tab" data-toggle="tab">View Graph</a>
            </li>
        </ul>
    </div>
</div>

<p>
    <input type="hidden" id="id" value="{{ $monitor->id }}" />
</p>

<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="setup">
        @include('monitors.show.setup', ['auth_json' => $auth_json, 'send_json' => $send_json])
    </div>
    <div role="tabpanel" class="tab-pane" id="view">
        @include('monitors.show.view')
    </div>
</div>

@include('monitors.show.components.temperature')

@endsection
