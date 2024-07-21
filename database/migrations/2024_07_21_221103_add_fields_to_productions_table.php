<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToProductionsTable extends Migration
{
    public function up()
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->string('plan_id')->nullable();
            $table->string('fileUpload')->nullable();
            $table->date('due_date')->nullable();
        });
    }

    public function down()
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->dropColumn('plan_id');
            $table->dropColumn('fileUpload');
            $table->dropColumn('due_date');
        });
    }
}
