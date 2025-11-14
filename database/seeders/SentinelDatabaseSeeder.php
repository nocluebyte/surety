<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Sentinel;
use DB;
use Activation;

class SentinelDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create Users
        // DB::table('users')->truncate();

        $users = config('seeder.user');

        $role = Sentinel::findRoleBySlug('administrator');

        if (!isset($role)) {

            $role = Sentinel::getRoleRepository()->create(array(
                'name' => 'Administrator',
                'slug' => 'administrator',
                'permissions' => array(
                    'users.create' => true,
                    'users.update' => true,
                    'users.view' => true,
                    'users.destroy' => true,
                    'roles.create' => true,
                    'roles.update' => true,
                    'roles.view' => true,
                    'roles.delete' => true
                )
            ));
        }

        foreach ($users as $key => $user) {
         $existe = Sentinel::findByCredentials($user);
        
            if(!$existe){
                $account = Sentinel::getUserRepository()->create($user);
        
                DB::table('users')
                ->where('id', $account->id)
                ->update([
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'roles_id'=>$role->id,
                    'permissions' => ['users.superadmin' => true], 
                    'is_active' => 'Yes'
             ]);

             $code = Activation::create($account)->code;
             Activation::complete($account, $code);
             

             $role->users()->attach($account);
        
            }
        }

    }
}
