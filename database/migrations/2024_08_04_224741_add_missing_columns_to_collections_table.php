<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->id()->first();
            $table->string('first_line_sent_whatsapp')->nullable()->after('paymnet_plus');
            $table->text('details')->nullable()->after('first_line_sent_whatsapp');
            $table->text('second_line_sent_email_details')->nullable()->after('details');
            $table->text('details_2')->nullable()->after('second_line_sent_email_details');
            $table->string('call_2_created')->nullable()->after('details_2');
            $table->decimal('collected_amount', 10, 2)->nullable()->after('call_2_created');
            $table->decimal('remaining_amount_to_collect', 10, 2)->nullable()->after('collected_amount');
            $table->decimal('offset_instead_of_guarantee', 10, 2)->nullable()->after('remaining_amount_to_collect');
            $table->timestamp('last_connection')->nullable()->after('offset_instead_of_guarantee');
            $table->timestamp('last_invoice_issuance_date')->nullable()->after('last_connection');
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
            $table->dropColumn([
                'id',
                'first_line_sent_whatsapp',
                'details',
                'second_line_sent_email_details',
                'details_2',
                'call_2_created',
                'collected_amount',
                'remaining_amount_to_collect',
                'offset_instead_of_guarantee',
                'last_connection',
                'last_invoice_issuance_date',
            ]);
        });
    }
}
