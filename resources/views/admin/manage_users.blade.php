@extends('layouts.app')

@section('content')

<?php
$access_lvl = Auth::user()->access_level;
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 container">
            
            <!-- intro card -->
            <div class='row top-buffer'>
                <div class='col'>
                    <div class="card">
                        <div class="card-header">{{ __('Welcome, ') . " " . Auth::user()->name . "!" }}</div>

                        <div class="card-body">
                            <?php
                            if (session('status')) {
                                ?>
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                                <?php
                            }
                            ?>

                            <p class="text-center">Connected to <b>Zwei.Net</b>, powered by <i>EnerBoost&#x2122;</i>. You may access your player character data and any information you have gathered in <b>ZweiTopia</b> here.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php
            //user access only visible by access level 9 - Administrator
            if ($access_lvl >= 9) {
                ?>
                <div class='row top-buffer'>
                    <div class='col-lg-6'>
                        <div class="card">
                            <div class="card-header">User Management</div>
                            <div class="card-body">
                                <div class='row top-buffer'>
                                    <a href="{{ route('dice_stats') }}" class='btn btn-block btn-success'>Manage Users</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class='col-lg-6'>
                        <div class="card">
                            <div class="card-header">Master Control</div>
                            <div class="card-body">
                                <div class='row top-buffer'>
                                    <a href="{{ route('dice_stats') }}" class='btn btn-block btn-success'>Manage Active Players</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

            <!-- player pages -->
            <div class='row top-buffer'>
                <div class='col-lg-6'>
                    <div class="card">
                        <div class="card-header">Player Info</div>
                        <div class="card-body">
                            <p class="text-center">You may view and modify your current stats here.</p>
                            <div class='row top-buffer'>
                                <button class='btn btn-block btn-primary'>Current Stats</button>
                            </div>
                            <div class='row top-buffer'>
                                <button class='btn btn-block btn-primary'>Stats Builder</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='col-lg-6'>
                    <div class="card">
                        <div class="card-header">Player Resources</div>
                        <div class="card-body">
                            <p class="text-center">Information on details of NetSavers&#x2122; are listed here for your convenience.</p>
                            <div class='row top-buffer'>
                                <a href="{{ route('dice_stats') }}" class='btn btn-block btn-primary'>Dice and Stats</a>
                            </div>
                            <div class='row top-buffer'>
                                <button class='btn btn-block btn-primary'>Classes</button>
                            </div>
                            <div class='row top-buffer'>
                                <button class='btn btn-block btn-primary'>Aspects</button>
                            </div>
                            <div class='row top-buffer'>
                                <button class='btn btn-block btn-primary'>Encountered NPCs</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
