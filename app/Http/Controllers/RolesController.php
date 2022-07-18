<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
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

    public function ajouter(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
        ]);
        $roles = DB::table('roles')->get();
        // echo print_r($_POST);
        // echo $_POST['email'];
        $newUser = new User;
        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = "password";
        $newUser->save();

        foreach($roles as $role)
        {
            
            if($_POST[$role->id])
            {
                $role_user = new RoleUser;
                $role_user->user_id = $newUser->id;
                $role_user->role_id = $role->id;
                $role_user->save();
            }
        }

        return redirect('/users');
        
    }
}
