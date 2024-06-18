<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class AddFieldsToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('company_number')->nullable();
            $table->string('accounting_phone')->nullable();
            $table->string('project_manager_phone')->nullable();
            $table->string('accounting_email')->nullable();
            $table->string('project_manager_email')->nullable();
            $table->string('project_manager_name')->nullable();
            $table->string('accounting_manager_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('company_number');
            $table->dropColumn('accounting_phone');
            $table->dropColumn('project_manager_phone');
            $table->dropColumn('accounting_email');
            $table->dropColumn('project_manager_email');
            $table->dropColumn('project_manager_name');
            $table->dropColumn('accounting_manager_name');
        });
    }
}
