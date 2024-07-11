<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->date('last_invoice_issue_date')->nullable();
            $table->date('last_detail_sent_date')->nullable();
            $table->string('offset_instead_of_guarantee_before_vat')->nullable();
            $table->date('guarantee_end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn('last_invoice_issue_date');
            $table->dropColumn('last_detail_sent_date');
            $table->dropColumn('offset_instead_of_guarantee_before_vat');
            $table->dropColumn('guarantee_end_date');
        });
    }
}
