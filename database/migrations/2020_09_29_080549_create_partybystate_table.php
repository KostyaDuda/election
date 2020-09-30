<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartybystateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partybystate', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->integer('party_id');
            $table->integer('state_id')->default(NULL);
            $table->integer('votes')->default(NULL);
            $table->float('rate')->default(NULL);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partybystate');
    }
}
