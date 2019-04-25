<?php

use App\User;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $userRole 			= Role::where('name', '=', 'User')->first();
        $adminRole 			= Role::where('name', '=', 'Admin')->first();
		$permissions 		= Permission::all();

	    /**
	     * Add Users
	     *
	     */
        if (User::where('email', '=', 'admin@admin.com')->first() === null) {

	        $newUser = User::create([
	            'name' => 'Admin',
	            'email' => 'admin@lafilgroup.com',
	            'password' => bcrypt('password'),
	        ]);

	        $newUser->attachRole($adminRole);
			foreach ($permissions as $permission) {
				$newUser->attachPermission($permission);
			}

        }

        if (User::where('email', '=', 'user@user.com')->first() === null) {

	        $newUser = User::create([
	            'name' => 'User',
	            'email' => 'user@user.com',
	            'password' => bcrypt('password'),
	        ]);

	        $newUser;
	        $newUser->attachRole($userRole);

		}

        if (User::where('email', '=', 'maryjean.dizon@lafilgroup.com')->first() === null) {

	        $newUser = User::create([
	            'name' => 'Mary Jean Dizon',
	            'email' => 'maryjean.dizon@lafilgroup.com',
	            'password' => bcrypt('maryjean.dizon'),
	        ]);

	        $newUser;
	        $newUser->attachRole($userRole);

		}

        if (User::where('email', '=', 'donalyn.acaso@philippineforemost.com')->first() === null) {

	        $newUser = User::create([
	            'name' => 'Donalyn Acaso',
	            'email' => 'donalyn.acaso@philippineforemost.com',
	            'password' => bcrypt('donalyn.acaso'),
	        ]);

	        $newUser;
	        $newUser->attachRole($userRole);

        }

    }
}
