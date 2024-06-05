<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_name')->nullable();
            $table->string('project_manager_mobile')->nullable();
            $table->string('accounting_manager_mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('last_execution_date')->nullable();
            $table->string('agreed_payment_date')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('debt')->nullable();
            $table->string('first_line_sent_whatsapp')->nullable();
            $table->string('details')->nullable();
            $table->string('second_line_sent_email_details')->nullable();
            $table->string('whatsapp_2')->nullable();
            $table->string('details_2')->nullable();
            $table->string('call_2_created')->nullable();
            $table->string('collected_amount')->nullable();
            $table->string('remaining_amount_to_collect')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
