<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departamentes_dimensiunes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('departament_id');
            $table->foreign('departament_id', 'user_id_fk_7602650')->references('id')->on('departamentes')->onDelete('cascade');

            $table->unsignedBigInteger('dimensiune_id');
            $table->foreign('dimensiune_id', 'role_id_fk_7602651')->references('id')->on('dimensiunes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departamentes_dimensiunes');
    }
};
