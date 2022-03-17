<?php

namespace App\Http\Controllers;

use App\Facades\Auth;

class TransferController extends Controller
{
    public function showEditForm()
    {
        $user = Auth::user();

        return view('admin.transfers', compact('user'));
    }
}
