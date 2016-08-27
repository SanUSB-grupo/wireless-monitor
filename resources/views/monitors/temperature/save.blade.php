@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        {!! BootForm::open(['model' => $model, 'store' => 'Monitors\TemperatureController@store']) !!}
        <div class="row">
            <div class="col-md-12">
                {!! BootForm::text('description') !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                {!! BootForm::text('min') !!}
            </div>
            <div class="col-md-3">
                {!! BootForm::text('max') !!}
            </div>
            <div class="col-md-3">
                {!! BootForm::select('unit', 'Unit', $units) !!}
            </div>
        </div>


            {!! BootForm::submit('Save') !!}
        {!! BootForm::close() !!}
    </div>
</div>

@endsection
