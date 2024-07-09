<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToCollectionsTable extends Migration
{
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->string('company_name')->nullable();
            $table->string('cumulative_offset')->nullable();
            $table->string('offset_instead_of_guarantee')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('last_connection')->nullable();
        });
    }

    public function down()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn('company_name');
            $table->dropColumn('cumulative_offset');
            $table->dropColumn('offset_instead_of_guarantee');
            $table->dropColumn('payment_status');
            $table->dropColumn('last_connection');
        });
    }
}
