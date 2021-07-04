<?php

namespace App\Http\Controllers;

use App\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller
{
    public function showAll(Request $request)
    {
        $user = Auth::user();

        if ($search = $request->input('search')) {
            $partners = User::partners()->whereExists(function ($query) {
                $query->select('id')->from('promo_codes')
                    ->whereRaw('promo_codes.id = :promo_code', []);
            })->withTrashed()->get();
        } else {
            $partners = User::partners()->withTrashed()->get();
        }

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
