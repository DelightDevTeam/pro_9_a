<?php

namespace Database\Seeders;

use App\Models\Admin\Bank;
use Illuminate\Database\Seeder;

class BankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bank = [
            [
                'name' =>  'CB Bank',
            ],
            [
                'name' => 'AYA Bank',
            ],
            [
                'name' => 'KBZ Bank',
            ],
            [
                'name' => 'A Bank',
            ],
            [
                'name' => 'Yoma Bank',
            ],
            [
                'name' => 'KBZPay',
            ],
            [
                'name' => 'Wave Pay',
            ],
            [
                'name' => 'Mytel Pay',
            ],
            [
                'name' => 'AYA Pay',
            ],
            [
                'name' => 'A Wallet',
            ],
            [
                'name' => 'MPT Pay',
            ],
            [
                'name' => 'OK Dollar',
            ]
            ];
       
        Bank::insert($bank);
 
    }
}
