<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMayorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mayors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('second_name');
            $table->string('father_name');
            $table->string('party_affiliation');
            $table->date('date');
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
        Schema::dropIfExists('mayors');
    }
}
