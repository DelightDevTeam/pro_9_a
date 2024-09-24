<?php

namespace App\Console\Commands;

use App\Models\Report;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PullReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pull-report';

    protected $operatorCode;

    protected $secretKey;

    protected $apiUrl;

    public const VERSION_KEY = 1;

    public function __construct()
    {
        parent::__construct();
        $this->operatorCode = config('game.api.operator_code');
        $this->secretKey = config('game.api.secret_key');
        $this->apiUrl = config('game.api.url');
    }

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $apiUrl = $this->apiUrl.'/Seamless/PullReport';

        $operatorCode = Config::get('game.api.operator_code');
        $secretKey = Config::get('game.api.secret_key');
        // Generate the signature
        $requestTime = now()->format('YmdHis');
        $signature = md5($operatorCode.$requestTime.'pullreport'.$secretKey);
        // Prepare the payload
        $startDate = now()->subMinutes(2);

        $data = [
            'OperatorCode' => $operatorCode,
            'StartDate' => $startDate->format('Y-m-d H:i'),
            'EndDate' => $startDate->copy()->addMinutes(5)->format('Y-m-d H:i'),
            'Sign' => $signature,
            'RequestTime' => $requestTime,
        ];
        //Log::info($data);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($apiUrl, $data);

        if ($response->successful()) {
            $data = $response->json();
            if ($data['Wagers'] != null) {
                $data = $response['Wagers'];
                foreach ($data as $report) {

                    $agent_commission = null;
                    $user = User::where('user_name', $report['MemberName'])->first();

                    if ($user && $user->agent_id) {
                        $agent = User::where('id', $user->agent_id)->first();

                        //Log::info($agent);

                        if ($agent) {
                            $agent_commission = $agent->commission; // Get the agent's commission

                            $agentData = DB::table('reports')
                                ->join('users', 'reports.agent_id', '=', 'users.id')
                                ->where('reports.agent_id', $agent->id)
                                ->select(
                                    DB::raw('SUM(reports.valid_bet_amount) as total_valid_bets'),
                                    DB::raw('MAX(users.commission) as commission_rate') // or use groupBy('users.commission')
                                )
                                ->first();

                            // Calculate the gross commission
                            $grossCommission = $agentData->total_valid_bets * ($agentData->commission_rate / 100);
                        } else {
                            Log::warning('Agent not found for agent_id: '.$user->agent_id);
                            $agent_commission = null; // Handle case where agent is not found
                        }
                    } else {
                        Log::warning('User not found or user does not have an agent: '.$report['MemberName']);
                        $agent_commission = null; // Handle case where user is not found or has no agent
                    }

                    // Get the master agent (the agent's agent)
                    $master = User::where('id', $agent->agent_id)->first();
                    // $masterAgentId = $master->id;
                    // Log::info($masterAgentId);
                    // Log::warning("Master Name: " . $master->user_name);
                    //  Log::warning("Master ID: " . $master->id);
                    // Log::warning("Agent Name: " . $agent->user_name);
                    //  Log::warning("Agent ID: " . $user->agent_id);

                    $wagerId = Report::where('wager_id', $report['WagerID'])->first();

                    if ($wagerId) {
                        $wagerId->update([
                            'member_name' => $report['MemberName'],
                            'wager_id' => $report['WagerID'],
                            'product_code' => $report['ProductID'],
                            'game_type_id' => $report['GameType'],
                            'game_name' => $report['GameID'],
                            'game_round_id' => $report['GameRoundID'],
                            'valid_bet_amount' => $report['ValidBetAmount'],
                            'bet_amount' => $report['BetAmount'],
                            'payout_amount' => $report['PayoutAmount'],
                            'commission_amount' => $report['CommissionAmount'],
                            'jack_pot_amount' => $report['JackpotAmount'],
                            'jp_bet' => $report['JPBet'],
                            'status' => $report['Status'],
                            'created_on' => $report['CreatedOn'],
                            'modified_on' => $report['ModifiedOn'],
                            //'settlement_date' => $report['SettlementDate'],
                            'settlement_date' => $report['SettlementDate'] ?? now(),
                            'agent_id' => $user->agent_id, // Store the agent_id
                            'master_id' => $master->id, // Store the agent_id
                            'agent_commission' => $grossCommission,
                        ]);
                    } else {
                        Report::create([
                            'member_name' => $report['MemberName'],
                            'wager_id' => $report['WagerID'],
                            'product_code' => $report['ProductID'],
                            'game_type_id' => $report['GameType'],
                            'game_name' => $report['GameID'],
                            'game_round_id' => $report['GameRoundID'],
                            'valid_bet_amount' => $report['ValidBetAmount'],
                            'bet_amount' => $report['BetAmount'],
                            'payout_amount' => $report['PayoutAmount'],
                            'commission_amount' => $report['CommissionAmount'],
                            'jack_pot_amount' => $report['JackpotAmount'],
                            'jp_bet' => $report['JPBet'],
                            'status' => $report['Status'],
                            'created_on' => $report['CreatedOn'],
                            'modified_on' => $report['ModifiedOn'],
                            //'settlement_date' => $report['SettlementDate'],
                            'settlement_date' => $report['SettlementDate'] ?? now(),
                            'agent_id' => $user->agent_id, // Store the agent_id
                            'master_id' => $master->id, // Store the agent_id
                            'agent_commission' => $grossCommission,

                        ]);
                    }
                }
            }
            $this->line('<fg=green>Pull Report success</>');
        } else {
            $this->line('<fg=green>Api Call Error</>');
        }
    }
}
