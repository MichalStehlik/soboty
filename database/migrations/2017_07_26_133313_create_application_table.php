<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("users_id");
            $table->integer("groups_id");
            $table->integer("created_by");
            $table->timestamp("cancelled_at")->nullable();
            $table->integer("cancelled_by")->nullable();
            $table->foreign('users_id')->references('id')->on('users')->onDelete('restrict');;
            $table->foreign('groups_id')->references('id')->on('groups')->onDelete('restrict');;
            $table->foreign('created_by')->references('id')->on('users')->onDelete('restrict');;
            $table->foreign('cancelled_by')->references('id')->on('users')->onDelete('restrict');;
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
        Schema::dropIfExists('applications');
    }
}
