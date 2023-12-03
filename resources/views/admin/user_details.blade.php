@extends('layouts.app')

@section('content')


<?php

use App\Models\User;

$user = Auth::user();
$access_lvl = $user->access_level;

$selected_user = User::find($uid);
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 container">

            <!-- user management -->
            <div class='row top-buffer'>
                <div class='col-lg-12'>
                    <div class="card">
                        <div class="card-header">User Details for {{ $selected_user->name }}</div>
                    </div>
                </div>
            </div>
            
            <div class='row top-buffer'>
                <div class='col-lg-6'>
                    <div class="card">
                        <div class="card-header">Credentials</div>
                        <div class="card-body">
                            <h3>test</h3>
                        </div>
                    </div>
                </div>
                
                <div class='col-lg-6'>
                    <div class="card">
                        <div class="card-header">Stats</div>
                        <div class="card-body">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection