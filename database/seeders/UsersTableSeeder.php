<?php

namespace Database\Seeders;

use App\Enums\TransactionName;
use App\Enums\UserType;
use App\Models\User;
use App\Services\WalletService;
use App\Settings\AppSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = $this->createUser(UserType::Admin, 'Owner', 'mk77', '09123456789');
        (new WalletService)->deposit($admin, 10 * 100_000, TransactionName::CapitalDeposit);

        $master = $this->createUser(UserType::Master, 'Master 1', 'TG-898437', '09112345678', $admin->id);
        (new WalletService)->transfer($admin, $master, 8 * 100_000, TransactionName::CreditTransfer);

        $agent_1 = $this->createUser(UserType::Agent, 'Agent 1', 'TG-898737', '09112345674', $master->id);
        (new WalletService)->transfer($master, $agent_1, 5 * 100_000, TransactionName::CreditTransfer);

        $player_1 = $this->createUser(UserType::Player, 'Player 1', 'TG-111111', '09111111111', $agent_1->id);
        (new WalletService)->transfer($agent_1, $player_1, 30000, TransactionName::CreditTransfer);

    }

    private function createUser(UserType $type, $name, $user_name, $phone, $parent_id = null)
    {
        return User::create([
            'name' => $name,
            'user_name' => $user_name,
            'phone' => $phone,
            'password' => Hash::make('delightmyanmar'),
            'agent_id' => $parent_id,
            'status' => 1,
            'is_changed_password' => 1,
            'type' => $type->value,
            'bank_id' => 1,
        ]);
    }
}
