<?php

namespace App\Http\Controllers;

use App\Models\User;
 
class AdminController extends Controller
{
    public function getUsers()
    {
        $users = User::with('access_level')->get();

        return \Yajra\DataTables\DataTables::of($users)->make(true);
    }
}