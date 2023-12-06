@extends('layouts.app')

@section('content')


<?php

use App\Models\User;
use App\Models\UserAccessLevels;

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
    <?php
    if ($permission) {
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class='row top-buffer'>
                    <div class='col-lg-12'>
                        <div class="card">
                            <div class="card-header">General Info</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <img src="{{ asset('assets/img/user_img/default.jpg') }}" class="top-buffer profile-img" />
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group row top-buffer">
                                            {{ Form::label('email', 'Email', ['class' => 'col-sm-4 control-label stat-label']) }}
                                            <div class="col-sm-8">
                                                {{ Form::text("email", $selected_user->email, array('class' => 'form-control', 'style' => 'text-align: center;', 'id' => 'email', 'disabled' => 'disabled')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row top-buffer">
                                            {{ Form::label('access_level', 'Access', ['class' => 'col-sm-4 control-label stat-label']) }}
                                            <div class="col-sm-8">
                                                {{ Form::text("access_level", $selected_access->access, array('class' => 'form-control', 'style' => 'text-align: center;', 'id' => 'access_level', 'disabled' => 'disabled')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row top-buffer">
                                            {{ Form::label('level', 'Level', ['class' => 'col-sm-4 control-label stat-label']) }}
                                            <div class="col-sm-8">
                                                {{ Form::text("level", $selected_details->level, array('class' => 'form-control', 'style' => 'text-align: center;', 'id' => 'level', 'disabled' => 'disabled')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row top-buffer">
                                            {{ Form::label('xp', 'Current XP', ['class' => 'col-sm-4 control-label stat-label']) }}
                                            <div class="col-sm-8">
                                                {{ Form::text("xp", "0/100", array('class' => 'form-control', 'style' => 'text-align: center;', 'id' => 'xp', 'disabled' => 'disabled')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row top-buffer">
                                            {{ Form::label('aspect', 'Aspect', ['class' => 'col-sm-4 control-label stat-label']) }}
                                            <div class="col-sm-8">
                                                {{ Form::text("aspect", $selected_aspect->aspect, array('class' => 'form-control', 'style' => 'text-align: center;', 'id' => 'aspect', 'disabled' => 'disabled')) }}
                                            </div>
                                        </div>
                                        <div class="form-group row top-buffer">
                                            {{ Form::label('aspect_rank', 'Aspect Rank', ['class' => 'col-sm-4 control-label stat-label']) }}
                                            <?php
                                            $aspect_rank = $selected_details->aspect_rank()->first();
                                            ?>
                                            <div class="col-sm-8">
                                                {{ Form::text("aspect_rank", $aspect_rank->id . "/5 - " . $aspect_rank->rank, array('class' => 'form-control', 'style' => 'text-align: center;', 'id' => 'xp', 'disabled' => 'disabled')) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <table style="width: 100%">
                                    <tr class="row top-buffer">
                                        <th class="col-lg-6">{{ Form::label(null, 'Classes', ['class' => 'control-label stat-label']) }}</th>
                                        <th class="col-lg-3">{{ Form::label(null, 'Rank', ['class' => 'control-label stat-label']) }}</th>
                                        <th class="col-lg-3">{{ Form::label(null, 'Skill #', ['class' => 'control-label stat-label']) }}</th>
                                    </tr>
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

                                        //amount of skills able to be taken
                                        $skillrankcap = [
                                            1 => 3,
                                            2 => 6,
                                            3 => 8,
                                            4 => 10
                                        ];
                                        $class_num = 0 . " / " . $skillrankcap[$class_rank];
                                        ?>
                                        <tr class="row {{ $class_row_spacing }}">
                                            <td class="col-lg-6">{{ Form::text("class[]", $class_name, array('class' => 'form-control', 'style' => 'text-align: center;', 'id' => 'email', 'disabled' => 'disabled')) }}</td>
                                            <td class="col-lg-3">{{ Form::text("class_rank[]", $class_rank, array('class' => 'form-control', 'style' => 'text-align: center;', 'id' => 'email', 'disabled' => 'disabled')) }}</td>
                                            <td class="col-lg-3">{{ Form::text("class_num[]", $class_num, array('class' => 'form-control', 'style' => 'text-align: center;', 'id' => 'email', 'disabled' => 'disabled')) }}</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='row top-buffer'>
                    <div class='col-lg-6'>
                        <div class="card">
                            <div class="card-header">Change Password</div>
                            <div class="card-body">
                                {{ Form::open(['url' => url('/user/edit/'.$uid.'/password'), 'class' => 'form-horizontal group-border-dashed' ]) }}
                                {{ csrf_field() }}
                                <div class='row'>
                                    <div class="col-lg-12">
                                        {{ Form::text("newpass", null, array('class' => 'form-control pw', 'autocomplete'=>'off', 'placeholder' => 'placeholder text do not steal lol lmao')) }}
                                    </div>
                                </div>
                                <div class='row top-buffer'>
                                    <button type="submit" form="changepass" class="btn btn-block btn-success col-lg-12">Submit</button>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                    <?php
                    $available_access = UserAccessLevels::where('access_level', '<=', $access_lvl)->pluck('access', 'access_level');
                    $user_able_to_edit = false;
                    if ($access_lvl > 3) { //any rank higher than moderator is able to change someones ranks to any rank below them
                        $user_able_to_edit = true;
                    }
                    ?>
                    <div class='col-lg-6'>
                        <div class="card">
                            {{ Form::open(['url' => url('/user/edit/'.$uid.'/access'), 'class' => 'form-horizontal group-border-dashed' ]) }}
                            {{ csrf_field() }}
                            <div class="card-header">Change Access Level</div>
                            <div class="card-body">
                                <div class="col-lg-12">
                                    {{ Form::select('accesslevel', $available_access, $selected_access->access_level, ['class' => 'form-control']) }}
                                </div>
                                <div class='row top-buffer'>
                                    <?php
                                    //you cannot change your own access level
                                    if ($user->id == $selected_user->id) {
                                        ?>
                                        <button type="button" class="btn btn-block btn-danger col-lg-12">ACCESS DENIED</button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="submit" form="changelevel" class="btn btn-block btn-success col-lg-12">Submit</button>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class='row top-buffer'>
                    <div class='col-lg-12'>
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-8"><span style="display: inline-block; vertical-align: middle;">Stats</span></div>
                                    <?php
                                    if ($permission) {
                                        ?>
                                        <a href="{{ url("/user/".$uid."/builder/") }}" class='btn btn-block btn-success col-lg-4'>Stats Builder</a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                //create a base stats dice array
                                $basedice = [
                                    'muscle' => $selected_details->muscle,
                                    'head' => $selected_details->head,
                                    'heart' => $selected_details->heart,
                                    'soul' => $selected_details->soul
                                        ]
                                ?>
                                <div class="form-group row" style="text-align: center;">
                                    <div class="col-sm-3">
                                        {{ Form::label('base_muscle', 'Muscle', ['class' => 'control-label stat-label']) }}
                                        <div>
                                            {{ Form::text("base_muscle", $basedice["muscle"], array('class' => 'form-control muscle', 'disabled' => 'disabled')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        {{ Form::label('base_head', 'Head', ['class' => 'control-label stat-label']) }}
                                        <div>
                                            {{ Form::text("base_head", $basedice["head"], array('class' => 'form-control head', 'disabled' => 'disabled')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        {{ Form::label('base_heart', 'Heart', ['class' => 'control-label stat-label']) }}
                                        <div>
                                            {{ Form::text("base_heart", $basedice["heart"], array('class' => 'form-control heart', 'disabled' => 'disabled')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        {{ Form::label('base_soul', 'Soul', ['class' => 'control-label stat-label']) }}
                                        <div>
                                            {{ Form::text("base_soul", $basedice["soul"], array('class' => 'form-control soul', 'disabled' => 'disabled')) }}
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
                                        'dice bonus value' => ""
                                    ];
                                    $bonusstats = [
                                        1 => [
                                            'name' => 'power',
                                            'value' => 0],
                                        2 => [
                                            'name' => 'speed',
                                            'value' => 0],
                                        3 => [
                                            'name' => 'sense',
                                            'value' => 0],
                                        4 => [
                                            'name' => 'analytics',
                                            'value' => 0],
                                        5 => [
                                            'name' => 'fortitude',
                                            'value' => 0],
                                        6 => [
                                            'name' => 'connection',
                                            'value' => 0],
                                        7 => [
                                            'name' => 'identity',
                                            'value' => 0],
                                        8 => [
                                            'name' => 'spirituality',
                                            'value' => 0]
                                    ];

                                    //add values to each stat here
                                    //boon and bane bonuses
                                    $boon = $selected_aspect->stat_boon;
                                    $bane = $selected_aspect->stat_bane;
                                    $bonusstats[$boon]['value'] += 2;
                                    $bonusstats[$bane]['value'] -= 1;
                                    //stat add bonus
                                    $mainstats['hp'] += max($bonusstats[1]["value"], $bonusstats[5]["value"]) + ($selected_details->level * 2); //power or fortitude + level*2 + healthy bonus
                                    $mainstats['initiative'] += max($bonusstats[2]["value"], $bonusstats[7]["value"]); //speed or identity
                                    $mainstats['dodge bonus'] += max($bonusstats[2]["value"], $bonusstats[3]["value"]); //speed or sense
                                    $mainstats['guard bonus'] += max($bonusstats[5]["value"], $bonusstats[6]["value"]); //fortitude or connection
                                    $mainstats['dice total'] += max($bonusstats[4]["value"], $bonusstats[8]["value"]); //analytics or spirituality + gambler bonus
                                    //bonus dice value determined by ???
                                    $mainstats['dice bonus value'] = "d" . 4;
                                    //weapon stats
                                    $wpstats = [
                                        'wp dice' => "",
                                        'wp range' => "Hand",
                                        'wp weight' => "N/A",
                                        'wp acc' => 0,
                                        'wp dmg' => 0
                                    ];
                                    $swpstats = [
                                        'secondary weapon active?' => 'No',
                                        's.wp weight' => "N/A",
                                        's.wp acc' => 0,
                                        's.wp dmg' => 0
                                    ];
                                    $fwpstats = [
                                        'total acc' => "D", //dice value
                                        'total dmg' => 0
                                    ];

                                    $selected_aspect = $selected_details->aspect()->first();
                                    //configure wp dice, range and weight
                                    $wpdice = $selected_details->wp_dice()->first();
                                    $wprange = $selected_details->wp_range()->first();
                                    $wpweight = $selected_details->wp_weight()->first();

                                    $wpstats['wp dice'] = $wpdice->dice;
                                    $wpdicevalue = $basedice[strtolower($wpstats['wp dice'])];

                                    $wpstats['wp range'] = $wprange->wp_range;
                                    $wpstats['wp weight'] = $wpweight->weight;
                                    $wpstats['wp acc'] = $wpweight->primary_accuracy;
                                    $wpstats['wp dmg'] = $wpweight->primary_damage;

                                    //toggle secondary data
                                    if ($selected_details->secondary_toggle == 1) {
                                        $swpweight = $selected_details->swp_weight()->first();
                                        $swpstats['secondary weapon active?'] = "Yes";
                                        $swpstats['s.wp weight'] = "Yes";
                                        $swpstats['s.wp acc'] = $swpweight->secondary_accuracy;
                                        $swpstats['s.wp dmg'] = $swpweight->secondary_damage;
                                    };

                                    //add primary and secondary accuracy and damage to get total
                                    $totalaccbonus = $wpstats['wp acc'] + $swpstats['s.wp acc'];
                                    $accpos = "";
                                    if ($totalaccbonus > 0) {
                                        $accpos = "+";
                                    } else if ($totalaccbonus == 0) {
                                        $totalaccbonus = "";
                                    };
                                    $fwpstats['total acc'] .= $wpdicevalue . $accpos . $totalaccbonus;
                                    $fwpstats['total dmg'] += $wpstats['wp dmg'] + $swpstats['s.wp dmg'];
                                    //final weapon damage has to be at least 1
                                    if ($fwpstats['total dmg'] < 1) {
                                        $fwpstats['total dmg'] = 1;
                                    };
                                    ?>
                                    <div class="col-sm-6">
                                        <?php
                                        //display main stats
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
                                        //display weapons
                                        foreach ($wpstats as $statname => $statval) {
                                            //wp dice colour toggle
                                            $wpcolourtoggle = "";
                                            if (array_key_exists(strtolower($wpstats['wp dice']), $basedice) && $statname == "wp dice") {
                                                $wpcolourtoggle = strtolower($wpstats['wp dice']);
                                            }
                                            ?>
                                            <div class="form-group row top-buffer">
                                                {{ Form::label($statname, $statname, ['class' => 'col-sm-8 control-label stat-label']) }}
                                                <div class="col-sm-4">
                                                    {{ Form::text($statname . "[]", $statval, array('class' => 'form-control ' . $wpcolourtoggle, 'style' => 'text-align: center;', 'disabled' => 'disabled')) }}
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        //display total weapon accuracy
                                        ?>
                                        <div class="form-group row top-buffer">
                                            {{ Form::label("total acc", "Total Weapon Accuracy", ['class' => 'col-sm-8 control-label stat-label']) }}
                                            <div class="col-sm-4">
                                                {{ Form::text("total acc",  $fwpstats['total acc'], array('class' => 'form-control ', 'style' => 'text-align: center;', 'disabled' => 'disabled')) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <?php
                                        $bonus_first = true;
                                        foreach ($bonusstats as $statname => $statval) {
                                            //add buffer spacing to every row but the first
                                            $stat = $bonusstats[$statname];
                                            $bonus_row_spacing = "";
                                            if ($bonus_first == true) {
                                                $bonus_first = false;
                                            } else {
                                                $bonus_row_spacing = " top-buffer";
                                            }
                                            ?>
                                            <div class="form-group row {{ $bonus_row_spacing }}">
                                                {{ Form::label($stat['name'], $stat['name'], ['class' => 'col-sm-8 control-label stat-label']) }}
                                                <div class="col-sm-4">
                                                    {{ Form::text($stat['name'], $stat['value'], array('class' => 'form-control ' . $stat['name'], 'style' => 'text-align: center;', 'disabled' => 'disabled')) }}
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        //display secondary weapons
                                        foreach ($swpstats as $statname => $statval) {
                                            ?>
                                            <div class="form-group row top-buffer">
                                                {{ Form::label($statname, $statname, ['class' => 'col-sm-8 control-label stat-label']) }}
                                                <div class="col-sm-4">
                                                    {{ Form::text($statname . "[]", $statval, array('class' => 'form-control ', 'style' => 'text-align: center;', 'disabled' => 'disabled')) }}
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="form-group row top-buffer">
                                            {{ Form::label("total dmg", "Total Weapon Damage", ['class' => 'col-sm-8 control-label stat-label']) }}
                                            <div class="col-sm-4">
                                                {{ Form::text("total dmg",  $fwpstats['total dmg'], array('class' => 'form-control ', 'style' => 'text-align: center;', 'disabled' => 'disabled')) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='row top-buffer'>
            <div class='col-lg-12'>
                <div class="card">
                    <div class="card-header">Stats and Skills</div>
                    <div class="card-body">

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
@endsection