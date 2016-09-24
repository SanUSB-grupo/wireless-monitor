@extends('layouts.app')

@push('scripts')
    <script src="{{ url('js/monitors/components/blinkleds-index.js') }}"></script>
@endpush

@section('content')

<div class="row">
    <div class="col-md-12">
        <h3>{{ $title }}</h3><hr>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        {!! BootForm::open([
            'model' => $model,
            'store' => '\Fidias\Blinkleds\Http\Controllers\BlinkledsController@store',
            'update' => '\Fidias\Blinkleds\Http\Controllers\BlinkledsController@update',
        ]) !!}
        {!! BootForm::hidden('id') !!}
        <div class="row">
            <div class="col-md-12">
                {!! BootForm::text('description') !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group pull-right">
                    <button type="button" id="new-led"
                        class="btn btn-default">
                        More LEDs
                    </button>
                    <button type="button" class="btn btn-danger delete-last-one">
                        <i class="fa fa-remove"></i>
                        Delete Last One
                    </button>
                </div>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-12" id="led-list">
                @php
                    $leds = null;
                    // priority to old leds, that represents
                    // already edited information!
                    if (Form::old('leds')) {
                        $leds = Form::old('leds');
                    } else if (! is_null($model)) {
                        $leds = $model->leds;
                    }
                @endphp

                @if($leds)
                    @foreach($leds as $key => $val)
                        <div class="row led--item" id="led-item-{{$key}}">
                            <div class="col-md-3">
                                {!! BootForm::text("leds[${key}][id]", "LED ${key}") !!}
                            </div>
                            <div class="col-md-3">
                                {!! BootForm::select("leds[${key}][color]", "Color ${key}", $colors) !!}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <hr>

        {!! BootForm::submit('Save') !!}
        {!! BootForm::close() !!}
    </div>
</div>

<script type="text/x-tmpl-mustache" id="template-led">
    <div class="row led--item" id="led-item-#{id}">
        <div class="col-md-3">
            {!! BootForm::text("leds[#{id}][id]", "LED #{id}") !!}
        </div>
        <div class="col-md-3">
            {!! BootForm::select("leds[#{id}][color]", "Color #{id}", $colors) !!}
        </div>
    </div>
</script>

@endsection
