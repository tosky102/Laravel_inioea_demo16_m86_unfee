<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function impersonate(Request $request, $id)
    {
        $userModel = config('admin.database.front_users_model');
        $user = $userModel::findOrFail($id);

        Auth::guard('web')->login($user);

        return redirect('/');
    }
}
