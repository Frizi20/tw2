<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyResultsTable extends Migration
{
    public function up()
    {
        Schema::create('survey_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('schema_results')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
