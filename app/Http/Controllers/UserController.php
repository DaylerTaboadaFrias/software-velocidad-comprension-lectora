<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function listAll()
    {
        $usersAll = User::all();
        return view('user.list', ['users' => $usersAll]);
    }

    public function bannedListAll()
    {
        $usersBanned = User::where('banned', true)->get();
        return view('user.list', ['users' => $usersBanned]);
    }

    public function bannedListAdd(User $user)
    {
        $user->banned = true;
        $user->save();
        $usersAll = User::all();
        return view('user.list', ['users' => $usersAll]);
    }

    public function notBannedListAll()
    {
        $usersBanned = User::where('banned', false)->get();
        return view('user.list', ['users' => $usersBanned]);
    }

    public function notBannedListAdd(User $user)
    {
        $user->banned = false;
        $user->save();
        $usersAll = User::all();
        return view('user.list', ['users' => $usersAll]);
    }
}
