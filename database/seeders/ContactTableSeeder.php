<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::create([
            'phone' => '093453456798',
            'facebook' => 'https://www.facebook.com/',
            'telegram' => '@mawite22',
            'viber' => '093453456798',
            'user_id' => 1
        ]);
    }
}
