<?php

namespace App\Http\Controllers;

use App\Facades\Auth;
use App\Models\User;

class PartnerController extends Controller
{
    public function showAll()
    {
        $user = Auth::user();

        $partners = User::partners()->withTrashed()->get();

        return view('admin.partners', compact('user', 'partners'));
    }

    public function show($id)
    {
        $partner = User::partners()->withTrashed()->findOrFail($id);

        return view('admin.partner', compact('partner'));
    }
}
