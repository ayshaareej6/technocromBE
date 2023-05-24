<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_boards', function (Blueprint $table) {
            $table->id();
            $table->string('job_code')->nullable();
            $table->string('title');
            $table->mediumText('desc')->nullable();
            $table->enum('type', ['part-time', 'full-time','contract'])->default('full-time');
            $table->enum('shift', ['morning', 'evening','night'])->default('morning');
            $table->enum('mode', ['in-house', 'remote','hybrid'])->default('in-house');
            $table->date('last_date')->nullable();
            $table->string('location');
            $table->longText('data')->nullable();
            $table->bigInteger('created_by')->unsigned()->index()->nullable();
            $table->bigInteger('updated_by')->unsigned()->index()->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users')->after('status');
            $table->timestamps();
            $table->softDeletes();
            $table->enum('status', [1, 0])->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_boards');
    }
}
