<?php

namespace Database\Seeders;

use App\Models\Admin\GameType;
use Illuminate\Database\Seeder;

class GameTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Slot',
                'name_mm' => 'စလော့',
                'code' => '1',
                'order' => '1',
                'status' => 1,
                'img' => 'slots.png',
            ],
            [
                'name' => 'Live Casino',
                'name_mm' => 'တိုက်ရိုက်ကာစီနို',
                'code' => '2',
                'order' => '2',
                'status' => 1,
                'img' => 'live_casino.png',
            ],
            [
                'name' => 'Sport Book',
                'name_mm' => 'အားကစား',
                'code' => '3',
                'order' => '3',
                'status' => 1,
                'img' => 'sportbook.png',
            ],
            [
                'name' => 'Fishing',
                'name_mm' => 'ငါးဖမ်းခြင်း',
                'code' => '8',
                'order' => '4',
                'status' => 1,
                'img' => 'fishing.png',
            ],
            [
                'name' => 'Other',
                'name_mm' => 'အခြားဂိမ်းများ',
                'code' => '9',
                'order' => '5',
                'status' => 0,
                'img' => 'other.png',
            ],

            [
                'name' => 'Other11',
                'name_mm' => 'အခြားဂိမ်းများ',
                'code' => '11',
                'order' => '5',
                'status' => 0,
                'img' => 'other.png',
            ],

            [
                'name' => 'Other12',
                'name_mm' => 'အခြားဂိမ်းများ',
                'code' => '12',
                'order' => '5',
                'status' => 0,
                'img' => 'other.png',
            ],
        ];

        GameType::insert($data);
    }
}
