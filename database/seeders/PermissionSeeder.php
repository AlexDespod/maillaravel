<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $per       = new Permission();
        $per->name = 'update record';
        $per->slug = 'update-record';
        $per->save();

        $per       = new Permission();
        $per->name = 'add user role';
        $per->slug = 'add-user-role';
        $per->save();

        $per       = new Permission();
        $per->name = 'create parcel';
        $per->slug = 'create-parcel';
        $per->save();

        $per       = new Permission();
        $per->name = 'delete parcel';
        $per->slug = 'delete-parcel';
        $per->save();

        $per       = new Permission();
        $per->name = 'view all parcels';
        $per->slug = 'view-all-parcels';
        $per->save();

        $per       = new Permission();
        $per->name = 'view one parcels';
        $per->slug = 'view-one-parcels';
        $per->save();

        $per       = new Permission();
        $per->name = 'view all users';
        $per->slug = 'view-all-users';
        $per->save();

    }
}
