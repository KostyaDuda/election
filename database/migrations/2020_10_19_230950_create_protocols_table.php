<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProtocolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('protocols', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('district_id');
            $table->string('type');
            $table->integer('status')->nullable();;
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('p1')->nullable();
            $table->integer('p2')->nullable();
            $table->integer('p3')->nullable();
            $table->integer('p4')->nullable();
            $table->integer('p5')->nullable();
            $table->integer('p6')->nullable();
            $table->integer('p7')->nullable();
            $table->integer('p8')->nullable();
            $table->integer('p9')->nullable();
            $table->integer('p10')->nullable();
            $table->integer('p11')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('protocols');
    }
}
