<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function store(Request $request)
    {
        $user = User::find($userId);

        $leftDownlineCount = $user->totalDownlineCount('left');
        $rightDownlineCount = $user->totalDownlineCount('right');
        $totalDownlineCount = $user->totalDownlineCount();

        $leftLastUser = $user->lastUserInDownline('left');
        $rightLastUser = $user->lastUserInDownline('right');
        $lastUsers = $user->lastUserInDownline();
    }
}
