<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectIdToProductionsAndCollectionsTables extends Migration
{
    public function up()
    {
        // Schema::table('productions', function (Blueprint $table) {
        //     $table->unsignedBigInteger('project_id')->nullable()->after('id');
        //     $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        // });

        // Schema::table('collections', function (Blueprint $table) {
        //     $table->unsignedBigInteger('project_id')->nullable()->after('collection_contact');
        //     $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        // });
    }

    public function down()
    {
        Schema::table('productions', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });

        Schema::table('collections', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });
    }
}
