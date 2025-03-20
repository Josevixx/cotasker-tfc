<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToTeamsTable extends Migration
{
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->text('description')->nullable(); // Agregar la columna description
        });
    }

    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('description'); // Eliminar la columna description si se revierte la migración
        });
    }
}
