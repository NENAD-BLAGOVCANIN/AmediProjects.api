<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsArchiveToProductionsAndCollectionsTables extends Migration
{
    public function up()
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->boolean('is_archive')->default(false);
        });

        Schema::table('collections', function (Blueprint $table) {
            $table->boolean('is_archive')->default(false);
        });
    }

    public function down()
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->dropColumn('is_archive');
        });

        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn('is_archive');
        });
    }
}
