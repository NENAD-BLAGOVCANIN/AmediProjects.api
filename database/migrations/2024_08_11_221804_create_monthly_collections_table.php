<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyCollectionsTable extends Migration
{
    public function up()
    {
        Schema::create('monthly_collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->integer('month');
            $table->integer('year');
            $table->decimal('amount_collected', 10, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('monthly_collections');
    }
}
