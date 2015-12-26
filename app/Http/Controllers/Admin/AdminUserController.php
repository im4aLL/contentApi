<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserFormRequest;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Hash;

class AdminUserController extends Controller
{
    /**
     * Change password form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage()
    {
        return view('admin.user.form');
    }

    /**
     * Update user passowrd
     *
     * @param UserFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserFormRequest $request)
    {
        $old_password = $request->input('oldpassword');
        $new_password = $request->input('password');

        if(Hash::check($old_password, auth()->user()->getAuthPassword())) {
            $user = User::findOrFail(auth()->user()->id);
            $user->fill([
                'password' => Hash::make($new_password)
            ])->save();

            return redirect()->route('admin.root')->with('alert-success', 'Passowrd has been changed!');
        }
        else {
            return redirect()->back()->with('alert-danger', 'Your current password doesn\'t match!');
        }
    }
}
