<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactPersonPhoneToCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->string('paymnet_plus')->nullable()->after('last_invoice_issuance_date'); // Adjust the 'after' parameter as needed
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
            $table->dropColumn('paymnet_plus');
        });
    }
}