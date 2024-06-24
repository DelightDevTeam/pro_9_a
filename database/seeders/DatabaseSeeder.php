<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

            $this->call([
            BankTableSeeder::class,
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            GameTypeTableSeeder::class,
            ProductTableSeeder::class,
            GameTypeProductTableSeeder::class,
            BannerSeeder::class,
            BannerTextSeeder::class,
            AsiaGamingTablesSeeder::class,
            CQ9GameListTableSeeder::class,
            EvolutionGamingTableSeeder::class,
            HotGameTablesSeeder::class,
            PragmaticPlaySeeder::class,
            PGSoftGameListSeeder::class,
            JokerGameListSeeder::class,
            HabaneroGameListTableSeeder::class,
            DragonSoftGameListTableSeeder::class,
            PlayStarGameListTableSeeder::class,
            SBOGameListSeeder::class,
            SkyWindGameListTableSeeder::class,
            ReevoGameListTableSeeder::class,
            PragmaticPlaySeeder::class,
            AsiaGamingTablesSeeder::class
        ]);
      
    }
}