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
        $users = User::with(['users', 'roles'])->get();
        echo $users;
    }
}
