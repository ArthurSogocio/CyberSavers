@extends('layouts.app')

@section('content')


<?php

use App\Models\User;
use App\Models\DiceModels;

//use App\Models\UserAccessLevels;

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

$first_time = false;
if ($selected_details->level === 0) {
    $first_time = true;
}
?>
<div class="row justify-content-center">
    <div class="col-md-8 container">
        <!-- user management -->
        <div class='row top-buffer'>
            <div class='col-lg-12'>
                <div class="card">
                    <div class="card-header">Stats Builder for {{ $selected_user->name }}</div>
                    <?php
                    //if this is their first time accessing this page or a new character, include the following message (level 0)
                    if ($first_time) {
                        ?>
                        <div class="card-body">If this is your first time here, please follow each step of the process to build your character!</div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        if ($permission) {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    //if this is their first time, step 1 is to select their first class
                    if ($first_time) {
                        ?>
                        <div class='row top-buffer'>
                            <div class='col-lg-12'>
                                <div class="card">
                                    <div class="card-header">Stats</div>
                                    <div class="card-body"></div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <div class='row top-buffer'>
                        <div class='col-lg-12'>
                            <div class="card">
                                <div class="card-header"><?php if ($first_time) echo "Step 2:"; ?> Select your Dice Model</div>
                                <div class="card-body">
                                    <div class="row">
                                        <table style="width: 100%">
                                            <thead>
                                                <tr class="row top-buffer">
                                                    <th class="col-sm-4">{{ Form::label("model", 'Dice Models', ['class' => 'control-label stat-label']) }}</th>
                                                    <th class="col-sm-2">{{ Form::label("muscle", 'Muscle', ['class' => 'control-label stat-label']) }}</th>
                                                    <th class="col-sm-2">{{ Form::label("head", 'Head', ['class' => 'control-label stat-label']) }}</th>
                                                    <th class="col-sm-2">{{ Form::label("heart", 'Heart', ['class' => 'control-label stat-label']) }}</th>
                                                    <th class="col-sm-2">{{ Form::label("soul", 'Soul', ['class' => 'control-label stat-label']) }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                //get existing dice values for user
                                                $current_model = $selected_details->dice_model;
                                                $current_muscle = $selected_details->muscle;
                                                $current_head = $selected_details->head;
                                                $current_heart = $selected_details->heart;
                                                $current_soul = $selected_details->soul;

                                                //get all dice models
                                                $models = DiceModels::pluck('model', 'id')->prepend('Select a Dice Model', null)->toArray();
                                                $model_values = DiceModels::all()->toJson();

                                                //if the current dice model is 0, have the display show N/A
                                                $current_model_name = "N/A";
                                                if ($current_model != 0) {
                                                    $current_model_name = $models[$current_model];
                                                }
                                                ?>
                                                <tr class="row top-buffer">
                                                    <td class="col-sm-4">{{ Form::text("current_model", "Current Model: " . $current_model_name, array('class' => 'form-control ', 'id' => 'current_model', 'style' => 'text-align: center;', 'disabled')) }}</td>
                                                    <td class="col-sm-2">{{ Form::text("current_muscle", $current_muscle, array('class' => 'form-control muscle', 'id' => 'current_muscle', 'style' => 'text-align: center;', 'disabled' => 'disabled')) }}</td>
                                                    <td class="col-sm-2">{{ Form::text("current_head", $current_head, array('class' => 'form-control head', 'id' => 'current_head', 'style' => 'text-align: center;', 'disabled' => 'disabled')) }}</td>
                                                    <td class="col-sm-2">{{ Form::text("current_heart", $current_heart, array('class' => 'form-control heart', 'id' => 'current_heart', 'style' => 'text-align: center;', 'disabled' => 'disabled')) }}</td>
                                                    <td class="col-sm-2">{{ Form::text("current_soul", $current_soul, array('class' => 'form-control soul', 'id' => 'current_soul', 'style' => 'text-align: center;', 'disabled' => 'disabled')) }}</td>
                                                </tr>
                                                <tr class="row top-buffer">
                                                    <td class="col-sm-4">{{ Form::select("model", $models, null, array('class' => 'form-control model', 'style' => 'text-align: center;')) }}</td>
                                                    <td class="col-sm-2">{{ Form::select("muscle", [], null, array('class' => 'form-control muscle dice_update du1', 'style' => 'text-align: center;')) }}</td>
                                                    <td class="col-sm-2">{{ Form::select("head", [], null, array('class' => 'form-control head dice_update du2', 'style' => 'text-align: center;')) }}</td>
                                                    <td class="col-sm-2">{{ Form::select("heart", [], null, array('class' => 'form-control heart dice_update du3', 'style' => 'text-align: center;')) }}</td>
                                                    <td class="col-sm-2">{{ Form::select("soul", [], null, array('class' => 'form-control soul dice_update du4', 'style' => 'text-align: center;', 'readonly' => 'readonly')) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button id="submit_dice" class="btn btn-block btn-success top-buffer">Update Dice Model</button>
                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                _token = "<?= csrf_token() ?>";
                                                uid = <?= $uid ?>;
                                                models = <?= $model_values ?>;
                                                current_model = <?= $current_model ?> - 1;
                                                modeldice = models[current_model];
                                                update_dice(modeldice);

                                                $("select.model").change(function () {
                                                    model_val = $(this).val();
                                                    //cancel out value diff
                                                    if (model_val != "") {
                                                        model_val--;

                                                        modeldice = models[model_val];
                                                        //update model variables
                                                        update_dice(modeldice);
                                                    }
                                                });

                                                //when a dice value is changed, update all dice values to the right of it
                                                $("select.dice_update").change(function () {
                                                    diceval = $(this).val();
                                                    //added id and model here just in case it break things later
                                                    selectedoptions = {
                                                        id: null,
                                                        model: null
                                                    };
                                                    // selected dice mod to make sure the offset is fisxed
                                                    select_dice_mod = 5;
                                                    //for each option in the selected dice set, put in a new model object
                                                    $.each($(this).prop("options"), function (i, opt) {
                                                        //if the option is not the same as the selected one, include it in the selected options
                                                        if (opt.value !== diceval) {
                                                            selectedoptions[opt.value] = opt.text;
                                                            select_dice_mod--;
                                                        }
                                                    });
                                                    update_dice(selectedoptions, select_dice_mod);
                                                });

                                                //function to update each dice options
                                                function update_dice(modeldice, dice_mod = 1) {
                                                    //recreate the model object with no reference so it doesnt delete itself
                                                    removable_modeldice = Object.assign({}, modeldice);
                                                    delete removable_modeldice.id;
                                                    delete removable_modeldice.model;

                                                    //if dice_mod is not set to anything, update every dice, otherwise update the dice that are after dice_mod
                                                    for (mod = dice_mod; mod <= 4; mod++) {//update the default arrays with each value
                                                        firstprop = "";
                                                        //clear all options before readding
                                                        $("select.dice_update.du" + mod).empty();
                                                        for (m in removable_modeldice) {
                                                            //do not include id and model
                                                            diceval = removable_modeldice[m];
                                                            $("select.dice_update.du" + mod).append($('<option>', {
                                                                value: m,
                                                                text: diceval
                                                            }));
                                                            //if this was the first property, list it as the first property
                                                            if (firstprop === "") {
                                                                firstprop = m;
                                                            }
                                                        }
                                                        //remove the selected first option from the removable model dice
                                                        delete removable_modeldice[firstprop];
                                                }
                                                }

                                                $("#submit_dice").click(function (e) {
                                                    //prevent any default actions
                                                    e.preventDefault();
                                                    model = $("select.model").val();
                                                    muscle = $("select.muscle").val();
                                                    head = $("select.head").val();
                                                    heart = $("select.heart").val();
                                                    soul = $("select.soul").val();

                                                    if (model != "") {
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: "{{ route('builder') }}",
                                                            data: {
                                                                _token: _token,
                                                                uid: uid,
                                                                update_type: "dice",
                                                                model: model,
                                                                muscle: muscle,
                                                                head: head,
                                                                heart: heart,
                                                                soul: soul
                                                            },
                                                            success: function (data) {
                                                                console.log(data);
                                                                //update the existing form with the data you populated to make sure it looks correct
                                                                $("#current_model").val("Current Model: " + data.model_name);
                                                                $("#current_muscle").val(data.details.muscle);
                                                                $("#current_head").val(data.details.head);
                                                                $("#current_heart").val(data.details.heart);
                                                                $("#current_soul").val(data.details.soul);
                                                            },
                                                            error: function (data) {
                                                                console.log('error');
                                                                console.log(data);
                                                            }
                                                        });
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class='row top-buffer'>
                        <div class='col-lg-12'>
                            <div class="card">
                                <div class="card-header">Stats</div>
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
</div>
@endsection