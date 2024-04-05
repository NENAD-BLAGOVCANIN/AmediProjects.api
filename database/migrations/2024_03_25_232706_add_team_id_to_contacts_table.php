<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{


    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {

            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('set null');

        });
    }


    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');

        });
    }
};
