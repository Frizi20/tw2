<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 18,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 19,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 20,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 21,
                'title' => 'departamente_create',
            ],
            [
                'id'    => 22,
                'title' => 'departamente_edit',
            ],
            [
                'id'    => 23,
                'title' => 'departamente_show',
            ],
            [
                'id'    => 24,
                'title' => 'departamente_delete',
            ],
            [
                'id'    => 25,
                'title' => 'departamente_access',
            ],
            [
                'id'    => 26,
                'title' => 'survey_builder_create',
            ],
            [
                'id'    => 27,
                'title' => 'survey_builder_edit',
            ],
            [
                'id'    => 28,
                'title' => 'survey_builder_show',
            ],
            [
                'id'    => 29,
                'title' => 'survey_builder_delete',
            ],
            [
                'id'    => 30,
                'title' => 'survey_builder_access',
            ],
            [
                'id'    => 31,
                'title' => 'survey_result_create',
            ],
            [
                'id'    => 32,
                'title' => 'survey_result_edit',
            ],
            [
                'id'    => 33,
                'title' => 'survey_result_show',
            ],
            [
                'id'    => 34,
                'title' => 'survey_result_delete',
            ],
            [
                'id'    => 35,
                'title' => 'survey_result_access',
            ],
            [
                'id'    => 36,
                'title' => 'admin_access',
            ],
            [
                'id'    => 37,
                'title' => 'dimensiune_create',
            ],
            [
                'id'    => 38,
                'title' => 'dimensiune_edit',
            ],
            [
                'id'    => 39,
                'title' => 'dimensiune_show',
            ],
            [
                'id'    => 40,
                'title' => 'dimensiune_delete',
            ],
            [
                'id'    => 41,
                'title' => 'dimensiune_access',
            ],
            [
                'id'    => 42,
                'title' => 'categorie_de_control_create',
            ],
            [
                'id'    => 43,
                'title' => 'categorie_de_control_edit',
            ],
            [
                'id'    => 44,
                'title' => 'categorie_de_control_show',
            ],
            [
                'id'    => 45,
                'title' => 'categorie_de_control_delete',
            ],
            [
                'id'    => 46,
                'title' => 'categorie_de_control_access',
            ],
            [
                'id'    => 47,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
