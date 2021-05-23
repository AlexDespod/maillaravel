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
        $Guest       = new Role();
        $Guest->name = 'Guest';
        $Guest->slug = 'guest';
        $Guest->save();

        $Sender       = new Role();
        $Sender->name = 'Sender';
        $Sender->slug = 'sender';
        $Sender->save();

        $Admin       = new Role();
        $Admin->name = 'Admin';
        $Admin->slug = 'admin';
        $Admin->save();

    }
}
