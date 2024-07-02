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
                'image' => 'ayapay'
            ],
            [
                'name' => 'AYA Bank',
                'name' => 'ayabank'
            ],
            [
                'name' => 'CB Bank',
                'image' => 'cbbank'
            ],
            [
                'name' => 'CB Pay',
                'image' => 'cbpay'
            ],
            [
                'name' => 'MAB Bank',
                'image' => 'mabbank'
            ],
            [
                'name' => 'UAB Bank',
                'image' => 'uabbank'
            ],
            [
                'name' => 'UAB Pay',
                'image' => 'uabpay'
            ],
            [
                'name' => 'Yoma Bank',
                'image' => 'yomabank'
            ]

        ];

        DB::table('payment_types')->insert($types);
    }
}
