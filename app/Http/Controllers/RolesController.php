<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    public function liste()
    {
        $users = User::with('roles')->get();
        $roles = DB::table('roles')->get();

        return view('roles.liste')
            ->with('users', $users)
            ->with('roles', $roles);
    }
}
