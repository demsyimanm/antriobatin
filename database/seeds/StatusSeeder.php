<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create(array(
        	'id'	=> 1,
        	'name'	=> 'Dikirim ke Apotek'
        ));

        Status::create(array(
        	'id'	=> 2,
        	'name'	=> 'Diterima Apotek'
        ));

        Status::create(array(
        	'id'	=> 3,
        	'name'	=> 'Sedang dalam proses peracikan obat'
        ));

        Status::create(array(
        	'id'	=> 4,
        	'name'	=> 'Obat sudah bisa diambil'
        ));

        Status::create(array(
        	'id'	=> 5,
        	'name'	=> 'Obat telah diambil'
        ));


    }
}
