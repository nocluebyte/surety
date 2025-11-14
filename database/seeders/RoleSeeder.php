<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Sentinel;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleArr = Role::pluck('slug')->toArray();
        $newRoleArr = ['administrator', 'Agent', 'Broker', 'Risk Underwriter', 'Commercial Underwriter', 'Employee', 'RM-Agent', 'RM-Broker', 'RM-Contractor', 'RM-Beneficiary', 'Contractor','Beneficiary', 'Claim Examiner'];
        foreach ($newRoleArr as $newRole) {
            $newRoleSlug = Str::slug($newRole);
            if (!in_array($newRoleSlug, $roleArr)) {
                $createRole = Sentinel::getRoleRepository()->create(array(
                    'name' => ucfirst($newRole),
                    'slug' => Str::slug($newRole),
                    'permissions' => [],
                ));
            }
        }
    }
}
