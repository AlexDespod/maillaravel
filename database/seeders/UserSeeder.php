<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guest  = Role::where('slug', 'guest')->first();
        $sender = Role::where('slug', 'sender')->first();
        $admin  = Role::where('slug', 'admin')->first();

        $create    = Permission::where('slug', 'create-parcel')->first();
        $update    = Permission::where('slug', 'update-record')->first();
        $addRole   = Permission::where('slug', 'add-user-role')->first();
        $delete    = Permission::where('slug', 'delete-parcel')->first();
        $viewAll   = Permission::where('slug', 'view-all-parcels')->first();
        $viewOne   = Permission::where('slug', 'view-one-parcels')->first();
        $viewUsers = Permission::where('slug', 'view-all-users')->first();

        $user1           = new User();
        $user1->name     = 'alex';
        $user1->email    = 'kolesniks559@gmail.com';
        $user1->password = bcrypt('kakashla12');
        $user1->save();
        $user1->roles()->attach($admin);

        $user1->permissions()->attach($create);
        $user1->permissions()->attach($update);
        $user1->permissions()->attach($addRole);
        $user1->permissions()->attach($delete);
        $user1->permissions()->attach($viewAll);
        $user1->permissions()->attach($viewOne);
        $user1->permissions()->attach($viewUsers);

        $user2           = new User();
        $user2->name     = 'mike';
        $user2->email    = 'mike@thomas.com';
        $user2->password = bcrypt('kakashla12');
        $user2->save();
        $user2->roles()->attach($guest);
        $user2->permissions()->attach($create);

        $user2           = new User();
        $user2->name     = 'nadya';
        $user2->email    = 'nadya@gmail.com';
        $user2->password = bcrypt('kakashla12');
        $user2->save();
        $user2->roles()->attach($sender);
        $user2->permissions()->attach($viewOne);
        $user2->permissions()->attach($delete);
        $user2->permissions()->attach($create);

    }
}
