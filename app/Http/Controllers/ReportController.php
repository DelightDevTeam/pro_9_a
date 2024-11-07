<?php

namespace App\Http\Controllers;

use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('reports')
            ->join('users', 'reports.member_name', '=', 'users.user_name')
            ->select(
                'users.name as member_name',
                'users.user_name as user_name',
                DB::raw('COUNT(DISTINCT reports.id) as qty'),
                DB::raw('SUM(reports.bet_amount) as total_bet_amount'),
                DB::raw('SUM(reports.valid_bet_amount) as total_valid_bet_amount'),
                DB::raw('SUM(reports.payout_amount) as total_payout_amount'),
                DB::raw('SUM(reports.commission_amount) as total_commission_amount'),
                DB::raw('SUM(reports.jack_pot_amount) as total_jack_pot_amount'),
                DB::raw('SUM(reports.jp_bet) as total_jp_bet'),
                DB::raw('(SUM(reports.payout_amount) - SUM(reports.valid_bet_amount)) as win_or_lose'),
                DB::raw('COUNT(*) as stake_count')
            );
        $query->when($request->start_date && $request->end_date, function ($query) use ($request) {
            $query->whereBetween('reports.created_at', [$request->start_date.' 00:00:00', $request->end_date.' 23:59:59']);
        });
        $query->when($request->member_name, function ($query) use ($request) {
            $query->where('reports.member_name', $request->member_name);
        });
        $query->when($request->product_code, function ($query) use ($request) {
            $query->where('reports.product_code', $request->product_code);
        });
        if (! Auth::user()->hasRole('Admin')) {
            $query->where('reports.agent_id', Auth::id());
        }

        $agentReports = $query->groupBy('reports.member_name', 'users.name', 'users.user_name')->get();

        $providers = Product::all();

        return view('report.show', compact('agentReports', 'providers'));
    }

    // amk
    public function detail(Request $request, $userName)
    {

        if ($request->ajax()) {
            $query = DB::table('reports')
                ->join('users', 'reports.member_name', '=', 'users.user_name')
                ->join('products', 'products.code', '=', 'reports.product_code')
                ->join('game_lists', 'game_lists.code', '=', 'reports.game_name')
                ->where('reports.member_name', $userName)
                ->orderBy('reports.id', 'desc')
                ->select(
                    'reports.*',
                    'game_lists.name as gamename',
                    'users.name as name',
                    'products.name as product_name',
                    DB::raw('(reports.payout_amount - reports.valid_bet_amount) as win_or_lose')
                );

            $report = $query->get();

            return DataTables::of($report)
                ->addIndexColumn()
                ->make(true);
        }
        $products = Product::all();

        return view('report.detail', compact('products', 'userName'));
    }
}
