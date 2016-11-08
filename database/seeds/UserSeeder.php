<?php

use Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insertGetId(array(
			'name' 		=> 'Admin', 
			'username' 	=> 'admin@gmail.com', 
			'password' 	=> bcrypt('admin'), 
			'telp' 		=> '085607227007', 
			'nip' 		=> '5113100081',
			'barcode'	=> '',
			'address'	=> 'Teknik Informatika ITS',
			'role_id'	=> 1
		));

		User::insertGetId(array(
			'name' 		=> 'Pasien', 
			'username' 	=> 'pasien@gmail.com', 
			'password' 	=> bcrypt('pasien'), 
			'telp' 		=> '085607227007', 
			'nip' 		=> '5113100046',
			'barcode'	=> '',
			'address'	=> 'Keputih',
			'role_id'	=> 2
		));

		User::insertGetId(array(
			'name' 		=> 'Dokter', 
			'username' 	=> 'dokter@gmail.com', 
			'password' 	=> bcrypt('dokter'), 
			'telp' 		=> '085607227007', 
			'nip' 		=> '5113100015',
			'barcode'	=> '',
			'address'	=> 'Wisma Permai Gg 3 no 3',
			'role_id'	=> 3
		));

		User::insertGetId(array(
			'name' 		=> 'Apotek', 
			'username' 	=> 'apotek@gmail.com', 
			'password' 	=> bcrypt('apotek'), 
			'telp' 		=> '085607227007', 
			'nip' 		=> '5113100300',
			'barcode'	=> '',
			'address'	=> 'Apotek Keputih Sukolilo',
			'role_id'	=> 4
		));

		User::insertGetId(array(
			'name' 		=> 'Dinas Kesehatan', 
			'username' 	=> 'dinas@gmail.com', 
			'password' 	=> bcrypt('dinas'), 
			'telp' 		=> '085607227007', 
			'nip' 		=> '5113100081',
			'barcode'	=> '',
			'address'	=> 'Dinas Kesehatan Surabaya',
			'role_id'	=> 5
		));
    }
}
