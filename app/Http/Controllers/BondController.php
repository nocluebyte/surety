<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\{
    BidBondDataTable,
    PerformanceBondDataTable,
};

class BondController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('permission:bond.list', ['only' => ['index']]);
        $this->title = trans('bond.bond');
        view()->share('title', $this->title);
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('bond.index');
    }

    // public function __invoke(Request $request, BidBondDataTable $bid_bond_datatable, PerformanceBondDataTable $performance_bond_datatable)
    // {
    //     return [$bid_bond_datatable->render('bond.index'), $performance_bond_datatable->render('bond.index')];
    // }

    // public function __invoke(Request $request, BidBondDataTable $bid_bond_datatable, PerformanceBondDataTable $performance_bond_datatable)
    // {
    //     // return $bid_bond_datatable->render('bond.index');
    //     return $performance_bond_datatable->render('bond.index');
    // }

    // public function __invoke(BidBondDataTable $bid_bond_datatable, PerformanceBondDataTable $performance_bond_datatable)
    // {
    //     return $bid_bond_datatable->render('bond.index', compact('performance_bond_datatable'));
    // }
}
