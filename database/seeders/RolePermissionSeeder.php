<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permission = [
            'manage statistic', 
            'manage products', 
            'manage principles', 
            'manage testimonials', 
            'manage clients', 
            'manage teams', 
            'manage abouts', 
            'manage appointments', 
            'manage hero sections',
        ];


        foreach($permission as $permission) {
            Permission::firstOrCreate(
                [
                    'name' => $permission
                ]
                );
        }

        $hrdRole = Role::firstOrCreate([
            'name' => 'hrd'
        ]);

        $hrdPermission = [
            'manage clients', 
            'manage teams', 
        ];

        $hrdRole->syncPermissions($hrdPermission);

        $superAdminRole = Role::firstOrCreate(
            [
                'name' => 'super_admin'
            ]
        );

        $user = User::create([
            'name' => 'KodeVisual',
            'email' => 'super@admin.com',
            'password' => bcrypt('123456789')
        ]);


        $user->assignRole($superAdminRole);
        $user->syncPermissions($permission);
       
        $hrd = User::create([
            'name' => 'hrd1',
            'email' => 'mm@hrd.com',
            'password' => bcrypt('123456789')
        ]);
        
        $hrd->assignRole($hrdRole); // Assign the HRD role correctly
        
    }
}
