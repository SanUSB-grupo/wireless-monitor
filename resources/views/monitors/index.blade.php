
@extends('layouts.app')

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
        <?php if (isset($result)) var_dump($result); ?>
    </div>
</div>

@endsection
