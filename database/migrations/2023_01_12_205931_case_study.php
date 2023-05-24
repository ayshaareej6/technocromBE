<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CaseStudy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('case_study', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['case', 'story'])->default('case');
            $table->mediumText('title')->nullable();
            $table->mediumText('desc')->nullable();
            $table->longText('challenges')->nullable();
            $table->longText('solution')->nullable();
            $table->longText('result')->nullable();
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
        Schema::dropIfExists('case_study');
    }
}
