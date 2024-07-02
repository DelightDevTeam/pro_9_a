<?php

namespace Database\Seeders;

use App\Models\PaymentImage;
use App\Models\PaymentType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'KBZ Pay',
                'image' => 'kpay.png',
            ],
            [
                'name' => 'Wave Pay',
                'image' => 'wave.png',
            ],
            [
                'name' => 'AYA Pay',
                'image' => 'ayapay.png'
            ],
            [
                'name' => 'AYA Bank',
                'image' => 'ayabank.png'
            ],
            [
                'name' => 'CB Bank',
                'image' => 'cbbank.png'
            ],
            [
                'name' => 'CB Pay',
                'image' => 'cbpay.png'
            ],
            [
                'name' => 'MAB Bank',
                'image' => 'mabbank.png'
            ],
            [
                'name' => 'UAB Bank',
                'image' => 'uabbank.png'
            ],
            [
                'name' => 'UAB Pay',
                'image' => 'uabpay.png'
            ],
            [
                'name' => 'Yoma Bank',
                'image' => 'yomabank.png'
            ]

        ];

        DB::table('payment_types')->insert($types);
    }
}
