<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class UserController extends Controller
{
    public function index ()
    {
      $users = User::with('userKyc')->where('id', '!=',  Auth::id())->get();
      return view('admin.users.index',compact('users'));
    }
    public function changeStatus(Request $request)
    {
        $user = User::find($request->user_id);
        $user->account_status = $request->account_status;
        $user->save();

        return response()->json(['success'=>'Status change successfully.']);
    }
}
