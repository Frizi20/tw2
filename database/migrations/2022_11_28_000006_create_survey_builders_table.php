<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyBuildersTable extends Migration
{
    public function up()
    {
        Schema::create('survey_builders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('schema')->nullable();
            $table->boolean('generala')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
