<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecurrenceToTasksTable extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('recurrence_type')->nullable(); // daily, weekly, monthly
            $table->date('recurrence_end_date')->nullable(); // End date for recurrence
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('recurrence_type');
            $table->dropColumn('recurrence_end_date');
        });
    }
}