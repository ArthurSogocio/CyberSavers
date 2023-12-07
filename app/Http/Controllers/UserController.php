<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\UserStats;
use App\Models\DiceModels;
use Hash;

class UserController extends Controller {

    public function getUsers() {
        $users = User::with('access_level')->get();

        return \Yajra\DataTables\DataTables::of($users)->make(true);
    }

    public function addUser(Request $request) {
        //get all values from page
        $name = $request->get('name');
        $email = $request->get('email');
        $access_level = $request->get('access_level');
        $level = $request->get('level');
        $active_player = $request->get('active_player');
        $password = $request->get('password');
        
        //create the new user
        $newuser = User::create([
                    'name' => $name,
                    'email' => $email,
                    'access_level' => $access_level,
                    'active_player' => $active_player,
                    'password' => Hash::make($password)
        ]);

        //get the id and create the user details
        $newuserid = $newuser->id;
        $newdetails = UserDetails::create([
                    'user_id' => $newuserid,
                    'level' => $level
        ]);

        //generate all stat defaults
        for ($i = 1; $i <= 8; $i++) {
            //create each individual stat
            $newstat = UserStats::create([
                'user_id' => $newuserid,
                'stat' => $i,
                'value' => 0
            ]);
        };

        return redirect('/user/' . $newuserid . '/details/')->with('success', 'User added!');
    }
    
    public function buildUser (Request $request) {
        $update_type = $request->get("update_type");
        $uid = $request->get("uid");
        $return = [];
        $updated_user = User::find($uid);
        
        if ($update_type === "dice") {
            //update dice values
            $model_id = $request->get("model");
            $muscle = $request->get("muscle");
            $head = $request->get("head");
            $heart = $request->get("heart");
            $soul = $request->get("soul");
            
            //get the current dice model
            $model = DiceModels::find($model_id);
            
            //update the player's dice
            $user_details = $updated_user->details()->first();
            $user_details->update([
                'dice_model' => $model_id,
                'muscle' => $model->$muscle,
                'head' => $model->$head,
                'heart' => $model->$heart,
                'soul' => $model->$soul
            ]);
            
            $return['details'] = $user_details;
            $return['model_name'] = $model->model;
        }
        
        return $return;
    }
}
