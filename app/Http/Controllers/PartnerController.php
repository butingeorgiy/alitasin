<?php

namespace App\Http\Controllers;

use App\Facades\Auth;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller
{
    /**
     * Show partners admin page.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function showAll(Request $request): Response
    {
        $user = Auth::user();

//        if ($search = $request->input('search')) {
//            $partners = User::partners()->whereExists(function ($query) {
//                $query->select('id')->from('promo_codes')
//                    ->whereRaw('promo_codes.id = :promo_code', []);
//            })->withTrashed()->get();
//        } else {
//            $partners = User::partners()->withTrashed()->get();
//        }

//        if ($search = $request->input('search')) {
//            $partners = Partner::withTrashed()->whereExists(function ($query) {
//                $query->select('id')->from('promo_codes')->whereRaw('promo_codes.id = :promo_code', []);
//            })->get();
//        } else {
        $partners = Partner::withTrashed()->with('user')->get();
//        }

        $totalFigures = Partner::getTotalFigures();

        return response()->view('admin.partners', compact('user', 'partners', 'totalFigures'));
    }

    /**
     * Show partner page.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(int $id): Response
    {
        /** @var Partner $partner */
        $partner = Partner::withTrashed()->findOrFail($id);

        $subPartners = Partner::withTrashed()->where('parent_id', $id)->get();

        return response()->view('admin.partner', [
            'partner' => $partner,
            'isSubPartner' => $partner->isSubPartner(),
            'subPartners' => $subPartners
        ]);
    }
}
