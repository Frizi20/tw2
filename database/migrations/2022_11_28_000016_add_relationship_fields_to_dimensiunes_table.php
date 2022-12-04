<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDimensiunesTable extends Migration
{
    public function up()
    {
        Schema::table('dimensiunes', function (Blueprint $table) {
            $table->unsignedBigInteger('departament_id')->nullable();
            $table->foreign('departament_id', 'departament_fk_7689082')->references('id')->on('departamentes');
        });
    }
}
