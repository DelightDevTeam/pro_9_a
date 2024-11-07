<?php

namespace App\Http\Controllers\Admin\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgentReportController extends Controller
{
    public function index()
    {
        $data = $this->makeJoinTable();

        return view('admin.agent.report.index', compact('data'));
    }

    // v2
    private function makeJoinTable()
    {
        $authAgentId = Auth::user()->id; // Get the authenticated agent's ID

        $query = DB::table('reports')
            ->select([
                'products.name as product_name',
                DB::raw('COUNT(reports.id) as total_record'), // Total Record
                DB::raw('SUM(reports.bet_amount) as total_bet'), // Total Bet
                DB::raw('SUM(reports.valid_bet_amount) as total_valid_bet'), // Total Valid Bet
                DB::raw('SUM(reports.jp_bet) as total_prog_jp'), // Total Progressive JP Bet
                DB::raw('SUM(reports.payout_amount) as total_payout'), // Total Payout
                DB::raw('SUM(reports.payout_amount - reports.valid_bet_amount) as total_win_lose'), // Total Win/Loss

                // Agent-related columns
                'agents.user_name as agent_user_name', // Agent Username

                // Member-related columns
                DB::raw('SUM(reports.agent_commission) as member_comm'), // Member Commission

                // Upline-related columns
                DB::raw('SUM(reports.agent_commission) as upline_comm'), // Upline Commission
                DB::raw('SUM(reports.payout_amount - reports.valid_bet_amount) as upline_total'), // Upline Win/Loss
            ])
            ->join('products', 'reports.product_code', '=', 'products.code') // Join reports with products
            ->join('users as agents', 'reports.agent_id', '=', 'agents.id') // Join reports with agent's user name
            ->join('users as masters', 'reports.master_id', '=', 'masters.id') // Join reports with master's user name
            ->where('reports.status', '101') // Filter by status '101'
            ->where('reports.agent_id', $authAgentId) // Filter to show only reports for the authenticated agent
            ->groupBy('products.name', 'agents.user_name'); // Group by product name and agent's user name

        return $query->get();
    }

    // private function makeJoinTable()
    // {
    //     $query = DB::table('reports')
    //         ->select([
    //             'products.name as product_name',
    //             DB::raw('COUNT(reports.id) as total_record'), // Total Record
    //             DB::raw('SUM(reports.bet_amount) as total_bet'), // Total Bet
    //             DB::raw('SUM(reports.valid_bet_amount) as total_valid_bet'), // Total Valid Bet
    //             DB::raw('SUM(reports.jp_bet) as total_prog_jp'), // Total Progressive JP Bet
    //             DB::raw('SUM(reports.payout_amount) as total_payout'), // Total Payout
    //             DB::raw('SUM(reports.payout_amount - reports.valid_bet_amount) as total_win_lose'), // Total Win/Loss

    //             // Agent-related columns
    //             'agents.user_name as agent_user_name', // Agent Username
    //             //'masters.user_name as master_user_name', // Master Username

    //             // Member-related columns
    //             DB::raw('SUM(reports.agent_commission) as member_comm'), // Member Commission

    //             // Upline-related columns
    //             DB::raw('SUM(reports.agent_commission) as upline_comm'), // Upline Commission
    //             DB::raw('SUM(reports.payout_amount - reports.valid_bet_amount) as upline_total'), // Upline Win/Loss
    //         ])
    //         ->join('products', 'reports.product_code', '=', 'products.code') // Join reports with products
    //         ->join('users as agents', 'reports.agent_id', '=', 'agents.id') // Join reports with agent's user name
    //         ->join('users as masters', 'reports.master_id', '=', 'masters.id') // Join reports with master's user name
    //         ->where('reports.status', '101') // Filter by status '101'
    //         ->groupBy('products.name', 'agents.user_name'); // Group by product name and agent

    //     return $query->get();
    // }

    // v1

    //     private function makeJoinTable()
    // {
    //     $query = DB::table('reports')
    //         ->select([
    //             'products.name as product_name',
    //             DB::raw('COUNT(reports.id) as total_record'), // Total Record
    //             DB::raw('SUM(reports.bet_amount) as total_bet'), // Total Bet
    //             DB::raw('SUM(reports.valid_bet_amount) as total_valid_bet'), // Total Valid Bet
    //             DB::raw('SUM(reports.jp_bet) as total_prog_jp'), // Total Progressive JP Bet
    //             DB::raw('SUM(reports.payout_amount) as total_payout'), // Total Payout
    //             DB::raw('SUM(reports.payout_amount - reports.valid_bet_amount) as total_win_lose'), // Total Win/Loss

    //             // Member-related columns
    //             DB::raw('SUM(reports.agent_commission) as member_comm'), // Member Commission
    //             //DB::raw('0 as member_total'), // Placeholder for member total

    //             // Upline-related columns
    //             DB::raw('SUM(reports.agent_commission) as upline_comm'), // Upline Commission
    //             DB::raw('SUM(reports.payout_amount - reports.valid_bet_amount) as upline_total'), // Upline Win/Loss
    //         ])
    //         ->join('products', 'reports.product_code', '=', 'products.code') // Joining reports with products
    //         ->where('reports.status', '101') // Filter by status '101'
    //         ->groupBy('products.name'); // Group by product name

    //     return $query->get();
    // }

    public function detail($productName)
    {
        // Fetch detailed information about the selected product
        $details = DB::table('reports')
            ->select([
                'reports.wager_id',
                'members.user_name as member_name', // Member alias
                DB::raw('agents.user_name as agent_name'), // Get agent's name
                'products.name as product_name',
                'game_lists.name as game_name', // Changed to use game_lists
                'reports.bet_amount',
                'reports.valid_bet_amount',
                'reports.payout_amount as payout',
                DB::raw('(reports.payout_amount - reports.valid_bet_amount) as win_loss'),
                'reports.settlement_date as settle_match_date',
            ])
            ->join('products', 'reports.product_code', '=', 'products.code')
            ->join('game_lists', 'reports.game_name', '=', 'game_lists.code') // Joining with game_lists
            ->join('users as members', 'reports.member_name', '=', 'members.user_name') // Join for member using alias 'members'
            ->join('users as agents', 'reports.agent_id', '=', 'agents.id') // Join for agent using alias 'agents'
            ->where('products.name', $productName)
            ->get();

        // Pass the details to the view
        return view('admin.agent.report.details', compact('details'));
    }
}
