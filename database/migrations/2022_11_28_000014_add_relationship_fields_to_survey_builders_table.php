<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSurveyBuildersTable extends Migration
{
    public function up()
    {
        Schema::table('survey_builders', function (Blueprint $table) {
            $table->unsignedBigInteger('departamente_id')->nullable();
            $table->foreign('departamente_id', 'departamente_fk_7607691')->references('id')->on('departamentes');
            $table->unsignedBigInteger('categorie_de_control_id')->nullable();
            $table->foreign('categorie_de_control_id', 'categorie_de_control_fk_7689134')->references('id')->on('categorie_de_controls');
            $table->unsignedBigInteger('dimensiune_id')->nullable();
            $table->foreign('dimensiune_id', 'departamente_fk_7664699')->references('id')->on('dimensiunes');
        });
    }
}
