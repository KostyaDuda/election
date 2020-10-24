<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateP12Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p12s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('protocol_id');
            $table->Integer('party_id');
            $table->Integer('state_id')->nullable();
            $table->Integer('count_voises')->nullable();
            $table->Integer('p13')->nullable();
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
        Schema::dropIfExists('p12');
    }
}
