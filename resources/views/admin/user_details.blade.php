@extends('layouts.app')

@section('content')


<?php

use App\Models\User;

$user = Auth::user();
$access_lvl = $user->access_level;

$selected_user = User::find($uid);
$selected_access = $selected_user->access_level()->first();
$selected_details = $selected_user->details()->first();
$selected_aspect = $selected_details->aspect()->first();

//if the user doesn't have access to this person's page, they should receive an error
$permission = false;
if ($user->id == $selected_user->id || $user->access_level >= 9) {
    $permission = true;
}
?>
<div class="justify-content-center" style="width: 99%;">
    <!-- user management -->
    <div class='row top-buffer'>
        <div class='col-lg-12'>
            <div class="card">
                <div class="card-header">User Details for {{ $selected_user->name }}</div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php
        if ($permission) {
            ?>
            <div class="col-md-6">
                <div class='row top-buffer'>
                    <div class='col-lg-12'>
                        <div class="card">
                            <div class="card-header">Credentials</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            {{ Form::label('email', 'Email', ['class' => 'col-sm-4 control-label stat-label']) }}
                                            <div class="col-sm-8">
                                                {{ Form::text("email", $selected_user->email, array('class' => 'form-control', 'id' => 'email', 'disabled' => 'disabled')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row top-buffer">
                                            {{ Form::label('access_level', 'Access', ['class' => 'col-sm-4 control-label stat-label']) }}
                                            <div class="col-sm-8">
                                                {{ Form::text("access_level", $selected_access->access, array('class' => 'form-control', 'id' => 'access_level', 'disabled' => 'disabled')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row top-buffer">
                                            {{ Form::label('level', 'Level / XP', ['class' => 'col-sm-4 control-label stat-label']) }}
                                            <div class="col-sm-8">
                                                <div class="row">
                                                    <div class="col-lg-6">{{ Form::text("level", $selected_details->level, array('class' => 'form-control', 'id' => 'level', 'disabled' => 'disabled')) }}</div>
                                                    <div class="col-lg-6">{{ Form::text("xp", "0/100", array('class' => 'form-control', 'id' => 'xp', 'disabled' => 'disabled')) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row top-buffer">
                                            {{ Form::label('aspect', 'Aspect', ['class' => 'col-sm-4 control-label stat-label']) }}
                                            <div class="col-sm-8">
                                                {{ Form::text("aspect", $selected_aspect->aspect, array('class' => 'form-control', 'id' => 'aspect', 'disabled' => 'disabled')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row top-buffer">
                                            {{ Form::label(null, 'Class(es) / Ranks', ['class' => 'col-sm-4 control-label stat-label']) }}
                                            <div class="col-sm-8">
                                                <?php
                                                //loop through classes
                                                $selected_classes = $selected_user->user_classes()->get();
                                                $classes_first = true;

                                                foreach ($selected_classes as $class_num => $class) {
                                                    //get class details
                                                    $class_rank = $class->rank;
                                                    $class_details = $class->class()->first();
                                                    $class_name = $class_details->class;
                                                    //add buffer spacing to every row but the first
                                                    $class_row_spacing = "";
                                                    if ($classes_first == true) {
                                                        $classes_first = false;
                                                    } else {
                                                        $class_row_spacing = " top-buffer";
                                                    }
                                                    ?>
                                                    <div class="row {{ $class_row_spacing }}">
                                                        <div class="col-sm-8">{{ Form::text("class[]", $class_name, array('class' => 'form-control', 'disabled' => 'disabled')) }}</div>
                                                        <div class="col-sm-4">{{ Form::text("class_rank[]", $class_rank, array('class' => 'form-control', 'disabled' => 'disabled')) }}</div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <img src="{{ asset('assets/img/user_img/default.jpg') }}" class="col-lg-6" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class='row top-buffer'>
                    <div class='col-lg-12'>
                        <div class="card">
                            <div class="card-header">Stats</div>
                            <div class="card-body">
                                <div class="form-group row" style="text-align: center;">
                                    <div class="col-sm-3">
                                        {{ Form::label('base_muscle', 'Muscle', ['class' => 'control-label stat-label']) }}
                                        <div>
                                            {{ Form::text("base_muscle", $selected_details->muscle, array('class' => 'form-control muscle', 'disabled' => 'disabled')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        {{ Form::label('base_head', 'Head', ['class' => 'control-label stat-label']) }}
                                        <div>
                                            {{ Form::text("base_head", $selected_details->head, array('class' => 'form-control head', 'disabled' => 'disabled')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        {{ Form::label('base_heart', 'Heart', ['class' => 'control-label stat-label']) }}
                                        <div>
                                            {{ Form::text("base_heart", $selected_details->heart, array('class' => 'form-control heart', 'disabled' => 'disabled')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        {{ Form::label('base_soul', 'Soul', ['class' => 'control-label stat-label']) }}
                                        <div>
                                            {{ Form::text("base_soul", $selected_details->soul, array('class' => 'form-control soul', 'disabled' => 'disabled')) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row top-buffer" style="text-align: center;">
                                    <?php
                                    //create array with base stats
                                    $mainstats = [
                                        'hp' => 10,
                                        'initiative' => 0,
                                        'dice total' => 2,
                                        'skill total' => 2,
                                        'dodge bonus' => 0,
                                        'guard bonus' => 0,
                                        'wp accuracy' => "",
                                        'wp damage' => 0
                                    ];
                                    $bonusstats = [
                                        'power' => 3,
                                        'speed' => 2,
                                        'sense' => 1,
                                        'analytics' => -1,
                                        'fortitude' => 2,
                                        'connection' => 3,
                                        'identity' => 4,
                                        'spirituality' => 0
                                    ];

                                    //add values to each stat here
                                    //stat hp bonus
                                    $mainstats['hp'] += max($bonusstats['power'], $bonusstats['fortitude']);
                                    $mainstats['initiative'] += max($bonusstats['speed'], $bonusstats['identity']);
                                    $mainstats['dodge bonus'] += max($bonusstats['speed'], $bonusstats['sense']);
                                    $mainstats['guard bonus'] += max($bonusstats['fortitude'], $bonusstats['connection']);
                                    $mainstats['dice total'] += max($bonusstats['analytics'], $bonusstats['spirituality']);
                                    ?>
                                    <div class="col-sm-6">
                                        <?php
                                        $main_first = true;
                                        foreach ($mainstats as $statname => $statval) {
                                            //add buffer spacing to every row but the first
                                            $main_row_spacing = "";
                                            if ($main_first == true) {
                                                $main_first = false;
                                            } else {
                                                $main_row_spacing = " top-buffer";
                                            }
                                            ?>
                                            <div class="form-group row {{ $main_row_spacing }}">
                                                {{ Form::label($statname, $statname, ['class' => 'col-sm-8 control-label stat-label']) }}
                                                <div class="col-sm-4">
                                                    {{ Form::text($statname, $statval, array('class' => 'form-control', 'style' => 'text-align: center;', 'disabled' => 'disabled')) }}
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <?php
                                        $bonus_first = true;
                                        foreach ($bonusstats as $statname => $statval) {
                                            //add buffer spacing to every row but the first
                                            $bonus_row_spacing = "";
                                            if ($bonus_first == true) {
                                                $bonus_first = false;
                                            } else {
                                                $bonus_row_spacing = " top-buffer";
                                            }
                                            ?>
                                            <div class="form-group row {{ $bonus_row_spacing }}">
                                                {{ Form::label($statname, $statname, ['class' => 'col-sm-8 control-label stat-label']) }}
                                                <div class="col-sm-4">
                                                    {{ Form::text($statname, $statval, array('class' => 'form-control ' . $statname, 'disabled' => 'disabled')) }}
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class='row top-buffer'>
                <div class='col-lg-12'>
                    <div class="card">
                        <div class="card-header-error">User Details for {{ $selected_user->name }}</div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
@endsection