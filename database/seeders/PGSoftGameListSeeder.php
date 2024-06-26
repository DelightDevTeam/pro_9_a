<?php

namespace Database\Seeders;

use App\Models\Admin\GameList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PGSoftGameListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'code' => '1',
                'name' => 'Honey Trap of Diao Chan',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1.png',
            ],
            [
                'code' => '2',
                'name' => 'Gem Saviour',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/2.png',
            ],
            [
                'code' => '3',
                'name' => 'Fortune Gods',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/3.png',
            ],
            [
                'code' => '6',
                'name' => 'Medusa 2: The Quest of Perseus',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/6.png',
            ],
            [
                'code' => '7',
                'name' => 'Medusa 1: The Curse of Athena',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/7.png',
            ],
            [
                'code' => '18',
                'name' => 'Hood vs Wolf',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/18.png',
            ],
            [
                'code' => '20',
                'name' => 'Reel Love',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/20.png',
            ],
            [
                'code' => '24',
                'name' => 'Win Win Won',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/24.png',
            ],
            [
                'code' => '25',
                'name' => 'Plushie Frenzy',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/25.png',
            ],
            [
                'code' => '26',
                'name' => 'Tree of Fortune',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/26.png',
            ],
            [
                'code' => '28',
                'name' => 'Hotpot',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/28.png',
            ],
            [
                'code' => '29',
                'name' => 'Dragon Legend',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/29.png',
            ],
            [
                'code' => '33',
                'name' => 'Hip Hop Panda',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/33.png',
            ],
            [
                'code' => '34',
                'name' => 'Legend of Hou Yi',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/34.png',
            ],
            [
                'code' => '35',
                'name' => 'Mr. Hallow-Win',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/35.png',
            ],
            [
                'code' => '36',
                'name' => 'Prosperity Lion',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/36.png',
            ],
            [
                'code' => '37',
                'name' => 'Santa\'s Gift Rush',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/37.png',
            ],
            [
                'code' => '1',
                'name' => 'Honey Trap of Diao Chan',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1.png',
            ],
            [
                'code' => '2',
                'name' => 'Gem Saviour',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/2.png',
            ],
            [
                'code' => '3',
                'name' => 'Fortune Gods',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/3.png',
            ],
            [
                'code' => '6',
                'name' => 'Medusa 2: The Quest of Perseus',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/6.png',
            ],
            [
                'code' => '7',
                'name' => 'Medusa 1: The Curse of Athena',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/7.png',
            ],
            [
                'code' => '18',
                'name' => 'Hood vs Wolf',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/18.png',
            ],
            [
                'code' => '20',
                'name' => 'Reel Love',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/20.png',
            ],
            [
                'code' => '24',
                'name' => 'Win Win Won',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/24.png',
            ],
            [
                'code' => '25',
                'name' => 'Plushie Frenzy',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/25.png',
            ],
            [
                'code' => '26',
                'name' => 'Tree of Fortune',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/26.png',
            ],
            [
                'code' => '28',
                'name' => 'Hotpot',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/28.png',
            ],
            [
                'code' => '29',
                'name' => 'Dragon Legend',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/29.png',
            ],
            [
                'code' => '33',
                'name' => 'Hip Hop Panda',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/33.png',
            ],
            [
                'code' => '34',
                'name' => 'Legend of Hou Yi',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/34.png',
            ],
            [
                'code' => '35',
                'name' => 'Mr. Hallow-Win',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/35.png',
            ],
            [
                'code' => '36',
                'name' => 'Prosperity Lion',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/36.png',
            ],
            [
                'code' => '37',
                'name' => 'Santa\'s Gift Rush',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/37.png',
            ],
            [
                'code' => '38',
                'name' => 'Gem Saviour Sword',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/38.png',
            ],
            [
                'code' => '39',
                'name' => 'Piggy Gold',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/39.png',
            ],
            [
                'code' => '40',
                'name' => 'Jungle Delight',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/40.png',
            ],
            [
                'code' => '41',
                'name' => 'Symbols Of Egypt',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/41.png',
            ],
            [
                'code' => '42',
                'name' => 'Ganesha Gold',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/42.png',
            ],
            [
                'code' => '44',
                'name' => 'Emperor\'s Favour',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/44.png',
            ],
            [
                'code' => '48',
                'name' => 'Double Fortune',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/48.png',
            ],
            [
                'code' => '50',
                'name' => 'Journey to the Wealth',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/50.png',
            ],
            [
                'code' => '53',
                'name' => 'The Great Icescape',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/53.png',
            ],
            [
                'code' => '54',
                'name' => 'Captain\'s Bounty',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/54.png',
            ],
            [
                'code' => '57',
                'name' => 'Dragon Hatch',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/57.png',
            ],
            [
                'code' => '58',
                'name' => 'Vampire\'s Charm',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/58.png',
            ],
            [
                'code' => '59',
                'name' => 'Ninja vs Samurai',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/59.png',
            ],
            [
                'code' => '60',
                'name' => 'Leprechaun Riches',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/60.png',
            ],
            [
                'code' => '61',
                'name' => 'Flirting Scholar',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/61.png',
            ],
            [
                'code' => '62',
                'name' => 'Gem Saviour Conquest',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/62.png',
            ],
            [
                'code' => '63',
                'name' => 'Dragon Tiger Luck',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/63.png',
            ],
            [
                'code' => '64',
                'name' => 'Muay Thai Champion',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/64.png',
            ],
            [
                'code' => '65',
                'name' => 'Mahjong Ways',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/65.png',
            ],
            [
                'code' => '67',
                'name' => 'Shaolin Soccer',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/67.png',
            ],
            [
                'code' => '68',
                'name' => 'Fortune Mouse',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/68.png',
            ],
            [
                'code' => '69',
                'name' => 'Bikini Paradise',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/69.png',
            ],
            [
                'code' => '70',
                'name' => 'Candy Burst',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/70.png',
            ],
            [
                'code' => '71',
                'name' => 'CaiShen Wins',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/71.png',
            ],
            [
                'code' => '73',
                'name' => 'Egypt\'s Book of Mystery',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/73.png',
            ],
            [
                'code' => '74',
                'name' => 'Mahjong Ways 2',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/74.png',
            ],
            [
                'code' => '75',
                'name' => 'Ganesha Fortune',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/75.png',
            ],
            [
                'code' => '79',
                'name' => 'Dreams of Macau',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/79.png',
            ],
            [
                'code' => '80',
                'name' => 'Circus Delight',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/80.png',
            ],
            [
                'code' => '82',
                'name' => 'Phoenix Rises',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/82.png',
            ],
            [
                'code' => '83',
                'name' => 'Wild Fireworks',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/83.png',
            ],
            [
                'code' => '84',
                'name' => 'Queen of Bounty',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/84.png',
            ],
            [
                'code' => '85',
                'name' => 'Genie\'s 3 Wishes',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/85.png',
            ],
            [
                'code' => '86',
                'name' => 'Galactic Gems',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/86.png',
            ],
            [
                'code' => '87',
                'name' => 'Treasures of Aztec',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/87.png',
            ],
            [
                'code' => '88',
                'name' => 'Jewels of Prosperity',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/88.png',
            ],
            [
                'code' => '89',
                'name' => 'Lucky Neko',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/89.png',
            ],
            [
                'code' => '90',
                'name' => 'Secrets of Cleopatra',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/90.png',
            ],
            [
                'code' => '91',
                'name' => 'Guardians of Ice & Fire',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/91.png',
            ],
            [
                'code' => '92',
                'name' => 'Thai River Wonders',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/92.png',
            ],
            [
                'code' => '93',
                'name' => 'Opera Dynasty',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/93.png',
            ],
            [
                'code' => '94',
                'name' => 'Bali Vacation',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/94.png',
            ],
            [
                'code' => '95',
                'name' => 'Majestic Treasures',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/95.png',
            ],
            [
                'code' => '97',
                'name' => 'Jack Frost\'s Winter',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/97.png',
            ],
            [
                'code' => '98',
                'name' => 'Fortune Ox',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/98.png',
            ],
            [
                'code' => '100',
                'name' => 'Candy Bonanza',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/100.png',
            ],
            [
                'code' => '101',
                'name' => 'Rise of Apollo',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/101.png',
            ],
            [
                'code' => '102',
                'name' => 'Mermaid Riches',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/102.png',
            ],
            [
                'code' => '103',
                'name' => 'Crypto Gold',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/103.png',
            ],
            [
                'code' => '104',
                'name' => 'Wild Bandito',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/104.png',
            ],
            [
                'code' => '105',
                'name' => 'Heist Stakes',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/105.png',
            ],
            [
                'code' => '106',
                'name' => 'Ways of the Qilin',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/106.png',
            ],
            [
                'code' => '107',
                'name' => 'Legendary Monkey King',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/107.png',
            ],
            [
                'code' => '108',
                'name' => 'Buffalo Win',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/108.png',
            ],
            [
                'code' => '110',
                'name' => 'Jurassic Kingdom',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/110.png',
            ],
            [
                'code' => '112',
                'name' => 'Oriental Prosperity',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/112.png',
            ],
            [
                'code' => '113',
                'name' => 'Raider Jane\'s Crypt of Fortune',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/113.png',
            ],
            [
                'code' => '114',
                'name' => 'Emoji Riches',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/114.png',
            ],
            [
                'code' => '115',
                'name' => 'Supermarket Spree',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/115.png',
            ],
            [
                'code' => '117',
                'name' => 'Cocktail Nights',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/117.png',
            ],
            [
                'code' => '118',
                'name' => 'Mask Carnival',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/118.png',
            ],
            [
                'code' => '119',
                'name' => 'Spirited Wonders',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/119.png',
            ],
            [
                'code' => '120',
                'name' => 'The Queen\'s Banquet',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/120.png',
            ],
            [
                'code' => '121',
                'name' => 'Destiny of Sun & Moon',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/121.png',
            ],
            [
                'code' => '122',
                'name' => 'Garuda Gems',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/122.png',
            ],
            [
                'code' => '123',
                'name' => 'Rooster Rumble',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/123.png',
            ],
            [
                'code' => '124',
                'name' => 'Battleground Royale',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/124.png',
            ],
            [
                'code' => '125',
                'name' => 'Butterfly Blossom',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/125.png',
            ],
            [
                'code' => '126',
                'name' => 'Fortune Tiger',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/126.png',
            ],
            [
                'code' => '127',
                'name' => 'Speed Winner',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/127.png',
            ],
            [
                'code' => '128',
                'name' => 'Legend of Perseus',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/128.png',
            ],
            [
                'code' => '129',
                'name' => 'Win Win Fish Prawn Crab',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/129.png',
            ],
            [
                'code' => '130',
                'name' => 'Lucky Piggy',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/130.png',
            ],
            [
                'code' => '132',
                'name' => 'Wild Coaster',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/132.png',
            ],
            [
                'code' => '135',
                'name' => 'Wild Bounty Showdown',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/135.png',
            ],
            [
                'code' => '1312883',
                'name' => 'Prosperity Fortune Tree',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1312883.png',
            ],
            [
                'code' => '1338274',
                'name' => 'Totem Wonders',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1338274.png',
            ],
            [
                'code' => '1340277',
                'name' => 'Asgardian Rising',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1340277.png',
            ],
            [
                'code' => '1368367',
                'name' => 'Alchemy Gold',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1368367.png',
            ],
            [
                'code' => '1372643',
                'name' => 'Diner Delights',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1372643.png',
            ],
            [
                'code' => '1381200',
                'name' => 'Hawaiian Tiki',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1381200.png',
            ],
            [
                'code' => '1397455',
                'name' => 'Fruity Candy',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1397455.png',
            ],
            [
                'code' => '1402846',
                'name' => 'Midas Fortune',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1402846.png',
            ],
            [
                'code' => '1418544',
                'name' => 'Bakery Bonanza',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1418544.png',
            ],
            [
                'code' => '1420892',
                'name' => 'Rave Party Fever',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1420892.png',
            ],
            [
                'code' => '1432733',
                'name' => 'Mystical Spirits',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1432733.png',
            ],
            [
                'code' => '1448762',
                'name' => 'Songkran Splash',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1448762.png',
            ],
            [
                'code' => '1451122',
                'name' => 'Dragon Hatch2',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1451122.png',
            ],
            [
                'code' => '1473388',
                'name' => 'Cruise Royale',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1473388.png',
            ],
            [
                'code' => '1489936',
                'name' => 'Ultimate Striker',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1489936.png',
            ],
            [
                'code' => '1492288',
                'name' => 'Pinata Wins',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1492288.png',
            ],
            [
                'code' => '1508783',
                'name' => 'Wild Ape #3258',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1508783.png',
            ],
            [
                'code' => '1513328',
                'name' => 'Super Golf Drive',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1513328.png',
            ],
            [
                'code' => '1529867',
                'name' => 'Ninja Raccoon Frenzy',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1529867.png',
            ],
            [
                'code' => '1543462',
                'name' => 'Fortune Rabbit',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1543462.png',
            ],
            [
                'code' => '1555350',
                'name' => 'Forge of Wealth',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1555350.png',
            ],
            [
                'code' => '1568554',
                'name' => 'Wild Heist Cashout',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1568554.png',
            ],
            [
                'code' => '1572362',
                'name' => 'Gladiator\'s Glory',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1572362.png',
            ],
            [
                'code' => '1580541',
                'name' => 'Mafia Mayhem',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1580541.png',
            ],
            [
                'code' => '1594259',
                'name' => 'Safari Wilds',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1594259.png',
            ],
            [
                'code' => '1615454',
                'name' => 'Werewolf\'s Hunt',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1615454.png',
            ],
            [
                'code' => '1623475',
                'name' => 'Anubis Wrath',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1623475.png',
            ],
            [
                'code' => '1635221',
                'name' => 'Zombie Outbreak',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1635221.png',
            ],
            [
                'code' => '1655268',
                'name' => 'Tsar Treasures',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1655268.png',
            ],
            [
                'code' => '1671262',
                'name' => 'Gemstones Gold',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1671262.png',
            ],
            [
                'code' => '1682240',
                'name' => 'Cash Mania',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1682240.png',
            ],
            [
                'code' => '1695365',
                'name' => 'Fortune Dragon',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1695365.png',
            ],
            [
                'code' => '1717688',
                'name' => 'Mystic Potion',
                'game_type_id' => 1,
                'product_id' => 31,
                'image_url' => 'http://prodmd.9977997.com/Image/PGSoft/en/1717688.png',
            ],

        ];

        foreach ($data as $gameData) {
            GameList::create($gameData);
        }
    }
}
