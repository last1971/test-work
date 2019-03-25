<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeduzaNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meduza_news', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->date('date')->index();
            $table->string('title', 767);
            $table->string('url', 767);
            $table->string('image', 767)->nullable();
            $table->string('document_type');
            $table->text('json');
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
        Schema::dropIfExists('meduza_news');
    }
}
