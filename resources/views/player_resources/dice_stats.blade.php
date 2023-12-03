@extends('layouts.app')

@section('content')
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

                            {{ __('Connected to Zwei.Net') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- player pages -->
            <div class='row top-buffer'>
                <div class='col-lg-6'>
                    <div class="card">
                        <div class="card-header">TEST</div>

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
                                <a href="{{ url('/player_resources/dice_stats') }}" class='btn btn-block btn-primary'>Dice and Stats</a>
                            </div>
                            <div class='row top-buffer'>
                                <button class='btn btn-block btn-primary'>Classes</button>
                            </div>
                            <div class='row top-buffer'>
                                <button class='btn btn-block btn-primary'>Aspects</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
