<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('run_id');
            $table->unsignedBigInteger('runner_id');
            $table->timestamp('begin_at')->nullable();
            $table->timestamp('end_at')->nullable();


            $table->foreign('run_id')->references('id')->on('runs')->onDelete('cascade');
            $table->foreign('runner_id')->references('id')->on('runners')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
}
