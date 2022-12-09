<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSurveyResultsTable extends Migration
{
    public function up()
    {
        Schema::table('survey_results', function (Blueprint $table) {
            $table->unsignedBigInteger('departament_id')->nullable();
            $table->foreign('departament_id', 'departament_fk_7607697')->references('id')->on('departamentes');
            $table->unsignedBigInteger('dimensiune_id')->nullable();
            $table->foreign('dimensiune_id', 'departamente_fk_7664123')->references('id')->on('dimensiunes');
            $table->unsignedBigInteger('categorie_de_control_id')->nullable();
            $table->foreign('categorie_de_control_id', 'categorie_de_control_fk_7689133')->references('id')->on('categorie_de_controls');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_7607698')->references('id')->on('users');

            $table->unsignedBigInteger('survey_builder_id')->nullable();
            $table->foreign('survey_builder_id', 'survey_builder_fk_7607699')->references('id')->on('survey_builders');


        });
    }
}
