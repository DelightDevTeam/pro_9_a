<?php

namespace Database\Seeders;

use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin permissions
        $admin_permissions = Permission::whereIn('title', [
            'admin_access',
            'master_access',
            //'agent_access',
            'role_index',
            'role_create',
            'role_store',
            'role_edit',
            'role_update',
            'role_delete',
            'permission_index',
            'permission_create',
            'permission_store',
            'permission_edit',
            'permission_update',
            'permission_delete',
            'master_index',
            'master_create',
            'master_store',
            'master_edit',
            'master_show',
            'master_delete',
            'master_update',
            'transfer_log',
            'make_transfer',
            'game_type_access',
            'contact',
            'agent_change_password_access',

        ]);
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        // master permissions
        $master_permissions = Permission::whereIn('title', [
            'master_access',
            'role_index',
            'role_create',
            'role_store',
            'role_edit',
            'role_update',
            'role_delete',
            'permission_index',
            'permission_create',
            'permission_store',
            'permission_edit',
            'permission_update',
            'permission_delete',
            'transfer_log',
            'agent_index',
            'agent_create',
            'agent_store',
            'agent_edit',
            'agent_show',
            'agent_delete',
            'agent_update',
            'make_transfer',
            'agent_change_password_access',

        ]);
        Role::findOrFail(2)->permissions()->sync($master_permissions->pluck('id'));

        // Agent gets specific permissions
        $agent_permissions = Permission::whereIn('title', [
            'agent_access',
            'player_index',
            'player_create',
            'player_store',
            'player_edit',
            'player_show',
            'player_update',
            'player_delete',
            'transfer_log',
            'make_transfer',
            'payment_type',
            'withdraw_requests',
            'deposit_requests',
            'contact',
            'agent_change_password_access',
        ])->pluck('id');
        Role::findOrFail(3)->permissions()->sync($agent_permissions);
    }
}
