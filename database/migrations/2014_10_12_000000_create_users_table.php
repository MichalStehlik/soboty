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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->dateTime('birthdate');
            $table->enum('gender', ['male', 'female']);
            $table->string('school')->nullable();
            $table->integer('year')->nullable();
            $table->boolean('potential_student')->default(0);
            $table->boolean('keep_informed')->default(0);
            $table->boolean('active')->default(1);
            $table->boolean('banned')->default(0);
            $table->string('email')->unique();
            $table->boolean('email_confirmed')->default(0);
            $table->string('confirmation_code')->nullable();
            $table->timestamp('confirmation_expiration')->nullable();
            $table->string('password');
            $table->bigInteger('fb_id')->nullable;
            $table->string('fb_token')->nullable;
            $table->string('request_token')->nullable();
            $table->timestamp('request_expiration')->nullable();
            $table->enum('role', ['user', 'lector', 'administrator'])->default("user");
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
