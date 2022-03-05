<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;

class UserController extends Controller
{
    public function update(Request $request, $id ){
        $input = $request->all();
        $user = User::find($id);
        $user->fill($input)->save();
        tosatr()->succes("Success!");
        return back();
    }
}
