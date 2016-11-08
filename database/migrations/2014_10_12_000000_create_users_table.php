<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('name')->nullable();
            $table->string('telp')->nullable();
            $table->string('nip')->nullable();
            $table->string('barcode')->nullable();
            $table->string('address')->nullable();
            $table->integer('role_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Schema::create('history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('illness')->nullable();
            $table->string('year')->nullable();
            $table->integer('doctor_id');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('description')->nullable();
            $table->string('activity')->nullable();
            $table->timestamps();
        });

        Schema::create('status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });

        Schema::create('transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('doctor_id');
            $table->integer('drugstore_id');
            $table->string('photo')->nullable();
            $table->string('cost')->nullable();
            $table->string('message')->nullable();
            $table->string('duration')->nullable();
            $table->integer('status_id')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user');
        Schema::drop('role');
        Schema::drop('history');
        Schema::drop('log');
        Schema::drop('transaction');
        Schema::drop('status');

    }
}
