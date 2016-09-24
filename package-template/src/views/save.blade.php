@extends('layouts.app')

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
            'store' => '\@@Vendor\@@Plugin\Http\Controllers\@@PluginController@store',
            'update' => '\@@Vendor\@@Plugin\Http\Controllers\@@PluginController@update',
        ]) !!}
        {!! BootForm::hidden('id') !!}
        <div class="row">
            <div class="col-md-12">
                {!! BootForm::text('description') !!}
            </div>
        </div>

        {!! BootForm::submit('Save') !!}
        {!! BootForm::close() !!}
    </div>
</div>

@endsection
