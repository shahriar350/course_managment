<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Admin Role'
            ]  ,
            [
                'name' => 'student',
                'display_name' => 'Student Role'
            ]  ,
            [
                'name' => 'Teacher',
                'display_name' => 'Teacher Role'
            ]  ,
        ];
        foreach ($roles as $role){
            Role::create($role);
        }
    }
}
