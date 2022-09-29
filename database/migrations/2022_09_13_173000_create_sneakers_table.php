<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sneakers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stepn_id')->unique();
            $table->unsignedTinyInteger('level')->default(0);
            $table->unsignedBigInteger('quality')->default(0);
            $table->unsignedBigInteger('efficiency')->default(0);
            $table->unsignedBigInteger('luck')->default(0);
            $table->unsignedBigInteger('comfort')->default(0);
            $table->unsignedBigInteger('resilience')->default(0);
            $table->unsignedBigInteger('price')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sneakers');
    }
};
