<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('otd')->index();
            $table->decimal('gmt')->default(0);
            $table->unsignedFloat('energy');
            $table->unsignedInteger('durability');
            $table->decimal('repair')->default(0);
            $table->unsignedFloat('hp');
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
        Schema::dropIfExists('tracking');
    }
};
