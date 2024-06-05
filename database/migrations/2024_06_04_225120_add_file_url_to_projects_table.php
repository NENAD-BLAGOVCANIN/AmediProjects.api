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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('file_url')->nullable();
            $table->string('company_name')->nullable();
            $table->string('location')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('file_url');
            $table->dropColumn('company_name');
            $table->dropColumn('location');
            $table->dropColumn('contact_person');
            $table->dropColumn('phone');
        });
    }
};
