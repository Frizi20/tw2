<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorieDeControlsTable extends Migration
{
    public function up()
    {
        Schema::create('categorie_de_controls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nume');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
