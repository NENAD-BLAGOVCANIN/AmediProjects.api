<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSummaryInstallationsTable extends Migration
{
    public function up()
    {
        Schema::table('summary_installations', function (Blueprint $table) {
            $table->text('notes')->nullable();
            $table->string('city')->nullable();
            $table->text('employee_comments')->nullable();
            $table->string('delivery')->nullable();
        });
    }

    public function down()
    {
        Schema::table('summary_installations', function (Blueprint $table) {
            $table->dropColumn(['notes', 'city', 'employee_comments', 'delivery']);
        });
    }
}
