<?php

namespace App\Http\Controllers;

use App\Facades\Auth;
use App\Facades\Hash;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        /** @var User|null $partner */
        $partner = User::partners()->withTrashed()->findOrFail($id);
        $subPartnerIds = [];

        foreach (DB::table('sub_partners')->select('user_id')
                     ->where('parent_user_id', $partner->id)->get() as $item) {
            $subPartnerIds[] = $item->user_id;
        }

        $subPartners = User::partners()->withTrashed()->whereIn('id', $subPartnerIds)->get();
        $isSubPartner = $partner->isSubPartner();

        return view(
            'admin.partner',
            compact('partner', 'subPartners', 'isSubPartner')
        );
    }
}
