<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(array(
        	'id'	=> 1,
        	'name'	=> 'Admin'
        ));

        Role::create(array(
        	'id'	=> 2,
        	'name'	=> 'Pasien'
        ));

        Role::create(array(
        	'id'	=> 3,
        	'name'	=> 'Dokter'
        ));

        Role::create(array(
        	'id'	=> 4,
        	'name'	=> 'Apotek'
        ));

        Role::create(array(
        	'id'	=> 5,
        	'name'	=> 'Dinas Kesehatan'
        ));
    }
}
