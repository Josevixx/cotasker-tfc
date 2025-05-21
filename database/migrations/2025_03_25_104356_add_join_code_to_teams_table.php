<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('teams', function (Blueprint $table) {
            $table->string('join_code', 10)->unique()->after('owner_id');
        });
    }

    public function down() {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('join_code');
        });
    }
};