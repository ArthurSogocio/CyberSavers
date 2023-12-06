@extends('layouts.app')

@section('content')


<?php

use App\Models\UserAccessLevels;

$user = Auth::user();
$access_lvl = $user->access_level;
$permission = false;
if ($access_lvl == 9) {
    $permission = true;
}
?>
<div class="row justify-content-center">
    <div class="col-md-8 container">
        <?php
        if ($permission) {
            ?>
            <div class="card">
                {{ Form::open(['url' => url('/user/add'), 'class' => 'form-horizontal group-border-dashed', 'id' => 'adduser' ]) }}
                {{ csrf_field() }}
                <div class="card-header">Create New User</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group row top-buffer">
                                {{ Form::label('name', 'Name', ['class' => 'col-sm-6 control-label stat-label']) }}
                                <div class="col-sm-6">
                                    {{ Form::text("name", null, array('class' => 'form-control', 'style' => 'text-align: center;', 'id' => 'name', 'required')) }}
                                </div>
                            </div>
                            <div class="form-group row top-buffer">
                                {{ Form::label('email', 'Email', ['class' => 'col-sm-6 control-label stat-label']) }}
                                <div class="col-sm-6">
                                    {{ Form::email("email", null, array('class' => 'form-control', 'style' => 'text-align: center;', 'id' => 'email', 'required')) }}
                                </div>
                            </div>
                            <?php
                            $available_access = UserAccessLevels::where('access_level', '<', 9)->pluck('access', 'access_level');
                            ?>
                            <div class="form-group row top-buffer">
                                {{ Form::label('access_level', 'Access', ['class' => 'col-sm-6 control-label stat-label']) }}
                                <div class="col-sm-6">
                                    {{ Form::select("access_level", $available_access, null, array('class' => 'form-control', 'style' => 'text-align: center;', 'id' => 'access_level', 'required')) }}
                                </div>
                            </div>
                            <div class="form-group row top-buffer">
                                {{ Form::label('level', 'Level (Set as 0 for New Players)', ['class' => 'col-sm-6 control-label stat-label']) }}
                                <div class="col-sm-6">
                                    {{ Form::number("level", 0, array('class' => 'form-control', 'style' => 'text-align: center;', 'id' => 'level', 'step' => '1', 'required')) }}
                                </div>
                            </div>
                            <div class="form-group row top-buffer">
                                {{ Form::label('active_player', 'Active Player', ['class' => 'col-sm-6 control-label stat-label']) }}
                                <div class="col-sm-6">
                                    {{ Form::checkbox('active_player') }} 
                                </div>
                            </div>
                            <div class="form-group row top-buffer">
                                {{ Form::label('password', 'Password', ['class' => 'col-sm-6 control-label stat-label']) }}
                                <div class="col-sm-6">
                                    {{ Form::text("password", null, array('class' => 'form-control pw','autocomplete'=>'off', 'required')) }}
                                </div>
                            </div>
                            <div class='form-group row top-buffer'>
                                <button type="submit" form="adduser" class="btn btn-block btn-success col-lg-12">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <?php
        } else {
            ?>
            <div class="card">
                <div class="card-header-error">User Details for {{ $selected_user->name }}</div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
@endsection