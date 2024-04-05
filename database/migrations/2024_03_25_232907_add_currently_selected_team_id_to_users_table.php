<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->unsignedBigInteger('currently_selected_project_id')->nullable();
            $table->foreign('currently_selected_project_id')->references('id')->on('projects')->onDelete('set null');

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['currently_selected_project_id']);
            $table->dropColumn('currently_selected_project_id');
            
        });
    }
};
