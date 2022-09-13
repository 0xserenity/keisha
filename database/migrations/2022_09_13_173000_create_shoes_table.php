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
        Schema::create('shoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stepn_id')->unique();
            $table->unsignedTinyInteger('level')->default(0);
            $table->unsignedTinyInteger('quality')->default(0);
            $table->unsignedTinyInteger('efficiency')->default(0);
            $table->unsignedTinyInteger('luck')->default(0);
            $table->unsignedTinyInteger('comfort')->default(0);
            $table->unsignedTinyInteger('resilience')->default(0);
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
        Schema::dropIfExists('shoes');
    }
};
