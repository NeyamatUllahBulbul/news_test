<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsCategoryPivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_category_pivots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('news_id');
            $table->foreign('news_id')->references('id')->on('news');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('news_categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_category_pivots');
    }
}
