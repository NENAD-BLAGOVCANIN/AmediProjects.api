<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSummaryDaysTable extends Migration
{
    public function up()
    {
        Schema::create('summary_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('body');
            $table->string('collected_today')->nullable();
            $table->string('future_collection')->nullable();
            $table->string('problems')->nullable();
            $table->boolean('is_archive')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('summary_days');
    }
}