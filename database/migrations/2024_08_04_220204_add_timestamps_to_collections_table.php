<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToCollectionsTable extends Migration
{
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->timestamps(); // This will add created_at and updated_at columns
        });
    }

    public function down()
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropTimestamps(); // This will drop the created_at and updated_at columns
        });
    }
}
